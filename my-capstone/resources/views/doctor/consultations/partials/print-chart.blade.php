<!-- PATIENT HEADER (ONE LINE) -->
<div style="border: 2px solid #000; padding: 4pt 8pt; margin-bottom: 3pt; font-family: Arial, sans-serif;">
    <span style="font-size: 11pt; font-weight: bold;">
        {{ strtoupper($consultation->patient->last_name) }}, {{ strtoupper($consultation->patient->first_name) }} {{ $consultation->patient->middle_name ? strtoupper(substr($consultation->patient->middle_name, 0, 1)).'.' : '' }}
    </span>
    <span style="font-size: 9pt; margin-left: 8pt;">
        {{ $consultation->patient->age }}yo {{ ucfirst(substr($consultation->patient->gender, 0, 1)) }}ale |
        DOB: {{ $consultation->patient->date_of_birth ? $consultation->patient->date_of_birth->format('m/d/Y') : 'N/A' }} |
        MRN: {{ $consultation->patient->patient_id }} |
        Date: {{ $consultation->consultation_date->format('m/d/Y') }}
    </span>
</div>

<!-- TWO-COLUMN LAYOUT -->
<table style="width: 100%; border-collapse: collapse; font-size: 9pt; font-family: Arial, sans-serif; min-height: 600pt;" cellpadding="0" cellspacing="0">
    <tr style="vertical-align: top;">

        <!-- LEFT COLUMN: SUBJECTIVE & OBJECTIVE -->
        <td style="width: 50%; border: 1px solid #000; padding: 0; vertical-align: top;">

            <!-- SUBJECTIVE -->
            <div style="border-bottom: 1px solid #000; min-height: 280pt;">
                <div style="background: #000; color: #fff; padding: 3pt 6pt; font-weight: bold; font-size: 10pt;">SUBJECTIVE</div>
                <div style="padding: 5pt 6pt; font-size: 8pt; line-height: 1.4;">
                    @if($consultation->selected_complaints && count($consultation->selected_complaints) > 0)
                    <strong>CC:</strong> {{ implode(', ', $consultation->selected_complaints) }}<br>
                    @endif

                    <strong>HPI:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->symptom_notes_final ?? $consultation->symptom_notes_manual ?? $consultation->symptom_notes_auto ?? 'None documented')) !!}

                    @if($consultation->symptom_onset || $consultation->symptom_duration || $consultation->aggravating_factors || $consultation->relieving_factors || $consultation->previous_episodes_details)
                    <br>
                    @if($consultation->symptom_onset || $consultation->symptom_duration)
                    <strong>Onset/Duration:</strong>
                    @if($consultation->symptom_onset) {{ $consultation->symptom_onset }} @endif
                    @if($consultation->symptom_duration), {{ $consultation->symptom_duration }} {{ $consultation->symptom_duration_unit ?? 'days' }} @endif
                    <br>
                    @endif

                    @if($consultation->aggravating_factors)
                    <strong>Aggravating:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->aggravating_factors)) !!}<br>
                    @endif

                    @if($consultation->relieving_factors)
                    <strong>Relieving:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->relieving_factors)) !!}<br>
                    @endif

                    @if($consultation->previous_episodes && $consultation->previous_episodes_details)
                    <strong>Previous Episodes:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->previous_episodes_details)) !!}<br>
                    @endif
                    @endif

                    @if($consultation->associated_symptoms && count($consultation->associated_symptoms) > 0)
                    <strong>Associated Sx:</strong> {{ implode(', ', $consultation->associated_symptoms) }}
                    @endif
                </div>
            </div>

            <!-- OBJECTIVE -->
            <div style="min-height: 280pt;">
                <div style="background: #000; color: #fff; padding: 3pt 6pt; font-weight: bold; font-size: 10pt;">OBJECTIVE</div>
                <div style="padding: 5pt 6pt; font-size: 8pt; line-height: 1.4;">
                    @if($consultation->temperature || $consultation->blood_pressure || $consultation->pulse_rate || $consultation->respiratory_rate || $consultation->spo2 || $consultation->weight || $consultation->height)
                    <strong>Vitals:</strong>
                    @if($consultation->temperature) T={{ $consultation->temperature }}°C @endif
                    @if($consultation->blood_pressure), BP={{ $consultation->blood_pressure }} @endif
                    @if($consultation->pulse_rate), HR={{ $consultation->pulse_rate }}bpm @endif
                    @if($consultation->respiratory_rate), RR={{ $consultation->respiratory_rate }}/min @endif
                    @if($consultation->spo2), SpO2={{ $consultation->spo2 }}% @endif
                    @if($consultation->weight), Wt={{ $consultation->weight }}kg @endif
                    @if($consultation->height), Ht={{ $consultation->height }}cm @endif
                    <br>
                    @endif

                    @if($consultation->general_appearance)
                    <strong>General:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->general_appearance)) !!}<br>
                    @endif

                    @php
                    $printExaminations = [
                        ['field' => 'heent_exam', 'findings' => 'heent_findings', 'label' => 'HEENT'],
                        ['field' => 'cardiovascular_exam', 'findings' => 'cardiovascular_findings', 'label' => 'CV'],
                        ['field' => 'respiratory_exam', 'findings' => 'respiratory_findings', 'label' => 'Resp'],
                        ['field' => 'abdominal_exam', 'findings' => 'abdominal_findings', 'label' => 'Abd'],
                        ['field' => 'neurological_exam', 'findings' => 'neurological_findings', 'label' => 'Neuro'],
                        ['field' => 'musculoskeletal_exam', 'findings' => 'musculoskeletal_findings', 'label' => 'MSK'],
                        ['field' => 'skin_exam', 'findings' => 'skin_findings', 'label' => 'Skin'],
                    ];
                    @endphp

                    @foreach($printExaminations as $exam)
                        @if($consultation->{$exam['field']} || ($consultation->{$exam['findings']} && count($consultation->{$exam['findings']}) > 0))
                        <strong>{{ $exam['label'] }}:</strong> {{ $consultation->{$exam['field']} ? ucfirst($consultation->{$exam['field']}) : 'Examined' }}
                        @if($consultation->{$exam['findings']} && count($consultation->{$exam['findings']}) > 0)
                         - {{ implode(', ', $consultation->{$exam['findings']}) }}
                        @endif
                        <br>
                        @endif
                    @endforeach

                    @if($consultation->examination_notes)
                    <strong>Notes:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->examination_notes)) !!}
                    @endif
                </div>
            </div>

        </td>

        <!-- RIGHT COLUMN: ASSESSMENT & PLAN -->
        <td style="width: 50%; border: 1px solid #000; border-left: none; padding: 0; vertical-align: top;">

            <!-- ASSESSMENT -->
            <div style="border-bottom: 1px solid #000; min-height: 120pt;">
                <div style="background: #000; color: #fff; padding: 3pt 6pt; font-weight: bold; font-size: 10pt;">ASSESSMENT</div>
                <div style="padding: 5pt 6pt; font-size: 8pt; line-height: 1.4;">
                    @if($consultation->diagnoses && count($consultation->diagnoses) > 0)
                        @foreach($consultation->diagnoses as $index => $diagnosis)
                            <strong>{{ $diagnosis['description'] ?? $diagnosis['name'] ?? 'Unknown' }}
                            @if(isset($diagnosis['code']) && $diagnosis['code']) ({{ $diagnosis['code'] }}) @endif
                            @if(isset($diagnosis['is_primary']) && $diagnosis['is_primary']) [PRIMARY] @endif
                            </strong>
                            @if(!$loop->last) • @endif
                        @endforeach
                    @else
                    None documented
                    @endif

                    @if($consultation->diagnosis_notes)
                    <br><strong>Notes:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->diagnosis_notes)) !!}
                    @endif
                </div>
            </div>

            <!-- PLAN -->
            <div style="min-height: 440pt;">
                <div style="background: #000; color: #fff; padding: 3pt 6pt; font-weight: bold; font-size: 10pt;">PLAN</div>
                <div style="padding: 5pt 6pt; font-size: 8pt; line-height: 1.4;">
                    @if($consultation->prescriptions && count($consultation->prescriptions) > 0)
                    <strong>Medications:</strong><br>
                        @foreach($consultation->prescriptions as $index => $rx)
                        {{ $index + 1 }}. {{ $rx['medicine_name'] ?? $rx['name'] ?? 'Unknown' }}
                        @if(isset($rx['dosage'])) {{ $rx['dosage'] }} @endif
                        @if(isset($rx['frequency'])) {{ $rx['frequency'] }} @endif
                        @if(isset($rx['duration'])) x{{ $rx['duration'] }} @endif
                        @if(isset($rx['instructions'])) ({{ $rx['instructions'] }}) @endif
                        <br>
                        @endforeach
                    <br>
                    @endif

                    @if($consultation->treatment_plan)
                    <strong>Treatment Plan:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->treatment_plan)) !!}<br>
                    @endif

                    @if($consultation->patient_education)
                    <strong>Patient Education:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->patient_education)) !!}<br>
                    @endif

                    @if($consultation->followup_instructions)
                    <strong>Follow-up:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->followup_instructions)) !!}<br>
                    @endif

                    @if($consultation->followup_date)
                    <strong>Follow-up Date:</strong> {{ $consultation->followup_date->format('m/d/Y') }}<br>
                    @endif

                    @if($consultation->referral_details)
                    <strong>Referral:</strong> {!! str_replace(["\r\n", "\r", "\n"], ' ', strip_tags($consultation->referral_details)) !!}
                    @endif
                </div>
            </div>

        </td>
    </tr>
</table>

<!-- SIGNATURE (RIGHT ALIGNED) -->
<div style="text-align: right; margin-top: 8pt; padding-top: 6pt; font-size: 8pt; font-family: Arial, sans-serif; page-break-inside: avoid;">
    <div style="display: inline-block; text-align: right;">
        <div style="border-top: 1.5pt solid #000; padding-top: 3pt; min-width: 150pt;">
            <strong style="font-size: 9pt;">
                @if($consultation->doctor->first_name && $consultation->doctor->last_name)
                    {{ $consultation->doctor->first_name }} {{ $consultation->doctor->last_name }}, MD
                @else
                    {{ $consultation->doctor->name ?? 'Doctor' }}, MD
                @endif
            </strong>
        </div>
        <div style="font-size: 7pt; margin-top: 2pt;">
            @if($consultation->doctor->specialization)
            {{ $consultation->doctor->specialization }}<br>
            @endif
            @if($consultation->doctor->license_number)
            PRC #{{ $consultation->doctor->license_number }}<br>
            @endif
            Signed: {{ $consultation->completed_at ? $consultation->completed_at->format('m/d/Y g:iA') : $consultation->updated_at->format('m/d/Y g:iA') }}
        </div>
    </div>
</div>
