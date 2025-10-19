<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'icon',
        'category',
        'sort_order',
        'is_active',
        'is_featured'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-facility.png');
        }
        
        // Check if it's already a full URL (including https://)
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // Check if it starts with http (but not validated by filter_var)
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        
        // Check if it's a storage path
        if (str_starts_with($this->image, 'facilities/')) {
            return asset('storage/' . $this->image);
        }
        
        // Check if it's a storage path with storage/ prefix
        if (str_starts_with($this->image, 'storage/')) {
            return asset($this->image);
        }
        
        // Check if it's a public file (not in storage)
        if (!str_starts_with($this->image, 'facilities/') && 
            !str_starts_with($this->image, 'storage/')) {
            // It's a public file
            return asset($this->image);
        }
        
        // Default fallback
        return asset('images/default-facility.png');
    }

    public function getCategoryLabelAttribute()
    {
        $categories = [
            'general' => 'Umum',
            'academic' => 'Akademik',
            'sports' => 'Olahraga',
            'library' => 'Perpustakaan',
            'laboratory' => 'Laboratorium',
            'technology' => 'Teknologi',
            'welfare' => 'Kesejahteraan'
        ];
        
        return $categories[$this->category] ?? $this->category;
    }
}
