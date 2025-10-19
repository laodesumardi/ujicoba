<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display all teaching and non-teaching staff.
     */
    public function index()
    {
        // Get all teachers
        $teachers = User::where('role', 'teacher')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get all admin staff
        $admins = User::where('role', 'admin')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('staff', compact('teachers', 'admins'));
    }
}


