<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisionMission extends Model
{
    protected $fillable = [
        'vision',
        'missions',
        'is_active',
        'image_one',
        'image_one_name',
        'image_two',
        'image_two_name',
        'image_three',
        'image_three_name'
    ];

    protected $casts = [
        'missions' => 'array',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getImageOneUrlAttribute()
    {
        if (!$this->image_one) { return null; }
        if (filter_var($this->image_one, FILTER_VALIDATE_URL) ||
            str_starts_with($this->image_one, 'http://') ||
            str_starts_with($this->image_one, 'https://')) {
            return $this->image_one;
        }
        $version = $this->updated_at ? $this->updated_at->timestamp : time();
        return route('image.serve.model', [
            'model' => 'vision-mission',
            'id' => $this->id,
            'field' => 'image_one',
            'v' => $version,
        ]);
    }

    public function getImageTwoUrlAttribute()
    {
        if (!$this->image_two) { return null; }
        if (filter_var($this->image_two, FILTER_VALIDATE_URL) ||
            str_starts_with($this->image_two, 'http://') ||
            str_starts_with($this->image_two, 'https://')) {
            return $this->image_two;
        }
        $version = $this->updated_at ? $this->updated_at->timestamp : time();
        return route('image.serve.model', [
            'model' => 'vision-mission',
            'id' => $this->id,
            'field' => 'image_two',
            'v' => $version,
        ]);
    }

    public function getImageThreeUrlAttribute()
    {
        if (!$this->image_three) { return null; }
        if (filter_var($this->image_three, FILTER_VALIDATE_URL) ||
            str_starts_with($this->image_three, 'http://') ||
            str_starts_with($this->image_three, 'https://')) {
            return $this->image_three;
        }
        $version = $this->updated_at ? $this->updated_at->timestamp : time();
        return route('image.serve.model', [
            'model' => 'vision-mission',
            'id' => $this->id,
            'field' => 'image_three',
            'v' => $version,
        ]);
    }
}
