<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    /**
     * Display social media management page
     */
    public function index()
    {
        $socialMedia = SocialMedia::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.social-media.index', compact('socialMedia'));
    }

    /**
     * Show the form for creating a new social media
     */
    public function create()
    {
        return view('admin.social-media.create');
    }

    /**
     * Store a newly created social media
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'color' => 'required|string|max:7',
            'sort_order' => 'required|integer|min:0',
        ]);

        SocialMedia::create($request->all());

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Sosial media berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified social media
     */
    public function edit(SocialMedia $socialMedia)
    {
        return view('admin.social-media.edit', compact('socialMedia'));
    }

    /**
     * Update the specified social media
     */
    public function update(Request $request, SocialMedia $socialMedia)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'color' => 'required|string|max:7',
            'sort_order' => 'required|integer|min:0',
        ]);

        $socialMedia->update($request->all());

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Sosial media berhasil diperbarui!');
    }

    /**
     * Remove the specified social media
     */
    public function destroy(SocialMedia $socialMedia)
    {
        $socialMedia->delete();

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Sosial media berhasil dihapus!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(SocialMedia $socialMedia)
    {
        $socialMedia->update(['is_active' => !$socialMedia->is_active]);

        $status = $socialMedia->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.social-media.index')
            ->with('success', "Sosial media {$socialMedia->name} berhasil {$status}!");
    }
}
