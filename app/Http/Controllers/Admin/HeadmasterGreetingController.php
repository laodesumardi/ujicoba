<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeadmasterGreeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeadmasterGreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $greetings = HeadmasterGreeting::latest()->get();
        return view('admin.headmaster-greetings.index', compact('greetings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.headmaster-greetings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'headmaster_name' => 'required|string|max:255',
            'greeting_message' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('headmaster-greetings', $filename, 'public');
            $data['photo'] = 'headmaster-greetings/' . $filename;
        }

        $data['is_active'] = $request->has('is_active');

        HeadmasterGreeting::create($data);

        // Copy uploaded files to public/storage for immediate access
        if ($request->hasFile('photo')) {
            $sourcePath = storage_path('app/public/' . $data['photo']);
            $destPath = public_path('storage/' . $data['photo']);
            $destDir = dirname($destPath);
            
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (copy($sourcePath, $destPath)) {
                \Log::info('Headmaster photo copied to public storage: ' . $data['photo']);
            } else {
                \Log::error('Failed to copy headmaster photo to public storage: ' . $data['photo']);
            }
        }

        return redirect()->route('admin.headmaster-greetings.index')
            ->with('success', 'Sambutan kepala sekolah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeadmasterGreeting $headmasterGreeting)
    {
        return view('admin.headmaster-greetings.show', compact('headmasterGreeting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeadmasterGreeting $headmasterGreeting)
    {
        return view('admin.headmaster-greetings.edit', compact('headmasterGreeting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeadmasterGreeting $headmasterGreeting)
    {
        $request->validate([
            'headmaster_name' => 'required|string|max:255',
            'greeting_message' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($headmasterGreeting->photo && Storage::disk('public')->exists($headmasterGreeting->photo)) {
                Storage::disk('public')->delete($headmasterGreeting->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('headmaster-greetings', $filename, 'public');
            $data['photo'] = 'headmaster-greetings/' . $filename;
        }

        $data['is_active'] = $request->has('is_active');

        $headmasterGreeting->update($data);

        // Copy uploaded files to public/storage for immediate access
        if ($request->hasFile('photo')) {
            $sourcePath = storage_path('app/public/' . $data['photo']);
            $destPath = public_path('storage/' . $data['photo']);
            $destDir = dirname($destPath);
            
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (copy($sourcePath, $destPath)) {
                \Log::info('Headmaster photo copied to public storage: ' . $data['photo']);
            } else {
                \Log::error('Failed to copy headmaster photo to public storage: ' . $data['photo']);
            }
        }

        return redirect()->route('admin.headmaster-greetings.index')
            ->with('success', 'Sambutan kepala sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeadmasterGreeting $headmasterGreeting)
    {
        // Delete photo if exists
        if ($headmasterGreeting->photo && Storage::disk('public')->exists($headmasterGreeting->photo)) {
            Storage::disk('public')->delete($headmasterGreeting->photo);
        }

        $headmasterGreeting->delete();

        return redirect()->route('admin.headmaster-greetings.index')
            ->with('success', 'Sambutan kepala sekolah berhasil dihapus.');
    }
}
