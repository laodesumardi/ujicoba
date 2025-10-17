<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

// Debug route
Route::get('/debug', function() {
    echo '<h1>Debug Route Working!</h1>';
    echo '<p>Current time: ' . now() . '</p>';
    echo '<p>Laravel version: ' . app()->version() . '</p>';
    echo '<p>Environment: ' . app()->environment() . '</p>';
    echo '<p><a href="/">Go to Homepage</a></p>';
});

// Simple debug route
Route::get('/ping', function() {
    return response('PONG - ' . now());
});

// Test route with controller
Route::get('/test-route', function() {
    return response('<h1>Test Route Working!</h1><p>Time: ' . now() . '</p>');
});

// Clear cache route
Route::get('/clear-cache', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        return response('<h1>Cache Cleared!</h1><p>✅ All caches cleared</p><p><a href="/">Home</a></p>');
    } catch (Exception $e) {
        return response('<h1>Error!</h1><p>Error: ' . $e->getMessage() . '</p>');
    }
});

// Simple test route
Route::get('/test', function() {
    return response('<h1>Test Route Working!</h1><p><a href="/">Home</a></p>');
});

// Test storage route
Route::get('/test-storage', function() {
    $html = '<h1>Storage Test</h1>';
    
    // Check storage directory
    $storagePath = 'storage/app/public/home-sections';
    if (is_dir($storagePath)) {
        $files = scandir($storagePath);
        $html .= '<h3>Storage Directory Contents:</h3><ul>';
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $storagePath . '/' . $file;
                $size = filesize($filePath);
                $html .= '<li>' . $file . ' (' . number_format($size) . ' bytes)</li>';
            }
        }
        $html .= '</ul>';
    }
    
    // Check public storage
    $publicPath = 'public/storage/home-sections';
    if (is_dir($publicPath)) {
        $files = scandir($publicPath);
        $html .= '<h3>Public Storage Contents:</h3><ul>';
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $publicPath . '/' . $file;
                $size = filesize($filePath);
                $html .= '<li>' . $file . ' (' . number_format($size) . ' bytes)</li>';
            }
        }
        $html .= '</ul>';
    }
    
    // Test image URLs
    $html .= '<h3>Test Image URLs:</h3>';
    $html .= '<p><a href="/storage/home-sections/placeholder.jpg" target="_blank">Placeholder Image</a></p>';
    $html .= '<p><img src="/storage/home-sections/placeholder.jpg" alt="Placeholder" style="max-width: 200px;"></p>';
    
    $html .= '<p><a href="/">Go to Homepage</a></p>';
    $html .= '<p><a href="/test-images">Test Images</a></p>';
    
    return response($html);
});

// Simple setup routes
Route::get('/generate', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return response('<h1>Storage Link Created!</h1><p>✅ Storage link created</p><p><a href="/">Home</a></p>');
    } catch (Exception $e) {
        return response('<h1>Error!</h1><p>Error: ' . $e->getMessage() . '</p>');
    }
});

Route::get('/setup', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        return response('<h1>Setup Complete!</h1><p>✅ Storage link created</p><p>✅ Caches cleared</p><p><a href="/">Home</a></p>');
    } catch (Exception $e) {
        return response('<h1>Error!</h1><p>Error: ' . $e->getMessage() . '</p>');
    }
});

Route::get('/test-images', function() {
    $html = '<h1>Image Test</h1>';
    
    if (is_dir('public/storage/home-sections')) {
        $files = scandir('public/storage/home-sections');
        $html .= '<h3>Images Found:</h3><ul>';
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $html .= '<li><a href="/storage/home-sections/' . $file . '" target="_blank">' . $file . '</a></li>';
            }
        }
        $html .= '</ul>';
    } else {
        $html .= '<p>❌ Storage directory not found</p>';
    }
    
    $html .= '<p><a href="/">Home</a></p>';
    return response($html);
});

// Setup routes using controller (backup)
Route::get('/generate-controller', [SetupController::class, 'generate']);
Route::get('/setup-controller', [SetupController::class, 'setup']);
Route::get('/test-images-controller', [SetupController::class, 'testImages']);

// Test upload functionality
Route::get('/test-upload', function() {
    $html = '<h1>Upload Test</h1>';
    
    // Check if directories exist and are writable
    $directories = [
        'public/uploads/home-sections',
        'storage/app/public/home-sections',
        'public/storage/home-sections'
    ];
    
    foreach ($directories as $dir) {
        if (is_dir($dir)) {
            if (is_writable($dir)) {
                $html .= '<p>✅ ' . $dir . ' - exists and writable</p>';
            } else {
                $html .= '<p>❌ ' . $dir . ' - exists but not writable</p>';
            }
        } else {
            $html .= '<p>❌ ' . $dir . ' - does not exist</p>';
        }
    }
    
    // Test file creation
    $testFile = 'storage/app/public/home-sections/test.txt';
    if (file_put_contents($testFile, 'test content')) {
        $html .= '<p>✅ Can create files in storage</p>';
        unlink($testFile);
    } else {
        $html .= '<p>❌ Cannot create files in storage</p>';
    }
    
    $html .= '<p><a href="/admin/home-sections">Go to Admin Panel</a></p>';
    $html .= '<p><a href="/">Go to Homepage</a></p>';
    
    return response($html);
});

