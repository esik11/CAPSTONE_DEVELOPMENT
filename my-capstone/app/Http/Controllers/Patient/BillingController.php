<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    /**
     * Display a listing of the patient's billing history.
     */
    public function index(): View
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            abort(404, 'Patient record not found.');
        }

        // Fetch all billing records linked to consultations for this patient
        $billings = Billing::with(['consultation.doctor'])
            ->whereHas('consultation', function ($query) use ($patient) {
                $query->where('patient_id', $patient->id);
            })
            ->latest('billing_date')
            ->get();

        return view('patient.billing.index', compact('billings'));
    }

    /**
     * Download PDF receipt for a specific billing record.
     */
    public function downloadReceipt(Billing $billing)
    {
        $patient = Auth::user()->patient;

        if (!$patient || $billing->consultation->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access to this receipt.');
        }

        // Load relationships
        $billing->load(['consultation.patient', 'consultation.doctor']);

        // Generate PDF using the doctor's receipt view (keeps design uniform)
        $pdf = \PDF::loadView('doctor.billing.receipt', compact('billing'));

        $filename = 'receipt_' . $billing->receipt_number . '.pdf';
        return $pdf->download($filename);
    }
}
