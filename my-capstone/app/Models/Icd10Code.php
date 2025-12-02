<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icd10Code extends Model
{
    protected $fillable = [
        'code',
        'description',
        'category',
        'is_common',
    ];

    protected $casts = [
        'is_common' => 'boolean',
    ];

    /**
     * Search ICD-10 codes by code or description
     */
    public static function search($query, $limit = 20)
    {
        return self::where('code', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orderBy('is_common', 'desc') // Show common codes first
            ->orderBy('code')
            ->limit($limit)
            ->get();
    }

    /**
     * Get common codes for quick access
     */
    public static function getCommon()
    {
        return self::where('is_common', true)
            ->orderBy('code')
            ->get();
    }
}
