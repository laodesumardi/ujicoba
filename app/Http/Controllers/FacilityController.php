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

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        // Get related facilities from the same category
        $relatedFacilities = Facility::active()
            ->where('category', $facility->category)
            ->where('id', '!=', $facility->id)
            ->ordered()
            ->limit(3)
            ->get();

        // Get all facilities for navigation
        $allFacilities = Facility::active()->ordered()->get();

        return view('facilities.show', compact('facility', 'relatedFacilities', 'allFacilities'));
    }
}
