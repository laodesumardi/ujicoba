<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get all notifications
     */
    public function index()
    {
        $notifications = Notification::latest()->take(10)->get();
        $unreadCount = Notification::unread()->count();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount()
    {
        $count = Notification::unread()->count();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);
        
        return response()->json(['success' => true]);
    }

    /**
     * Delete notification
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        
        return response()->json(['success' => true]);
    }

    /**
     * Clear all notifications
     */
    public function clearAll()
    {
        Notification::truncate();
        
        return response()->json(['success' => true]);
    }
}
