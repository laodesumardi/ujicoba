<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'description',
        'image',
        'image_alt',
        'image_position',
        'button_text',
        'button_link',
        'background_color',
        'text_color',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // Absolute URLs
        if (filter_var($this->image, FILTER_VALIDATE_URL) ||
            str_starts_with($this->image, 'http://') ||
            str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        // Already storage-prefixed (e.g. storage/home-sections/file.jpg)
        if (str_starts_with($this->image, 'storage/')) {
            return asset($this->image);
        }

        // Old saved path including 'public/' prefix (e.g. public/home-sections/file.jpg)
        if (str_starts_with($this->image, 'public/')) {
            return asset('storage/' . substr($this->image, 7));
        }

        // Just filename (no slash): assume home-sections/<filename>
        if (!str_contains($this->image, '/')) {
            return asset('storage/home-sections/' . $this->image);
        }

        // Default: prepend storage/
        return asset('storage/' . $this->image);
    }
}