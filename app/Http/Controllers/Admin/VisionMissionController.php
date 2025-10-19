<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use Illuminate\Http\Request;

class VisionMissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visionMissions = VisionMission::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.vision-missions.index', compact('visionMissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vision-missions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vision' => 'required|string',
            'missions' => 'required|array|min:1',
            'missions.*' => 'required|string|max:500',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        VisionMission::create($data);

        return redirect()->route('admin.vision-missions.index')
            ->with('success', 'Visi & Misi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VisionMission $visionMission)
    {
        return view('admin.vision-missions.show', compact('visionMission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisionMission $visionMission)
    {
        return view('admin.vision-missions.edit', compact('visionMission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisionMission $visionMission)
    {
        $request->validate([
            'vision' => 'required|string',
            'missions' => 'required|array|min:1',
            'missions.*' => 'required|string|max:500',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $visionMission->update($data);

        return redirect()->route('admin.vision-missions.index')
            ->with('success', 'Visi & Misi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisionMission $visionMission)
    {
        $visionMission->delete();

        return redirect()->route('admin.vision-missions.index')
            ->with('success', 'Visi & Misi berhasil dihapus.');
    }
}