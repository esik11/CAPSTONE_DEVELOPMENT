<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allergy extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id',
        'allergen_name',
        'type',
        'severity',
    ];

    protected $casts = [
        'type' => 'string',
        'severity' => 'string',
    ];

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
