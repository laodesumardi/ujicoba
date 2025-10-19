<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'icon',
        'color',
        'data',
        'is_read',
        'read_at',
        'action_url',
        'action_text'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getColorClassAttribute()
    {
        $colors = [
            'blue' => 'bg-blue-100 text-blue-800 border-blue-200',
            'green' => 'bg-green-100 text-green-800 border-green-200',
            'red' => 'bg-red-100 text-red-800 border-red-200',
            'yellow' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'purple' => 'bg-purple-100 text-purple-800 border-purple-200'
        ];
        
        return $colors[$this->color] ?? $colors['blue'];
    }

    public function getIconClassAttribute()
    {
        $icons = [
            'ppdb_registration' => 'fas fa-user-plus',
            'message' => 'fas fa-envelope',
            'system' => 'fas fa-cog',
            'success' => 'fas fa-check-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'info' => 'fas fa-info-circle'
        ];
        
        return $icons[$this->icon] ?? $icons['info'];
    }

    // Methods
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null
        ]);
    }

    // Static methods for creating notifications
    public static function createPPDBRegistration($studentName, $registrationId = null)
    {
        return self::create([
            'type' => 'ppdb_registration',
            'title' => 'Pendaftaran PPDB Baru',
            'message' => "Siswa baru {$studentName} telah mendaftar PPDB",
            'icon' => 'ppdb_registration',
            'color' => 'green',
            'action_url' => $registrationId ? route('admin.ppdb.show-registration', $registrationId) : route('admin.ppdb.registrations'),
            'action_text' => 'Lihat Detail',
            'data' => [
                'student_name' => $studentName,
                'registration_id' => $registrationId
            ]
        ]);
    }

    public static function createMessage($senderName, $messageId = null)
    {
        return self::create([
            'type' => 'message',
            'title' => 'Pesan Baru',
            'message' => "Pesan baru dari {$senderName}",
            'icon' => 'message',
            'color' => 'blue',
            'action_url' => $messageId ? route('admin.messages.show', $messageId) : route('admin.messages.index'),
            'action_text' => 'Lihat Pesan',
            'data' => [
                'sender_name' => $senderName,
                'message_id' => $messageId
            ]
        ]);
    }

    public static function createSystem($title, $message, $color = 'blue')
    {
        return self::create([
            'type' => 'system',
            'title' => $title,
            'message' => $message,
            'icon' => 'system',
            'color' => $color,
            'action_url' => null,
            'action_text' => null
        ]);
    }
}
