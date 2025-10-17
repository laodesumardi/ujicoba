<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPDB extends Model
{
    protected $table = 'ppdb_info';
    
    protected $fillable = [
        'title',
        'description',
        'requirements',
        'schedule',
        'technical_guide',
        'faq',
        'contact_person',
        'contact_phone',
        'contact_email',
        'registration_link',
        'is_active',
        'registration_start',
        'registration_end',
        'quota'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'registration_start' => 'date',
        'registration_end' => 'date',
    ];

    // Scope untuk PPDB aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Cek apakah pendaftaran masih dibuka
    public function isRegistrationOpen()
    {
        $now = now();
        return $this->is_active && 
               $this->registration_start <= $now && 
               $this->registration_end >= $now;
    }
}
