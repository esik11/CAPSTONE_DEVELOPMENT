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
        return $this->belongsToMany(MedicalCondition::class, 'patient_conditions', 'medical_record_id', 'condition_id')->withPivot(['status', 'notes']);
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


