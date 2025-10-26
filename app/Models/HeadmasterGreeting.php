<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadmasterGreeting extends Model
{
    protected $fillable = [
        'headmaster_name',
        'greeting_message',
        'photo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            return asset('images/default-headmaster.png');
        }
        
        if (filter_var($this->photo, FILTER_VALIDATE_URL) ||
            str_starts_with($this->photo, 'http://') ||
            str_starts_with($this->photo, 'https://')) {
            return $this->photo;
        }
        
        $version = $this->updated_at ? $this->updated_at->timestamp : time();
        return route('image.serve.model', [
            'model' => 'headmaster-greeting',
            'id' => $this->id,
            'field' => 'photo',
            'v' => $version,
        ], false);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
