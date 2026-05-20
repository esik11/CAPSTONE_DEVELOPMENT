<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosticTest extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'consultation_id',
        'uploaded_by',
        'test_name',
        'category',
        'reference_number',
        'request_notes',
        'results_findings',
        'attachment_path',
        'status',
        'requested_at',
        'resulted_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'resulted_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
