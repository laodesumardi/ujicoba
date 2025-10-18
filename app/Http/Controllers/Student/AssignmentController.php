<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display a listing of assignments.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get assignments from enrolled courses
        $assignments = Assignment::whereHas('course', function($query) use ($user) {
            $query->whereHas('enrollments', function($q) use ($user) {
                $q->where('student_id', $user->id)
                  ->where('status', 'approved');
            });
        })
        ->where('is_published', true)
        ->with(['course', 'submissions' => function($query) use ($user) {
            $query->where('student_id', $user->id);
        }])
        ->orderBy('due_date', 'asc')
        ->paginate(10);

        return view('student.assignments.index', compact('assignments'));
    }

    /**
     * Display submitted assignments.
     */
    public function submitted()
    {
        $user = Auth::user();
        
        $submissions = Submission::where('student_id', $user->id)
            ->where('status', 'submitted')
            ->with(['assignment.course'])
            ->orderBy('submitted_at', 'desc')
            ->paginate(10);

        return view('student.assignments.submitted', compact('submissions'));
    }

    /**
     * Display graded assignments.
     */
    public function graded()
    {
        $user = Auth::user();
        
        $submissions = Submission::where('student_id', $user->id)
            ->where('status', 'graded')
            ->with(['assignment.course'])
            ->orderBy('graded_at', 'desc')
            ->paginate(10);

        return view('student.assignments.graded', compact('submissions'));
    }

    /**
     * Display the specified assignment.
     */
    public function show(Assignment $assignment)
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the course
        $enrollment = $user->enrollments()
            ->where('course_id', $assignment->course_id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        // Get student's submission
        $submission = $assignment->submissions()
            ->where('student_id', $user->id)
            ->first();

        return view('student.assignments.show', compact('assignment', 'submission'));
    }

    /**
     * Submit assignment.
     */
    public function submit(Request $request, Assignment $assignment)
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the course
        $enrollment = $user->enrollments()
            ->where('course_id', $assignment->course_id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        // Check if assignment is still open
        if ($assignment->due_date && $assignment->due_date < now()) {
            return redirect()->back()
                ->with('error', 'Tugas sudah melewati deadline.');
        }

        $request->validate([
            'content' => 'required|string',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:pdf,doc,docx,txt,jpg,jpeg,png|max:10240' // 10MB max
        ]);

        // Handle file uploads
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('submissions', 'public');
                $attachments[] = $path;
            }
        }

        // Create or update submission
        $submission = Submission::updateOrCreate(
            [
                'student_id' => $user->id,
                'assignment_id' => $assignment->id
            ],
            [
                'content' => $request->content,
                'attachments' => $attachments,
                'status' => 'submitted',
                'submitted_at' => now()
            ]
        );

        return redirect()->route('student.assignments.show', $assignment)
            ->with('success', 'Tugas berhasil dikumpulkan!');
    }

    /**
     * Download assignment attachment.
     */
    public function downloadAttachment(Assignment $assignment, $filename)
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the course
        $enrollment = $user->enrollments()
            ->where('course_id', $assignment->course_id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        $filePath = 'assignments/' . $filename;
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath);
    }
}