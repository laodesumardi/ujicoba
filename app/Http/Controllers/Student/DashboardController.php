<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Forum;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * Display student dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Check if user is student
        if ($user->role !== 'student') {
            abort(403, 'Unauthorized access. Student role required.');
        }
        
        // Get enrolled courses
        $enrolledCourses = $user->enrollments()
            ->with('course')
            ->where('status', 'approved')
            ->get()
            ->pluck('course');

        // Get recent assignments
        $recentAssignments = Assignment::whereHas('course', function($query) use ($user) {
            $query->whereHas('enrollments', function($q) use ($user) {
                $q->where('student_id', $user->id)
                  ->where('status', 'approved');
            });
        })
        ->where('is_published', true)
        ->orderBy('due_date', 'asc')
        ->limit(5)
        ->get();

        // Get upcoming assignments
        $upcomingAssignments = Assignment::whereHas('course', function($query) use ($user) {
            $query->whereHas('enrollments', function($q) use ($user) {
                $q->where('student_id', $user->id)
                  ->where('status', 'approved');
            });
        })
        ->where('is_published', true)
        ->where('due_date', '>', now())
        ->orderBy('due_date', 'asc')
        ->limit(5)
        ->get();

        // Get overdue assignments
        $overdueAssignments = Assignment::whereHas('course', function($query) use ($user) {
            $query->whereHas('enrollments', function($q) use ($user) {
                $q->where('student_id', $user->id)
                  ->where('status', 'approved');
            });
        })
        ->where('is_published', true)
        ->where('due_date', '<', now())
        ->whereDoesntHave('submissions', function($q) use ($user) {
            $q->where('student_id', $user->id)
              ->where('status', 'submitted');
        })
        ->orderBy('due_date', 'asc')
        ->limit(5)
        ->get();

        // Get recent forum posts
        $recentForums = Forum::whereHas('course', function($query) use ($user) {
            $query->whereHas('enrollments', function($q) use ($user) {
                $q->where('student_id', $user->id)
                  ->where('status', 'approved');
            });
        })
        ->orderBy('last_activity', 'desc')
        ->limit(5)
        ->get();

        // Get submission statistics
        $totalAssignments = Assignment::whereHas('course', function($query) use ($user) {
            $query->whereHas('enrollments', function($q) use ($user) {
                $q->where('student_id', $user->id)
                  ->where('status', 'approved');
            });
        })->count();

        $submittedAssignments = Submission::where('student_id', $user->id)
            ->where('status', 'submitted')
            ->count();

        $gradedAssignments = Submission::where('student_id', $user->id)
            ->where('status', 'graded')
            ->count();

        // Calculate statistics
        $stats = [
            'total_courses' => $enrolledCourses->count(),
            'total_assignments' => $totalAssignments,
            'submitted_assignments' => $submittedAssignments,
            'graded_assignments' => $gradedAssignments,
            'upcoming_assignments' => $upcomingAssignments->count(),
            'overdue_assignments' => $overdueAssignments->count(),
            'recent_forums' => $recentForums->count()
        ];

        return view('student.dashboard', compact(
            'enrolledCourses',
            'recentAssignments',
            'upcomingAssignments',
            'overdueAssignments',
            'recentForums',
            'stats'
        ));
    }
}
