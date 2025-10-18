<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display assignments overview for teacher
     */
    public function overview()
    {
        $teacher = Auth::user();
        
        // Get all assignments from teacher's courses
        $assignments = Assignment::whereHas('course', function($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })
        ->with(['course', 'submissions'])
        ->orderBy('due_date', 'desc')
        ->paginate(15);

        $stats = [
            'total_assignments' => Assignment::whereHas('course', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->count(),
            'published_assignments' => Assignment::whereHas('course', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->where('is_published', true)->count(),
            'total_submissions' => Assignment::whereHas('course', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->withCount('submissions')->get()->sum('submissions_count'),
            'graded_submissions' => Assignment::whereHas('course', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->withCount(['submissions' => function($query) {
                $query->where('status', 'graded');
            }])->get()->sum('submissions_count')
        ];

        return view('teacher.assignments.overview', compact('assignments', 'stats'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $assignments = $course->assignments()
                             ->withCount('submissions')
                             ->orderBy('due_date', 'desc')
                             ->paginate(10);

        $stats = [
            'total_assignments' => $assignments->total(),
            'published_assignments' => $course->assignments()->where('is_published', true)->count(),
            'total_submissions' => $course->assignments()->withCount('submissions')->get()->sum('submissions_count'),
            'graded_submissions' => $course->assignments()->withCount(['submissions' => function($query) {
                $query->where('status', 'graded');
            }])->get()->sum('submissions_count')
        ];

        return view('teacher.assignments.index', compact('course', 'assignments', 'stats'));
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
        
        return view('teacher.assignments.create', compact('course'));
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
            'instructions' => 'required|string',
            'type' => 'required|in:assignment,quiz,exam,project',
            'points' => 'required|integer|min:1',
            'due_date' => 'required|date|after:now',
            'allow_late_submission' => 'boolean',
            'late_penalty' => 'nullable|integer|min:0|max:100',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif|max:10240',
            'rubric' => 'nullable|array'
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('assignments/attachments', 'public');
                $attachments[] = $path;
            }
        }

        $assignment = Assignment::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'instructions' => $request->instructions,
            'type' => $request->type,
            'points' => $request->points,
            'due_date' => $request->due_date,
            'allow_late_submission' => $request->boolean('allow_late_submission'),
            'late_penalty' => $request->late_penalty,
            'attachments' => $attachments,
            'rubric' => $request->rubric,
            'is_published' => $request->boolean('is_published', false),
            'published_at' => $request->boolean('is_published') ? now() : null
        ]);

        return redirect()->route('teacher.courses.assignments.show', [$course, $assignment])
                        ->with('success', 'Tugas berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Assignment $assignment)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $assignment->load(['submissions.student']);
        
        $submissions = $assignment->submissions()
                                ->with('student')
                                ->orderBy('submitted_at', 'desc')
                                ->paginate(10);

        $stats = [
            'total_submissions' => $assignment->submissions->count(),
            'graded_submissions' => $assignment->submissions->where('status', 'graded')->count(),
            'pending_submissions' => $assignment->submissions->where('status', 'pending')->count(),
            'late_submissions' => $assignment->submissions->where('is_late', true)->count()
        ];

        return view('teacher.assignments.show', compact('course', 'assignment', 'submissions', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Assignment $assignment)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        return view('teacher.assignments.edit', compact('course', 'assignment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Assignment $assignment)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'type' => 'required|in:assignment,quiz,exam,project',
            'points' => 'required|integer|min:1',
            'due_date' => 'required|date',
            'allow_late_submission' => 'boolean',
            'late_penalty' => 'nullable|integer|min:0|max:100',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif|max:10240',
            'rubric' => 'nullable|array'
        ]);

        $attachments = $assignment->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('assignments/attachments', 'public');
                $attachments[] = $path;
            }
        }

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'instructions' => $request->instructions,
            'type' => $request->type,
            'points' => $request->points,
            'due_date' => $request->due_date,
            'allow_late_submission' => $request->boolean('allow_late_submission'),
            'late_penalty' => $request->late_penalty,
            'attachments' => $attachments,
            'rubric' => $request->rubric,
            'is_published' => $request->boolean('is_published', $assignment->is_published),
            'published_at' => $request->boolean('is_published') && !$assignment->is_published ? now() : $assignment->published_at
        ]);

        return redirect()->route('teacher.courses.assignments.show', [$course, $assignment])
                        ->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Assignment $assignment)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        // Delete attachments
        if ($assignment->attachments) {
            foreach ($assignment->attachments as $attachment) {
                Storage::disk('public')->delete($attachment);
            }
        }
        
        $assignment->delete();
        
        return redirect()->route('teacher.courses.assignments.index', $course)
                        ->with('success', 'Tugas berhasil dihapus!');
    }

    /**
     * Toggle assignment published status
     */
    public function togglePublished(Course $course, Assignment $assignment)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $assignment->update([
            'is_published' => !$assignment->is_published,
            'published_at' => !$assignment->is_published ? now() : null
        ]);

        $status = $assignment->is_published ? 'dipublikasikan' : 'disembunyikan';
        
        return redirect()->back()
                        ->with('success', "Tugas berhasil {$status}!");
    }

    /**
     * Grade submission
     */
    public function gradeSubmission(Request $request, Course $course, Assignment $assignment, Submission $submission)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $request->validate([
            'grade' => 'required|numeric|min:0|max:' . $assignment->points,
            'feedback' => 'nullable|string|max:1000'
        ]);

        $submission->update([
            'score' => $request->grade,
            'feedback' => $request->feedback,
            'status' => 'graded',
            'graded_at' => now(),
            'graded_by' => Auth::id()
        ]);

        return redirect()->back()
                        ->with('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Download all submissions
     */
    public function downloadAllSubmissions(Course $course, Assignment $assignment)
    {
        // Check if user is the teacher of this course
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        // This would typically create a ZIP file of all submissions
        // For now, return a placeholder response
        return response()->json(['message' => 'Download feature coming soon']);
    }
}