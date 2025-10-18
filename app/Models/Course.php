<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'code',
        'description',
        'subject',
        'class_level',
        'class_section',
        'teacher_id',
        'status',
        'is_public',
        'start_date',
        'end_date',
        'max_students',
        'settings'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'settings' => 'array'
    ];

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_enrollments', 'course_id', 'student_id')
                    ->withPivot('status', 'enrolled_at', 'progress', 'grade')
                    ->withTimestamps();
    }

    public function forums()
    {
        return $this->hasMany(Forum::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeBySubject($query, $subject)
    {
        return $query->where('subject', $subject);
    }

    public function scopeByClassLevel($query, $classLevel)
    {
        return $query->where('class_level', $classLevel);
    }

    public function scopeByClassSection($query, $classSection)
    {
        return $query->where('class_section', $classSection);
    }

    public function scopeForStudent($query, $studentClassLevel, $studentClassSection = null)
    {
        $query->where('is_public', true)
              ->where('status', 'active')
              ->where('class_level', $studentClassLevel);
              
        if ($studentClassSection) {
            $query->where(function($q) use ($studentClassSection) {
                $q->where('class_section', $studentClassSection)
                  ->orWhereNull('class_section');
            });
        }
        
        return $query;
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'draft' => 'Draft',
            'active' => 'Aktif',
            'archived' => 'Diarsipkan'
        ];
        
        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    public function getEnrolledStudentsCountAttribute()
    {
        return $this->enrollments()->where('status', 'approved')->count();
    }

    public function getIsEnrollmentOpenAttribute()
    {
        if (!$this->is_public || $this->status !== 'active') {
            return false;
        }

        if ($this->max_students && $this->enrolled_students_count >= $this->max_students) {
            return false;
        }

        if ($this->start_date && $this->start_date > now()) {
            return false;
        }

        if ($this->end_date && $this->end_date < now()) {
            return false;
        }

        return true;
    }

    public function getProgressAttribute()
    {
        $totalLessons = $this->lessons()->count();
        if ($totalLessons === 0) return 0;
        
        $completedLessons = $this->lessons()->where('is_published', true)->count();
        return round(($completedLessons / $totalLessons) * 100);
    }
}