<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSection;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        // Get contact section data
        $contactSection = HomeSection::where('section_key', 'contact')->first();
        
        return view('contact.index', compact('contactSection'));
    }
}
