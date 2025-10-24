<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\StorageHelper;
use App\Events\ModelUpdated;

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

    /**
     * The event map for the model.
     */
    protected $dispatchesEvents = [
        'updated' => ModelUpdated::class,
        'created' => ModelUpdated::class,
    ];

    // Accessor for image URL - Direct serving with cache-busting
    public function getImageUrlAttribute()
    {
        // Use updated_at timestamp to force refresh when record changes
        $version = $this->updated_at ? $this->updated_at->timestamp : time();

        if (!$this->image) {
            return route('image.serve.model', [
                'model' => 'home-section',
                'id' => $this->id,
                'field' => 'image',
                'v' => $version,
            ]);
        }

        // Absolute URLs
        if (filter_var($this->image, FILTER_VALIDATE_URL) ||
            str_starts_with($this->image, 'http://') ||
            str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        // Use direct image serving route with cache-busting
        return route('image.serve.model', [
            'model' => 'home-section',
            'id' => $this->id,
            'field' => 'image',
            'v' => $version,
        ]);
    }
}