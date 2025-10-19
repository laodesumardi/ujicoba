<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Accreditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $achievements = Achievement::orderBy('year', 'desc')->orderBy('created_at', 'desc')->paginate(10);
        $accreditation = Accreditation::active()->first();
        return view('admin.achievements.index', compact('achievements', 'accreditation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.achievements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:academic,non_academic',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|string|in:kabupaten,provinsi,nasional,internasional',
            'year' => 'required|integer|min:2000|max:2030',
            'position' => 'nullable|string|max:100',
            'participant_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        Achievement::create($data);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Achievement $achievement)
    {
        return view('admin.achievements.show', compact('achievement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'type' => 'required|string|in:academic,non_academic',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|string|in:kabupaten,provinsi,nasional,internasional',
            'year' => 'required|integer|min:2000|max:2030',
            'position' => 'nullable|string|max:100',
            'participant_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $achievement->update($data);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil dihapus.');
    }
}
