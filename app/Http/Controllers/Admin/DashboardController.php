<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\User;
use App\Models\Achievement;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Facility;
use App\Models\PPDBRegistration;
use App\Models\Message;
use App\Models\Notification;
use App\Models\HeadmasterGreeting;
use App\Models\HomeSection;
use App\Models\AcademicCalendar;
use App\Models\Document;
use App\Models\Library;
use App\Models\Subject;
use App\Models\Assignment;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Submission;
use App\Models\Forum;
use App\Models\ForumReply;
use App\Models\VisionMission;
use App\Models\Accreditation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Info
        $schoolProfile = SchoolProfile::first();
        
        // User Statistics
        $teachersCount = User::where('role', 'teacher')->count();
        $studentsCount = User::where('role', 'student')->count();
        $totalUsers = User::count();
        
        // Content Statistics
        $achievementsCount = Achievement::count();
        $newsCount = News::count();
        $galleryCount = Gallery::count();
        $facilitiesCount = Facility::count();
        $documentsCount = Document::count();
        $librariesCount = Library::count();
        $staffCount = User::whereIn('role', ['teacher', 'admin'])->count();
        $subjectsCount = Subject::count();
        $assignmentsCount = Assignment::count();
        $lessonsCount = Lesson::count();
        $coursesCount = Course::count();
        $forumsCount = Forum::count();
        $headmasterGreetingsCount = HeadmasterGreeting::count();
        $homeSectionsCount = HomeSection::count();
        $academicCalendarsCount = AcademicCalendar::count();
        $visionMissionsCount = VisionMission::count();
        $accreditationsCount = Accreditation::count();
        
        // PPDB Statistics
        $ppdbRegistrationsCount = PPDBRegistration::count();
        $ppdbPendingCount = PPDBRegistration::where('status', 'pending')->count();
        $ppdbApprovedCount = PPDBRegistration::where('status', 'approved')->count();
        $ppdbRejectedCount = PPDBRegistration::where('status', 'rejected')->count();
        
        // Message Statistics
        $messagesCount = Message::count();
        $unreadMessagesCount = Message::where('status', 'unread')->count();
        $repliedMessagesCount = Message::where('status', 'replied')->count();
        
        // Notification Statistics
        $notificationsCount = Notification::count();
        $unreadNotificationsCount = Notification::where('is_read', false)->count();
        
        // Recent Activity
        $recentUsers = User::latest()->take(5)->get();
        $recentNews = News::latest()->take(5)->get();
        $recentMessages = Message::latest()->take(5)->get();
        $recentNotifications = Notification::latest()->take(5)->get();
        
        // Active Content
        $activeNews = News::where('status', 'published')->count();
        $activeFacilities = Facility::where('is_active', true)->count();
        $activeHomeSections = HomeSection::where('is_active', true)->count();
        $activeHeadmasterGreetings = HeadmasterGreeting::where('is_active', true)->count();

        return view('admin.dashboard', compact(
            'schoolProfile', 'teachersCount', 'studentsCount', 'totalUsers',
            'achievementsCount', 'newsCount', 'galleryCount', 'facilitiesCount',
            'documentsCount', 'librariesCount', 'staffCount', 'subjectsCount',
            'assignmentsCount', 'lessonsCount', 'coursesCount', 'forumsCount',
            'headmasterGreetingsCount', 'homeSectionsCount', 'academicCalendarsCount',
            'visionMissionsCount', 'accreditationsCount',
            'ppdbRegistrationsCount', 'ppdbPendingCount', 'ppdbApprovedCount', 'ppdbRejectedCount',
            'messagesCount', 'unreadMessagesCount', 'repliedMessagesCount',
            'notificationsCount', 'unreadNotificationsCount',
            'recentUsers', 'recentNews', 'recentMessages', 'recentNotifications',
            'activeNews', 'activeFacilities', 'activeHomeSections', 'activeHeadmasterGreetings'
        ));
    }
}
