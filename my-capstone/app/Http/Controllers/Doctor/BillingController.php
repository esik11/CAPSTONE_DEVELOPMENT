<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Consultation;
use App\Models\User;
use App\Notifications\ClinicNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    /**
     * Show the billing form for a consultation
     */
    public function create(Consultation $consultation)
    {
        // Check authorization
        if ($consultation->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this consultation.');
        }

        // Check if billing already exists
        if ($consultation->billing) {
            return redirect()->route('doctor.billing.show', $consultation->billing)
                ->with('info', 'Billing already exists for this consultation.');
        }

        // Calculate consultation fee (same for all appointment types)
        $consultationFee = 500; // Standard consultation fee

        return view('doctor.billing.create', compact('consultation', 'consultationFee'));
    }

    /**
     * Store the billing record
     */
    public function store(Request $request, Consultation $consultation)
    {
        // Check authorization
        if ($consultation->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this consultation.');
        }

        // Check if payment is waived
        $isWaived = $request->has('waive_payment') && $request->waive_payment == '1';

        // Validate request
        $rules = [
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'nullable|string',
        ];

        if ($isWaived) {
            $rules['waive_reason'] = 'required|string';
        } else {
            $rules['payment_method'] = 'required|in:cash,card,gcash,paymaya,bank_transfer';
            $rules['payment_status'] = 'required|in:paid,pending,partial';
        }

        $validated = $request->validate($rules);

        // Parse items JSON
        $items = [];
        if (!empty($validated['items'])) {
            $additionalItems = json_decode($validated['items'], true);
        } else {
            $additionalItems = [];
        }

        // Build items array
        $consultationFee = 500;
        if ($consultation->appointment && $consultation->appointment->appointment_type === 'telemedicine') {
            $consultationFee = 400;
        }

        $items[] = [
            'description' => 'Consultation Fee (' . ($consultation->appointment && $consultation->appointment->appointment_type === 'telemedicine' ? 'Telemedicine' : 'Walk-in') . ')',
            'amount' => $consultationFee
        ];

        // Add additional items
        if (!empty($additionalItems)) {
            foreach ($additionalItems as $item) {
                $items[] = [
                    'description' => $item['description'],
                    'amount' => $item['amount']
                ];
            }
        }

        // Generate receipt number
        $receiptNumber = Billing::generateReceiptNumber();

        // Create billing record
        $billingData = [
            'consultation_id' => $consultation->id,
            'receipt_number' => $receiptNumber,
            'billing_date' => now(),
            'total_amount' => $validated['total_amount'],
            'items' => $items,
            'notes' => $validated['notes'] ?? null,
        ];

        if ($isWaived) {
            $billingData['is_waived'] = true;
            $billingData['waive_reason'] = $request->waive_reason;
            $billingData['payment_status'] = 'waived';
            $billingData['payment_method'] = null;
        } else {
            $billingData['is_waived'] = false;
            $billingData['payment_method'] = $validated['payment_method'];
            $billingData['payment_status'] = $validated['payment_status'];
        }

        $billing = Billing::create($billingData);

        // Trigger Notifications
        // 1. Patient Notification
        $patientUser = $consultation->patient->user;
        if ($patientUser) {
            if ($isWaived) {
                $patientUser->notify(new ClinicNotification(
                    'Consultation Fee Waived',
                    'Your consultation fee of ₱' . number_format($billing->total_amount, 2) . ' has been waived. Reason: ' . $billing->getWaiveReasonLabel(),
                    'success'
                ));
            } elseif ($billing->payment_status === 'paid') {
                $patientUser->notify(new ClinicNotification(
                    'Payment Confirmed',
                    'Thank you! Your upfront payment of ₱' . number_format($billing->total_amount, 2) . ' has been processed. Receipt: ' . $billing->receipt_number,
                    'success'
                ));
            } else {
                $patientUser->notify(new ClinicNotification(
                    'Invoice Pending',
                    'Your invoice of ₱' . number_format($billing->total_amount, 2) . ' is ready. Please settle payment at the lobby front desk.',
                    'warning'
                ));
            }
        }

        // 2. Assistant Notifications (only if not waived)
        if (!$isWaived) {
            $assistants = User::where('role', 'assistant')->get();
            foreach ($assistants as $assistant) {
                if ($billing->payment_status === 'paid') {
                    $assistant->notify(new ClinicNotification(
                        'Upfront Payment Settled',
                        'Patient ' . $consultation->patient->user->name . ' settled their bill of ₱' . number_format($billing->total_amount, 2) . ' upfront in consultation.',
                        'success'
                    ));
                } else {
                    $assistant->notify(new ClinicNotification(
                        'New Pending Invoice',
                        'Dr. ' . Auth::user()->last_name . ' sent a pending invoice of ₱' . number_format($billing->total_amount, 2) . ' for Patient ' . $consultation->patient->user->name,
                        'info'
                    ));
                }
            }
        }

        $message = $isWaived 
            ? 'Billing record created successfully! Payment has been waived.' 
            : 'Billing record created successfully!';

        return redirect()->route('doctor.billing.show', $billing)
            ->with('success', $message);
    }

    /**
     * Show billing summary
     */
    public function show(Billing $billing)
    {
        // Check authorization
        if ($billing->consultation->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this billing record.');
        }

        // Load relationships
        $billing->load(['consultation.patient', 'consultation.doctor']);

        return view('doctor.billing.show', compact('billing'));
    }

    /**
     * Generate and download PDF receipt
     */
    public function receipt(Billing $billing)
    {
        // Check authorization
        if ($billing->consultation->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this billing record.');
        }

        // Load relationships
        $billing->load(['consultation.patient', 'consultation.doctor']);

        // Generate PDF
        $pdf = \PDF::loadView('doctor.billing.receipt', compact('billing'));

        // Download PDF
        $filename = 'receipt_' . $billing->receipt_number . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * List all billing records
     */
    public function index(Request $request)
    {
        $query = Billing::with(['consultation.patient'])
            ->whereHas('consultation', function ($q) {
                $q->where('doctor_id', Auth::id());
            });

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                    ->orWhereHas('consultation.patient', function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Get paginated results
        $billings = $query->latest('billing_date')->paginate(15);

        return view('doctor.billing.index', compact('billings'));
    }
}
