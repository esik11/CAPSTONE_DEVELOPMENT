<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalCondition extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'condition_name',
    ];

    public function medicalRecords()
    {
        return $this->belongsToMany(MedicalRecord::class, 'patient_conditions', 'condition_id', 'medical_record_id');
    }
}
