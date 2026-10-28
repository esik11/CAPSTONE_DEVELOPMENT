<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitTypeTemplate extends Model
{
    protected $fillable = [
        'visit_type_name',
        'template_questions',
        'required_fields',
    ];

    protected $casts = [
        'template_questions' => 'array',
        'required_fields' => 'array',
    ];

    // Helper methods
    public function hasRequiredFields(): bool
    {
        return !empty($this->required_fields);
    }

    public function getRequiredFieldsList(): array
    {
        return $this->required_fields ?? [];
    }
}
