<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AcademicCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AcademicCalendar::query();

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->byType($request->type);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->byPriority($request->priority);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        $events = $query->orderBy('start_date', 'desc')->paginate(20);

        $types = [
            'semester' => 'Semester',
            'ujian' => 'Ujian',
            'libur' => 'Libur',
            'hari_besar' => 'Hari Besar',
            'kegiatan' => 'Kegiatan',
            'lainnya' => 'Lainnya'
        ];

        $priorities = [
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'critical' => 'Kritis'
        ];

        return view('admin.academic-calendar.index', compact('events', 'types', 'priorities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = [
            'semester' => 'Semester',
            'ujian' => 'Ujian',
            'libur' => 'Libur',
            'hari_besar' => 'Hari Besar',
            'kegiatan' => 'Kegiatan',
            'lainnya' => 'Lainnya'
        ];

        $priorities = [
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'critical' => 'Kritis'
        ];

        return view('admin.academic-calendar.create', compact('types', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'type' => 'required|in:semester,ujian,libur,hari_besar,kegiatan,lainnya',
            'priority' => 'required|in:low,medium,high,critical',
            'location' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'is_all_day' => 'boolean',
            'is_public' => 'boolean',
            'is_downloadable' => 'boolean',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'color' => 'nullable|string|max:7',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_all_day'] = $request->has('is_all_day');
        $data['is_public'] = $request->has('is_public');
        $data['is_downloadable'] = $request->has('is_downloadable');
        $data['is_active'] = $request->has('is_active');

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('academic-calendar', $filename, 'public');
            $data['file_path'] = $path;
        }

        AcademicCalendar::create($data);

        return redirect()->route('admin.academic-calendar.index')
                        ->with('success', 'Acara kalender akademik berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicCalendar $academicCalendar)
    {
        return view('admin.academic-calendar.show', compact('academicCalendar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicCalendar $academicCalendar)
    {
        $types = [
            'semester' => 'Semester',
            'ujian' => 'Ujian',
            'libur' => 'Libur',
            'hari_besar' => 'Hari Besar',
            'kegiatan' => 'Kegiatan',
            'lainnya' => 'Lainnya'
        ];

        $priorities = [
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'critical' => 'Kritis'
        ];

        return view('admin.academic-calendar.edit', compact('academicCalendar', 'types', 'priorities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicCalendar $academicCalendar)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'type' => 'required|in:semester,ujian,libur,hari_besar,kegiatan,lainnya',
            'priority' => 'required|in:low,medium,high,critical',
            'location' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'is_all_day' => 'boolean',
            'is_public' => 'boolean',
            'is_downloadable' => 'boolean',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'color' => 'nullable|string|max:7',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_all_day'] = $request->has('is_all_day');
        $data['is_public'] = $request->has('is_public');
        $data['is_downloadable'] = $request->has('is_downloadable');
        $data['is_active'] = $request->has('is_active');

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($academicCalendar->file_path && Storage::disk('public')->exists($academicCalendar->file_path)) {
                Storage::disk('public')->delete($academicCalendar->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('academic-calendar', $filename, 'public');
            $data['file_path'] = $path;
        }

        $academicCalendar->update($data);

        return redirect()->route('admin.academic-calendar.index')
                        ->with('success', 'Acara kalender akademik berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicCalendar $academicCalendar)
    {
        // Delete associated file
        if ($academicCalendar->file_path && Storage::disk('public')->exists($academicCalendar->file_path)) {
            Storage::disk('public')->delete($academicCalendar->file_path);
        }

        $academicCalendar->delete();

        return redirect()->route('admin.academic-calendar.index')
                        ->with('success', 'Acara kalender akademik berhasil dihapus!');
    }

    /**
     * Edit section for academic calendar.
     */
    public function editSection()
    {
        $section = HomeSection::where('section_key', 'academic-calendar')->first();
        
        if (!$section) {
            // Create default section if not exists
            $section = HomeSection::create([
                'section_key' => 'academic-calendar',
                'title' => 'Kalender Akademik',
                'subtitle' => 'Jadwal penting dan kegiatan sekolah',
                'content' => 'Lihat jadwal lengkap kegiatan dan acara sekolah SMP Negeri 01 Namrole',
                'is_active' => true,
                'sort_order' => 5
            ]);
        }

        return view('admin.academic-calendar.edit-section', compact('section'));
    }

    /**
     * Update section for academic calendar.
     */
    public function updateSection(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'image_position' => 'nullable|in:left,right,center,top,bottom',
            'is_active' => 'boolean'
        ]);

        $section = HomeSection::where('section_key', 'academic-calendar')->first();
        
        if (!$section) {
            return redirect()->back()->with('error', 'Section tidak ditemukan!');
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($section->image && Storage::disk('public')->exists($section->image)) {
                Storage::disk('public')->delete($section->image);
            }

            $image = $request->file('image');
            $filename = time() . '_academic_calendar.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('home-sections', $filename, 'public');
            $data['image'] = $path;
        }

        $section->update($data);

        return redirect()->route('admin.academic-calendar.index')
                        ->with('success', 'Section kalender akademik berhasil diperbarui!');
    }
}