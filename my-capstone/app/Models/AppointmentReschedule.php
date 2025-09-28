<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentReschedule extends Model
{
    protected $fillable = [
        'appointment_id',
        'old_start_time',
        'new_start_time',
        'old_end_time',
        'new_end_time',
        'reason',
        'rescheduled_by',
    ];

    protected $casts = [
        'old_start_time' => 'datetime',
        'new_start_time' => 'datetime',
        'old_end_time' => 'datetime',
        'new_end_time' => 'datetime',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function rescheduledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rescheduled_by');
    }
}
