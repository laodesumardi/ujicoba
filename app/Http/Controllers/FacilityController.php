<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = Facility::active()->ordered()->get();
        $featuredFacilities = Facility::active()->featured()->ordered()->get();
        
        return view('facilities', compact('facilities', 'featuredFacilities'));
    }
}
