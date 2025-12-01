<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintTemplate extends Model
{
    protected $fillable = [
        'complaint_name',
        'category',
        'template_questions',
        'output_template',
        'common_symptoms',
    ];

    protected $casts = [
        'template_questions' => 'array',
        'common_symptoms' => 'array',
    ];

    // Scopes
    public function scopeAdult($query)
    {
        return $query->whereIn('category', ['adult', 'both']);
    }

    public function scopePediatric($query)
    {
        return $query->whereIn('category', ['pediatric', 'both']);
    }

    public function scopeByCategory($query, $category)
    {
        if ($category === 'adult') {
            return $query->adult();
        } elseif ($category === 'pediatric') {
            return $query->pediatric();
        }
        
        return $query;
    }

    // Helper methods
    public function isAdult(): bool
    {
        return in_array($this->category, ['adult', 'both']);
    }

    public function isPediatric(): bool
    {
        return in_array($this->category, ['pediatric', 'both']);
    }
}
