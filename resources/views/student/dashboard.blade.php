@extends('layouts.student')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl shadow-lg text-white p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Selamat datang, {{ auth()->user()->name }}!</h1>
                <p class="text-primary-100">Kelola pembelajaran Anda dengan mudah</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-graduation-cap text-6xl text-primary-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Courses -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kelas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_courses'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Assignments -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-tasks text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tugas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_assignments'] }}</p>
                </div>
            </div>
        </div>

        <!-- Submitted Assignments -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tugas Dikumpulkan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['submitted_assignments'] }}</p>
                </div>
            </div>
        </div>

        <!-- Graded Assignments -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tugas Dinilai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['graded_assignments'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('student.courses.index') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-graduation-cap text-blue-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-blue-900">Kelas Saya</p>
                    <p class="text-sm text-blue-600">Lihat semua kelas</p>
                </div>
            </a>
            
            <a href="{{ route('student.assignments.index') }}" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-tasks text-green-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-green-900">Tugas & Ujian</p>
                    <p class="text-sm text-green-600">Lihat tugas terbaru</p>
                </div>
            </a>
            
            <a href="{{ route('student.forums.index') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-comments text-purple-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-purple-900">Forum Diskusi</p>
                    <p class="text-sm text-purple-600">Diskusi dengan teman</p>
                </div>
            </a>
            
            <a href="{{ route('student.grades.index') }}" class="flex items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-chart-line text-orange-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-orange-900">Nilai & Rapor</p>
                    <p class="text-sm text-orange-600">Lihat progress belajar</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Enrolled Courses -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Kelas Saya</h2>
                <a href="{{ route('student.courses.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Lihat Semua
                </a>
            </div>
            
            @if($enrolledCourses->count() > 0)
                <div class="space-y-3">
                    @foreach($enrolledCourses->take(3) as $course)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $course->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $course->code }} • {{ $course->subject }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($course->status === 'active') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $course->status_label }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('student.courses.show', $course) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                Masuk
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-graduation-cap text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada kelas</h3>
                    <p class="text-gray-600 mb-4">Daftar ke kelas untuk memulai pembelajaran</p>
                    <a href="{{ route('student.courses.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Lihat Kelas Tersedia
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Assignments -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Tugas Terbaru</h2>
                <a href="{{ route('student.assignments.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Lihat Semua
                </a>
            </div>
            
            @if($recentAssignments->count() > 0)
                <div class="space-y-3">
                    @foreach($recentAssignments->take(3) as $assignment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $assignment->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $assignment->course->title }}</p>
                                <div class="flex items-center mt-2 space-x-2">
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $assignment->due_date ? $assignment->due_date->format('d M Y') : 'Tidak ada deadline' }}
                                    </span>
                                    @if($assignment->due_date && $assignment->due_date < now())
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                            Terlambat
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('student.assignments.show', $assignment) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                Lihat
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-tasks text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada tugas</h3>
                    <p class="text-gray-600">Tugas akan muncul setelah Anda mendaftar ke kelas</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Upcoming & Overdue Assignments -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Assignments -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Tugas Mendatang</h2>
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                    {{ $stats['upcoming_assignments'] }} tugas
                </span>
            </div>
            
            @if($upcomingAssignments->count() > 0)
                <div class="space-y-3">
                    @foreach($upcomingAssignments->take(3) as $assignment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $assignment->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $assignment->course->title }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-xs text-blue-600">
                                        <i class="fas fa-clock mr-1"></i>
                                        Deadline: {{ $assignment->due_date->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('student.assignments.show', $assignment) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                Kerjakan
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-calendar-check text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada tugas mendatang</h3>
                    <p class="text-gray-600">Semua tugas sudah selesai!</p>
                </div>
            @endif
        </div>

        <!-- Overdue Assignments -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Tugas Terlambat</h2>
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">
                    {{ $stats['overdue_assignments'] }} tugas
                </span>
            </div>
            
            @if($overdueAssignments->count() > 0)
                <div class="space-y-3">
                    @foreach($overdueAssignments->take(3) as $assignment)
                    <div class="border border-red-200 rounded-lg p-4 hover:shadow-md transition-all duration-300 bg-red-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $assignment->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $assignment->course->title }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-xs text-red-600">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Terlambat: {{ $assignment->due_date->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('student.assignments.show', $assignment) }}" class="text-red-600 hover:text-red-700 font-medium">
                                Segera Kumpulkan
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-4xl text-green-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada tugas terlambat</h3>
                    <p class="text-gray-600">Bagus! Semua tugas sudah dikumpulkan tepat waktu</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Forum Activity -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Aktivitas Forum Terbaru</h2>
            <a href="{{ route('student.forums.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                Lihat Semua
            </a>
        </div>
        
        @if($recentForums->count() > 0)
            <div class="space-y-3">
                @foreach($recentForums->take(3) as $forum)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $forum->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $forum->course->title }}</p>
                            <div class="flex items-center mt-2 space-x-4">
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-user mr-1"></i>
                                    {{ $forum->author->name }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $forum->last_activity->format('d M Y, H:i') }}
                                </span>
                                @if($forum->is_pinned)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-thumbtack mr-1"></i>
                                        Pinned
                                    </span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('student.forums.show', $forum) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                            Lihat
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada aktivitas forum</h3>
                <p class="text-gray-600">Diskusi akan muncul setelah Anda mendaftar ke kelas</p>
            </div>
        @endif
    </div>
</div>
@endsection