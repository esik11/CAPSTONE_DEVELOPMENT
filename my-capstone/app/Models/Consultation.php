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
        'consultation_mode',
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
        // Plan & Notes
        'treatment_plan',
        'patient_education',
        'followup_instructions',
        'doctor_notes',
        'followup_date',
        'referral_details',
    ];

    protected $casts = [
        'consultation_date' => 'date',
        'consultation_time' => 'datetime:H:i',
        'selected_complaints' => 'encrypted:array',
        'template_responses' => 'encrypted:array',
        'symptom_notes_auto' => 'encrypted',
        'symptom_notes_manual' => 'encrypted',
        'symptom_notes_final' => 'encrypted',
        'aggravating_factors' => 'encrypted',
        'relieving_factors' => 'encrypted',
        'previous_episodes' => 'boolean',
        'previous_episodes_details' => 'encrypted',
        'review_of_systems' => 'encrypted:array',
        'associated_symptoms' => 'encrypted:array',
        'cardiovascular_findings' => 'encrypted:array',
        'respiratory_findings' => 'encrypted:array',
        'abdominal_findings' => 'encrypted:array',
        'neurological_findings' => 'encrypted:array',
        'musculoskeletal_findings' => 'encrypted:array',
        'heent_findings' => 'encrypted:array',
        'skin_findings' => 'encrypted:array',
        'examination_notes' => 'encrypted',
        'diagnoses' => 'encrypted:array',
        'prescriptions' => 'encrypted:array',
        'diagnosis_notes' => 'encrypted',
        'treatment_plan' => 'encrypted',
        'patient_education' => 'encrypted',
        'followup_instructions' => 'encrypted',
        'doctor_notes' => 'encrypted',
        'followup_date' => 'date',
        'referral_details' => 'encrypted',
    ];

    /**
     * Boot the model and add event listeners for audit logging.
     */
    protected static function booted()
    {
        static::created(function ($consultation) {
            $patientName = $consultation->patient ? ($consultation->patient->first_name . ' ' . $consultation->patient->last_name) : 'Patient ID: ' . $consultation->patient_id;
            AuditLog::log(
                $consultation,
                'created',
                'Consultation record started for patient: ' . $patientName,
                null,
                $consultation->toArray()
            );
        });

        static::updated(function ($consultation) {
            $changes = $consultation->getChanges();
            $original = $consultation->getOriginal();
            
            unset($changes['updated_at'], $changes['created_at']);
            
            if (!empty($changes)) {
                $oldValues = array_intersect_key($original, $changes);
                $patientName = $consultation->patient ? ($consultation->patient->first_name . ' ' . $consultation->patient->last_name) : 'Patient ID: ' . $consultation->patient_id;
                
                AuditLog::log(
                    $consultation,
                    'updated',
                    'Consultation record updated for patient: ' . $patientName,
                    $oldValues,
                    $changes
                );
            }
        });

        static::deleted(function ($consultation) {
            $patientName = $consultation->patient ? ($consultation->patient->first_name . ' ' . $consultation->patient->last_name) : 'Patient ID: ' . $consultation->patient_id;
            AuditLog::log(
                $consultation,
                'deleted',
                'Consultation record deleted for patient: ' . $patientName
            );
        });
    }

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

    public function billing()
    {
        return $this->hasOne(Billing::class);
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

    public function referral()
    {
        return $this->hasOne(Referral::class);
    }
}
