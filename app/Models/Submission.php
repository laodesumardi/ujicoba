<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'content',
        'attachments',
        'status',
        'score',
        'feedback',
        'submitted_at',
        'graded_at',
        'is_late'
    ];

    protected $casts = [
        'attachments' => 'array',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'is_late' => 'boolean'
    ];

    // Relationships
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Scopes
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeGraded($query)
    {
        return $query->where('status', 'graded');
    }

    public function scopeLate($query)
    {
        return $query->where('is_late', true);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'draft' => 'Draft',
            'submitted' => 'Dikirim',
            'graded' => 'Dinilai',
            'returned' => 'Dikembalikan'
        ];
        
        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    public function getAttachmentUrlsAttribute()
    {
        if (!$this->attachments) return [];
        
        return array_map(function($attachment) {
            return asset('storage/' . $attachment);
        }, $this->attachments);
    }

    public function getGradePercentageAttribute()
    {
        if (!$this->score || !$this->assignment) return null;
        
        return round(($this->score / $this->assignment->points) * 100, 2);
    }

    public function getGradeLetterAttribute()
    {
        $percentage = $this->grade_percentage;
        if (!$percentage) return null;
        
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'F';
    }
}