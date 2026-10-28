<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of patient prescriptions.
     */
    public function index(): View
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            abort(404, 'Patient record not found.');
        }

        // Fetch completed consultations for the patient that contain prescriptions
        $consultations = Consultation::with(['doctor'])
            ->where('patient_id', $patient->id)
            ->where('status', 'completed')
            ->whereNotNull('prescriptions')
            ->latest('completed_at')
            ->get()
            ->filter(function ($consultation) {
                // Ensure prescriptions array is not empty
                return is_array($consultation->prescriptions) && count($consultation->prescriptions) > 0;
            });

        return view('patient.prescriptions.index', compact('consultations'));
    }

    /**
     * Download the official Rx prescription PDF for a consultation.
     */
    public function downloadPrescriptionPdf(Consultation $consultation)
    {
        $patient = Auth::user()->patient;

        if (!$patient || $consultation->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access to this prescription.');
        }

        if (empty($consultation->prescriptions) || !is_array($consultation->prescriptions)) {
            abort(404, 'No prescriptions found for this consultation.');
        }

        // Load relationships
        $consultation->load(['patient', 'doctor']);

        // Generate Rx PDF
        $pdf = \PDF::loadView('patient.prescriptions.pdf', compact('consultation'));

        $filename = 'rx_prescription_' . $consultation->consultation_date->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
}
