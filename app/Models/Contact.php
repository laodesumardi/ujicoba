<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'phone',
        'email',
        'website',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the active contact information
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Get formatted address
     */
    public function getFormattedAddressAttribute()
    {
        return str_replace("\n", '<br>', $this->address);
    }

    /**
     * Get formatted phone with link
     */
    public function getPhoneLinkAttribute()
    {
        $phone = str_replace([' ', '-', '(', ')'], '', $this->phone);
        return 'tel:' . $phone;
    }

    /**
     * Get formatted email with link
     */
    public function getEmailLinkAttribute()
    {
        return 'mailto:' . $this->email;
    }

    /**
     * Get formatted website with link
     */
    public function getWebsiteLinkAttribute()
    {
        $website = $this->website;
        if (!str_starts_with($website, 'http')) {
            $website = 'https://' . $website;
        }
        return $website;
    }
}
