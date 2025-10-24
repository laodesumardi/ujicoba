<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryItem extends Model
{
    protected $fillable = [
        'gallery_id',
        'title',
        'description',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'width',
        'height',
        'duration',
        'thumbnail_path',
        'sort_order',
        'is_featured',
        'is_active',
        'metadata'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'metadata' => 'array'
    ];

    // Relationships
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if (!$this->file_path) {
            return asset('images/default-gallery-item.png');
        }
        
        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }
        
        if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
            return $this->file_path;
        }
        
        if (str_starts_with($this->file_path, 'gallery-items/')) {
            return asset('storage/' . $this->file_path);
        }
        
        if (str_starts_with($this->file_path, 'storage/')) {
            return asset($this->file_path);
        }
        
        if (!str_starts_with($this->file_path, 'gallery-items/') && 
            !str_starts_with($this->file_path, 'storage/')) {
            return asset('storage/' . $this->file_path);
        }
        
        return asset('images/default-gallery-item.png');
    }

    public function getTypeLabelAttribute()
    {
        $types = [
            'image' => 'Gambar',
            'video' => 'Video',
            'document' => 'Dokumen'
        ];

        return $types[$this->file_type] ?? ucfirst($this->file_type);
    }

    // Methods
    public function isImage()
    {
        return $this->file_type === 'image';
    }

    public function isVideo()
    {
        return $this->file_type === 'video';
    }

    public function isDocument()
    {
        return $this->file_type === 'document';
    }
}