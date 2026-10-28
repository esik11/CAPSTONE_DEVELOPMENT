<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'role',
        'specialization',
        'license_number',
        'ptr_number',
        's2_number',
        'contact_number',
        'clinic_address',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Dynamically generate the full name with "Dr." prefix for doctors.
     * Overrides the default 'name' attribute when first/last names are present.
     */
    public function getNameAttribute($value)
    {
        if (!empty($this->first_name) || !empty($this->last_name)) {
            $prefix = $this->isDoctor() ? 'Dr. ' : '';
            $middle = !empty($this->middle_name) ? ' ' . substr($this->middle_name, 0, 1) . '. ' : ' ';
            $fullName = trim($prefix . $this->first_name . $middle . $this->last_name);
            return preg_replace('/\s+/', ' ', $fullName);
        }
        
        return $value;
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * Check if user is a doctor
     */
    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    /**
     * Check if user is a patient
     */
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    /**
     * Check if user is an assistant
     */
    public function isAssistant(): bool
    {
        return $this->role === 'assistant';
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    /**
     * Get the availabilities for the doctor.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(DoctorAvailability::class, 'doctor_id');
    }
    
    /**
     * Get the audit logs for the user.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}
