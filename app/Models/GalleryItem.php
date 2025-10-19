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
        'metadata'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'metadata' => 'array'
    ];

    // Relationships
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('file_type', $type);
    }

    // Accessors
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail_path) {
            return asset('storage/' . str_replace('public/', '', $this->thumbnail_path));
        }
        return $this->file_url;
    }

    public function getFileSizeFormattedAttribute()
    {
        if (!$this->file_size) return null;
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getDurationFormattedAttribute()
    {
        if (!$this->duration) return null;
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getDimensionsAttribute()
    {
        if ($this->width && $this->height) {
            return $this->width . 'x' . $this->height;
        }
        return null;
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

    public function getMimeTypeCategory()
    {
        if (str_starts_with($this->mime_type, 'image/')) {
            return 'image';
        } elseif (str_starts_with($this->mime_type, 'video/')) {
            return 'video';
        }
        return 'unknown';
    }
}
