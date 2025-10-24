<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::ordered()->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:subjects,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|string|in:SD,SMP,SMA',
            'hours_per_week' => 'required|integer|min:1|max:10',
            'color' => 'required|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        Subject::create($data);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $teachers = $subject->teachers()->paginate(10);
        return view('admin.subjects.show', compact('subject', 'teachers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:subjects,code,' . $subject->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|string|in:SD,SMP,SMA',
            'hours_per_week' => 'required|integer|min:1|max:10',
            'color' => 'required|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $subject->update($data);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        // Check if subject has teachers
        $teachersCount = $subject->teachers()->count();
        
        if ($teachersCount > 0) {
            // Get teachers details for better error message
            $teachers = $subject->teachers()->pluck('name')->toArray();
            $teachersList = implode(', ', $teachers);
            
            return redirect()->back()
                ->with('error', "Tidak dapat menghapus mata pelajaran karena masih memiliki {$teachersCount} guru: {$teachersList}. Silakan pindahkan atau hapus guru terlebih dahulu.");
        }

        // Check if subject has courses
        $coursesCount = Course::where('subject', $subject->name)->count();
        
        if ($coursesCount > 0) {
            return redirect()->back()
                ->with('error', "Tidak dapat menghapus mata pelajaran karena masih memiliki {$coursesCount} kelas. Silakan hapus atau pindahkan kelas terlebih dahulu.");
        }

        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    /**
     * Force delete subject and handle related data
     */
    public function forceDelete(Subject $subject)
    {
        // Get teachers and courses before deletion
        $teachers = $subject->teachers()->get();
        $courses = Course::where('subject', $subject->name)->get();
        
        // Update teachers to have no subject
        foreach ($teachers as $teacher) {
            $teacher->update(['subject' => null]);
        }
        
        // Update courses to have no subject
        foreach ($courses as $course) {
            $course->update(['subject' => null]);
        }
        
        $subject->delete();
        
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil dihapus. Guru dan kelas terkait telah dipindahkan.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Subject $subject)
    {
        $subject->update(['is_active' => !$subject->is_active]);
        
        $status = $subject->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()
            ->with('success', "Mata pelajaran berhasil {$status}.");
    }
}