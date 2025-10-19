<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display user management page
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('role')
                      ->orderBy('name')
                      ->paginate(20);

        return view('admin.user-management.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.user-management.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,teacher,student',
            'is_active' => 'boolean',
            'nip' => 'nullable|string|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'religion' => 'nullable|string|max:100',
            'class' => 'nullable|string|max:50',
            'student_id' => 'nullable|string|max:50',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'employment_status' => 'nullable|in:PNS,Honorer,Kontrak',
            'subject_specialization' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:100',
        ]);

        $userData = $request->all();
        $userData['password'] = Hash::make($request->password);
        $userData['is_active'] = $request->has('is_active');

        User::create($userData);

        return redirect()->route('admin.user-management.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        return view('admin.user-management.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,teacher,student',
            'is_active' => 'boolean',
            'nip' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'religion' => 'nullable|string|max:100',
            'class' => 'nullable|string|max:50',
            'student_id' => 'nullable|string|max:50',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'employment_status' => 'nullable|in:PNS,Honorer,Kontrak',
            'subject_specialization' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:100',
        ]);

        $userData = $request->except('password');
        $userData['is_active'] = $request->has('is_active');

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.user-management.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting the current admin user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user-management.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.user-management.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(User $user)
    {
        // Prevent deactivating the current admin user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user-management.index')
                ->with('error', 'Tidak dapat menonaktifkan akun sendiri!');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.user-management.index')
            ->with('success', "User {$user->name} berhasil {$status}!");
    }

    /**
     * Show user details
     */
    public function show(User $user)
    {
        return view('admin.user-management.show', compact('user'));
    }
}
