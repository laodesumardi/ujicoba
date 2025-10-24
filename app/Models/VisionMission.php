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
        if (filter_var($this->image_one, FILTER_VALIDATE_URL)) { return $this->image_one; }
        return asset($this->image_one);
    }

    public function getImageTwoUrlAttribute()
    {
        if (!$this->image_two) { return null; }
        if (filter_var($this->image_two, FILTER_VALIDATE_URL)) { return $this->image_two; }
        return asset($this->image_two);
    }

    public function getImageThreeUrlAttribute()
    {
        if (!$this->image_three) { return null; }
        if (filter_var($this->image_three, FILTER_VALIDATE_URL)) { return $this->image_three; }
        return asset($this->image_three);
    }
}
