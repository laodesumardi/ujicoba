<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\StorageHelper;

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

    // Accessor for image URL - Hosting compatible
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-section.png');
        }

        // Absolute URLs
        if (filter_var($this->image, FILTER_VALIDATE_URL) ||
            str_starts_with($this->image, 'http://') ||
            str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        // Clean path untuk StorageHelper
        $path = $this->image;
        
        // Remove public/ prefix if exists
        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7);
        }
        
        // Remove storage/ prefix if exists
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }
        
        // Ensure home-sections folder
        if (!str_starts_with($path, 'home-sections/')) {
            $path = 'home-sections/' . $path;
        }

        // Use StorageHelper untuk akses hosting yang aman
        return StorageHelper::getImageUrl($path, 'images/default-section.png');
    }
}