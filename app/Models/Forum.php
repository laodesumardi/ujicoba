<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'type',
        'is_pinned',
        'is_locked',
        'author_id',
        'views',
        'replies_count',
        'last_activity',
        'attachments'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'last_activity' => 'datetime',
        'attachments' => 'array'
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function replies()
    {
        return $this->hasMany(ForumReply::class);
    }

    public function latestReply()
    {
        return $this->hasOne(ForumReply::class)->latest();
    }

    // Scopes
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeUnlocked($query)
    {
        return $query->where('is_locked', false);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('last_activity', 'desc');
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        $types = [
            'general' => 'Umum',
            'announcement' => 'Pengumuman',
            'discussion' => 'Diskusi',
            'qna' => 'Tanya Jawab'
        ];
        
        return $types[$this->type] ?? ucfirst($this->type);
    }

    public function getIsActiveAttribute()
    {
        return $this->last_activity && $this->last_activity > now()->subDays(7);
    }

    public function getTimeAgoAttribute()
    {
        return $this->last_activity ? $this->last_activity->diffForHumans() : null;
    }
}