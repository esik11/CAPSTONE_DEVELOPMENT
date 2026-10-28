<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription - {{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</title>
    <style>
        @page {
            size: A5 portrait;
            margin: 12mm 10mm 10mm 10mm;
        }
        
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            line-height: 1.5;
            color: #2d3748;
            margin: 0;
            padding: 0;
        }
        
        /* Clinic Header Styling */
        .clinic-header {
            text-align: center;
            border-bottom: 2px solid #059669;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        
        .clinic-header h1 {
            margin: 0;
            font-family: 'Georgia', serif;
            font-size: 18px;
            color: #059669;
            font-weight: bold;
            letter-spacing: 0.2px;
        }
        
        .clinic-header h2 {
            margin: 3px 0 0 0;
            font-size: 11px;
            color: #4a5568;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .clinic-header p {
            margin: 4px 0 0 0;
            font-size: 8px;
            color: #718096;
            line-height: 1.3;
        }
        
        /* Patient Details Grid */
        .patient-details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .patient-details-table td {
            padding: 5px 0;
            font-size: 10px;
            color: #2d3748;
            border-bottom: 1px solid #edf2f7;
        }
        
        .patient-details-table td.label {
            font-weight: bold;
            color: #718096;
            width: 12%;
        }
        
        .patient-details-table td.value {
            color: #1a202c;
            font-weight: 500;
        }
        
        .patient-details-table td.value-strong {
            color: #1a202c;
            font-weight: bold;
        }
        
        /* Rx Container */
        .rx-body-container {
            min-height: 220px;
            margin-top: 10px;
        }
        
        /* Bulletproof Rx symbol styled to render perfectly in dompdf without unicode issues */
        .rx-symbol-box {
            margin-bottom: 15px;
        }
        
        .rx-symbol {
            font-family: 'Georgia', serif;
            font-size: 32px;
            font-weight: bold;
            color: #059669;
            font-style: italic;
            line-height: 1;
        }
        
        .rx-subscript {
            font-size: 18px;
            font-style: normal;
            margin-left: -4px;
            vertical-align: baseline;
            position: relative;
            bottom: -2px;
        }
        
        /* Medications list styling */
        .medication-list {
            width: 100%;
            margin-top: 5px;
        }
        
        .medication-card {
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #e2e8f0;
        }
        
        .medication-card:last-child {
            border-bottom: none;
        }
        
        .med-row {
            width: 100%;
            margin-bottom: 4px;
        }
        
        .med-name {
            font-weight: bold;
            font-size: 11px;
            color: #1a202c;
            display: inline-block;
            width: 75%;
        }
        
        .med-qty {
            font-weight: bold;
            color: #059669;
            display: inline-block;
            width: 23%;
            text-align: right;
            font-size: 10px;
        }
        
        .med-instructions {
            font-size: 9px;
            color: #4a5568;
            padding-left: 12px;
            line-height: 1.4;
        }
        
        .med-notes {
            font-size: 8px;
            color: #718096;
            margin-top: 3px;
            padding-left: 12px;
            font-style: italic;
        }
        
        /* Doctor Signature Footer */
        .footer-signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        
        .footer-signature-table td {
            vertical-align: bottom;
        }
        
        .clinic-stamp-td {
            width: 50%;
            font-size: 8px;
            color: #a0aec0;
        }
        
        .doctor-signature-td {
            width: 50%;
            text-align: right;
        }
        
        .signature-line-box {
            border-top: 1.5px solid #4a5568;
            width: 160px;
            display: inline-block;
            margin-top: 35px;
            padding-top: 5px;
            text-align: center;
        }
        
        .doctor-name-print {
            font-family: 'Georgia', serif;
            font-weight: bold;
            font-size: 11px;
            color: #1a202c;
        }
        
        .doctor-spec-print {
            font-size: 8px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-top: 1px;
        }
        
        .doctor-credentials-print {
            font-size: 8px;
            color: #718096;
            margin-top: 3px;
            line-height: 1.3;
        }
        
        /* Document footer */
        .system-footer {
            margin-top: 35px;
            border-top: 1px solid #edf2f7;
            padding-top: 8px;
            text-align: center;
            font-size: 8px;
            color: #a0aec0;
        }
    </style>
</head>
<body>
    @php
        $doctorName = $consultation->doctor->name;
        // Clean prefix "Dr." to avoid double prefixing
        if (stripos($doctorName, 'dr. ') === 0) {
            $doctorName = substr($doctorName, 4);
        } elseif (stripos($doctorName, 'dr.') === 0) {
            $doctorName = substr($doctorName, 3);
        }
    @endphp

    <!-- Clinic / Doctor Header -->
    <div class="clinic-header">
        <h1>Dr. {{ $doctorName }}</h1>
        <h2>{{ $consultation->doctor->specialization ?? 'General Physician' }}</h2>
        <p>
            {{ $consultation->doctor->clinic_address ?? 'Family Clinic & Diagnostic Center' }}<br>
            Contact: {{ $consultation->doctor->contact_number ?? '+63 912 345 6789' }} | Email: {{ $consultation->doctor->email }}
        </p>
    </div>

    <!-- Patient Details Section -->
    <table class="patient-details-table">
        <tr>
            <td class="label">Patient:</td>
            <td class="value-strong" style="width: 50%;">{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</td>
            <td class="label" style="width: 10%; text-align: right; padding-right: 8px;">Date:</td>
            <td class="value" style="width: 28%; text-align: right;">{{ $consultation->consultation_date->format('F d, Y') }}</td>
        </tr>
        <tr>
            <td class="label">Age/Sex:</td>
            <td class="value">{{ $consultation->patient->age }} yrs / {{ $consultation->patient->gender }}</td>
            <td class="label" style="text-align: right; padding-right: 8px;">Ref No:</td>
            <td class="value" style="text-align: right;">#{{ $consultation->id }}</td>
        </tr>
    </table>

    <!-- Rx Body Container -->
    <div class="rx-body-container">
        <!-- Elegant CSS-styled Rx symbol -->
        <div class="rx-symbol-box">
            <span class="rx-symbol">R<sub class="rx-subscript">x</sub></span>
        </div>
        
        <!-- Medication Prescription Cards -->
        <div class="medication-list">
            @foreach($consultation->prescriptions as $index => $prescription)
                <div class="medication-card">
                    <div class="med-row">
                        <span class="med-name">
                            {{ $index + 1 }}. {{ $prescription['medicine_name'] }}
                            @if(!empty($prescription['strength']))
                                {{ $prescription['strength'] }}
                            @endif
                            @if(!empty($prescription['form']))
                                <span style="font-weight: normal; color: #718096; font-size: 8px;">({{ $prescription['form'] }})</span>
                            @endif
                        </span>
                        <span class="med-qty">Dispense: #{{ $prescription['quantity'] }}</span>
                    </div>
                    <div class="med-instructions">
                        <strong>Sig:</strong> {{ $prescription['dosage'] }} &bull; {{ $prescription['duration'] }} &bull; {{ $prescription['instructions'] }}
                    </div>
                    @if(!empty($prescription['additional_instructions']))
                        <div class="med-notes">
                            * {{ $prescription['additional_instructions'] }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Doctor Signature & License details -->
    <table class="footer-signature-table">
        <tr>
            <td class="clinic-stamp-td">
                <span style="font-style: italic;">Electronic Prescription Statement</span><br>
                Valid under clinic registry #{{ $consultation->id }}.
            </td>
            <td class="doctor-signature-td">
                <div class="signature-line-box">
                    <span class="doctor-name-print">Dr. {{ $doctorName }}</span>
                    <div class="doctor-spec-print">{{ $consultation->doctor->specialization ?? 'Attending Physician' }}</div>
                </div>
                <div class="doctor-credentials-print">
                    PRC License No: {{ $consultation->doctor->license_number ?? '__________' }}<br>
                    PTR License No: {{ $consultation->doctor->ptr_number ?? '__________' }}
                </div>
            </td>
        </tr>
    </table>

    <!-- System Footer -->
    <div class="system-footer">
        <p>This document is a certified electronic prescription generated by {{ config('app.name', 'SalamatDoc') }}.</p>
        <p>Generated on {{ now()->format('F d, Y h:i A') }}</p>
    </div>
</body>
</html>
