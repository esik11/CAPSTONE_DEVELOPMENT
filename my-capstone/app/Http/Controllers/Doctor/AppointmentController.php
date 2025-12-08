<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $doctor = Auth::user();
        $appointments = Appointment::where('doctor_id', $doctor->id)
                                ->with(['patient.user', 'patient.medicalRecords'])
                                ->orderBy('start_time', 'asc')
                                ->get();

        return view('doctor.appointments.index-new', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        // Ensure the doctor owns this appointment
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        $appointment->load(['patient.user', 'patient.medicalRecords', 'patient.allergies', 'patient.medications', 'patient.surgicalHistories', 'patient.hospitalizations', 'patient.familyHistories', 'patient.socialHistories']);

        return response()->json($appointment);
    }

    public function approve(Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        $appointment->update(['status' => 'confirmed']);

        // Send notification to patient
        $appointment->patient->user->notify(new \App\Notifications\AppointmentStatusUpdated($appointment, 'confirmed'));

        return response()->json(['success' => true, 'message' => 'Appointment approved']);
    }

    public function decline(Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        $appointment->update(['status' => 'declined']);

        // Send notification to patient
        $appointment->patient->user->notify(new \App\Notifications\AppointmentStatusUpdated($appointment, 'declined'));

        return response()->json(['success' => true, 'message' => 'Appointment declined']);
    }

    public function checkIn(Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        $appointment->update([
            'status' => 'checked_in',
            'checked_in_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Patient checked in']);
    }

    public function startConsultation(Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        // Check if consultation already exists
        $consultation = \App\Models\Consultation::where('appointment_id', $appointment->id)->first();

        if (!$consultation) {
            // Create new consultation
            $consultation = \App\Models\Consultation::create([
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'appointment_id' => $appointment->id,
                'consultation_date' => now()->toDateString(),
                'consultation_time' => now()->toTimeString(),
                'status' => 'in_progress',
                'current_section' => 'symptoms',
            ]);

            // Update appointment status
            $appointment->update([
                'status' => 'in_progress',
                'consultation_started_at' => now()
            ]);
        }

        return redirect()->route('consultations.show', $consultation->id);
    }
}
