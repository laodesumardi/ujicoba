<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of available courses.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get available courses for student's class level and section
        $availableCourses = Course::forStudent($user->class_level, $user->class_section)
            ->whereDoesntHave('enrollments', function($query) use ($user) {
                $query->where('student_id', $user->id);
            })
            ->with(['teacher', 'enrollments'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('student.courses.index', compact('availableCourses'));
    }

    /**
     * Display enrolled courses.
     */
    public function enrolled()
    {
        $user = Auth::user();
        
        $enrolledCourses = $user->enrollments()
            ->with('course.teacher')
            ->where('status', 'approved')
            ->get()
            ->pluck('course');

        return view('student.courses.enrolled', compact('enrolledCourses'));
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $user = Auth::user();
        
        // Check if student is enrolled
        $enrollment = $user->enrollments()
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment || $enrollment->status !== 'approved') {
            return redirect()->route('student.courses.index')
                ->with('error', 'Anda belum terdaftar di kelas ini.');
        }

        // Load course data
        $course->load([
            'lessons' => function($query) {
                $query->where('is_published', true)->orderBy('order');
            },
            'assignments' => function($query) {
                $query->where('is_published', true)->orderBy('due_date');
            },
            'forums' => function($query) {
                $query->orderBy('is_pinned', 'desc')->orderBy('last_activity', 'desc');
            }
        ]);

        return view('student.courses.show', compact('course', 'enrollment'));
    }

    /**
     * Enroll in a course.
     */
    public function enroll(Course $course)
    {
        $user = Auth::user();
        
        // Check if already enrolled
        $existingEnrollment = $user->enrollments()
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->back()
                ->with('error', 'Anda sudah terdaftar di kelas ini.');
        }

        // Check if course is available for enrollment
        if (!$course->is_public || $course->status !== 'active') {
            return redirect()->back()
                ->with('error', 'Kelas ini tidak tersedia untuk pendaftaran.');
        }

        // Check enrollment limit
        if ($course->max_students && $course->enrollments()->where('status', 'approved')->count() >= $course->max_students) {
            return redirect()->back()
                ->with('error', 'Kelas ini sudah penuh.');
        }

        // Create enrollment
        CourseEnrollment::create([
            'student_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'approved', // Auto-approve for now
            'enrolled_at' => now()
        ]);

        return redirect()->route('student.courses.show', $course)
            ->with('success', 'Berhasil mendaftar di kelas ' . $course->title . '!');
    }
}