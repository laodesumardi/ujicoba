<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::latest()->paginate(10);
        $unreadCount = Message::unread()->count();
        
        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        // Mark as read when viewed
        if ($message->status === 'unread') {
            $message->markAsRead();
        }
        
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000'
        ]);

        $message->markAsReplied($request->admin_reply);

        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Pesan berhasil dibalas.');
    }

    /**
     * Mark message as read
     */
    public function markAsRead(Message $message)
    {
        $message->markAsRead();
        
        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan ditandai sebagai sudah dibaca.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
