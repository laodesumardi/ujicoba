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
        $library = Library::where('is_active', true)->first();
        
        return view('library', compact('library'));
    }
}


