<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SetupController extends Controller
{
    public function generate()
    {
        try {
            Artisan::call('storage:link');
            return response('<h1>Storage Link Created Successfully!</h1><p>Storage link has been created for image access.</p><p><a href="/">Go to Homepage</a></p><p><a href="/admin/home-sections">Go to Admin Panel</a></p>');
        } catch (\Exception $e) {
            return response('<h1>Error Creating Storage Link</h1><p>Error: ' . $e->getMessage() . '</p><p>Please try again or contact administrator.</p>');
        }
    }

    public function setup()
    {
        try {
            // Create storage link
            Artisan::call('storage:link');
            
            // Clear caches
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            
            // Rebuild config cache
            Artisan::call('config:cache');
            
            return response('<h1>Setup Completed Successfully!</h1><p>✅ Storage link created</p><p>✅ Caches cleared</p><p>✅ Config cache rebuilt</p><p><a href="/">Go to Homepage</a></p><p><a href="/admin/home-sections">Go to Admin Panel</a></p><p><a href="/generate">Test Storage Link Only</a></p>');
        } catch (\Exception $e) {
            return response('<h1>Error During Setup</h1><p>Error: ' . $e->getMessage() . '</p><p>Please try again or contact administrator.</p>');
        }
    }

    public function testImages()
    {
        $html = '<h1>Image Access Test</h1>';
        
        // Check if storage link exists
        if (is_link(public_path('storage'))) {
            $html .= '<p>✅ Storage link exists</p>';
        } else {
            $html .= '<p>❌ Storage link does not exist</p>';
        }
        
        // Check if placeholder image exists
        $placeholderPath = public_path('storage/home-sections/placeholder.jpg');
        if (file_exists($placeholderPath)) {
            $html .= '<p>✅ Placeholder image exists</p>';
            $html .= '<p><img src="/storage/home-sections/placeholder.jpg" alt="Placeholder" style="max-width: 200px;"></p>';
        } else {
            $html .= '<p>❌ Placeholder image not found</p>';
        }
        
        // List all images in storage
        $storagePath = public_path('storage/home-sections');
        if (is_dir($storagePath)) {
            $images = scandir($storagePath);
            $html .= '<h3>Available Images:</h3>';
            $html .= '<ul>';
            foreach ($images as $image) {
                if ($image != '.' && $image != '..') {
                    $html .= '<li><a href="/storage/home-sections/' . $image . '" target="_blank">' . $image . '</a></li>';
                }
            }
            $html .= '</ul>';
        }
        
        $html .= '<p><a href="/">Go to Homepage</a></p>';
        $html .= '<p><a href="/setup">Run Complete Setup</a></p>';
        
        return response($html);
    }
}
