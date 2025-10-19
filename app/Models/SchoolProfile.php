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

    // Accessors
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-school-profile.png');
        }
        
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        
        // If it starts with storage/, use it directly with asset()
        if (str_starts_with($this->image, 'storage/')) {
            return asset($this->image);
        }
        
        // If it starts with school-profiles/, add storage/ prefix
        if (str_starts_with($this->image, 'school-profiles/')) {
            return asset('storage/' . $this->image);
        }
        
        // If it starts with uploads/school-profiles/, change to storage/school-profiles/
        if (str_starts_with($this->image, 'uploads/school-profiles/')) {
            return asset(str_replace('uploads/school-profiles/', 'storage/school-profiles/', $this->image));
        }
        
        // If it's just a filename, add the full path
        if (!str_contains($this->image, '/')) {
            return asset('storage/school-profiles/' . $this->image);
        }
        
        // Default fallback
        return asset('images/default-school-profile.png');
    }
}
