<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Display a listing of grades.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get graded submissions
        $submissions = Submission::where('student_id', $user->id)
            ->where('status', 'graded')
            ->with(['assignment.course'])
            ->orderBy('graded_at', 'desc')
            ->paginate(10);

        // Calculate statistics
        $totalAssignments = Submission::where('student_id', $user->id)
            ->where('status', 'graded')
            ->count();

        $averageGrade = Submission::where('student_id', $user->id)
            ->where('status', 'graded')
            ->avg('score');

        $highestGrade = Submission::where('student_id', $user->id)
            ->where('status', 'graded')
            ->max('score');

        $lowestGrade = Submission::where('student_id', $user->id)
            ->where('status', 'graded')
            ->min('score');

        // Get grades by course
        $gradesByCourse = Course::whereHas('enrollments', function($query) use ($user) {
            $query->where('student_id', $user->id)
                  ->where('status', 'approved');
        })
        ->with(['assignments.submissions' => function($query) use ($user) {
            $query->where('student_id', $user->id)
                  ->where('status', 'graded');
        }])
        ->get()
        ->map(function($course) {
            $gradedSubmissions = $course->assignments->flatMap->submissions;
            $totalPoints = $gradedSubmissions->sum('score');
            $maxPoints = $course->assignments->sum('points');
            
            return [
                'course' => $course,
                'total_points' => $totalPoints,
                'max_points' => $maxPoints,
                'percentage' => $maxPoints > 0 ? round(($totalPoints / $maxPoints) * 100, 2) : 0,
                'assignments_count' => $gradedSubmissions->count()
            ];
        });

        $stats = [
            'total_assignments' => $totalAssignments,
            'average_grade' => round($averageGrade, 2),
            'highest_grade' => $highestGrade,
            'lowest_grade' => $lowestGrade
        ];

        return view('student.grades.index', compact('submissions', 'stats', 'gradesByCourse'));
    }
}