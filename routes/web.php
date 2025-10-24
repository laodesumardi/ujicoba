<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PPDBController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AcademicCalendarController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\PPDBController as AdminPPDBController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\AcademicCalendarController as AdminAcademicCalendarController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');
Route::get('/perpustakaan', [App\Http\Controllers\LibraryController::class, 'index'])->name('library');
Route::get('/tenaga-pendidik', [App\Http\Controllers\StaffController::class, 'index'])->name('staff');
Route::get('/fasilitas', [App\Http\Controllers\FacilityController::class, 'index'])->name('facilities');

/* Disabled: /test-password debug route */

// Universal Login Routes (for all roles)
Route::get('/login', function () {
    return view('auth.universal-login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Try to authenticate with web guard
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $request->session()->regenerate();
        
        // Debug info (remove in production)
        \Log::info('Login successful', [
            'user_role' => $user->role ?? 'NULL',
            'user_name' => $user->name ?? 'NULL',
            'user_email' => $user->email ?? 'NULL',
            'user_id' => $user->id ?? 'NULL'
        ]);
        
        // Force redirect based on user role
        if ($user->role === 'teacher') {
            \Log::info('Redirecting teacher to dashboard');
            return response()->view('auth.redirect', [
                'url' => '/teacher/dashboard',
                'message' => 'Login berhasil! Selamat datang di Dashboard Guru.'
            ]);
        } elseif ($user->role === 'admin') {
            \Log::info('Redirecting admin to dashboard');
            return response()->view('auth.redirect', [
                'url' => '/admin/dashboard',
                'message' => 'Login berhasil! Selamat datang di Admin Dashboard.'
            ]);
        } elseif ($user->role === 'student') {
            \Log::info('Redirecting student to dashboard');
            return response()->view('auth.redirect', [
                'url' => '/student/dashboard',
                'message' => 'Login berhasil! Selamat datang di Student Dashboard.'
            ]);
        } else {
            \Log::info('Redirecting to fallback dashboard');
            return response()->view('auth.redirect', [
                'url' => '/dashboard',
                'message' => 'Login berhasil!'
            ]);
        }
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->name('login.submit');

Route::post('/logout', function (Illuminate\Http\Request $request) {
    // Logout from web guard
    Auth::logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// E-Learning Routes
Route::middleware(['auth'])->group(function () {
    // Student Dashboard
    Route::prefix('student')->name('student.')->middleware(['auth', 'role:student', 'student.registered'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
        
        // Student Courses
        Route::get('/courses', [App\Http\Controllers\Student\CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/enrolled', [App\Http\Controllers\Student\CourseController::class, 'enrolled'])->name('courses.enrolled');
        Route::get('/courses/{course}', [App\Http\Controllers\Student\CourseController::class, 'show'])->name('courses.show');
        Route::post('/courses/{course}/enroll', [App\Http\Controllers\Student\CourseController::class, 'enroll'])->name('courses.enroll');
        
        // Student Lessons
        Route::get('/courses/{course}/lessons/{lesson}', [App\Http\Controllers\Student\LessonController::class, 'show'])->name('courses.lessons.show');
        Route::post('/courses/{course}/lessons/{lesson}/complete', [App\Http\Controllers\Student\LessonController::class, 'complete'])->name('courses.lessons.complete');
        
        // Student Attachments
        Route::get('/courses/{course}/lessons/{lesson}/attachments/{filename}', [App\Http\Controllers\Student\AttachmentController::class, 'downloadLessonAttachment'])->name('courses.lessons.attachments.download');
        Route::get('/assignments/{assignment}/attachments/{filename}', [App\Http\Controllers\Student\AttachmentController::class, 'downloadAssignmentAttachment'])->name('assignments.attachments.download');
        
        // Student Assignments
        Route::get('/assignments', [App\Http\Controllers\Student\AssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/assignments/submitted', [App\Http\Controllers\Student\AssignmentController::class, 'submitted'])->name('assignments.submitted');
        Route::get('/assignments/graded', [App\Http\Controllers\Student\AssignmentController::class, 'graded'])->name('assignments.graded');
        Route::get('/assignments/{assignment}', [App\Http\Controllers\Student\AssignmentController::class, 'show'])->name('assignments.show');
        Route::post('/assignments/{assignment}/submit', [App\Http\Controllers\Student\AssignmentController::class, 'submit'])->name('assignments.submit');
        Route::get('/assignments/{assignment}/download/{filename}', [App\Http\Controllers\Student\AssignmentController::class, 'downloadAttachment'])->name('assignments.download-attachment');
        
        // Student Forums
        Route::get('/forums', [App\Http\Controllers\Student\ForumController::class, 'index'])->name('forums.index');
        Route::get('/forums/{forum}', [App\Http\Controllers\Student\ForumController::class, 'show'])->name('forums.show');
        Route::post('/forums/{forum}/replies', [App\Http\Controllers\Student\ForumController::class, 'storeReply'])->name('forums.replies.store');
        
        // Student Grades
        Route::get('/grades', [App\Http\Controllers\Student\GradeController::class, 'index'])->name('grades.index');
        
        // Student Profile
        Route::get('/profile', [App\Http\Controllers\Student\ProfileController::class, 'show'])->name('profile');
        Route::get('/profile/edit', [App\Http\Controllers\Student\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile/photo', [App\Http\Controllers\Student\ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    });
    
    // Teacher Dashboard
    Route::prefix('teacher')->name('teacher.')->middleware(['auth', 'role:teacher'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');
        
        // Profile Routes
        Route::get('/profile', [App\Http\Controllers\Teacher\ProfileController::class, 'show'])->name('profile');
        Route::get('/profile/edit', [App\Http\Controllers\Teacher\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [App\Http\Controllers\Teacher\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile/photo', [App\Http\Controllers\Teacher\ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
        
        // LMS Routes
        Route::resource('courses', App\Http\Controllers\Teacher\CourseController::class);
        Route::post('courses/{course}/toggle-status', [App\Http\Controllers\Teacher\CourseController::class, 'toggleStatus'])->name('courses.toggle-status');
        Route::post('courses/{course}/archive', [App\Http\Controllers\Teacher\CourseController::class, 'archive'])->name('courses.archive');
        
        // Course Lessons
        Route::resource('courses.lessons', App\Http\Controllers\Teacher\LessonController::class);
        Route::post('courses/{course}/lessons/{lesson}/toggle-published', [App\Http\Controllers\Teacher\LessonController::class, 'togglePublished'])->name('courses.lessons.toggle-published');
        Route::post('courses/{course}/lessons/reorder', [App\Http\Controllers\Teacher\LessonController::class, 'reorder'])->name('courses.lessons.reorder');
        
        // Course Assignments
        Route::resource('courses.assignments', App\Http\Controllers\Teacher\AssignmentController::class);
        Route::post('courses/{course}/assignments/{assignment}/toggle-published', [App\Http\Controllers\Teacher\AssignmentController::class, 'togglePublished'])->name('courses.assignments.toggle-published');
        Route::post('courses/{course}/assignments/{assignment}/submissions/{submission}/grade', [App\Http\Controllers\Teacher\AssignmentController::class, 'gradeSubmission'])->name('courses.assignments.submissions.grade');
        Route::get('courses/{course}/assignments/{assignment}/download-submissions', [App\Http\Controllers\Teacher\AssignmentController::class, 'downloadAllSubmissions'])->name('courses.assignments.download-submissions');
        
        // Assignments Overview
        Route::get('assignments', [App\Http\Controllers\Teacher\AssignmentController::class, 'overview'])->name('assignments.overview');
        
        // Course Forums
        Route::resource('courses.forums', App\Http\Controllers\Teacher\ForumController::class);
        Route::post('courses/{course}/forums/{forum}/toggle-pin', [App\Http\Controllers\Teacher\ForumController::class, 'togglePin'])->name('courses.forums.toggle-pin');
        Route::post('courses/{course}/forums/{forum}/toggle-lock', [App\Http\Controllers\Teacher\ForumController::class, 'toggleLock'])->name('courses.forums.toggle-lock');
        Route::post('courses/{course}/forums/{forum}/replies', [App\Http\Controllers\Teacher\ForumController::class, 'storeReply'])->name('courses.forums.replies.store');
        Route::delete('courses/{course}/forums/{forum}/replies/{reply}', [App\Http\Controllers\Teacher\ForumController::class, 'deleteReply'])->name('courses.forums.replies.delete');
    });
    
    // Admin Dashboard
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    });
});

// Document Routes
Route::prefix('download')->name('documents.')->group(function () {
    Route::get('/', [DocumentController::class, 'index'])->name('index');
    Route::get('/kategori/{category}', [DocumentController::class, 'category'])->name('category');
    Route::get('/tipe/{type}', [DocumentController::class, 'type'])->name('type');
    Route::get('/unggulan', [DocumentController::class, 'featured'])->name('featured');
    Route::get('/download/{id}', [DocumentController::class, 'download'])->name('download');
});

// Student Registration Routes
Route::get('/register', function () {
    return view('auth.student-registration-info');
})->name('register');

Route::get('/register/info', function () {
    return view('auth.student-registration-info');
})->name('student.register');

Route::get('/register/form', [App\Http\Controllers\Auth\StudentRegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [App\Http\Controllers\Auth\StudentRegisterController::class, 'register'])->name('register.submit');

// PPDB Routes
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', [PPDBController::class, 'index'])->name('index');
    Route::get('/register', [PPDBController::class, 'register'])->name('register');
    Route::post('/register', [PPDBController::class, 'store'])->name('store');
    Route::get('/success', [PPDBController::class, 'success'])->name('success');
    Route::get('/check-status', [PPDBController::class, 'checkStatus'])->name('check-status');
    Route::post('/check-status', [PPDBController::class, 'checkStatus'])->name('check-status.post');
    Route::get('/refresh-token', [PPDBController::class, 'refreshToken'])->name('refresh-token');
});

// News Routes
Route::prefix('berita')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
    Route::get('/kategori/{category}', [NewsController::class, 'category'])->name('category');
    Route::get('/pengumuman', [NewsController::class, 'announcements'])->name('announcements');
});

// Academic Calendar Routes
Route::prefix('kalender')->name('academic-calendar.')->group(function () {
    Route::get('/', [AcademicCalendarController::class, 'index'])->name('index');
    Route::get('/calendar', [AcademicCalendarController::class, 'calendar'])->name('calendar');
    Route::get('/upcoming', [AcademicCalendarController::class, 'upcoming'])->name('upcoming');
    Route::get('/download/{id}', [AcademicCalendarController::class, 'download'])->name('download');
});

// Gallery Routes
Route::prefix('galeri')->name('gallery.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index');
    Route::get('/unggulan', [GalleryController::class, 'featured'])->name('featured');
    Route::get('/kategori/{category}', [GalleryController::class, 'category'])->name('category');
    Route::get('/{slug}', [GalleryController::class, 'show'])->name('show');
});

// Legal Pages Routes
Route::get('/kebijakan-privasi', [App\Http\Controllers\PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/syarat-ketentuan', [App\Http\Controllers\PageController::class, 'termsConditions'])->name('terms-conditions');
Route::get('/peta-situs', [App\Http\Controllers\PageController::class, 'sitemap'])->name('sitemap');

/* Disabled: debug and test routes (debug, ping, test-route, clear-cache, test, test-storage) */

/* Disabled: /generate setup route (manual copy) */

/* Disabled: /setup route (dangerous exec and symlink/copy operations) */

/* Disabled: /test-images route */

// Image upload routes
Route::get('/image-upload', [App\Http\Controllers\ImageController::class, 'showUploadForm'])->name('image.upload.form');
Route::post('/upload-public', [App\Http\Controllers\ImageController::class, 'uploadToPublic'])->name('image.upload.public');
Route::post('/upload-storage', [App\Http\Controllers\ImageController::class, 'uploadToStorage'])->name('image.upload.storage');
Route::delete('/delete-public', [App\Http\Controllers\ImageController::class, 'deleteFromPublic'])->name('image.delete.public');
Route::delete('/delete-storage', [App\Http\Controllers\ImageController::class, 'deleteFromStorage'])->name('image.delete.storage');

/* Disabled: setup/test controller routes (generate-controller, setup-controller, test-images-controller) */

/* Disabled: /test-upload route */

/* Disabled: /fix-database route (diagnostik DB/cache) */

/* Disabled: /test-upload-detailed route */

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
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Removed duplicate
    
    // Specific routes first (before resource routes)
    Route::get('school-profile/hero/edit', [SchoolProfileController::class, 'editHero'])->name('school-profile.edit-hero');
    Route::put('school-profile/hero/update', [SchoolProfileController::class, 'updateHero'])->name('school-profile.update-hero');
    Route::get('school-profile/struktur/edit', [SchoolProfileController::class, 'editStruktur'])->name('school-profile.edit-struktur');
    Route::put('school-profile/struktur/update', [SchoolProfileController::class, 'updateStruktur'])->name('school-profile.update-struktur');
    
    // Resource routes
    Route::resource('school-profile', SchoolProfileController::class);
    Route::resource('teachers', TeacherController::class);
    Route::post('teachers/{teacher}/transfer-courses', [TeacherController::class, 'transferCourses'])->name('teachers.transfer-courses');
        Route::resource('achievements', AchievementController::class);
        Route::post('achievements/{achievement}/toggle-featured', [AchievementController::class, 'toggleFeatured'])->name('achievements.toggle-featured');
        Route::resource('accreditations', App\Http\Controllers\Admin\AccreditationController::class);
        Route::resource('facilities', App\Http\Controllers\Admin\FacilityController::class);
        
        // Subject routes
        Route::resource('subjects', SubjectController::class);
        Route::post('subjects/{subject}/toggle-active', [SubjectController::class, 'toggleActive'])->name('subjects.toggle-active');
    Route::resource('home-sections', HomeSectionController::class);
    
        // PPDB Admin Routes
        Route::resource('ppdb', AdminPPDBController::class);
        Route::get('ppdb-registrations', [AdminPPDBController::class, 'registrations'])->name('ppdb.registrations');
        Route::get('ppdb-registrations/{registration}', [AdminPPDBController::class, 'showRegistration'])->name('ppdb.show-registration');
        Route::put('ppdb-registrations/{registration}/status', [AdminPPDBController::class, 'updateRegistrationStatus'])->name('ppdb.update-registration-status');
        Route::get('ppdb-registrations/{registration}/download/{type}', [AdminPPDBController::class, 'downloadDocument'])->name('ppdb.download-document');
        Route::get('ppdb-export', [AdminPPDBController::class, 'exportRegistrations'])->name('ppdb.export');
        
        // News Admin Routes
        Route::resource('news', AdminNewsController::class);
        Route::post('news/{news}/toggle-featured', [AdminNewsController::class, 'toggleFeatured'])->name('news.toggle-featured');
        Route::post('news/{news}/toggle-pinned', [AdminNewsController::class, 'togglePinned'])->name('news.toggle-pinned');
        Route::get('news-section/edit', [AdminNewsController::class, 'editSection'])->name('news.edit-section');
        Route::put('news-section/update', [AdminNewsController::class, 'updateSection'])->name('news.update-section');
        
        // Academic Calendar Admin Routes
        Route::resource('academic-calendar', AdminAcademicCalendarController::class);
        Route::get('academic-calendar-section/edit', [AdminAcademicCalendarController::class, 'editSection'])->name('academic-calendar.edit-section');
        Route::put('academic-calendar-section/update', [AdminAcademicCalendarController::class, 'updateSection'])->name('academic-calendar.update-section');
        
        // Gallery Admin Routes
        Route::resource('gallery', AdminGalleryController::class);
        Route::get('gallery-section/edit', [AdminGalleryController::class, 'editSection'])->name('gallery.edit-section');
        Route::put('gallery-section/update', [AdminGalleryController::class, 'updateSection'])->name('gallery.update-section');

        // Document Admin Routes
        Route::resource('documents', AdminDocumentController::class);
        Route::post('documents/{document}/toggle-featured', [AdminDocumentController::class, 'toggleFeatured'])->name('documents.toggle-featured');
        Route::get('documents-section/edit', [AdminDocumentController::class, 'editSection'])->name('documents.edit-section');
        Route::put('documents-section/update', [AdminDocumentController::class, 'updateSection'])->name('documents.update-section');
        
        // Library Admin Routes
        Route::resource('libraries', App\Http\Controllers\Admin\LibraryController::class);
        
        // Vision Mission Admin Routes
        Route::resource('vision-missions', App\Http\Controllers\Admin\VisionMissionController::class);
        
        // Message Admin Routes
        Route::resource('messages', App\Http\Controllers\Admin\MessageController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::post('messages/{message}/mark-as-read', [App\Http\Controllers\Admin\MessageController::class, 'markAsRead'])->name('messages.mark-as-read');
        
        // Headmaster Greeting Admin Routes
        Route::resource('headmaster-greetings', App\Http\Controllers\Admin\HeadmasterGreetingController::class);
        
        // Notification Admin Routes
        Route::get('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/unread-count', [App\Http\Controllers\Admin\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
        Route::post('notifications/{notification}/mark-as-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
        Route::post('notifications/mark-all-as-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
        Route::delete('notifications/{notification}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
        
        // Contact Admin Routes
        Route::get('contact', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contact.index');
        Route::put('contact', [App\Http\Controllers\Admin\ContactController::class, 'update'])->name('contact.update');
        
        // Social Media Admin Routes
        Route::resource('social-media', App\Http\Controllers\Admin\SocialMediaController::class);
        Route::post('social-media/{socialMedia}/toggle-active', [App\Http\Controllers\Admin\SocialMediaController::class, 'toggleActive'])->name('social-media.toggle-active');
        
        // User Management Admin Routes
        Route::resource('user-management', App\Http\Controllers\Admin\UserManagementController::class)->parameters(['user-management' => 'user']);
        Route::post('user-management/{user}/toggle-active', [App\Http\Controllers\Admin\UserManagementController::class, 'toggleActive'])->name('user-management.toggle-active');
        Route::delete('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'clearAll'])->name('notifications.clear-all');
});



require __DIR__.'/auth.php';


// Mobile PPDB Fix Routes
Route::get("/ppdb/refresh-token", function() {
    return response()->json([
        "token" => csrf_token(),
        "success" => true,
        "timestamp" => time()
    ]);
})->name('ppdb.refresh-token');

Route::get("/ppdb/auto-refresh", function() {
    return response()->json([
        "token" => csrf_token(),
        "success" => true,
        "auto_refresh" => true,
        "timestamp" => time()
    ]);
})->name('ppdb.auto-refresh');