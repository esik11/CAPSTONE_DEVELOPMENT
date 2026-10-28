<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\Consultation;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $status = $request->get('status');

        $appointments = Appointment::with(['patient.user', 'doctor'])
            ->whereDate('start_time', $date)
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('start_time', 'asc')
            ->get();

        // Get all doctors for the appointment form
        $doctors = User::where('role', 'doctor')->get();
        
        // Get all active patients for the appointment form
        $patients = Patient::where('status', 'active')->with('user')->get();

        // Get doctor availability for the selected date
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        $availabilities = \App\Models\DoctorAvailability::with('doctor')
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->orderBy('start_time')
            ->get()
            ->groupBy('doctor_id');

        // Get all pending and confirmed appointments to check for availability conflicts globally
        $allAppointments = Appointment::with(['patient.user', 'doctor'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->get();

        // Filter those that are OUTSIDE of doctor availability
        $conflicts = $allAppointments->filter(function($appointment) {
            return !$appointment->isWithinDoctorAvailability();
        });

        return view('assistant.appointments.index', compact('appointments', 'doctors', 'patients', 'date', 'status', 'availabilities', 'conflicts'));
    }



    public function approve(Appointment $appointment)
    {
        $appointment->update(['status' => 'confirmed']);

        // Send notification to patient
        $appointment->patient->user->notify(new \App\Notifications\AppointmentStatusUpdated($appointment, 'confirmed'));

        // Send notification to doctor
        if ($appointment->doctor) {
            $appointment->doctor->notify(new \App\Notifications\DoctorAppointmentUpdated($appointment, 'approved'));
        }

        return response()->json(['success' => true, 'message' => 'Appointment approved']);
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        // Send notification to patient
        $appointment->patient->user->notify(new \App\Notifications\AppointmentStatusUpdated($appointment, 'cancelled'));

        // Send notification to doctor
        if ($appointment->doctor) {
            $appointment->doctor->notify(new \App\Notifications\DoctorAppointmentUpdated($appointment, 'cancelled'));
        }

        return response()->json(['success' => true, 'message' => 'Appointment cancelled']);
    }

    public function reschedule(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        $appointment->update([
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'confirmed',
        ]);

        // Send notification to patient (we pass 'rescheduled' as a string so the notification text says rescheduled)
        $appointment->patient->user->notify(new \App\Notifications\AppointmentStatusUpdated($appointment, 'rescheduled'));

        // Send notification to doctor
        if ($appointment->doctor) {
            $appointment->doctor->notify(new \App\Notifications\DoctorAppointmentUpdated($appointment, 'rescheduled'));
        }

        return response()->json(['success' => true, 'message' => 'Appointment rescheduled']);
    }

    public function checkIn(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
            'checked_in_by' => auth()->id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Patient checked in successfully']);
    }

    public function triage(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor']);
        return view('assistant.appointments.triage', compact('appointment'));
    }

    public function storeTriage(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'temperature' => 'nullable|numeric|min:30|max:45',
            'blood_pressure' => 'nullable|string|max:20',
            'pulse_rate' => 'nullable|integer|min:30|max:250',
            'respiratory_rate' => 'nullable|integer|min:5|max:60',
            'weight' => 'nullable|numeric|min:1|max:500',
            'height' => 'nullable|numeric|min:20|max:300',
        ]);

        // Create the draft consultation with vital signs
        Consultation::create([
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'consultation_date' => now()->toDateString(),
            'consultation_time' => now()->toTimeString(),
            'status' => 'draft',
            'current_section' => 'examination', // Start at examination so doctor sees vitals immediately
            'documentation_mode' => 'template',
            'temperature' => $validated['temperature'],
            'blood_pressure' => $validated['blood_pressure'],
            'pulse_rate' => $validated['pulse_rate'],
            'respiratory_rate' => $validated['respiratory_rate'],
            'weight' => $validated['weight'],
            'height' => $validated['height'],
        ]);

        // Check in the appointment
        $appointment->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
            'checked_in_by' => auth()->id(),
        ]);

        return redirect()->route('assistant.appointments.index')
            ->with('success', 'Patient checked in and vital signs recorded successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'reason' => 'required|string',
            'appointment_mode' => 'required|in:walk-in,follow-up,online',
        ]);

        $appointment = Appointment::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'reason' => $validated['reason'],
            'appointment_mode' => $validated['appointment_mode'],
            'status' => 'confirmed', // Assistant-created appointments are auto-confirmed
        ]);

        return redirect()->route('assistant.appointments.index')
            ->with('success', 'Appointment created successfully');
    }
}
