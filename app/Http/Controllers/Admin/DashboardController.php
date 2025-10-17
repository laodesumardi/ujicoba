<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use App\Models\Achievement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $schoolProfile = SchoolProfile::first();
        $teachersCount = Teacher::count();
        $achievementsCount = Achievement::count();

        return view('admin.dashboard', compact('schoolProfile', 'teachersCount', 'achievementsCount'));
    }
}
