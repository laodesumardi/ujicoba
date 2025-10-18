<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'description',
        'type',
        'order',
        'is_published',
        'published_at',
        'due_date',
        'points',
        'attachments',
        'settings'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'due_date' => 'datetime',
        'attachments' => 'array',
        'settings' => 'array'
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        $types = [
            'lesson' => 'Materi',
            'assignment' => 'Tugas',
            'quiz' => 'Kuis',
            'exam' => 'Ujian'
        ];
        
        return $types[$this->type] ?? ucfirst($this->type);
    }

    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date < now();
    }

    public function getAttachmentUrlsAttribute()
    {
        if (!$this->attachments) return [];
        
        return array_map(function($attachment) {
            return asset('storage/' . $attachment);
        }, $this->attachments);
    }
}