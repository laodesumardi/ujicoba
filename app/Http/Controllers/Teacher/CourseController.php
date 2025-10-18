<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = Auth::user();
        
        $courses = Course::where('teacher_id', $teacher->id)
                        ->with(['lessons', 'enrollments'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        $stats = [
            'total_courses' => $courses->total(),
            'active_courses' => Course::where('teacher_id', $teacher->id)
                                    ->where('status', 'active')
                                    ->count(),
            'total_students' => Course::where('teacher_id', $teacher->id)
                                    ->withCount('enrollments')
                                    ->get()
                                    ->sum('enrollments_count'),
            'total_lessons' => Course::where('teacher_id', $teacher->id)
                                    ->withCount('lessons')
                                    ->get()
                                    ->sum('lessons_count')
        ];

        return view('teacher.courses.index', compact('courses', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::where('is_active', true)->get();
        return view('teacher.courses.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $teacher = Auth::user();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'description' => 'required|string',
            'subject' => 'required|string',
            'class_level' => 'required|string',
            'class_section' => 'nullable|string|in:A,B,C,D',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'max_students' => 'nullable|integer|min:1',
            'is_public' => 'boolean'
        ]);

        $course = Course::create([
            'title' => $request->title,
            'code' => $request->code,
            'description' => $request->description,
            'subject' => $request->subject,
            'class_level' => $request->class_level,
            'class_section' => $request->class_section,
            'teacher_id' => $teacher->id,
            'status' => 'draft',
            'is_public' => $request->boolean('is_public'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'max_students' => $request->max_students,
            'settings' => [
                'allow_discussions' => $request->boolean('allow_discussions', true),
                'allow_announcements' => $request->boolean('allow_announcements', true),
                'auto_enroll' => $request->boolean('auto_enroll', false)
            ]
        ]);

        return redirect()->route('teacher.courses.show', $course)
                        ->with('success', 'Kelas berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $course->load(['lessons' => function($query) {
            $query->orderBy('order');
        }, 'enrollments.student', 'forums' => function($query) {
            $query->orderBy('is_pinned', 'desc')->orderBy('last_activity', 'desc');
        }]);

        $stats = [
            'total_lessons' => $course->lessons->count(),
            'published_lessons' => $course->lessons->where('is_published', true)->count(),
            'total_students' => $course->enrollments->where('status', 'approved')->count(),
            'pending_enrollments' => $course->enrollments->where('status', 'pending')->count(),
            'total_forums' => $course->forums->count(),
            'active_forums' => $course->forums->where('is_active', true)->count()
        ];

        return view('teacher.courses.show', compact('course', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $subjects = Subject::where('is_active', true)->get();
        return view('teacher.courses.edit', compact('course', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'description' => 'required|string',
            'subject' => 'required|string',
            'class_level' => 'required|string',
            'class_section' => 'nullable|string|in:A,B,C,D',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'max_students' => 'nullable|integer|min:1',
            'status' => 'required|string|in:draft,active,archived',
            'is_public' => 'boolean'
        ]);

        $course->update([
            'title' => $request->title,
            'code' => $request->code,
            'description' => $request->description,
            'subject' => $request->subject,
            'class_level' => $request->class_level,
            'class_section' => $request->class_section,
            'status' => $request->status,
            'is_public' => $request->boolean('is_public'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'max_students' => $request->max_students,
            'settings' => array_merge($course->settings ?? [], [
                'allow_discussions' => $request->boolean('allow_discussions', true),
                'allow_announcements' => $request->boolean('allow_announcements', true),
                'auto_enroll' => $request->boolean('auto_enroll', false)
            ])
        ]);

        return redirect()->route('teacher.courses.show', $course)
                        ->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $course->delete();
        
        return redirect()->route('teacher.courses.index')
                        ->with('success', 'Kelas berhasil dihapus!');
    }

    /**
     * Toggle course status
     */
    public function toggleStatus(Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $course->update([
            'status' => $course->status === 'active' ? 'draft' : 'active'
        ]);

        $status = $course->status === 'active' ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
                        ->with('success', "Kelas berhasil {$status}!");
    }

    /**
     * Archive course
     */
    public function archive(Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $course->update(['status' => 'archived']);
        
        return redirect()->back()
                        ->with('success', 'Kelas berhasil diarsipkan!');
    }
}