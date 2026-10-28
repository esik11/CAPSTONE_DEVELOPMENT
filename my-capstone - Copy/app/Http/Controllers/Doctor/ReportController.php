<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Billing;
use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $doctorId = Auth::id();

        // Summary Statistics
        $totalConsultations = Consultation::where('doctor_id', $doctorId)
            ->where('status', 'completed')
            ->count();

        $totalRevenue = Billing::whereHas('consultation', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // Count prescriptions from consultations
        $consultationsWithPrescriptions = Consultation::where('doctor_id', $doctorId)
            ->where('status', 'completed')
            ->whereNotNull('prescriptions')
            ->get();
        
        $totalPrescriptions = 0;
        foreach ($consultationsWithPrescriptions as $consultation) {
            if (is_array($consultation->prescriptions)) {
                $totalPrescriptions += count($consultation->prescriptions);
            }
        }

        $activePatients = Patient::where('status', 'active')
            ->whereHas('consultations', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->count();

        $inactivePatients = Patient::where('status', 'inactive')
            ->whereHas('consultations', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->count();

        return view('doctor.reports.index', compact(
            'totalConsultations',
            'totalRevenue',
            'totalPrescriptions',
            'activePatients',
            'inactivePatients'
        ));
    }

    public function consultations(Request $request)
    {
        $doctorId = Auth::id();
        
        $query = Consultation::where('doctor_id', $doctorId)
            ->with(['patient', 'appointment'])
            ->where('status', 'completed');

        // Date filters
        if ($request->filled('date_from')) {
            $query->whereDate('consultation_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('consultation_date', '<=', $request->date_to);
        }

        $consultations = $query->latest('consultation_date')->paginate(20);

        if ($request->has('export') && $request->export === 'pdf') {
            return $this->exportConsultationsPdf($consultations, $request);
        }

        return view('doctor.reports.consultations', compact('consultations'));
    }

    public function billing(Request $request)
    {
        $doctorId = Auth::id();
        
        $query = Billing::whereHas('consultation', function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })
            ->with(['consultation.patient']);

        // Date filters
        if ($request->filled('date_from')) {
            $query->whereDate('billing_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('billing_date', '<=', $request->date_to);
        }

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $billings = $query->latest('billing_date')->paginate(20);

        // Calculate totals
        $totalAmount = $query->sum('total_amount');
        $paidAmount = (clone $query)->where('payment_status', 'paid')->sum('total_amount');
        $pendingAmount = (clone $query)->where('payment_status', 'pending')->sum('total_amount');

        if ($request->has('export') && $request->export === 'pdf') {
            return $this->exportBillingPdf($billings, $totalAmount, $paidAmount, $pendingAmount, $request);
        }

        return view('doctor.reports.billing', compact('billings', 'totalAmount', 'paidAmount', 'pendingAmount'));
    }

    public function prescriptions(Request $request)
    {
        $doctorId = Auth::id();
        
        $query = Consultation::where('doctor_id', $doctorId)
            ->with(['patient'])
            ->where('status', 'completed')
            ->whereNotNull('prescriptions');

        // Date filters
        if ($request->filled('date_from')) {
            $query->whereDate('consultation_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('consultation_date', '<=', $request->date_to);
        }

        $consultations = $query->latest('consultation_date')->paginate(20);

        if ($request->has('export') && $request->export === 'pdf') {
            return $this->exportPrescriptionsPdf($consultations, $request);
        }

        return view('doctor.reports.prescriptions', compact('consultations'));
    }

    public function patients(Request $request)
    {
        $doctorId = Auth::id();
        
        $query = Patient::whereHas('consultations', function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })
            ->withCount(['consultations' => function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId)->where('status', 'completed');
            }]);

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $patients = $query->latest('created_at')->paginate(20);

        if ($request->has('export') && $request->export === 'pdf') {
            return $this->exportPatientsPdf($patients, $request);
        }

        return view('doctor.reports.patients', compact('patients'));
    }

    private function exportConsultationsPdf($consultations, $request)
    {
        $pdf = Pdf::loadView('doctor.reports.pdf.consultations', [
            'consultations' => $consultations,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
        ]);

        return $pdf->download('consultations-report-' . now()->format('Y-m-d') . '.pdf');
    }

    private function exportBillingPdf($billings, $totalAmount, $paidAmount, $pendingAmount, $request)
    {
        $pdf = Pdf::loadView('doctor.reports.pdf.billing', [
            'billings' => $billings,
            'totalAmount' => $totalAmount,
            'paidAmount' => $paidAmount,
            'pendingAmount' => $pendingAmount,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
        ]);

        return $pdf->download('billing-report-' . now()->format('Y-m-d') . '.pdf');
    }

    private function exportPrescriptionsPdf($consultations, $request)
    {
        $pdf = Pdf::loadView('doctor.reports.pdf.prescriptions', [
            'consultations' => $consultations,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
        ]);

        return $pdf->download('prescriptions-report-' . now()->format('Y-m-d') . '.pdf');
    }

    private function exportPatientsPdf($patients, $request)
    {
        $pdf = Pdf::loadView('doctor.reports.pdf.patients', [
            'patients' => $patients,
            'status' => $request->status,
        ]);

        return $pdf->download('patients-report-' . now()->format('Y-m-d') . '.pdf');
    }
}
