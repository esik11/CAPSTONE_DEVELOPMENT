<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VitalSign extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'medical_record_id',
        'recorded_by',
        'weight',
        'height',
        'bmi',
        'blood_pressure',
        'systolic',
        'diastolic',
        'temperature',
        'pulse_rate',
        'respiratory_rate',
        'oxygen_saturation',
        'blood_glucose',
        'head_circumference',
        'notes',
        'recorded_at',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'bmi' => 'decimal:2',
        'temperature' => 'decimal:1',
        'blood_glucose' => 'decimal:2',
        'head_circumference' => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    /**
     * Get the patient that owns the vital signs.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the medical record associated with these vital signs.
     */
    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    /**
     * Get the user who recorded the vital signs.
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Calculate and set BMI based on weight and height.
     */
    public function calculateBmi(): void
    {
        if ($this->weight && $this->height) {
            $heightInMeters = $this->height / 100;
            $this->bmi = round($this->weight / ($heightInMeters * $heightInMeters), 2);
        }
    }

    /**
     * Boot the model and add event listeners.
     */
    protected static function booted()
    {
        static::saving(function ($vitalSign) {
            // Auto-calculate BMI if weight and height are present
            if ($vitalSign->weight && $vitalSign->height && !$vitalSign->bmi) {
                $vitalSign->calculateBmi();
            }
        });
    }
}
