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
        // Versi untuk cache-busting berdasarkan updated_at
        $version = $this->updated_at ? $this->updated_at->timestamp : time();

        // Jika URL eksternal, kembalikan apa adanya
        if ($this->organization_chart && (
            filter_var($this->organization_chart, FILTER_VALIDATE_URL) ||
            str_starts_with($this->organization_chart, 'http://') ||
            str_starts_with($this->organization_chart, 'https://')
        )) {
            return $this->organization_chart;
        }

        // Gunakan direct image serving route agar konsisten dengan HomeSections
        // ImageController akan melakukan fallback ke 'images/default-struktur.png' jika kosong/tidak ditemukan
        return route('image.serve.model', [
            'model' => 'library',
            'id' => $this->id,
            'field' => 'organization_chart',
            'v' => $version,
        ], false);
    }
}
