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

// Simple test route
Route::get('/test', function() {
    return response('<h1>Test Route Working!</h1><p><a href="/">Home</a></p>');
});

// Setup routes using controller
Route::get('/generate', [SetupController::class, 'generate']);
Route::get('/setup', [SetupController::class, 'setup']);
Route::get('/test-images', [SetupController::class, 'testImages']);

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
