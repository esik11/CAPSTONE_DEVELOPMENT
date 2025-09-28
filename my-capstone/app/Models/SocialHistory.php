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
        'smoking',
        'alcohol',
        'drug_use',
        'diet_exercise',
        'occupation',
        'living_situation',
    ];

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
