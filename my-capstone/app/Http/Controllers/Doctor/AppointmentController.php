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
                                ->latest()
                                ->get();

        return view('doctor.appointments.index', compact('appointments'));
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
}
