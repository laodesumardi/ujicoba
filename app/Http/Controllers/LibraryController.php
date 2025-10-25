<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display the library profile page.
     */
    public function index()
    {
        // Gunakan perpustakaan aktif; jika tidak ada, fallback ke record pertama
        $library = Library::where('is_active', true)->first() ?? Library::first();
        
        return view('library', compact('library'));
    }
}