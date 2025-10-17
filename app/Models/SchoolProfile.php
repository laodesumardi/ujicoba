<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'content',
        'subtitle',
        'description',
        'image',
        'image_alt',
        'is_active',
        'sort_order',
        'extra_data'
    ];

    protected $casts = [
        'extra_data' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBySection($query, $sectionKey)
    {
        return $query->where('section_key', $sectionKey);
    }
}
