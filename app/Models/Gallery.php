<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Helpers\StorageHelper;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'cover_image',
        'type',
        'category',
        'status',
        'is_featured',
        'is_public',
        'is_active',
        'sort_order',
        'metadata'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'metadata' => 'array'
    ];

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });
        
        static::updating(function ($gallery) {
            if ($gallery->isDirty('title') && empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });
    }

    // Relationships
    public function items()
    {
        return $this->hasMany(GalleryItem::class)->orderBy('sort_order');
    }

    public function featuredItems()
    {
        return $this->hasMany(GalleryItem::class)->where('is_featured', true)->orderBy('sort_order');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('is_public', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            $path = str_replace('public/', '', $this->cover_image);
            return StorageHelper::getImageUrl($path, 'images/default-gallery.jpg');
        }
        return asset('images/default-gallery.jpg');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-gallery.png');
        }
        
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        
        // Clean path untuk StorageHelper
        $path = $this->image;
        if (str_starts_with($path, 'gallery/')) {
            $path = $path;
        } elseif (str_starts_with($path, 'storage/')) {
            $path = str_replace('storage/', '', $path);
        } elseif (!str_starts_with($path, 'gallery/') && !str_starts_with($path, 'storage/')) {
            $path = 'galleries/' . $path;
        }
        
        return StorageHelper::getImageUrl($path, 'images/default-gallery.png');
    }

    public function getTypeLabelAttribute()
    {
        $types = [
            'photo' => 'Foto',
            'video' => 'Video',
            'mixed' => 'Campuran'
        ];

        return $types[$this->type] ?? ucfirst($this->type);
    }

    public function getCategoryLabelAttribute()
    {
        $categories = [
            'kegiatan' => 'Kegiatan Siswa',
            'event' => 'Event Besar',
            'profil' => 'Profil Sekolah',
            'testimoni' => 'Testimoni',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'lainnya' => 'Lainnya'
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'draft' => 'Draft',
            'published' => 'Dipublikasikan',
            'archived' => 'Diarsipkan'
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    // Methods
    public function getItemCount()
    {
        return $this->items()->count();
    }

    public function getFeaturedItemCount()
    {
        return $this->featuredItems()->count();
    }

    public function isPublished()
    {
        return $this->status === 'published' && $this->is_public;
    }
}