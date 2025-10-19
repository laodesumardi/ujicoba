<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use Illuminate\Http\Request;

class AccreditationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accreditations = Accreditation::orderBy('year', 'desc')->paginate(10);
        return view('admin.accreditations.index', compact('accreditations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.accreditations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'certificate_number' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2030',
            'score' => 'required|integer|min:0|max:100',
            'valid_until' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        Accreditation::create($data);

        return redirect()->route('admin.accreditations.index')
            ->with('success', 'Akreditasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Accreditation $accreditation)
    {
        return view('admin.accreditations.show', compact('accreditation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accreditation $accreditation)
    {
        return view('admin.accreditations.edit', compact('accreditation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accreditation $accreditation)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'certificate_number' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2030',
            'score' => 'required|integer|min:0|max:100',
            'valid_until' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $accreditation->update($data);

        return redirect()->route('admin.accreditations.index')
            ->with('success', 'Akreditasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accreditation $accreditation)
    {
        $accreditation->delete();

        return redirect()->route('admin.accreditations.index')
            ->with('success', 'Akreditasi berhasil dihapus.');
    }
}
