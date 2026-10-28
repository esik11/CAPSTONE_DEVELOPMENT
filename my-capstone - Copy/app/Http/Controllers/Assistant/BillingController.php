<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\AuditLog;
use App\Notifications\ClinicNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    /**
     * Display a listing of billing records.
     */
    public function index(Request $request)
    {
        // 1. Pending Queue (pending or partial)
        $pendingQuery = Billing::with(['consultation.patient', 'consultation.doctor'])
            ->whereIn('payment_status', ['pending', 'partial']);

        // 2. Billing History (paid or waived)
        $historyQuery = Billing::with(['consultation.patient', 'consultation.doctor'])
            ->whereIn('payment_status', ['paid', 'waived']);

        // Apply Search Filter to both
        if ($request->filled('search')) {
            $search = $request->search;
            $filter = function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                  ->orWhereHas('consultation.patient', function ($pq) use ($search) {
                      $pq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            };
            $pendingQuery->where($filter);
            $historyQuery->where($filter);
        }

        // Apply Date Filter
        if ($request->filled('date')) {
            $date = $request->date;
            $pendingQuery->whereDate('billing_date', $date);
            $historyQuery->whereDate('billing_date', $date);
        }

        $pendingInvoices = $pendingQuery->latest('billing_date')->get();
        $historyInvoices = $historyQuery->latest('billing_date')->paginate(15);

        return view('assistant.billing.index', compact('pendingInvoices', 'historyInvoices'));
    }

    /**
     * Show billing summary/details.
     */
    public function show(Billing $billing)
    {
        $billing->load(['consultation.patient', 'consultation.doctor']);
        return view('assistant.billing.show', compact('billing'));
    }

    /**
     * Open payment processor form.
     */
    public function process(Billing $billing)
    {
        if ($billing->isPaid() || $billing->isWaived()) {
            return redirect()->route('assistant.billing.index')
                ->with('info', 'This invoice has already been settled.');
        }

        $billing->load(['consultation.patient', 'consultation.doctor']);
        return view('assistant.billing.process', compact('billing'));
    }

    /**
     * Record payment and complete the transaction.
     */
    public function pay(Request $request, Billing $billing)
    {
        if ($billing->isPaid() || $billing->isWaived()) {
            return redirect()->route('assistant.billing.index')
                ->with('info', 'This invoice has already been settled.');
        }

        // Validate
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,card,gcash,paymaya,bank_transfer',
            'amount_tendered' => 'required|numeric|min:' . $billing->total_amount,
            'notes' => 'nullable|string',
        ]);

        $oldValues = $billing->toArray();

        // Update payment details
        $billing->update([
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'paid',
            'notes' => $validated['notes'] ?? $billing->notes,
            'billing_date' => now(), // finalize date
        ]);

        // Dispatch notifications
        // 1. Patient Notification
        $patientUser = $billing->consultation->patient->user;
        if ($patientUser) {
            $patientUser->notify(new ClinicNotification(
                'Payment Confirmed',
                'Thank you! Your payment of ₱' . number_format($billing->total_amount, 2) . ' has been received and confirmed. Receipt: ' . $billing->receipt_number,
                'success'
            ));
        }

        // 2. Doctor Notification
        $doctorUser = $billing->consultation->doctor;
        if ($doctorUser) {
            $doctorUser->notify(new ClinicNotification(
                'Billing Settled',
                'Patient ' . $billing->consultation->patient->user->name . ' settled their pending bill of ₱' . number_format($billing->total_amount, 2) . ' at the front desk via ' . strtoupper($validated['payment_method']) . '.',
                'success'
            ));
        }

        // Flash beautiful notification!
        return redirect()->route('assistant.billing.index')
            ->with('success', 'Payment of ₱' . number_format($billing->total_amount, 2) . ' for ' . $billing->consultation->patient->first_name . ' ' . $billing->consultation->patient->last_name . ' was processed successfully! Official Receipt: ' . $billing->receipt_number);
    }

    /**
     * Download or stream PDF receipt.
     */
    public function receipt(Billing $billing)
    {
        $billing->load(['consultation.patient', 'consultation.doctor']);

        // Generate using same doctor's receipt template to keep design matching perfectly
        $pdf = \PDF::loadView('doctor.billing.receipt', compact('billing'));

        $filename = 'receipt_' . $billing->receipt_number . '.pdf';
        return $pdf->download($filename);
    }
}
