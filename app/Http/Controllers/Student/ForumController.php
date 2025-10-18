<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use App\Models\ForumReply;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Display a listing of forums.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get forums from enrolled courses
        $forums = Forum::whereHas('course', function($query) use ($user) {
            $query->whereHas('enrollments', function($q) use ($user) {
                $q->where('student_id', $user->id)
                  ->where('status', 'approved');
            });
        })
        ->with(['author', 'course', 'latestReply'])
        ->orderBy('is_pinned', 'desc')
        ->orderBy('last_activity', 'desc')
        ->paginate(10);

        return view('student.forums.index', compact('forums'));
    }

    /**
     * Display the specified forum.
     */
    public function show(Forum $forum)
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the course
        $enrollment = $user->enrollments()
            ->where('course_id', $forum->course_id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        // Load forum with replies
        $forum->load(['author', 'replies.user']);
        
        $replies = $forum->replies()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('student.forums.show', compact('forum', 'replies'));
    }

    /**
     * Store a new reply.
     */
    public function storeReply(Request $request, Forum $forum)
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the course
        $enrollment = $user->enrollments()
            ->where('course_id', $forum->course_id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        // Check if forum is locked
        if ($forum->is_locked) {
            return redirect()->back()
                ->with('error', 'Forum ini dikunci, tidak dapat membalas.');
        }

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        // Create reply
        ForumReply::create([
            'forum_id' => $forum->id,
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        // Update forum last activity
        $forum->update([
            'last_activity' => now(),
            'replies_count' => $forum->replies_count + 1
        ]);

        return redirect()->back()
            ->with('success', 'Balasan berhasil dikirim!');
    }
}