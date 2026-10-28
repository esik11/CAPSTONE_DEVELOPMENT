<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GynaeHistory extends Model
{
    protected $fillable = [
        'medical_record_id',
        'contraception',
        'contraception_comments',
        'age_at_menarche',
        'last_menstrual_period',
        'cycle_regularity',
        'cycle_length_days',
        'menstrual_issues',
        'menstrual_comments',
        'number_of_pregnancies',
        'number_of_children',
        'pregnancy_complications',
        'pregnancy_complications_comments',
    ];

    protected $casts = [
        'contraception' => 'array',
        'last_menstrual_period' => 'date',
        'menstrual_issues' => 'array',
        'pregnancy_complications' => 'array',
    ];

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
