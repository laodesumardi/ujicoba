<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Forum;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $forums = $course->forums()
                        ->with(['author', 'latestReply'])
                        ->orderBy('is_pinned', 'desc')
                        ->orderBy('last_activity', 'desc')
                        ->paginate(10);

        $stats = [
            'total_forums' => $forums->total(),
            'pinned_forums' => $course->forums()->where('is_pinned', true)->count(),
            'locked_forums' => $course->forums()->where('is_locked', true)->count(),
            'total_replies' => $course->forums()->withCount('replies')->get()->sum('replies_count')
        ];

        return view('teacher.forums.index', compact('course', 'forums', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        return view('teacher.forums.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:general,announcement,discussion,qna',
            'is_pinned' => 'boolean',
            'is_locked' => 'boolean',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif|max:10240'
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('forums/attachments', 'public');
                $attachments[] = $path;
            }
        }

        $forum = Forum::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'author_id' => Auth::id(),
            'is_pinned' => $request->boolean('is_pinned'),
            'is_locked' => $request->boolean('is_locked'),
            'attachments' => $attachments,
            'last_activity' => now()
        ]);

        return redirect()->route('teacher.courses.forums.show', [$course, $forum])
                        ->with('success', 'Forum berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Forum $forum)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $forum->load(['author', 'replies.user']);
        
        $replies = $forum->replies()
                        ->with('user')
                        ->orderBy('created_at')
                        ->paginate(20);

        return view('teacher.forums.show', compact('course', 'forum', 'replies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Forum $forum)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        return view('teacher.forums.edit', compact('course', 'forum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Forum $forum)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:general,announcement,discussion,qna',
            'is_pinned' => 'boolean',
            'is_locked' => 'boolean',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif|max:10240'
        ]);

        $attachments = $forum->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('forums/attachments', 'public');
                $attachments[] = $path;
            }
        }

        $forum->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'is_pinned' => $request->boolean('is_pinned'),
            'is_locked' => $request->boolean('is_locked'),
            'attachments' => $attachments
        ]);

        return redirect()->route('teacher.courses.forums.show', [$course, $forum])
                        ->with('success', 'Forum berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Forum $forum)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $forum->delete();
        
        return redirect()->route('teacher.courses.forums.index', $course)
                        ->with('success', 'Forum berhasil dihapus!');
    }

    /**
     * Toggle pin status
     */
    public function togglePin(Course $course, Forum $forum)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $forum->update(['is_pinned' => !$forum->is_pinned]);
        
        $status = $forum->is_pinned ? 'dipasang' : 'dilepas';
        
        return redirect()->back()
                        ->with('success', "Forum berhasil {$status}!");
    }

    /**
     * Toggle lock status
     */
    public function toggleLock(Course $course, Forum $forum)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $forum->update(['is_locked' => !$forum->is_locked]);
        
        $status = $forum->is_locked ? 'dikunci' : 'dibuka';
        
        return redirect()->back()
                        ->with('success', "Forum berhasil {$status}!");
    }

    /**
     * Store a reply
     */
    public function storeReply(Request $request, Course $course, Forum $forum)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        if ($forum->is_locked) {
            return redirect()->back()
                           ->with('error', 'Forum ini dikunci, tidak dapat membalas.');
        }
        
        $request->validate([
            'content' => 'required|string|max:2000'
        ]);

        ForumReply::create([
            'forum_id' => $forum->id,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        // Update forum last activity
        $forum->update([
            'last_activity' => now(),
            'replies_count' => $forum->replies_count + 1
        ]);

        return redirect()->back()
                        ->with('success', 'Balasan berhasil dikirim!');
    }

    /**
     * Delete a reply
     */
    public function deleteReply(Course $course, Forum $forum, ForumReply $reply)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $reply->delete();
        
        // Update forum replies count
        $forum->update([
            'replies_count' => $forum->replies_count - 1
        ]);

        return redirect()->back()
                        ->with('success', 'Balasan berhasil dihapus!');
    }
}