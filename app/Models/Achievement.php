<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'level',
        'year',
        'student_name',
        'student_class',
        'teacher_name',
        'position',
        'event_name',
        'organizer',
        'certificate_image',
        'photo',
        'is_featured',
        'is_public',
        'sort_order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    // Accessors
    public function getCertificateImageUrlAttribute()
    {
        if ($this->certificate_image) {
            return asset('storage/achievements/certificates/' . $this->certificate_image);
        }
        return null;
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/achievements/photos/' . $this->photo);
        }
        return null;
    }

    public function getCategoryLabelAttribute()
    {
        $categories = [
            'academic' => 'Akademik',
            'sports' => 'Olahraga',
            'arts' => 'Seni & Budaya',
            'science' => 'Sains & Teknologi',
            'leadership' => 'Kepemimpinan',
            'community' => 'Pengabdian Masyarakat'
        ];
        return $categories[$this->category] ?? $this->category;
    }

    public function getLevelLabelAttribute()
    {
        $levels = [
            'school' => 'Sekolah',
            'district' => 'Kecamatan',
            'provincial' => 'Provinsi',
            'national' => 'Nasional',
            'international' => 'Internasional'
        ];
        return $levels[$this->level] ?? $this->level;
    }
}
