@extends('layouts.teacher')

@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
            <p class="text-sm text-gray-600 mt-1">Akses cepat ke fitur utama</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('teacher.courses.index') }}" class="group flex items-center p-5 border border-gray-200 rounded-xl hover:border-primary-300 hover:shadow-lg transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-4 mr-4 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-primary-700 transition-colors">Kelas Saya</h4>
                        <p class="text-sm text-gray-600">Kelola kelas yang diajar</p>
                    </div>
                </a>


                <a href="{{ route('teacher.courses.index') }}?tab=assignments" class="group flex items-center p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-lg transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 mr-4 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-green-700 transition-colors">Tugas & Penilaian</h4>
                        <p class="text-sm text-gray-600">Kelola tugas dan nilai siswa</p>
                    </div>
                </a>

                <a href="{{ route('teacher.courses.index') }}?tab=forums" class="group flex items-center p-5 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-lg transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 mr-4 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-2-2V10a2 2 0 012-2h2m3-4h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-2-2V6a2 2 0 012-2h2"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-purple-700 transition-colors">Forum Diskusi</h4>
                        <p class="text-sm text-gray-600">Diskusi dengan siswa</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- My Courses -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
                <h3 class="text-lg font-semibold text-gray-900">Kelas Saya</h3>
                <p class="text-sm text-gray-600 mt-1">Daftar kelas yang Anda ajar</p>
            </div>
            <div class="px-6 py-6">
                    @if($courses->count() > 0)
                        <div class="space-y-4">
                            @foreach($courses as $course)
                            <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ $course->title }}</h4>
                                        <p class="text-sm text-gray-600 mb-2">{{ $course->subject }} - {{ $course->class_level }}</p>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            {{ $course->enrollments_count }} siswa
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $course->status === 'active' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-800 border border-gray-200' }}">
                                            {{ $course->status_label }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-gray-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada kelas</h3>
                            <p class="text-gray-600 mb-4">Anda belum membuat kelas apapun.</p>
                            <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Buat Kelas Pertama
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pending Submissions -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
                    <h3 class="text-lg font-semibold text-gray-900">Tugas Menunggu Penilaian</h3>
                    <p class="text-sm text-gray-600 mt-1">Tugas yang perlu dinilai</p>
                </div>
                <div class="px-6 py-6">
                    @if($pendingSubmissions->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingSubmissions as $submission)
                            <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ $submission->assignment->title }}</h4>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ $submission->student->name }}
                                        </div>
                                    </div>
                                    <div class="text-right ml-4">
                                        <div class="text-sm text-gray-500 font-medium">
                                            {{ $submission->submitted_at->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $submission->submitted_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Menunggu Penilaian
                                    </span>
                                    <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                        Nilai Sekarang
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-green-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Semua tugas sudah dinilai</h3>
                            <p class="text-gray-600">Tidak ada tugas yang menunggu penilaian.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Overdue Assignments -->
        @if($overdueAssignments->count() > 0)
        <div class="mt-8">
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Tugas yang Sudah Melewati Batas Waktu</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($overdueAssignments as $assignment)
                                <li>{{ $assignment->title }} - {{ $assignment->course->title }} ({{ $assignment->submissions_count }} pengumpulan)</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Statistics Section -->
    <div id="statistics" class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-900">Statistik Lengkap</h3>
            <p class="text-sm text-gray-600 mt-1">Analisis mendalam tentang aktivitas mengajar Anda</p>
        </div>
        <div class="p-6">
            <!-- Overview Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-500 rounded-lg p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">{{ $totalCourses }}</span>
                    </div>
                    <h4 class="text-lg font-semibold text-blue-900 mb-2">Total Kelas</h4>
                    <p class="text-sm text-blue-700">{{ $activeCourses }} aktif, {{ $totalCourses - $activeCourses }} draft</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-500 rounded-lg p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-green-600">{{ $totalStudents }}</span>
                    </div>
                    <h4 class="text-lg font-semibold text-green-900 mb-2">Total Siswa</h4>
                    <p class="text-sm text-green-700">Rata-rata {{ $totalCourses > 0 ? round($totalStudents / $totalCourses, 1) : 0 }} per kelas</p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-500 rounded-lg p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-purple-600">{{ $totalAssignments }}</span>
                    </div>
                    <h4 class="text-lg font-semibold text-purple-900 mb-2">Total Tugas</h4>
                    <p class="text-sm text-purple-700">{{ $pendingSubmissions->count() }} menunggu penilaian</p>
                </div>

                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-yellow-500 rounded-lg p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-yellow-600">{{ $pendingSubmissions->count() }}</span>
                    </div>
                    <h4 class="text-lg font-semibold text-yellow-900 mb-2">Menunggu</h4>
                    <p class="text-sm text-yellow-700">Tugas perlu dinilai</p>
                </div>
            </div>

            <!-- Performance Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Course Performance -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Performa Kelas</h4>
                    <div class="space-y-4">
                        @foreach($coursePerformance as $course)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h5 class="text-sm font-medium text-gray-900">{{ $course['title'] }}</h5>
                                <p class="text-xs text-gray-600">{{ $course['subject'] }} - {{ $course['class_level'] }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $course['enrollments_count'] > 0 ? min(($course['enrollments_count'] / 30) * 100, 100) : 0 }}%"></div>
                                </div>
                                <span class="text-xs text-gray-600 w-8">{{ $course['enrollments_count'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h4>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-500 rounded-full p-2 mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Dashboard diakses</p>
                                <p class="text-xs text-gray-500">{{ now()->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($courses->count() > 0)
                        <div class="flex items-start">
                            <div class="bg-green-500 rounded-full p-2 mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $courses->count() }} kelas aktif</p>
                                <p class="text-xs text-gray-500">Total {{ $totalStudents }} siswa</p>
                            </div>
                        </div>
                        @endif

                        @if($pendingSubmissions->count() > 0)
                        <div class="flex items-start">
                            <div class="bg-yellow-500 rounded-full p-2 mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $pendingSubmissions->count() }} tugas menunggu penilaian</p>
                                <p class="text-xs text-gray-500">Perlu segera dinilai</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
            <p class="text-sm text-gray-600 mt-1">Aktivitas terbaru Anda</p>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-full p-3 mr-4 shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-900">Selamat datang di Dashboard Guru</p>
                        <p class="text-xs text-gray-500 mt-1">{{ now()->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                
                @if($courses->count() > 0)
                <div class="flex items-start">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-full p-3 mr-4 shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-900">Anda memiliki {{ $courses->count() }} kelas aktif</p>
                        <p class="text-xs text-gray-500 mt-1">{{ now()->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
