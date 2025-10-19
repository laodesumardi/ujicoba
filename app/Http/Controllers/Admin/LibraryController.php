<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $libraries = Library::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.libraries.index', compact('libraries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.libraries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'opening_hours' => 'nullable|string',
            'services' => 'nullable|string',
            'rules' => 'nullable|string',
            'librarian_name' => 'nullable|string|max:255',
            'librarian_phone' => 'nullable|string|max:20',
            'librarian_email' => 'nullable|email|max:255',
            'organization_chart' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facilities' => 'nullable|string',
            'collection_info' => 'nullable|string',
            'membership_info' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('organization_chart')) {
            $file = $request->file('organization_chart');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Ensure directory exists
            $librariesDir = storage_path('app/public/libraries');
            if (!is_dir($librariesDir)) {
                mkdir($librariesDir, 0755, true);
            }
            
            $file->storeAs('public/libraries', $filename);
            $data['organization_chart'] = 'libraries/' . $filename;
        }

        Library::create($data);

        return redirect()->route('admin.libraries.index')
            ->with('success', 'Data perpustakaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Library $library)
    {
        return view('admin.libraries.show', compact('library'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Library $library)
    {
        return view('admin.libraries.edit', compact('library'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Library $library)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'opening_hours' => 'nullable|string',
            'services' => 'nullable|string',
            'rules' => 'nullable|string',
            'librarian_name' => 'nullable|string|max:255',
            'librarian_phone' => 'nullable|string|max:20',
            'librarian_email' => 'nullable|email|max:255',
            'organization_chart' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facilities' => 'nullable|string',
            'collection_info' => 'nullable|string',
            'membership_info' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('organization_chart')) {
            // Delete old organization chart
            if ($library->organization_chart) {
                $oldPath = str_starts_with($library->organization_chart, 'libraries/') 
                    ? 'public/' . $library->organization_chart 
                    : 'public/libraries/' . $library->organization_chart;
                Storage::delete($oldPath);
            }

            $file = $request->file('organization_chart');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Ensure directory exists
            $librariesDir = storage_path('app/public/libraries');
            if (!is_dir($librariesDir)) {
                mkdir($librariesDir, 0755, true);
            }
            
            $file->storeAs('public/libraries', $filename);
            $data['organization_chart'] = 'libraries/' . $filename;
        }

        $library->update($data);

        return redirect()->route('admin.libraries.index')
            ->with('success', 'Data perpustakaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Library $library)
    {
        // Delete organization chart file
        if ($library->organization_chart) {
            $path = str_starts_with($library->organization_chart, 'libraries/') 
                ? 'public/' . $library->organization_chart 
                : 'public/libraries/' . $library->organization_chart;
            Storage::delete($path);
        }

        $library->delete();

        return redirect()->route('admin.libraries.index')
            ->with('success', 'Data perpustakaan berhasil dihapus.');
    }
}