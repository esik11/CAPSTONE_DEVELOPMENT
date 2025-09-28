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
        $doctors = User::where('role', 'doctor')->get();
        $medicalConditions = MedicalCondition::all();

        return view('patient.appointments.create', compact('doctors', 'medicalConditions'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        try {
            $validatedData = $request->validate([
                'doctor_id' => 'required|exists:users,id',
                'appointment_date' => 'required|date',
                'appointment_time' => 'required|date_format:H:i',
                'symptoms_complaint' => 'nullable|string',
                'appointment_mode' => 'required|in:online,walk-in,follow-up',
                'urgency_priority' => 'required|in:routine,urgent,emergency',
                'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
                'consent' => 'accepted',
            ]);

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
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['appointment_date'] . ' ' . $validatedData['appointment_time']);
            $endDateTime = $startDateTime->copy()->addMinutes(30);

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

            return redirect()->route('patient.appointments.index')
                ->with(['success' => 'Appointment request submitted successfully.', 'bookingDetails' => $bookingDetails]);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
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

            return redirect()->route('patient.appointments.show', $appointment->id)
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