<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consultation Summary - {{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }
        
        .header {
            background-color: #1f2937;
            color: white;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0 0 0;
            font-size: 9px;
            color: #d1d5db;
        }
        
        .consultation-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .consultation-table th,
        .consultation-table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        
        .consultation-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
            font-size: 9px;
        }
        
        .consultation-table td {
            color: #1f2937;
            font-size: 9px;
        }
        
        .section-header {
            background-color: #1f2937;
            color: white;
            font-weight: 700;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 8px;
        }
        
        .subsection-header {
            background-color: #e5e7eb;
            font-weight: 600;
            color: #1f2937;
        }
        
        .vital-signs-grid {
            display: table;
            width: 100%;
            margin: 5px 0;
        }
        
        .vital-sign-item {
            display: table-cell;
            text-align: center;
            padding: 5px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        
        .vital-label {
            display: block;
            font-size: 8px;
            color: #6b7280;
            margin-bottom: 2px;
        }
        
        .vital-value {
            display: block;
            font-size: 10px;
            font-weight: 600;
            color: #111827;
        }
        
        .diagnosis-item {
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .diagnosis-item:last-child {
            border-bottom: none;
        }
        
        .diagnosis-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 2px;
        }
        
        .diagnosis-code {
            font-size: 8px;
            color: #6b7280;
        }
        
        .primary-badge {
            display: inline-block;
            background: #a78bfa;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: 600;
            margin-left: 5px;
        }
        
        .prescription-item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .prescription-item:last-child {
            border-bottom: none;
        }
        
        .prescription-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        
        .prescription-name {
            font-weight: 600;
            color: #1f2937;
        }
        
        .prescription-qty {
            background: #fed7aa;
            color: #9a3412;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 600;
        }
        
        .prescription-details {
            font-size: 8px;
            color: #4b5563;
            line-height: 1.4;
        }
        
        .complaint-tag {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 8px;
            margin-right: 3px;
            margin-bottom: 3px;
        }
        
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    @php
        $doctorName = $consultation->doctor->name;
        if (stripos($doctorName, 'dr. ') === 0) {
            $doctorName = substr($doctorName, 4);
        } elseif (stripos($doctorName, 'dr.') === 0) {
            $doctorName = substr($doctorName, 3);
        }
    @endphp

    <!-- Header -->
    <div class="header">
        <h1>CONSULTATION NOTE</h1>
        <p>{{ config('app.name', 'Medical Clinic') }}</p>
    </div>

    <!-- Consultation Table -->
    <table class="consultation-table">
        <!-- Patient Information -->
        <tr>
            <th colspan="4" class="section-header">Patient Information</th>
        </tr>
        <tr>
            <th style="width: 25%;">Name</th>
            <td style="width: 25%;">{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</td>
            <th style="width: 25%;">Date</th>
            <td style="width: 25%;">{{ $consultation->consultation_date->format('F d, Y') }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ $consultation->patient->date_of_birth ? \Carbon\Carbon::parse($consultation->patient->date_of_birth)->format('F d, Y') : 'Not specified' }}</td>
            <th>Patient ID</th>
            <td>{{ $consultation->patient->id }}</td>
        </tr>
        <tr>
            <th>Age / Gender</th>
            <td>{{ $consultation->patient->age }} years / {{ $consultation->patient->gender }}</td>
            <th>Time</th>
            <td>{{ $consultation->consultation_time ? $consultation->consultation_time->format('h:i A') : 'Not specified' }}</td>
        </tr>
        <tr>
            <th>Consulting Provider</th>
            <td colspan="3">Dr. {{ $doctorName }}</td>
        </tr>

        <!-- Chief Complaint & History -->
        <tr>
            <th colspan="4" class="section-header">Chief Complaint & History of Present Illness</th>
        </tr>
        @if($consultation->selected_complaints && count($consultation->selected_complaints) > 0)
        <tr>
            <th>Chief Complaints</th>
            <td colspan="3">
                @foreach($consultation->selected_complaints as $complaint)
                    <span class="complaint-tag">{{ $complaint }}</span>
                @endforeach
            </td>
        </tr>
        @endif
        @if($consultation->symptom_onset || $consultation->symptom_duration)
        <tr>
            <th>Onset / Duration</th>
            <td colspan="3">
                @if($consultation->symptom_onset)
                    <strong>Onset:</strong> {{ $consultation->symptom_onset }}
                @endif
                @if($consultation->symptom_duration)
                    @if($consultation->symptom_onset) | @endif
                    <strong>Duration:</strong> {{ $consultation->symptom_duration }} {{ $consultation->symptom_duration_unit }}
                @endif
            </td>
        </tr>
        @endif
        <tr>
            <th>History of Present Illness</th>
            <td colspan="3" style="white-space: pre-line;">{{ $consultation->symptom_notes_auto ?? $consultation->symptom_notes_manual ?? 'No symptoms documented' }}</td>
        </tr>

        <!-- Physical Examination -->
        <tr>
            <th colspan="4" class="section-header">Physical Examination</th>
        </tr>
        @if($consultation->temperature || $consultation->pulse_rate || $consultation->blood_pressure || $consultation->respiratory_rate || $consultation->spo2 || $consultation->weight)
        <tr>
            <th colspan="4" class="subsection-header">Vital Signs</th>
        </tr>
        <tr>
            <td colspan="4">
                <div class="vital-signs-grid">
                    @if($consultation->temperature)
                        <div class="vital-sign-item">
                            <span class="vital-label">Temperature</span>
                            <span class="vital-value">{{ $consultation->temperature }}°C</span>
                        </div>
                    @endif
                    @if($consultation->pulse_rate)
                        <div class="vital-sign-item">
                            <span class="vital-label">Pulse Rate</span>
                            <span class="vital-value">{{ $consultation->pulse_rate }} bpm</span>
                        </div>
                    @endif
                    @if($consultation->blood_pressure)
                        <div class="vital-sign-item">
                            <span class="vital-label">Blood Pressure</span>
                            <span class="vital-value">{{ $consultation->blood_pressure }}</span>
                        </div>
                    @endif
                    @if($consultation->respiratory_rate)
                        <div class="vital-sign-item">
                            <span class="vital-label">Resp. Rate</span>
                            <span class="vital-value">{{ $consultation->respiratory_rate }}/min</span>
                        </div>
                    @endif
                    @if($consultation->spo2)
                        <div class="vital-sign-item">
                            <span class="vital-label">SpO2</span>
                            <span class="vital-value">{{ $consultation->spo2 }}%</span>
                        </div>
                    @endif
                    @if($consultation->weight)
                        <div class="vital-sign-item">
                            <span class="vital-label">Weight</span>
                            <span class="vital-value">{{ $consultation->weight }} kg</span>
                        </div>
                    @endif
                </div>
            </td>
        </tr>
        @endif
        @if($consultation->general_appearance)
        <tr>
            <th>General Appearance</th>
            <td colspan="3">{{ $consultation->general_appearance }}</td>
        </tr>
        @endif
        @if($consultation->examination_notes)
        <tr>
            <th>Examination Findings</th>
            <td colspan="3" style="white-space: pre-line;">{{ $consultation->examination_notes }}</td>
        </tr>
        @endif

        <!-- Assessment & Diagnosis -->
        <tr>
            <th colspan="4" class="section-header">Assessment & Diagnosis</th>
        </tr>
        @if($consultation->diagnoses && count($consultation->diagnoses) > 0)
        <tr>
            <th>Diagnoses</th>
            <td colspan="3">
                @foreach($consultation->diagnoses as $index => $diagnosis)
                    <div class="diagnosis-item">
                        <div class="diagnosis-name">
                            {{ $index + 1 }}. {{ $diagnosis['description'] }}
                            @if($diagnosis['is_primary'])
                                <span class="primary-badge">PRIMARY</span>
                            @endif
                        </div>
                        <div class="diagnosis-code">ICD-10: {{ $diagnosis['code'] }}</div>
                    </div>
                @endforeach
            </td>
        </tr>
        @endif
        @if($consultation->diagnosis_notes)
        <tr>
            <th>Clinical Notes</th>
            <td colspan="3" style="white-space: pre-line;">{{ $consultation->diagnosis_notes }}</td>
        </tr>
        @endif

        <!-- Treatment Plan & Recommendations -->
        <tr>
            <th colspan="4" class="section-header">Treatment Plan & Recommendations</th>
        </tr>
        @if($consultation->prescriptions && count($consultation->prescriptions) > 0)
        <tr>
            <th>Prescriptions</th>
            <td colspan="3">
                @foreach($consultation->prescriptions as $index => $prescription)
                    <div class="prescription-item">
                        <div style="display: table; width: 100%;">
                            <div style="display: table-cell; width: 80%;">
                                <div class="prescription-name">{{ $index + 1 }}. {{ $prescription['medicine_name'] }} {{ $prescription['strength'] }}</div>
                            </div>
                            <div style="display: table-cell; width: 20%; text-align: right;">
                                <span class="prescription-qty">Qty: {{ $prescription['quantity'] }}</span>
                            </div>
                        </div>
                        <div class="prescription-details">
                            <strong>Dosage:</strong> {{ $prescription['dosage'] }}<br>
                            <strong>Duration:</strong> {{ $prescription['duration'] }}<br>
                            <strong>Instructions:</strong> {{ $prescription['instructions'] }}
                            @if(!empty($prescription['additional_instructions']))
                                <br><em>{{ $prescription['additional_instructions'] }}</em>
                            @endif
                        </div>
                    </div>
                @endforeach
            </td>
        </tr>
        @endif
        @if($consultation->treatment_plan)
        <tr>
            <th>Treatment Plan</th>
            <td colspan="3" style="white-space: pre-line;">{{ $consultation->treatment_plan }}</td>
        </tr>
        @endif
        @if($consultation->patient_education)
        <tr>
            <th>Patient Education</th>
            <td colspan="3" style="white-space: pre-line;">{{ $consultation->patient_education }}</td>
        </tr>
        @endif
        @if($consultation->followup_instructions)
        <tr>
            <th>Follow-up Instructions</th>
            <td colspan="3" style="white-space: pre-line;">{{ $consultation->followup_instructions }}</td>
        </tr>
        @endif

        <!-- Signature -->
        <tr>
            <th colspan="4" class="section-header">Physician Signature</th>
        </tr>
        <tr>
            <th>Signature</th>
            <td>Dr. {{ $doctorName }}</td>
            <th>Date</th>
            <td>{{ now()->format('F d, Y h:i A') }}</td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>This is a computer-generated document from {{ config('app.name', 'Medical Clinic') }}</p>
        <p>Generated on {{ now()->format('F d, Y h:i A') }} | Consultation ID: #{{ $consultation->id }}</p>
    </div>
</body>
</html>