// Fix database connection
Route::get('/fix-database', function() {
    try {
        $html = '<h1>Database Fix</h1>';
        
        // Check environment variables
        $html .= '<h3>Environment Variables:</h3>';
        $html .= '<p>APP_ENV: ' . env('APP_ENV', 'not set') . '</p>';
        $html .= '<p>DB_CONNECTION: ' . env('DB_CONNECTION', 'not set') . '</p>';
        $html .= '<p>DB_HOST: ' . env('DB_HOST', 'not set') . '</p>';
        $html .= '<p>DB_DATABASE: ' . env('DB_DATABASE', 'not set') . '</p>';
        $html .= '<p>DB_USERNAME: ' . env('DB_USERNAME', 'not set') . '</p>';
        $html .= '<p>DB_PASSWORD: ' . (env('DB_PASSWORD') ? 'Set' : 'Not set') . '</p>';
        
        // Test database connection
        $html .= '<h3>Database Connection:</h3>';
        try {
            $connection = \Illuminate\Support\Facades\DB::connection();
            $connection->getPdo();
            $html .= '<p>✅ Database connection successful</p>';
        } catch (Exception $e) {
            $html .= '<p>❌ Database connection failed: ' . $e->getMessage() . '</p>';
        }
        
        // Check tables
        $html .= '<h3>Tables Check:</h3>';
        try {
            $sessions = \Illuminate\Support\Facades\DB::table('sessions')->count();
            $html .= '<p>✅ Sessions table has ' . $sessions . ' records</p>';
        } catch (Exception $e) {
            $html .= '<p>❌ Sessions table error: ' . $e->getMessage() . '</p>';
        }
        
        try {
            $sections = \Illuminate\Support\Facades\DB::table('home_sections')->count();
            $html .= '<p>✅ Home sections table has ' . $sections . ' records</p>';
        } catch (Exception $e) {
            $html .= '<p>❌ Home sections table error: ' . $e->getMessage() . '</p>';
        }
        
        // Clear cache
        $html .= '<h3>Cache Management:</h3>';
        try {
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            $html .= '<p>✅ Cache cleared</p>';
        } catch (Exception $e) {
            $html .= '<p>❌ Cache clear failed: ' . $e->getMessage() . '</p>';
        }
        
        $html .= '<p><a href="/">Go to Homepage</a></p>';
        $html .= '<p><a href="/admin/home-sections">Go to Admin Panel</a></p>';
        
        return response($html);
    } catch (Exception $e) {
        return response('<h1>Database Fix Error</h1><p>Error: ' . $e->getMessage() . '</p>');
    }
});

// Test upload functionality with detailed diagnostics
Route::get('/test-upload-detailed', function() {
    $html = '<h1>Detailed Upload Test</h1>';
    
    // PHP settings
    $html .= '<h3>PHP Settings:</h3>';
    $html .= '<p>upload_max_filesize: ' . ini_get('upload_max_filesize') . '</p>';
    $html .= '<p>post_max_size: ' . ini_get('post_max_size') . '</p>';
    $html .= '<p>max_execution_time: ' . ini_get('max_execution_time') . '</p>';
    $html .= '<p>memory_limit: ' . ini_get('memory_limit') . '</p>';
    
    // Directory check
    $html .= '<h3>Directory Check:</h3>';
    $directories = [
        'public/uploads/home-sections',
        'storage/app/public/home-sections',
        'public/storage/home-sections'
    ];
    
    foreach ($directories as $dir) {
        if (is_dir($dir)) {
            $writable = is_writable($dir) ? 'Yes' : 'No';
            $html .= '<p>✅ ' . $dir . ' - Writable: ' . $writable . '</p>';
        } else {
            $html .= '<p>❌ ' . $dir . ' - does not exist</p>';
        }
    }
    
    // Test file creation
    $html .= '<h3>File Creation Test:</h3>';
    $testFile = 'storage/app/public/home-sections/test_' . time() . '.txt';
    if (file_put_contents($testFile, 'test content')) {
        $html .= '<p>✅ Can create files in storage</p>';
        if (unlink($testFile)) {
            $html .= '<p>✅ Can delete files from storage</p>';
        }
    } else {
        $html .= '<p>❌ Cannot create files in storage</p>';
    }
    
    $html .= '<p><a href="/admin/home-sections">Go to Admin Panel</a></p>';
    $html .= '<p><a href="/">Go to Homepage</a></p>';
    
    return response($html);
});

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Specific routes first (before resource routes)
    Route::get('school-profile/hero/edit', [SchoolProfileController::class, 'editHero'])->name('school-profile.edit-hero');
    Route::put('school-profile/hero/update', [SchoolProfileController::class, 'updateHero'])->name('school-profile.update-hero');
    Route::get('school-profile/struktur/edit', [SchoolProfileController::class, 'editStruktur'])->name('school-profile.edit-struktur');
    Route::put('school-profile/struktur/update', [SchoolProfileController::class, 'updateStruktur'])->name('school-profile.update-struktur');
    
    // Resource routes
    Route::resource('school-profile', SchoolProfileController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('achievements', AchievementController::class);
    Route::resource('home-sections', HomeSectionController::class);
});



require __DIR__.'/auth.php';
