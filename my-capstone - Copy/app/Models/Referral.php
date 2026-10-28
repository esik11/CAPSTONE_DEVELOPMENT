<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = [
        'consultation_id',
        'patient_id',
        'doctor_id',
        'receiving_provider_name',
        'receiving_specialty',
        'receiving_facility',
        'receiving_contact',
        'reason_for_referral',
        'medical_history_summary',
        'current_medications',
        'supporting_docs',
        'insurance_provider',
        'policy_number',
        'pre_auth_number',
        'status',
        'signed_at',
        'digital_signature_hash',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
