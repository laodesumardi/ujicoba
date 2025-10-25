<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'vision',
        'mission',
        'goals',
        'logo',
        'banner_image',
        'gallery_images',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'gallery_images' => 'array',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return asset('images/default-library-logo.png');
        }

        // Jika URL eksternal, kembalikan apa adanya
        if (filter_var($this->logo, FILTER_VALIDATE_URL) ||
            str_starts_with($this->logo, 'http://') ||
            str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        }

        // Gunakan direct image serving route
        return route('image.serve.model', [
            'model' => 'library',
            'id' => $this->id,
            'field' => 'logo',
            'v' => $this->updated_at ? $this->updated_at->timestamp : time(),
        ], false);
    }

    public function getBannerImageUrlAttribute()
    {
        if (!$this->banner_image) {
            return asset('images/default-hero.png');
        }

        // Jika URL eksternal, kembalikan apa adanya
        if (filter_var($this->banner_image, FILTER_VALIDATE_URL) ||
            str_starts_with($this->banner_image, 'http://') ||
            str_starts_with($this->banner_image, 'https://')) {
            return $this->banner_image;
        }

        // Gunakan direct image serving route
        return route('image.serve.model', [
            'model' => 'library',
            'id' => $this->id,
            'field' => 'banner_image',
            'v' => $this->updated_at ? $this->updated_at->timestamp : time(),
        ], false);
    }

    public function getOrganizationChartUrlAttribute()
    {
        if (!$this->organization_chart) {
            return asset('images/default-struktur.png');
        }

        // Jika URL eksternal, kembalikan apa adanya
        if (filter_var($this->organization_chart, FILTER_VALIDATE_URL) ||
            str_starts_with($this->organization_chart, 'http://') ||
            str_starts_with($this->organization_chart, 'https://')) {
            return $this->organization_chart;
        }

        // Gunakan direct image serving route
        return route('image.serve.model', [
            'model' => 'library',
            'id' => $this->id,
            'field' => 'organization_chart',
            'v' => $this->updated_at ? $this->updated_at->timestamp : time(),
        ], false);
    }

    public function getGalleryImagesUrlsAttribute()
    {
        if (!$this->gallery_images || !is_array($this->gallery_images)) {
            return [];
        }

        $urls = [];
        foreach ($this->gallery_images as $image) {
            if (filter_var($image, FILTER_VALIDATE_URL) ||
                str_starts_with($image, 'http://') ||
                str_starts_with($image, 'https://')) {
                $urls[] = $image;
            } else {
                $urls[] = route('image.serve.model', [
                    'model' => 'library',
                    'id' => $this->id,
                    'field' => 'gallery_images',
                    'filename' => $image,
                    'v' => $this->updated_at ? $this->updated_at->timestamp : time(),
                ], false);
            }
        }

        return $urls;
    }

    // Helper methods
    public function getFormattedOpeningHours()
    {
        if (!$this->opening_hours) {
            return 'Jam operasional belum ditentukan';
        }

        return nl2br($this->opening_hours);
    }

    public function getFormattedServices()
    {
        if (!$this->services) {
            return [];
        }

        return array_filter(array_map('trim', explode("\n", $this->services)));
    }

    public function getFormattedRules()
    {
        if (!$this->rules) {
            return [];
        }

        return array_filter(array_map('trim', explode("\n", $this->rules)));
    }

    public function getFormattedFacilities()
    {
        if (!$this->facilities) {
            return [];
        }

        return array_filter(array_map('trim', explode("\n", $this->facilities)));
    }
}