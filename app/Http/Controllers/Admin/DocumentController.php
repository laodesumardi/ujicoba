<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\HomeSection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Document::getCategories();
        $types = Document::getTypes();
        return view('admin.documents.create', compact('categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
            'category' => 'required|in:' . implode(',', array_keys(Document::getCategories())),
            'type' => 'required|in:' . implode(',', array_keys(Document::getTypes())),
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
            'tags' => 'nullable|string'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        $document = Document::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientMimeType(),
            'category' => $request->category,
            'type' => $request->type,
            'status' => $request->status,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->published_at,
            'expires_at' => $request->expires_at,
            'tags' => $request->tags ? explode(',', $request->tags) : null,
        ]);

        return redirect()->route('admin.documents.index')
                        ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $categories = Document::getCategories();
        $types = Document::getTypes();
        return view('admin.documents.edit', compact('document', 'categories', 'types'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'category' => 'required|in:' . implode(',', array_keys(Document::getCategories())),
            'type' => 'required|in:' . implode(',', array_keys(Document::getTypes())),
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
            'tags' => 'nullable|string'
        ]);

        $data = $request->except(['file']);

        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('documents', $fileName, 'public');
            
            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['file_type'] = $file->getClientMimeType();
        }

        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['tags'] = $request->tags ? explode(',', $request->tags) : null;

        $document->update($data);

        return redirect()->route('admin.documents.index')
                        ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        // Delete file from storage
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')
                        ->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Document $document)
    {
        $document->update(['is_featured' => !$document->is_featured]);
        
        $status = $document->is_featured ? 'ditandai sebagai unggulan' : 'tidak lagi unggulan';
        
        return redirect()->back()
                        ->with('success', "Dokumen berhasil {$status}.");
    }

    /**
     * Edit download center section.
     */
    public function editSection()
    {
        $section = HomeSection::where('section_key', 'download-center')->first();
        return view('admin.documents.edit-section', compact('section'));
    }

    /**
     * Update download center section.
     */
    public function updateSection(Request $request)
    {
        // Debug: Log request method
        \Log::info('updateSection called with method: ' . $request->method());
        
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'is_active' => 'boolean'
        ]);

        $section = HomeSection::where('section_key', 'download-center')->first();
        
        if (!$section) {
            $section = HomeSection::create([
                'section_key' => 'download-center',
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'content' => $request->content,
                'is_active' => $request->boolean('is_active', true),
                'sort_order' => 7
            ]);
        } else {
            $data = $request->except(['image']);
            $data['is_active'] = $request->boolean('is_active', true);
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($section->image && Storage::disk('public')->exists($section->image)) {
                    Storage::disk('public')->delete($section->image);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_download_center.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('home-sections', $imageName, 'public');
                $data['image'] = 'storage/' . $imagePath;
            }
            
            $section->update($data);
        }

        return redirect()->route('admin.documents.index')
                        ->with('success', 'Section Download Center berhasil diperbarui.');
    }
}
