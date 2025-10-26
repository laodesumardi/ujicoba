<?php

namespace App\Http\Controllers;

use App\Models\HeadmasterGreeting;
use Illuminate\Http\Request;

class HeadmasterGreetingController extends Controller
{
    /**
     * Display the specified headmaster greeting.
     */
    public function show()
    {
        $headmasterGreeting = HeadmasterGreeting::first();
        
        if (!$headmasterGreeting) {
            abort(404, 'Sambutan kepala sekolah tidak ditemukan');
        }
        
        return view('headmaster-greeting.show', compact('headmasterGreeting'));
    }
}
