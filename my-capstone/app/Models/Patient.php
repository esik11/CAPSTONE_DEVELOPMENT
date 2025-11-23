<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'philhealth_number',
        'date_of_birth',
        'gender',
        'marital_status',
        'language',
        'race',
        'region',
        'province',
        'city',
        'barangay',
        'zip_code',
        'phone_number',
        'email',
        'employment_status',
        'photo',
        'address',
        'city',
        'state',
        'zip_code',
        'country',

        // Emergency/Next of Kin Contact Information
        'emergency_last_name',
        'emergency_first_name',
        'emergency_relationship',
        'emergency_address',
        'emergency_apt_num',
        'emergency_city',
        'emergency_state',
        'emergency_zip_code',
        'emergency_home_phone',
        'emergency_work_phone',
        'emergency_other_phone',
        'emergency_other_phone_cell',
        'emergency_other_phone_pager',
        'emergency_other_phone_fax',
        'emergency_region',
        'emergency_province',
        'emergency_barangay',

        // Other Contact Information (Not Living with Patient)
        'other_last_name',
        'other_first_name',
        'other_relationship',
        'other_address',
        'other_apt_num',
        'other_city',
        'other_state',
        'other_zip_code',
        'other_home_phone',
        'other_work_phone',
        'other_other_phone',
        'other_other_phone_cell',
        'other_other_phone_pager',
        'other_other_phone_fax',
        'other_region',
        'other_province',
        'other_barangay',
        'user_id',
        'status',
    ];

    /**
     * Get the medical records for the patient.
     */
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    /**
     * Get the audit logs for the patient.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'auditable_id')
            ->where('auditable_type', self::class)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the latest audit log.
     */
    public function latestAuditLog()
    {
        return $this->auditLogs()->latest()->first();
    }

    /**
     * Boot the model and add event listeners for audit logging.
     */
    protected static function booted()
    {
        static::created(function ($patient) {
            AuditLog::log(
                $patient,
                'created',
                'Patient record created'
            );
        });

        static::updated(function ($patient) {
            $changes = $patient->getChanges();
            $original = $patient->getOriginal();
            
            // Remove timestamps from changes
            unset($changes['updated_at'], $changes['created_at']);
            
            if (!empty($changes)) {
                $oldValues = array_intersect_key($original, $changes);
                
                AuditLog::log(
                    $patient,
                    'updated',
                    'Patient record updated',
                    $oldValues,
                    $changes
                );
            }
        });

        static::deleted(function ($patient) {
            AuditLog::log(
                $patient,
                'deleted',
                'Patient record deleted'
            );
        });
    }
}

