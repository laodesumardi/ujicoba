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
            return asset('images/default-struktur.png');
        }
        
        // URL eksternal
        if (filter_var($this->organization_chart, FILTER_VALIDATE_URL) ||
            str_starts_with($this->organization_chart, 'http://') ||
            str_starts_with($this->organization_chart, 'https://')) {
            return $this->organization_chart;
        }
        
        // Gunakan storage link yang lebih sederhana
        return \Storage::url($this->organization_chart);
    }
}
