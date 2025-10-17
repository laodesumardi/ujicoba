<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;

class SchoolProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolProfile = SchoolProfile::first();
        return view('admin.school-profile.index', compact('schoolProfile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.school-profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'history' => 'required|string',
            'established_year' => 'required|string',
            'location' => 'required|string|max:255',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'headmaster_name' => 'required|string|max:255',
            'headmaster_position' => 'required|string|max:255',
            'headmaster_education' => 'required|string|max:255',
            'accreditation_status' => 'required|string|max:255',
            'accreditation_number' => 'required|string|max:255',
            'accreditation_year' => 'required|string',
            'accreditation_score' => 'required|integer',
            'accreditation_valid_until' => 'required|string',
        ]);

        SchoolProfile::create($request->all());

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Profil sekolah berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolProfile $schoolProfile)
    {
        return view('admin.school-profile.show', compact('schoolProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolProfile $schoolProfile)
    {
        return view('admin.school-profile.edit', compact('schoolProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolProfile $schoolProfile)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'history' => 'required|string',
            'established_year' => 'required|string',
            'location' => 'required|string|max:255',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'headmaster_name' => 'required|string|max:255',
            'headmaster_position' => 'required|string|max:255',
            'headmaster_education' => 'required|string|max:255',
            'accreditation_status' => 'required|string|max:255',
            'accreditation_number' => 'required|string|max:255',
            'accreditation_year' => 'required|string',
            'accreditation_score' => 'required|integer',
            'accreditation_valid_until' => 'required|string',
        ]);

        $schoolProfile->update($request->all());

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Profil sekolah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolProfile $schoolProfile)
    {
        $schoolProfile->delete();

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Profil sekolah berhasil dihapus!');
    }
}
