<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'strength',
        'form',
        'generic_name',
        'description',
        'is_common',
    ];

    protected $casts = [
        'is_common' => 'boolean',
    ];

    /**
     * Search medicines by name or generic name
     */
    public static function search($query, $limit = 20)
    {
        return self::where('name', 'like', "%{$query}%")
            ->orWhere('generic_name', 'like', "%{$query}%")
            ->orderBy('is_common', 'desc')
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }

    /**
     * Get full medicine name with strength
     */
    public function getFullNameAttribute()
    {
        return $this->name . ($this->strength ? ' ' . $this->strength : '') . ' (' . $this->form . ')';
    }
}
