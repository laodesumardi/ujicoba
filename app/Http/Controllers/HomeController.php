<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSection;

class HomeController extends Controller
{
    public function index()
    {
        $sections = HomeSection::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key');

        return view('welcome', compact('sections'));
    }
}