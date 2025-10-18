<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Download lesson attachment.
     */
    public function downloadLessonAttachment(Course $course, Lesson $lesson, $filename)
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

        // Check if attachment exists
        if (!$lesson->attachments || !in_array($filename, $lesson->attachments)) {
            return redirect()->route('student.courses.lessons.show', [$course, $lesson])
                ->with('error', 'Lampiran tidak ditemukan.');
        }

        // Get the full path to the attachment
        $attachmentPath = $filename;
        
        // Check if file exists in storage
        if (!Storage::exists($attachmentPath)) {
            return redirect()->route('student.courses.lessons.show', [$course, $lesson])
                ->with('error', 'File lampiran tidak ditemukan.');
        }

        // Return file download
        return Storage::download($attachmentPath, basename($filename));
    }

    /**
     * Download assignment attachment.
     */
    public function downloadAssignmentAttachment($assignmentId, $filename)
    {
        $user = Auth::user();
        
        // Get assignment with course
        $assignment = \App\Models\Assignment::with('course')->findOrFail($assignmentId);
        
        // Check if student is enrolled in the course
        $enrollment = $user->enrollments()
            ->where('course_id', $assignment->course_id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses.index')
                ->with('error', 'Anda belum terdaftar di kelas ini.');
        }

        // Check if assignment is published
        if (!$assignment->is_published) {
            return redirect()->route('student.courses.show', $assignment->course)
                ->with('error', 'Tugas ini belum tersedia.');
        }

        // Check if attachment exists
        if (!$assignment->attachments || !in_array($filename, $assignment->attachments)) {
            return redirect()->route('student.assignments.show', $assignment)
                ->with('error', 'Lampiran tidak ditemukan.');
        }

        // Get the full path to the attachment
        $attachmentPath = $filename;
        
        // Check if file exists in storage
        if (!Storage::exists($attachmentPath)) {
            return redirect()->route('student.assignments.show', $assignment)
                ->with('error', 'File lampiran tidak ditemukan.');
        }

        // Return file download
        return Storage::download($attachmentPath, basename($filename));
    }
}