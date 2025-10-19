<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    protected $fillable = [
        'status',
        'certificate_number',
        'year',
        'score',
        'valid_until',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'year' => 'integer',
        'score' => 'integer'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
