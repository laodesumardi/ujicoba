<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'phone',
        'email',
        'opening_hours',
        'services',
        'rules',
        'librarian_name',
        'librarian_phone',
        'librarian_email',
        'organization_chart',
        'facilities',
        'collection_info',
        'membership_info',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getOrganizationChartUrlAttribute()
    {
        if (!$this->organization_chart) {
            return null;
        }
        
        // Check if it's already a full URL
        if (filter_var($this->organization_chart, FILTER_VALIDATE_URL)) {
            return $this->organization_chart;
        }
        
        // Check if it's a public file (not in storage)
        if (!str_starts_with($this->organization_chart, 'libraries/') && 
            !str_starts_with($this->organization_chart, 'storage/')) {
            // It's a public file
            return asset($this->organization_chart);
        }
        
        // Return the storage URL
        return asset('storage/' . $this->organization_chart);
    }
}
