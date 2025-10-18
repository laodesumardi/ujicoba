<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display teacher dashboard.
     */
    public function index()
    {
        $teacher = Auth::user();
        
        // Check if user is teacher
        if (!$teacher || $teacher->role !== 'teacher') {
            abort(403, 'Unauthorized access. Teacher role required.');
        }
        
        // Get teacher's courses
        $courses = $teacher->courses()->with(['lessons', 'enrollments'])->get();
        
        // Get basic statistics
        $totalTeachers = User::where('role', 'teacher')->where('is_active', true)->count();
        $totalStudents = $courses->sum(function($course) {
            return $course->enrollments->where('status', 'approved')->count();
        });
        $totalSubjects = $courses->pluck('subject')->unique()->count();
        $totalCourses = $courses->count();
        $activeCourses = $courses->where('status', 'active')->count();
        $totalAssignments = $courses->sum(function($course) {
            return $course->assignments->count();
        });
        
        // Get most popular course
        $mostPopularCourse = $courses->sortByDesc(function($course) {
            return $course->enrollments->where('status', 'approved')->count();
        })->first();
        $mostPopularCourseName = $mostPopularCourse ? $mostPopularCourse->title : 'N/A';
        
        // Get course performance data
        $coursePerformance = $courses->map(function($course) {
            return [
                'title' => $course->title,
                'subject' => $course->subject,
                'class_level' => $course->class_level,
                'enrollments_count' => $course->enrollments->where('status', 'approved')->count(),
                'assignments_count' => $course->assignments->count(),
                'status' => $course->status
            ];
        });
        
        // Get pending submissions
        $pendingSubmissions = collect();
        foreach ($courses as $course) {
            $submissions = $course->assignments()
                                ->with(['submissions' => function($query) {
                                    $query->where('status', 'pending');
                                }])
                                ->get()
                                ->pluck('submissions')
                                ->flatten();
            $pendingSubmissions = $pendingSubmissions->merge($submissions);
        }
        
        // Get overdue assignments
        $overdueAssignments = collect();
        foreach ($courses as $course) {
            $overdue = $course->assignments()
                            ->where('due_date', '<', now())
                            ->where('is_published', true)
                            ->get();
            $overdueAssignments = $overdueAssignments->merge($overdue);
        }
        
        // Get recent activities (placeholder)
        $recentActivities = [
            [
                'title' => 'Login ke sistem',
                'description' => 'Anda berhasil login ke dashboard guru',
                'time' => now()->format('d M Y H:i'),
                'type' => 'success'
            ]
        ];
        
        // Get teacher info
        $teacherInfo = [
            'name' => $teacher->name,
            'email' => $teacher->email,
            'subject' => 'Matematika', // Default subject
            'position' => 'Guru',
            'employment_status' => 'Aktif',
            'join_date' => now()->format('d M Y')
        ];
        
        return view('teacher.dashboard', compact(
            'teacher',
            'totalTeachers',
            'totalStudents', 
            'totalSubjects',
            'totalCourses',
            'activeCourses',
            'totalAssignments',
            'courses',
            'pendingSubmissions',
            'overdueAssignments',
            'recentActivities',
            'teacherInfo',
            'mostPopularCourseName',
            'coursePerformance'
        ));
    }
}