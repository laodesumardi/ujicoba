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
            'image_one' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_one_name' => 'nullable|string|max:255',
            'image_two' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_two_name' => 'nullable|string|max:255',
            'image_three' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_three_name' => 'nullable|string|max:255',
        ]);

        $data = [];

        foreach (['image_one', 'image_two', 'image_three'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('vision-missions', $filename, 'public');
                // Store DB value pointing to public storage URL
                $data[$field] = 'storage/' . $path;

                // Ensure file is accessible via public/storage (hosting-friendly)
                $sourcePath = storage_path('app/public/' . $path);
                $destPath = public_path('storage/' . $path);
                if (!is_dir(dirname($destPath))) {
                    @mkdir(dirname($destPath), 0755, true);
                }
                @copy($sourcePath, $destPath);
            }
        }

        // Names
        foreach (['image_one_name','image_two_name','image_three_name'] as $nameField) {
            if ($request->filled($nameField)) {
                $data[$nameField] = $request->input($nameField);
            }
        }

        // Default active
        $data['is_active'] = true;

        VisionMission::create($data);

        return redirect()->route('admin.vision-missions.index')
            ->with('success', 'Gambar visi & misi berhasil ditambahkan.');
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
            'vision' => 'nullable|string',
            'missions' => 'nullable|array',
            'missions.*' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'image_one' => 'nullable',
            'image_one_name' => 'nullable|string|max:255',
            'image_two' => 'nullable',
            'image_two_name' => 'nullable|string|max:255',
            'image_three' => 'nullable',
            'image_three_name' => 'nullable|string|max:255',
        ]);

        $data = [];
        if ($request->filled('vision')) {
            $data['vision'] = $request->input('vision');
        }
        if ($request->filled('missions')) {
            $data['missions'] = $request->input('missions');
        }

        $data['is_active'] = $request->has('is_active');

        foreach (['image_one', 'image_two', 'image_three'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('vision-missions', $filename, 'public');
                $data[$field] = 'storage/' . $path;

                $sourcePath = storage_path('app/public/' . $path);
                $destPath = public_path('storage/' . $path);
                if (!is_dir(dirname($destPath))) {
                    @mkdir(dirname($destPath), 0755, true);
                }
                @copy($sourcePath, $destPath);
            } elseif ($request->filled($field)) {
                $data[$field] = $request->input($field);
            }
        }

        // Names
        foreach (['image_one_name','image_two_name','image_three_name'] as $nameField) {
            if ($request->filled($nameField)) {
                $data[$nameField] = $request->input($nameField);
            }
        }

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