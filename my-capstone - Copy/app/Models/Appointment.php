<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\DoctorAvailability;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'start_time',
        'end_time',
        'reason',
        'status',
        'notes',
        'appointment_mode',
        'urgency_priority',
        'file_path',
        'consent',
        'checked_in_at',
        'consultation_started_at',
        'completed_at',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'checked_in_at' => 'datetime',
        'consultation_started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Boot the model and add event listeners for audit logging.
     */
    protected static function booted()
    {
        static::created(function ($appointment) {
            $patientName = $appointment->patient ? ($appointment->patient->first_name . ' ' . $appointment->patient->last_name) : 'Patient ID: ' . $appointment->patient_id;
            AuditLog::log(
                $appointment,
                'created',
                'Appointment scheduled for patient ' . $patientName . ' on ' . ($appointment->start_time ? $appointment->start_time->format('Y-m-d H:i') : 'N/A'),
                null,
                $appointment->toArray()
            );
        });

        static::updated(function ($appointment) {
            $changes = $appointment->getChanges();
            $original = $appointment->getOriginal();
            
            unset($changes['updated_at'], $changes['created_at']);
            
            if (!empty($changes)) {
                $oldValues = array_intersect_key($original, $changes);
                $patientName = $appointment->patient ? ($appointment->patient->first_name . ' ' . $appointment->patient->last_name) : 'Patient ID: ' . $appointment->patient_id;
                
                AuditLog::log(
                    $appointment,
                    'updated',
                    'Appointment for patient ' . $patientName . ' updated',
                    $oldValues,
                    $changes
                );
            }
        });

        static::deleted(function ($appointment) {
            $patientName = $appointment->patient ? ($appointment->patient->first_name . ' ' . $appointment->patient->last_name) : 'Patient ID: ' . $appointment->patient_id;
            AuditLog::log(
                $appointment,
                'deleted',
                'Appointment for patient ' . $patientName . ' deleted'
            );
        });
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function reschedules(): HasMany
    {
        return $this->hasMany(AppointmentReschedule::class);
    }

    /**
     * Check if the appointment is within the doctor's availability.
     */
    public function isWithinDoctorAvailability(): bool
    {
        $dayOfWeek = $this->start_time->dayOfWeek;
        $startTime = $this->start_time->format('H:i:s');
        $endTime = $this->end_time->format('H:i:s');

        $availabilities = DoctorAvailability::where('doctor_id', $this->doctor_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->get();

        if ($availabilities->isEmpty()) {
            return false;
        }

        // Check if appointment start and end fall within ANY of the availability slots
        foreach ($availabilities as $availability) {
            if ($startTime >= $availability->start_time && $endTime <= $availability->end_time) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if this appointment conflicts with any existing appointments.
     * Includes buffer time to prevent back-to-back scheduling.
     * 
     * @param int $bufferMinutes Buffer time in minutes (default: 15)
     * @return bool True if there's a conflict, false otherwise
     */
    public function hasScheduleConflict(int $bufferMinutes = 15): bool
    {
        // Add buffer time to start and end
        $bufferedStart = $this->start_time->copy()->subMinutes($bufferMinutes);
        $bufferedEnd = $this->end_time->copy()->addMinutes($bufferMinutes);

        $query = self::where('doctor_id', $this->doctor_id)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in', 'in_progress'])
            ->where(function ($q) use ($bufferedStart, $bufferedEnd) {
                $q->whereBetween('start_time', [$bufferedStart, $bufferedEnd])
                  ->orWhereBetween('end_time', [$bufferedStart, $bufferedEnd])
                  ->orWhere(function ($q2) use ($bufferedStart, $bufferedEnd) {
                      $q2->where('start_time', '<=', $bufferedStart)
                         ->where('end_time', '>=', $bufferedEnd);
                  });
            });

        // Exclude current appointment when updating
        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }

        return $query->exists();
    }

    /**
     * Get all conflicting appointments for this time slot.
     */
    public function getConflictingAppointments()
    {
        return self::where('doctor_id', $this->doctor_id)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in', 'in_progress'])
            ->where('id', '!=', $this->id ?? 0)
            ->where(function ($q) {
                $q->whereBetween('start_time', [$this->start_time, $this->end_time])
                  ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                  ->orWhere(function ($q2) {
                      $q2->where('start_time', '<=', $this->start_time)
                         ->where('end_time', '>=', $this->end_time);
                  });
            })
            ->with('patient')
            ->get();
    }
}
