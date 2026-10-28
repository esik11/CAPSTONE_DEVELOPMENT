<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Patient;
use App\Models\MedicalCondition;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;
        $appointments = $patient ? $patient->appointments()->with('doctor')->latest()->get() : collect();

        return view('patient.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = User::where('role', 'doctor')->with('availabilities')->get();
        $medicalConditions = MedicalCondition::all();

        return view('patient.appointments.create', compact('doctors', 'medicalConditions'));
    }

    /**
     * Get available time slots for a specific doctor on a specific date.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $doctorId = $request->doctor_id;
        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeek;

        // Get doctor's availability for this day
        $availabilities = \App\Models\DoctorAvailability::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->get();

        if ($availabilities->isEmpty()) {
            return response()->json([
                'available' => false,
                'message' => 'Doctor is not available on this day.',
                'slots' => []
            ]);
        }

        // Get all booked appointments for this day
        $bookedAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('start_time', $date)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in', 'in_progress'])
            ->get(['start_time', 'end_time']);

        $availableSlots = [];
        $slotDuration = 60; // 1 hour slots
        $bufferTime = 15; // 15-minute buffer

        foreach ($availabilities as $availability) {
            $slotStart = Carbon::parse($date->toDateString() . ' ' . $availability->start_time);
            $slotEnd = Carbon::parse($date->toDateString() . ' ' . $availability->end_time);

            while ($slotStart->lt($slotEnd)) {
                $slotEndTime = $slotStart->copy()->addMinutes($slotDuration);

                if ($slotEndTime->gt($slotEnd)) {
                    break;
                }

                // Check if this slot conflicts with any booked appointment (including buffer)
                $hasConflict = $bookedAppointments->contains(function ($appointment) use ($slotStart, $slotEndTime, $bufferTime) {
                    $bufferedStart = $slotStart->copy()->subMinutes($bufferTime);
                    $bufferedEnd = $slotEndTime->copy()->addMinutes($bufferTime);

                    return $appointment->start_time->lt($bufferedEnd) && $appointment->end_time->gt($bufferedStart);
                });

                if (!$hasConflict) {
                    $availableSlots[] = [
                        'start' => $slotStart->format('H:i'),
                        'end' => $slotEndTime->format('H:i'),
                        'display' => $slotStart->format('g:i A') . ' - ' . $slotEndTime->format('g:i A'),
                    ];
                }

                $slotStart->addMinutes($slotDuration);
            }
        }

        return response()->json([
            'available' => count($availableSlots) > 0,
            'message' => count($availableSlots) > 0 ? 'Available slots found.' : 'No available slots for this day.',
            'slots' => $availableSlots
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        try {
            $validatedData = $request->validate([
                'doctor_id' => 'required|exists:users,id',
                'appointment_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'symptoms_complaint' => 'required|string|min:10',
                'appointment_mode' => 'required|in:in-clinic,telemedicine',
                'urgency_priority' => 'required|in:routine,urgent,emergency',
                'consent' => 'accepted',
            ]);

            // Combine date and time to create start_time and end_time
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['appointment_date'] . ' ' . $validatedData['start_time']);
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['appointment_date'] . ' ' . $validatedData['end_time']);

            // --- AVAILABILITY & CONFLICT CHECK ---
            $tempAppointment = new Appointment([
                'doctor_id' => $validatedData['doctor_id'],
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
            ]);

            // Check if doctor is available at this time
            if (!$tempAppointment->isWithinDoctorAvailability()) {
                throw ValidationException::withMessages([
                    'appointment_date' => 'The doctor is not available at this time. Please check their schedule and try again.'
                ]);
            }

            // Check for schedule conflicts (double-booking)
            if ($tempAppointment->hasScheduleConflict()) {
                throw ValidationException::withMessages([
                    'start_time' => 'This time slot is already booked. Please choose a different time.'
                ]);
            }
            // ---------------------------

            // Get or create patient record
            $patient = $user->patient;
            if (!$patient) {
                $patient = \App\Models\Patient::create([
                    'user_id' => $user->id,
                    'first_name' => $user->name,
                    'last_name' => 'N/A',
                    'date_of_birth' => '2000-01-01',
                    'gender' => 'Other',
                    'phone_number' => 'N/A',
                    'address' => 'N/A',
                    'city' => 'N/A',
                    'state' => 'N/A',
                    'zip_code' => 'N/A',
                    'country' => 'N/A',
                ]);
            }

            // Combine date and time to create start_time and end_time
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['appointment_date'] . ' ' . $validatedData['start_time']);
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['appointment_date'] . ' ' . $validatedData['end_time']);

            // Handle file upload
            $filePath = null;
            if ($request->hasFile('file_upload')) {
                $file = $request->file('file_upload');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('appointment_files', $fileName, 'public');
            }

            // Create appointment directly instead of API call
            $appointment = \App\Models\Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $validatedData['doctor_id'],
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'reason' => $validatedData['symptoms_complaint'] ?? '',
                'appointment_mode' => $validatedData['appointment_mode'],
                'urgency_priority' => $validatedData['urgency_priority'],
                'file_path' => $filePath,
                'consent' => true, // Consent is validated as 'accepted', so it's always true here
                'status' => 'pending',
            ]);

            // Prepare booking details for the modal
            $bookingDetails = [
                'doctorName' => \App\Models\User::find($validatedData['doctor_id'])->name ?? 'N/A',
                'date' => $startDateTime->format('F j, Y'),
                'time' => $startDateTime->format('h:i A'),
                'mode' => ucfirst($validatedData['appointment_mode']),
                'reason' => $validatedData['symptoms_complaint'] ?? 'N/A',
            ];

            // Notify all assistants of the new request
            $assistants = \App\Models\User::where('role', 'assistant')->get();
            foreach ($assistants as $assistant) {
                $assistant->notify(new \App\Notifications\NewAppointmentRequest($appointment));
            }

            return redirect()->route('patient.appointments.index')
                ->with(['success' => 'Appointment request submitted successfully.', 'bookingDetails' => $bookingDetails]);
        } catch (ValidationException $e) {
            \Log::error('Appointment Validation Error:', ['errors' => $e->errors(), 'input' => $request->all()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Appointment Creation Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Failed to book appointment. ' . $e->getMessage())->withInput();
        }
    }

    public function show(Appointment $appointment)
    {
        if (Auth::user()->id !== $appointment->patient->user_id) {
            return redirect()->route('patient.appointments.index')->with('error', 'Unauthorized access.');
        }

        return view('patient.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        if (Auth::user()->id !== $appointment->patient->user_id) {
            return redirect()->route('patient.appointments.index')->with('error', 'Unauthorized access.');
        }

        return view('patient.appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if (Auth::user()->id !== $appointment->patient->user_id) {
            return redirect()->route('patient.appointments.index')->with('error', 'Unauthorized access.');
        }

        try {
            $validatedData = $request->validate([
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'reason' => 'nullable|string',
                'reschedule_reason' => 'required|string|min:10',
            ]);

            $appointment->reschedules()->create([
                'old_start_time' => $appointment->start_time,
                'old_end_time' => $appointment->end_time,
                'new_start_time' => $validatedData['start_time'],
                'new_end_time' => $validatedData['end_time'],
                'reason' => $validatedData['reschedule_reason'],
                'rescheduled_by_id' => Auth::id(),
            ]);

            $appointment->update([
                'start_time' => $validatedData['start_time'],
                'end_time' => $validatedData['end_time'],
                'reason' => $validatedData['reason'] ?? $appointment->reason,
                'status' => 'pending',
            ]);

            return redirect()->route('patient.appointments.index')
                ->with('success', 'Appointment rescheduled successfully. Waiting for doctor\'s approval.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reschedule appointment. ' . $e->getMessage())->withInput();
        }
    }

    public function cancel(Appointment $appointment)
    {
        if (Auth::user()->id !== $appointment->patient->user_id) {
            return redirect()->route('patient.appointments.index')->with('error', 'Unauthorized access.');
        }

        try {
            $appointment->update(['status' => 'cancelled']);
            return redirect()->route('patient.appointments.index')->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to cancel appointment. ' . $e->getMessage());
        }
    }
}