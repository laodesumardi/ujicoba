<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of forums.
     */
    public function index()
    {
        // Ambil semua forum yang tersedia untuk siswa
        $forums = \App\Models\Forum::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.forums.index', compact('forums'));
    }

    /**
     * Display the specified forum (from course context).
     */
    public function show($courseId, $forumId)
    {
        // Ambil balasan dari database untuk forum ini
        $replies = \App\Models\ForumReply::where('forum_id', $forumId)
            ->with('user')
            ->orderBy('created_at')
            ->get();

        return view('student.forums.show', compact('courseId', 'forumId', 'replies'));
    }

    /**
     * Display the specified forum (from general forums).
     */
    public function showForum($forumId)
    {
        // Ambil balasan dari database untuk forum ini
        $replies = \App\Models\ForumReply::where('forum_id', $forumId)
            ->with('user')
            ->orderBy('created_at')
            ->get();

        $forum = \App\Models\Forum::findOrFail($forumId);

        return view('student.forums.show', [
            'courseId' => $forum->course_id ?? 0,
            'forumId' => $forumId,
            'replies' => $replies,
            'forum' => $forum
        ]);
    }

    /**
     * Store a newly created reply.
     */
    public function storeReply(Request $request, $courseId, $forumId)
    {
        $validated = $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        // Simpan balasan ke database
        $reply = \App\Models\ForumReply::create([
            'forum_id' => $forumId,
            'user_id' => auth()->id(),
            'content' => $validated['reply'],
        ]);

        // Broadcast pesan ke guru melalui localStorage untuk real-time
        $broadcastScript = $this->broadcastMessageToTeacher($reply, $courseId, $forumId);

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Balasan berhasil dikirim!',
                'reply' => [
                    'id' => $reply->id,
                    'content' => $reply->content,
                    'author' => $reply->user->name,
                    'timestamp' => $reply->created_at->toISOString(),
                    'fromStudent' => true
                ]
            ]);
        }

        return redirect()->route('student.courses.forums.show', [$courseId, $forumId])
            ->with('success', 'Balasan berhasil dikirim!')
            ->with('broadcast_script', $broadcastScript);
    }

    /**
     * Store a newly created reply (from general forums).
     */
    public function storeReplyForum(Request $request, $forumId)
    {
        $validated = $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        // Simpan balasan ke database
        $reply = \App\Models\ForumReply::create([
            'forum_id' => $forumId,
            'user_id' => auth()->id(),
            'content' => $validated['reply'],
        ]);

        // Broadcast pesan ke guru melalui localStorage untuk real-time
        $broadcastScript = $this->broadcastMessageToTeacher($reply, 0, $forumId);

        return redirect()->route('student.forums.show', $forumId)
            ->with('success', 'Balasan berhasil dikirim!')
            ->with('broadcast_script', $broadcastScript);
    }

    private function broadcastMessageToTeacher($reply, $courseId, $forumId)
    {
        // Buat script JavaScript untuk broadcast ke halaman guru
        $script = "
        <script>
        if (typeof(Storage) !== 'undefined') {
            const messageObj = {
                message: '" . addslashes($reply->content) . "',
                author: '" . addslashes($reply->user->name) . "',
                isOwn: false,
                timestamp: '" . $reply->created_at->toISOString() . "',
                fromStudent: true
            };
            
            const broadcastKey = 'student_broadcast_" . $courseId . "_" . $forumId . "';
            localStorage.setItem(broadcastKey, JSON.stringify(messageObj));
            
            // Trigger storage event
            window.dispatchEvent(new StorageEvent('storage', {
                key: broadcastKey,
                newValue: JSON.stringify(messageObj),
                url: window.location.href
            }));
        }
        </script>";
        
        return $script;
    }
}