<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = User::where('role', 'teacher')->orderBy('name')->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:users,nip',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'religion' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'classes' => 'nullable|array',
            'classes.*' => 'string|max:10',
            'education' => 'required|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'employment_status' => 'nullable|in:PNS,CPNS,Guru Honorer,Guru Kontrak,Guru Bantu,Non-Aktif,Cuti',
            'join_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:teacher,staff',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Set role to teacher
        $data['role'] = 'teacher';

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            
            // Store file using Laravel Storage facade
            $path = $photo->storeAs('teachers', $filename, 'public');
            $data['photo'] = $path;
        } else {
            $data['photo'] = null;
        }

        User::create($data);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $teacher)
    {
        $request->validate([
            'nip' => 'required|unique:users,nip,' . $teacher->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'religion' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'classes' => 'nullable|array',
            'classes.*' => 'string|max:10',
            'education' => 'required|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'employment_status' => 'nullable|in:PNS,CPNS,Guru Honorer,Guru Kontrak,Guru Bantu,Non-Aktif,Cuti',
            'join_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:teacher,staff',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }

            $photo = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            
            // Store file using Laravel Storage facade
            $path = $photo->storeAs('teachers', $filename, 'public');
            $data['photo'] = $path;
        } else {
            // Keep existing photo if no new photo uploaded
            unset($data['photo']);
        }

        $teacher->update($data);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $teacher)
    {
        // Check if teacher has courses
        $coursesCount = $teacher->courses()->count();
        
        if ($coursesCount > 0) {
            // Get courses details for better error message
            $courses = $teacher->courses()->pluck('title')->toArray();
            $coursesList = implode(', ', $courses);
            
            return redirect()->route('admin.teachers.index')
                ->with('error', "Tidak dapat menghapus guru karena masih memiliki {$coursesCount} kelas: {$coursesList}. Silakan hapus atau pindahkan kelas terlebih dahulu.");
        }

        // Check if teacher has other related data
        $enrollmentsCount = $teacher->enrollments()->count();
        $submissionsCount = $teacher->submissions()->count();
        $forumPostsCount = $teacher->forumPosts()->count();
        $forumRepliesCount = $teacher->forumReplies()->count();
        
        if ($enrollmentsCount > 0 || $submissionsCount > 0 || $forumPostsCount > 0 || $forumRepliesCount > 0) {
            $relatedData = [];
            if ($enrollmentsCount > 0) $relatedData[] = "{$enrollmentsCount} pendaftaran kelas";
            if ($submissionsCount > 0) $relatedData[] = "{$submissionsCount} pengumpulan tugas";
            if ($forumPostsCount > 0) $relatedData[] = "{$forumPostsCount} forum post";
            if ($forumRepliesCount > 0) $relatedData[] = "{$forumRepliesCount} balasan forum";
            
            $relatedDataList = implode(', ', $relatedData);
            
            return redirect()->route('admin.teachers.index')
                ->with('error', "Tidak dapat menghapus guru karena masih memiliki data terkait: {$relatedDataList}. Silakan hapus data terkait terlebih dahulu.");
        }

        // Delete photo if exists
        if ($teacher->photo) {
            Storage::delete('public/teachers/' . $teacher->photo);
        }

        // Delete teacher
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    /**
     * Transfer courses to another teacher
     */
    public function transferCourses(Request $request, User $teacher)
    {
        $request->validate([
            'new_teacher_id' => 'required|exists:users,id',
        ]);

        $newTeacher = User::findOrFail($request->new_teacher_id);
        
        // Check if new teacher is also a teacher
        if ($newTeacher->role !== 'teacher') {
            return redirect()->back()
                ->with('error', 'Guru tujuan harus memiliki role teacher.');
        }

        // Transfer courses
        $coursesCount = $teacher->courses()->count();
        $teacher->courses()->update(['teacher_id' => $newTeacher->id]);

        return redirect()->route('admin.teachers.index')
            ->with('success', "Berhasil memindahkan {$coursesCount} kelas dari {$teacher->name} ke {$newTeacher->name}.");
    }
}
