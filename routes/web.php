<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\HomeSectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

// Storage link generation for hosting
Route::get('/generate', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        echo '<h1>Storage Link Created Successfully!</h1>';
        echo '<p>Storage link has been created for image access.</p>';
        echo '<p><a href="/">Go to Homepage</a></p>';
        echo '<p><a href="/admin/home-sections">Go to Admin Panel</a></p>';
    } catch (Exception $e) {
        echo '<h1>Error Creating Storage Link</h1>';
        echo '<p>Error: ' . $e->getMessage() . '</p>';
        echo '<p>Please try again or contact administrator.</p>';
    }
});

// Complete setup for hosting
Route::get('/setup', function() {
    try {
        // Create storage link
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        
        // Clear caches
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        
        // Rebuild config cache
        \Illuminate\Support\Facades\Artisan::call('config:cache');
        
        echo '<h1>Setup Completed Successfully!</h1>';
        echo '<p>✅ Storage link created</p>';
        echo '<p>✅ Caches cleared</p>';
        echo '<p>✅ Config cache rebuilt</p>';
        echo '<p><a href="/">Go to Homepage</a></p>';
        echo '<p><a href="/admin/home-sections">Go to Admin Panel</a></p>';
        echo '<p><a href="/generate">Test Storage Link Only</a></p>';
    } catch (Exception $e) {
        echo '<h1>Error During Setup</h1>';
        echo '<p>Error: ' . $e->getMessage() . '</p>';
        echo '<p>Please try again or contact administrator.</p>';
    }
});

// Test image access
Route::get('/test-images', function() {
    echo '<h1>Image Access Test</h1>';
    
    // Check if storage link exists
    if (is_link(public_path('storage'))) {
        echo '<p>✅ Storage link exists</p>';
    } else {
        echo '<p>❌ Storage link does not exist</p>';
    }
    
    // Check if placeholder image exists
    $placeholderPath = public_path('storage/home-sections/placeholder.jpg');
    if (file_exists($placeholderPath)) {
        echo '<p>✅ Placeholder image exists</p>';
        echo '<p><img src="/storage/home-sections/placeholder.jpg" alt="Placeholder" style="max-width: 200px;"></p>';
    } else {
        echo '<p>❌ Placeholder image not found</p>';
    }
    
    // List all images in storage
    $storagePath = public_path('storage/home-sections');
    if (is_dir($storagePath)) {
        $images = scandir($storagePath);
        echo '<h3>Available Images:</h3>';
        echo '<ul>';
        foreach ($images as $image) {
            if ($image != '.' && $image != '..') {
                echo '<li><a href="/storage/home-sections/' . $image . '" target="_blank">' . $image . '</a></li>';
            }
        }
        echo '</ul>';
    }
    
    echo '<p><a href="/">Go to Homepage</a></p>';
    echo '<p><a href="/setup">Run Complete Setup</a></p>';
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
    Route::resource('school-profile', SchoolProfileController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('achievements', AchievementController::class);
    Route::resource('home-sections', HomeSectionController::class);
});



require __DIR__.'/auth.php';
