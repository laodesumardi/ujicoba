<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'lesson_id',
        'title',
        'description',
        'instructions',
        'type',
        'points',
        'due_date',
        'allow_late_submission',
        'late_penalty',
        'is_published',
        'published_at',
        'attachments',
        'rubric'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'allow_late_submission' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'attachments' => 'array',
        'rubric' => 'array'
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
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

    public function scopeUpcoming($query)
    {
        return $query->where('due_date', '>', now());
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now());
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        $types = [
            'assignment' => 'Tugas',
            'quiz' => 'Kuis',
            'exam' => 'Ujian',
            'project' => 'Proyek'
        ];
        
        return $types[$this->type] ?? ucfirst($this->type);
    }

    public function getIsOverdueAttribute()
    {
        return $this->due_date < now();
    }

    public function getSubmissionCountAttribute()
    {
        return $this->submissions()->count();
    }

    public function getGradedCountAttribute()
    {
        return $this->submissions()->where('status', 'graded')->count();
    }

    public function getAttachmentUrlsAttribute()
    {
        if (!$this->attachments) return [];
        
        return array_map(function($attachment) {
            return asset('storage/' . $attachment);
        }, $this->attachments);
    }
}