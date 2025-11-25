<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id',
        'parents_status',
        'parents_comments',
        'smoking',
        'smoking_years',
        'smoking_daily_cigarettes',
        'smoking_comments',
        'alcohol',
        'alcohol_comments',
        'drug_use',
        'drug_type',
        'drug_comments',
        'diet_exercise',
        'occupation',
        'living_situation',
    ];

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
