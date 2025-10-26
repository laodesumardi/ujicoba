<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display the specified forum.
     */
    public function show($courseId, $forumId)
    {
        try {
            // Ambil balasan dari database untuk forum ini
            $replies = \App\Models\ForumReply::where('forum_id', $forumId)
                ->with('user')
                ->orderBy('created_at')
                ->get();

            return view('teacher.forums.show', compact('courseId', 'forumId', 'replies'));
        } catch (\Exception $e) {
            // Jika ada error, return view dengan data kosong
            $replies = collect();
            return view('teacher.forums.show', compact('courseId', 'forumId', 'replies'))
                ->with('error', 'Error loading forum: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new forum.
     */
    public function create($courseId)
    {
        return view('teacher.forums.create', [
            'courseId' => $courseId
        ]);
    }

    /**
     * Store a newly created forum.
     */
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'is_pinned' => 'boolean',
            'is_locked' => 'boolean',
        ]);

        // In a real application, you would save the forum to database
        // For now, we'll just redirect back with success message
        
        return redirect()->route('teacher.courses.show', $courseId)
            ->with('success', 'Forum berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified forum.
     */
    public function edit($courseId, $forumId)
    {
        try {
            // Ambil forum dari database
            $forum = \App\Models\Forum::findOrFail($forumId);
            
            return view('teacher.forums.edit', [
                'courseId' => $courseId,
                'forumId' => $forumId,
                'forum' => $forum
            ]);
        } catch (\Exception $e) {
            return redirect()->route('teacher.courses.forums.show', [$courseId, $forumId])
                ->with('error', 'Forum tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified forum.
     */
    public function update(Request $request, $courseId, $forumId)
    {
        // Debug: Log request data
        \Log::info('Update Forum Request Data:', $request->all());
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:discussion,announcement,question',
            'is_pinned' => 'boolean',
            'is_locked' => 'boolean',
        ]);

        try {
            // Ambil forum dari database
            $forum = \App\Models\Forum::findOrFail($forumId);
            
            // Update forum
            $forum->update([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'is_pinned' => $request->has('is_pinned'),
                'is_locked' => $request->has('is_locked'),
                'last_activity' => now(),
            ]);
            
            return redirect()->route('teacher.courses.forums.show', [$courseId, $forumId])
                ->with('success', 'Forum berhasil diperbarui!');
                
        } catch (\Exception $e) {
            return redirect()->route('teacher.courses.forums.edit', [$courseId, $forumId])
                ->with('error', 'Error memperbarui forum: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified forum.
     */
    public function destroy($courseId, $forumId)
    {
        // In a real application, you would delete the forum from database
        
        return redirect()->route('teacher.courses.show', $courseId)
            ->with('success', 'Forum berhasil dihapus!');
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

        // Broadcast pesan ke siswa melalui localStorage untuk real-time
        $broadcastScript = $this->broadcastMessageToStudents($reply, $courseId, $forumId);

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
                    'fromTeacher' => true
                ]
            ]);
        }

        return redirect()->route('teacher.courses.forums.show', [$courseId, $forumId])
            ->with('broadcast_script', $broadcastScript);
    }

    private function broadcastMessageToStudents($reply, $courseId, $forumId)
    {
        // Buat script JavaScript untuk broadcast ke halaman siswa
        $script = "
        <script>
        if (typeof(Storage) !== 'undefined') {
            const messageObj = {
                message: '" . addslashes($reply->content) . "',
                author: '" . addslashes($reply->user->name) . "',
                isOwn: false,
                timestamp: '" . $reply->created_at->toISOString() . "',
                fromTeacher: true
            };
            
            const broadcastKey = 'teacher_broadcast_" . $courseId . "_" . $forumId . "';
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

    /**
     * Delete all replies for a forum.
     */
    public function deleteAllReplies(Request $request, $courseId, $forumId)
    {
        try {
            // Hapus semua balasan untuk forum ini
            $deletedCount = \App\Models\ForumReply::where('forum_id', $forumId)->delete();
            
            // Return JSON response for AJAX requests
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Semua pesan ($deletedCount pesan) telah dihapus!",
                    'deletedCount' => $deletedCount
                ]);
            }
            
            return redirect()->route('teacher.courses.forums.show', [$courseId, $forumId])
                ->with('success', "Semua pesan ($deletedCount pesan) telah dihapus!");
                
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error menghapus pesan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('teacher.courses.forums.show', [$courseId, $forumId])
                ->with('error', 'Error menghapus pesan: ' . $e->getMessage());
        }
    }
}