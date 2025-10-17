<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\HomeSection;

class DocumentController extends Controller
{
    /**
     * Display the document center page.
     */
    public function index(Request $request)
    {
        $query = Document::published()->notExpired();

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        $documents = $query->orderBy('is_featured', 'desc')
                          ->orderBy('published_at', 'desc')
                          ->paginate(12);

        // Get featured documents
        $featuredDocuments = Document::published()
            ->notExpired()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        // Get categories for filter
        $categories = Document::getCategories();
        $types = Document::getTypes();

        // Get section data
        $section = HomeSection::where('section_key', 'download-center')->first();

        return view('documents.index', compact(
            'documents', 
            'featuredDocuments', 
            'categories', 
            'types', 
            'section'
        ));
    }

    /**
     * Display documents by category.
     */
    public function category($category)
    {
        $documents = Document::published()
            ->notExpired()
            ->byCategory($category)
            ->orderBy('is_featured', 'desc')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $categories = Document::getCategories();
        $categoryLabel = $categories[$category] ?? ucfirst($category);

        return view('documents.category', compact('documents', 'category', 'categoryLabel'));
    }

    /**
     * Display documents by type.
     */
    public function type($type)
    {
        $documents = Document::published()
            ->notExpired()
            ->byType($type)
            ->orderBy('is_featured', 'desc')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $types = Document::getTypes();
        $typeLabel = $types[$type] ?? ucfirst($type);

        return view('documents.type', compact('documents', 'type', 'typeLabel'));
    }

    /**
     * Display featured documents.
     */
    public function featured()
    {
        $documents = Document::published()
            ->notExpired()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('documents.featured', compact('documents'));
    }

    /**
     * Download a document.
     */
    public function download($id)
    {
        $document = Document::published()->notExpired()->findOrFail($id);
        
        // Increment download count
        $document->incrementDownloadCount();
        
        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        
        return response()->download($filePath, $document->file_name);
    }

    /**
     * Get latest documents for homepage.
     */
    public function getLatestDocuments($limit = 6)
    {
        return Document::published()
            ->notExpired()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get featured documents for homepage.
     */
    public function getFeaturedDocuments($limit = 3)
    {
        return Document::published()
            ->notExpired()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
