<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'school_name',
        'history',
        'established_year',
        'location',
        'vision',
        'mission',
        'headmaster_name',
        'headmaster_position',
        'headmaster_education',
        'accreditation_status',
        'accreditation_number',
        'accreditation_year',
        'accreditation_score',
        'accreditation_valid_until',
        'section_key',
        'title',
        'content',
        'subtitle',
        'description',
        'image',
        'image_alt',
        'button_text',
        'button_link',
        'background_color',
        'text_color',
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
