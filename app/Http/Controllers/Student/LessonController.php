<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Display the specified lesson.
     */
    public function show(Course $course, Lesson $lesson)
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the course
        $enrollment = $user->enrollments()
            ->where('course_id', $course->id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses.index')
                ->with('error', 'Anda belum terdaftar di kelas ini.');
        }

        // Check if lesson is published
        if (!$lesson->is_published) {
            return redirect()->route('student.courses.show', $course)
                ->with('error', 'Materi ini belum tersedia.');
        }

        // Check if lesson belongs to the course
        if ($lesson->course_id !== $course->id) {
            return redirect()->route('student.courses.show', $course)
                ->with('error', 'Materi tidak ditemukan.');
        }

        // Load lesson with course data
        $lesson->load('course.teacher');
        
        // Get next and previous lessons
        $nextLesson = $course->lessons()
            ->where('is_published', true)
            ->where('order', '>', $lesson->order)
            ->orderBy('order')
            ->first();
            
        $previousLesson = $course->lessons()
            ->where('is_published', true)
            ->where('order', '<', $lesson->order)
            ->orderBy('order', 'desc')
            ->first();

        return view('student.lessons.show', compact('course', 'lesson', 'nextLesson', 'previousLesson'));
    }

    /**
     * Mark lesson as completed.
     */
    public function complete(Course $course, Lesson $lesson)
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the course
        $enrollment = $user->enrollments()
            ->where('course_id', $course->id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses.index')
                ->with('error', 'Anda belum terdaftar di kelas ini.');
        }

        // Check if lesson is published
        if (!$lesson->is_published) {
            return redirect()->route('student.courses.show', $course)
                ->with('error', 'Materi ini belum tersedia.');
        }

        // Check if lesson belongs to the course
        if ($lesson->course_id !== $course->id) {
            return redirect()->route('student.courses.show', $course)
                ->with('error', 'Materi tidak ditemukan.');
        }

        // Mark lesson as completed (you might want to create a lesson_completions table)
        // For now, we'll just redirect back with success message
        
        return redirect()->route('student.courses.show', $course)
            ->with('success', 'Materi "' . $lesson->title . '" telah diselesaikan!');
    }
}