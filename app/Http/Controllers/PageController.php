<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display privacy policy page.
     */
    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    /**
     * Display terms and conditions page.
     */
    public function termsConditions()
    {
        return view('pages.terms-conditions');
    }

    /**
     * Display sitemap page.
     */
    public function sitemap()
    {
        return view('pages.sitemap');
    }
}
