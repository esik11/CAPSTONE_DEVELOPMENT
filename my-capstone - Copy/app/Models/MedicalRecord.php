<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MedicalRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_date',
        'chief_complaint',
        'history_of_present_illness',
        'review_of_systems',
        'consent_signed',
        'talking_points',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'visit_date' => 'date',
        'chief_complaint' => 'encrypted',
        'history_of_present_illness' => 'encrypted',
        'review_of_systems' => 'encrypted',
        'talking_points' => 'encrypted',
    ];

    /**
     * Boot the model and add event listeners for audit logging.
     */
    protected static function booted()
    {
        static::created(function ($medicalRecord) {
            $patientName = $medicalRecord->patient ? ($medicalRecord->patient->first_name . ' ' . $medicalRecord->patient->last_name) : 'Patient ID: ' . $medicalRecord->patient_id;
            AuditLog::log(
                $medicalRecord,
                'created',
                'Medical record history created for patient ' . $patientName,
                null,
                $medicalRecord->toArray()
            );
        });

        static::updated(function ($medicalRecord) {
            $changes = $medicalRecord->getChanges();
            $original = $medicalRecord->getOriginal();
            
            unset($changes['updated_at'], $changes['created_at']);
            
            if (!empty($changes)) {
                $oldValues = array_intersect_key($original, $changes);
                $patientName = $medicalRecord->patient ? ($medicalRecord->patient->first_name . ' ' . $medicalRecord->patient->last_name) : 'Patient ID: ' . $medicalRecord->patient_id;
                
                AuditLog::log(
                    $medicalRecord,
                    'updated',
                    'Medical record history for patient ' . $patientName . ' updated',
                    $oldValues,
                    $changes
                );
            }
        });

        static::deleted(function ($medicalRecord) {
            $patientName = $medicalRecord->patient ? ($medicalRecord->patient->first_name . ' ' . $medicalRecord->patient->last_name) : 'Patient ID: ' . $medicalRecord->patient_id;
            AuditLog::log(
                $medicalRecord,
                'deleted',
                'Medical record history for patient ' . $patientName . ' deleted'
            );
        });
    }

    /**
     * Get the patient that owns the medical record.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor that created the medical record.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get the surgical histories for the medical record.
     */
    public function surgicalHistories(): HasMany
    {
        return $this->hasMany(SurgicalHistory::class);
    }

    /**
     * Get the hospitalizations for the medical record.
     */
    public function hospitalizations(): HasMany
    {
        return $this->hasMany(Hospitalization::class);
    }

    /**
     * Get the medications for the medical record.
     */
    public function medications(): HasMany
    {
        return $this->hasMany(Medication::class);
    }

    /**
     * Get the allergies for the medical record.
     */
    public function allergies(): HasMany
    {
        return $this->hasMany(Allergy::class);
    }

    /**
     * Get the gynae history for the medical record.
     */
    public function gynaeHistory()
    {
        return $this->hasOne(GynaeHistory::class);
    }

    /**
     * Get the family histories for the medical record.
     */
    public function familyHistories(): HasMany
    {
        return $this->hasMany(FamilyHistory::class);
    }

    /**
     * Get the social histories for the medical record.
     */
    public function socialHistories(): HasMany
    {
        return $this->hasMany(SocialHistory::class);
    }

    /**
     * Get the medical conditions for the medical record.
     */
    public function medicalConditions(): BelongsToMany
    {
        return $this->belongsToMany(MedicalCondition::class, 'patient_conditions', 'medical_record_id', 'condition_id')
            ->withPivot(['status', 'notes', 'is_pinned']);
    }

    /**
     * Get the vital signs for the medical record.
     */
    public function vitalSigns(): HasMany
    {
        return $this->hasMany(VitalSign::class);
    }

    /**
     * Get the latest vital signs for the medical record.
     */
    public function latestVitalSigns(): HasOne
    {
        return $this->hasOne(VitalSign::class)->latestOfMany('recorded_at');
    }
}


