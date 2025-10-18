<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
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
        
        $lessons = $course->lessons()
                         ->orderBy('order')
                         ->paginate(10);

        return view('teacher.lessons.index', compact('course', 'lessons'));
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
        
        return view('teacher.lessons.create', compact('course'));
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
            'description' => 'nullable|string',
            'content' => 'required|string',
            'type' => 'required|in:lesson,assignment,quiz,exam',
            'due_date' => 'nullable|date|after:now',
            'points' => 'nullable|integer|min:0',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif|max:10240'
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('lessons/attachments', 'public');
                $attachments[] = $path;
            }
        }

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'type' => $request->type,
            'order' => $course->lessons()->max('order') + 1,
            'due_date' => $request->due_date,
            'points' => $request->points,
            'attachments' => $attachments,
            'is_published' => $request->boolean('is_published', false),
            'published_at' => $request->boolean('is_published') ? now() : null,
            'settings' => [
                'allow_comments' => $request->boolean('allow_comments', true),
                'require_completion' => $request->boolean('require_completion', false),
                'show_progress' => $request->boolean('show_progress', true)
            ]
        ]);

        return redirect()->route('teacher.courses.lessons.show', [$course, $lesson])
                        ->with('success', 'Materi berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Lesson $lesson)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $lesson->load(['assignments']);
        
        return view('teacher.lessons.show', compact('course', 'lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Lesson $lesson)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        return view('teacher.lessons.edit', compact('course', 'lesson'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Lesson $lesson)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'type' => 'required|in:lesson,assignment,quiz,exam',
            'due_date' => 'nullable|date|after:now',
            'points' => 'nullable|integer|min:0',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif|max:10240'
        ]);

        $attachments = $lesson->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('lessons/attachments', 'public');
                $attachments[] = $path;
            }
        }

        $lesson->update([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'type' => $request->type,
            'due_date' => $request->due_date,
            'points' => $request->points,
            'attachments' => $attachments,
            'is_published' => $request->boolean('is_published', $lesson->is_published),
            'published_at' => $request->boolean('is_published') && !$lesson->is_published ? now() : $lesson->published_at,
            'settings' => array_merge($lesson->settings ?? [], [
                'allow_comments' => $request->boolean('allow_comments', true),
                'require_completion' => $request->boolean('require_completion', false),
                'show_progress' => $request->boolean('show_progress', true)
            ])
        ]);

        return redirect()->route('teacher.courses.lessons.show', [$course, $lesson])
                        ->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        // Delete attachments
        if ($lesson->attachments) {
            foreach ($lesson->attachments as $attachment) {
                Storage::disk('public')->delete($attachment);
            }
        }
        
        $lesson->delete();
        
        return redirect()->route('teacher.courses.lessons.index', $course)
                        ->with('success', 'Materi berhasil dihapus!');
    }

    /**
     * Toggle lesson published status
     */
    public function togglePublished(Course $course, Lesson $lesson)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $lesson->update([
            'is_published' => !$lesson->is_published,
            'published_at' => !$lesson->is_published ? now() : null
        ]);

        $status = $lesson->is_published ? 'dipublikasikan' : 'disembunyikan';
        
        return redirect()->back()
                        ->with('success', "Materi berhasil {$status}!");
    }

    /**
     * Reorder lessons
     */
    public function reorder(Request $request, Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $request->validate([
            'lessons' => 'required|array',
            'lessons.*' => 'integer|exists:lessons,id'
        ]);

        foreach ($request->lessons as $index => $lessonId) {
            Lesson::where('id', $lessonId)
                  ->where('course_id', $course->id)
                  ->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}