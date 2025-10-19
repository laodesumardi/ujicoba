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
        
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }
        
        if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
            return $this->photo;
        }
        
        if (str_starts_with($this->photo, 'headmaster-greetings/')) {
            return asset('storage/' . $this->photo);
        }
        
        if (str_starts_with($this->photo, 'storage/')) {
            return asset($this->photo);
        }
        
        if (!str_starts_with($this->photo, 'headmaster-greetings/') && 
            !str_starts_with($this->photo, 'storage/')) {
            return asset('storage/' . $this->photo);
        }
        
        return asset('images/default-headmaster.png');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
