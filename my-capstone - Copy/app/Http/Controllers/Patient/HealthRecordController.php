<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Consultation;
use App\Models\MedicalRecord;

class HealthRecordController extends Controller
{
    /**
     * Display the patient's health record summary.
     */
    public function index(): View
    {
        // Get the authenticated user's associated patient record
        $patient = Auth::user()->patient;

        if (!$patient) {
            abort(404, 'Patient record not found.');
        }

        // Get latest vitals
        $latestVitals = $patient->latestVitalSigns;

        // Get latest medical record for conditions, medications, and allergies
        $latestMedicalRecord = MedicalRecord::where('patient_id', $patient->id)
            ->latest()
            ->first();

        // Get active conditions
        $activeConditions = $latestMedicalRecord
            ? $latestMedicalRecord->medicalConditions()
                ->wherePivot('status', 'active')
                ->orderByPivot('is_pinned', 'desc')
                ->get()
            : collect();

        // Get medications
        $activeMedications = $latestMedicalRecord
            ? $latestMedicalRecord->medications
            : collect();

        // Get allergies
        $allergies = $latestMedicalRecord
            ? $latestMedicalRecord->allergies
            : collect();

        // Get surgical and hospital history
        $surgicalHistories = $latestMedicalRecord ? $latestMedicalRecord->surgicalHistories : collect();
        $hospitalizations = $latestMedicalRecord ? $latestMedicalRecord->hospitalizations : collect();

        // Get family and social history
        $familyHistories = $latestMedicalRecord ? $latestMedicalRecord->familyHistories : collect();
        $socialHistory = $latestMedicalRecord ? $latestMedicalRecord->socialHistories()->latest()->first() : null;

        // Get gynae history
        $gynaeHistory = $latestMedicalRecord ? $latestMedicalRecord->gynaeHistory : null;

        // Get completed consultation history (Timeline)
        // We eager load the doctor to show who attended them
        $consultations = Consultation::with('doctor')
            ->where('patient_id', $patient->id)
            ->where('status', 'completed')
            ->latest('completed_at')
            ->get();

        return view('patient.health-record.index', compact(
            'patient',
            'latestVitals',
            'activeConditions',
            'activeMedications',
            'allergies',
            'surgicalHistories',
            'hospitalizations',
            'familyHistories',
            'socialHistory',
            'gynaeHistory',
            'consultations'
        ));
    }

    /**
     * Download PDF of a specific consultation note.
     */
    public function downloadConsultationPdf(Consultation $consultation)
    {
        $patient = Auth::user()->patient;

        if (!$patient || $consultation->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access to this consultation record.');
        }

        // Only completed consultations can be accessed
        if ($consultation->status !== 'completed') {
            abort(404, 'Consultation record is not finalized.');
        }

        // Load relationships
        $consultation->load(['patient', 'doctor', 'appointment']);

        // Generate PDF using the doctor's consultation PDF layout
        $pdf = \PDF::loadView('doctor.consultations.pdf', compact('consultation'));

        $filename = 'consultation_note_' . $consultation->consultation_date->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
}
