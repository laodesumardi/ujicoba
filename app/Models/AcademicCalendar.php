<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AcademicCalendar extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'type',
        'priority',
        'location',
        'organizer',
        'is_all_day',
        'is_public',
        'is_downloadable',
        'file_path',
        'color',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_all_day' => 'boolean',
        'is_public' => 'boolean',
        'is_downloadable' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeUpcoming($query, $days = 30)
    {
        return $query->where('start_date', '>=', now())
                    ->where('start_date', '<=', now()->addDays($days));
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('start_date', now()->month)
                    ->whereYear('start_date', now()->year);
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        $types = [
            'semester' => 'Semester',
            'ujian' => 'Ujian',
            'libur' => 'Libur',
            'hari_besar' => 'Hari Besar',
            'kegiatan' => 'Kegiatan',
            'lainnya' => 'Lainnya'
        ];

        return $types[$this->type] ?? ucfirst($this->type);
    }

    public function getPriorityLabelAttribute()
    {
        $priorities = [
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'critical' => 'Kritis'
        ];

        return $priorities[$this->priority] ?? ucfirst($this->priority);
    }

    public function getDurationAttribute()
    {
        if ($this->end_date && $this->start_date) {
            return $this->start_date->diffInDays($this->end_date) + 1;
        }
        return 1;
    }

    public function getFormattedDateAttribute()
    {
        if ($this->is_all_day) {
            if ($this->end_date && $this->start_date != $this->end_date) {
                return $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y');
            }
            return $this->start_date->format('d M Y');
        }

        $date = $this->start_date->format('d M Y');
        if ($this->start_time) {
            $date .= ' ' . Carbon::parse($this->start_time)->format('H:i');
        }
        if ($this->end_time) {
            $date .= ' - ' . Carbon::parse($this->end_time)->format('H:i');
        }

        return $date;
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    // Methods
    public function isUpcoming()
    {
        return $this->start_date >= now()->startOfDay();
    }

    public function isPast()
    {
        return $this->start_date < now()->startOfDay();
    }

    public function isToday()
    {
        return $this->start_date->isToday();
    }

    public function isThisWeek()
    {
        return $this->start_date->isCurrentWeek();
    }

    public function isThisMonth()
    {
        return $this->start_date->isCurrentMonth();
    }
}
