<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the student profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Ambil data statistik dari database
        $stats = [
            'total_courses' => $user->enrollments()->where('status', 'approved')->count(),
            'total_assignments' => 0, // Will be calculated from enrolled courses
            'submitted_assignments' => $user->submissions()->where('status', 'submitted')->count(),
            'graded_assignments' => $user->submissions()->where('status', 'graded')->count(),
            'upcoming_assignments' => 0, // Will be calculated
            'overdue_assignments' => 0, // Will be calculated
        ];
        
        // Ambil data enrolled courses
        $enrolledCourses = $user->enrollments()
            ->with('course')
            ->where('status', 'approved')
            ->latest()
            ->get()
            ->pluck('course');
        
        // Hitung statistik dari enrolled courses
        if ($enrolledCourses->count() > 0) {
            $courseIds = $enrolledCourses->pluck('id');
            
            $stats['total_assignments'] = \App\Models\Assignment::whereIn('course_id', $courseIds)->count();
            $stats['upcoming_assignments'] = \App\Models\Assignment::whereIn('course_id', $courseIds)
                ->where('due_date', '>', now())
                ->where('due_date', '<=', now()->addDays(7))
                ->count();
            $stats['overdue_assignments'] = \App\Models\Assignment::whereIn('course_id', $courseIds)
                ->where('due_date', '<', now())
                ->whereDoesntHave('submissions', function($query) use ($user) {
                    $query->where('student_id', $user->id)
                          ->where('status', 'submitted');
                })
                ->count();
        }
        
        // Ambil recent assignments dari enrolled courses
        $recentAssignments = collect();
        if ($enrolledCourses->count() > 0) {
            $courseIds = $enrolledCourses->pluck('id');
            $recentAssignments = \App\Models\Assignment::whereIn('course_id', $courseIds)
                ->with('course')
                ->latest()
                ->take(5)
                ->get();
        }
        
        // Ambil upcoming assignments
        $upcomingAssignments = collect();
        if ($enrolledCourses->count() > 0) {
            $courseIds = $enrolledCourses->pluck('id');
            $upcomingAssignments = \App\Models\Assignment::whereIn('course_id', $courseIds)
                ->with('course')
                ->where('due_date', '>', now())
                ->where('due_date', '<=', now()->addDays(7))
                ->orderBy('due_date')
                ->take(5)
                ->get();
        }
        
        // Ambil overdue assignments
        $overdueAssignments = collect();
        if ($enrolledCourses->count() > 0) {
            $courseIds = $enrolledCourses->pluck('id');
            $overdueAssignments = \App\Models\Assignment::whereIn('course_id', $courseIds)
                ->with('course')
                ->where('due_date', '<', now())
                ->whereDoesntHave('submissions', function($query) use ($user) {
                    $query->where('student_id', $user->id)
                          ->where('status', 'submitted');
                })
                ->orderBy('due_date', 'desc')
                ->take(5)
                ->get();
        }
        
        // Ambil recent forums dari enrolled courses
        $recentForums = collect();
        if ($enrolledCourses->count() > 0) {
            $courseIds = $enrolledCourses->pluck('id');
            $recentForums = \App\Models\Forum::whereIn('course_id', $courseIds)
                ->with(['course', 'author'])
                ->latest()
                ->take(5)
                ->get();
        }
        
        return view('student.profile.show', compact('user', 'stats', 'enrolledCourses', 'recentAssignments', 'upcomingAssignments', 'overdueAssignments', 'recentForums'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        
        return view('student.profile.edit', compact('user'));
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'student_id' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'class_level' => 'required|string|in:VII,VIII,IX',
            'class_section' => 'nullable|string|in:A,B,C,D',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'religion' => 'nullable|string|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_email' => 'nullable|string|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->only([
            'name', 'email', 'student_id', 'phone', 'address',
            'class_level', 'class_section', 'date_of_birth', 'gender', 'religion',
            'parent_name', 'parent_phone', 'parent_email'
        ]);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $user->id . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('students/photos', $filename, 'public');
            $data['photo'] = $path;
        }
        
        $user->update($data);
        
        return redirect()->route('student.profile.show')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();
        
        if ($user->photo) {
            // Delete file from storage
            \Storage::disk('public')->delete($user->photo);
            
            // Update database
            $user->update(['photo' => null]);
        }
        
        return redirect()->route('student.profile.show')
            ->with('success', 'Foto profil berhasil dihapus!');
    }
}