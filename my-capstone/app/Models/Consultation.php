<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'consultation_date',
        'consultation_time',
        'status',
        'current_section',
        'selected_complaints',
        'visit_type',
        'documentation_mode',
        'template_responses',
        'symptom_notes_auto',
        'symptom_notes_manual',
        'symptom_notes_final',
        'symptom_onset',
        'symptom_duration',
        'symptom_duration_unit',
        'aggravating_factors',
        'relieving_factors',
        'previous_episodes',
        'previous_episodes_details',
        'review_of_systems',
        'associated_symptoms',
        // Vital signs
        'temperature',
        'pulse_rate',
        'blood_pressure',
        'respiratory_rate',
        'spo2',
        'weight',
        'height',
        'waist_circumference',
        // Examination fields
        'general_appearance',
        'heent_exam',
        'heent_findings',
        'cardiovascular_exam',
        'cardiovascular_findings',
        'respiratory_exam',
        'respiratory_findings',
        'abdominal_exam',
        'abdominal_findings',
        'neurological_exam',
        'neurological_findings',
        'musculoskeletal_exam',
        'musculoskeletal_findings',
        'skin_exam',
        'skin_findings',
        'examination_notes',
        // Diagnosis & Prescription
        'diagnoses',
        'prescriptions',
        'diagnosis_notes',
    ];

    protected $casts = [
        'consultation_date' => 'date',
        'consultation_time' => 'datetime:H:i',
        'selected_complaints' => 'array',
        'template_responses' => 'array',
        'review_of_systems' => 'array',
        'associated_symptoms' => 'array',
        'previous_episodes' => 'boolean',
        'cardiovascular_findings' => 'array',
        'respiratory_findings' => 'array',
        'abdominal_findings' => 'array',
        'neurological_findings' => 'array',
        'musculoskeletal_findings' => 'array',
        'heent_findings' => 'array',
        'skin_findings' => 'array',
        'diagnoses' => 'array',
        'prescriptions' => 'array',
    ];

    // Relationships
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    // Helper methods
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
    }
}
