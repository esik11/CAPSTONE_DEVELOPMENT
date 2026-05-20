<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $billing->receipt_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #1f2937;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .receipt-info {
            margin-bottom: 20px;
        }
        
        .receipt-info table {
            width: 100%;
        }
        
        .receipt-info td {
            padding: 5px 0;
        }
        
        .receipt-info .label {
            font-weight: bold;
            width: 150px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .items-table th {
            background-color: #f3f4f6;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #333;
            font-weight: bold;
        }
        
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .items-table .amount {
            text-align: right;
        }
        
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        
        .total-row {
            display: flex;
            justify-content: flex-end;
            padding: 10px 0;
        }
        
        .total-row.grand-total {
            border-top: 2px solid #333;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            padding-top: 15px;
        }
        
        .total-label {
            width: 150px;
            text-align: right;
            padding-right: 20px;
        }
        
        .total-amount {
            width: 120px;
            text-align: right;
        }
        
        .payment-info {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }
        
        .payment-info h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        
        .payment-info p {
            margin: 5px 0;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 11px;
        }
        
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    @php
        $doctorName = $billing->consultation->doctor->name;
        if (stripos($doctorName, 'dr. ') === 0) {
            $doctorName = substr($doctorName, 4);
        } elseif (stripos($doctorName, 'dr.') === 0) {
            $doctorName = substr($doctorName, 3);
        }
    @endphp

    <!-- Header -->
    <div class="header">
        <h1>{{ config('app.name', 'SalamatDoc') }}</h1>
        <p>Official Receipt</p>
        <p style="font-size: 10px; margin-top: 10px;">
            {{ $billing->consultation->doctor->clinic_address ?? 'Family Clinic & Diagnostic Center' }}<br>
            Contact: {{ $billing->consultation->doctor->contact_number ?? '+63 (02) 888-0000' }} | Email: {{ $billing->consultation->doctor->email }}
        </p>
    </div>

    <!-- Receipt Information -->
    <div class="receipt-info">
        <table>
            <tr>
                <td class="label">Receipt Number:</td>
                <td><strong>{{ $billing->receipt_number }}</strong></td>
                <td class="label" style="text-align: right;">Date:</td>
                <td style="text-align: right;">{{ $billing->billing_date->format('F d, Y') }}</td>
            </tr>
            <tr>
                <td class="label">Patient Name:</td>
                <td colspan="3">{{ $billing->consultation->patient->first_name }} {{ $billing->consultation->patient->last_name }}</td>
            </tr>
            <tr>
                <td class="label">Doctor:</td>
                <td colspan="3">Dr. {{ $doctorName }}</td>
            </tr>
            <tr>
                <td class="label">Consultation Date:</td>
                <td colspan="3">{{ $billing->consultation->consultation_date->format('F d, Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 70%;">Description</th>
                <th style="width: 30%;" class="amount">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billing->items as $item)
                <tr>
                    <td>{{ $item['description'] }}</td>
                    <td class="amount"><span style="font-family: DejaVu Sans, sans-serif;">&#8369;</span>{{ number_format($item['amount'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total Section -->
    <div class="total-section">
        <div class="total-row grand-total">
            <div class="total-label">TOTAL AMOUNT:</div>
            <div class="total-amount"><span style="font-family: DejaVu Sans, sans-serif;">&#8369;</span>{{ number_format($billing->total_amount, 2) }}</div>
        </div>
    </div>

    <!-- Payment Information -->
    <div class="payment-info">
        <h3>Payment Information</h3>
        <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $billing->payment_method)) }}</p>
        <p><strong>Payment Status:</strong> {{ ucfirst($billing->payment_status) }}</p>
        @if($billing->notes)
            <p><strong>Notes:</strong> {{ $billing->notes }}</p>
        @endif
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">
                Patient Signature
            </div>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                <strong>Dr. {{ $doctorName }}</strong><br>
                <span style="font-size: 8px; color: #666; text-transform: uppercase;">
                    {{ $billing->consultation->doctor->specialization ?? 'Attending Physician' }}
                </span><br>
                @if($billing->consultation->doctor->license_number)
                    <span style="font-size: 7px; color: #999;">PRC No: {{ $billing->consultation->doctor->license_number }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>This is a computer-generated receipt and is valid without signature.</p>
        <p>Thank you for your payment!</p>
        <p style="margin-top: 10px;">Generated on {{ now()->format('F d, Y h:i A') }}</p>
    </div>
</body>
</html>
