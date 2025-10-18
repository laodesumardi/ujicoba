<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'level',
        'hours_per_week',
        'color',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'hours_per_week' => 'integer',
        'sort_order' => 'integer'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Relationships
    public function teachers()
    {
        return $this->hasMany(User::class, 'subject', 'name')->where('role', 'teacher');
    }

    // Accessors
    public function getLevelLabelAttribute()
    {
        $levels = [
            'SD' => 'Sekolah Dasar',
            'SMP' => 'Sekolah Menengah Pertama',
            'SMA' => 'Sekolah Menengah Atas'
        ];
        return $levels[$this->level] ?? $this->level;
    }

    public function getColorClassAttribute()
    {
        $colorMap = [
            '#3B82F6' => 'bg-blue-100 text-blue-800',
            '#EF4444' => 'bg-red-100 text-red-800',
            '#10B981' => 'bg-green-100 text-green-800',
            '#F59E0B' => 'bg-yellow-100 text-yellow-800',
            '#8B5CF6' => 'bg-purple-100 text-purple-800',
            '#F97316' => 'bg-orange-100 text-orange-800',
        ];
        return $colorMap[$this->color] ?? 'bg-gray-100 text-gray-800';
    }
}