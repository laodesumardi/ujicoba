@extends('layouts.teacher')

@section('title', 'Profil Guru')
@section('page-title', 'Profil Guru')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl shadow-lg text-white p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Avatar -->
                <div class="relative">
                    @if($user->photo)
                        <img src="{{ $user->photo_url }}" alt="Foto Profil" 
                             class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    @endif
                    <div class="w-20 h-20 bg-primary-200 rounded-full flex items-center justify-center shadow-lg {{ $user->photo ? 'hidden' : 'flex' }}">
                        <span class="text-primary-600 font-bold text-2xl">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <!-- Status Badge -->
                    <div class="absolute -bottom-2 -right-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                        <i class="fas fa-chalkboard-teacher mr-1"></i>Guru
                    </div>
                </div>
                
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $user->name }}</h1>
                    <p class="text-primary-100">{{ $user->email }}</p>
                    <p class="text-sm text-primary-200">
                        <i class="fas fa-book mr-1"></i>{{ $user->subject ?? 'Mata Pelajaran' }} • 
                        <i class="fas fa-calendar mr-1"></i>Bergabung {{ $user->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
            
            <div class="hidden md:block">
                <a href="{{ route('teacher.profile.edit') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Profil
                </a>
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

        <!-- Total Students -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Assignments -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-tasks text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tugas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_assignments'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Forums -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-comments text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Forum</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_forums'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Informasi Dasar</h2>
                <a href="{{ route('teacher.profile.edit') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Edit
                </a>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 font-semibold">{{ $user->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>
                
                @if($user->phone)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <p class="text-gray-900">{{ $user->phone }}</p>
                </div>
                @endif
                
                @if($user->subject)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                    <p class="text-gray-900">{{ $user->subject }}</p>
                </div>
                @endif
                
                @if($user->class_level)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas yang Diampu</label>
                    <p class="text-gray-900">
                        Kelas {{ $user->class_level }}
                        @if($user->class_section)
                            - {{ $user->class_section }}
                        @endif
                    </p>
                </div>
                @endif
                
                @if($user->position)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                    <p class="text-gray-900">{{ $user->position }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Professional Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Informasi Profesional</h2>
                <a href="{{ route('teacher.profile.edit') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Edit
                </a>
            </div>
            
            <div class="space-y-4">
                @if($user->employment_status)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Kepegawaian</label>
                    <p class="text-gray-900">{{ ucfirst(str_replace('-', ' ', $user->employment_status)) }}</p>
                </div>
                @endif
                
                @if($user->education)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                    <p class="text-gray-900">{{ $user->education }}</p>
                </div>
                @endif
                
                @if($user->certification)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sertifikasi</label>
                    <p class="text-gray-900 text-sm">{{ $user->certification }}</p>
                </div>
                @endif
                
                @if($user->experience_years)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman</label>
                    <p class="text-gray-900">{{ $user->experience_years }} tahun</p>
                </div>
                @endif
                
                @if($user->bio)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                    <p class="text-gray-900 text-sm">{{ $user->bio }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Classes Taught -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Kelas yang Diampu</h2>
            <a href="{{ route('teacher.courses.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                Kelola Kelas
            </a>
        </div>
        
        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($courses as $course)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-900">{{ $course->title }}</h3>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            @if($course->status === 'active') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $course->status_label }}
                        </span>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-2">{{ $course->code }} • {{ $course->subject }}</p>
                    
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>
                            <i class="fas fa-users mr-1"></i>
                            {{ $course->enrollments_count }} siswa
                        </span>
                        <a href="{{ route('teacher.courses.show', $course) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                            Kelola
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-graduation-cap text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada kelas</h3>
                <p class="text-gray-600 mb-4">Buat kelas untuk memulai mengajar</p>
                <a href="{{ route('teacher.courses.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Kelola Kelas
                </a>
            </div>
        @endif
    </div>

    <!-- Recent Assignments -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Tugas Terbaru</h2>
            <a href="{{ route('teacher.assignments.overview') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                Lihat Semua
            </a>
        </div>
        
        @if($recentAssignments->count() > 0)
            <div class="space-y-3">
                @foreach($recentAssignments as $assignment)
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
                                @if($assignment->is_published)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        Published
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        Draft
                                    </span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('teacher.courses.assignments.show', [$assignment->course, $assignment]) }}" class="text-primary-600 hover:text-primary-700 font-medium">
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
                <p class="text-gray-600">Tugas akan muncul setelah Anda membuat kelas</p>
            </div>
        @endif
    </div>

    <!-- Recent Forums -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Forum Terbaru</h2>
            <a href="{{ route('teacher.courses.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                Kelola Kelas
            </a>
        </div>
        
        @if($recentForums->count() > 0)
            <div class="space-y-3">
                @foreach($recentForums as $forum)
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
                                    {{ $forum->created_at->format('d M Y, H:i') }}
                                </span>
                                @if($forum->is_pinned)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-thumbtack mr-1"></i>
                                        Pinned
                                    </span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('teacher.courses.forums.show', [$forum->course, $forum]) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                            Lihat
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada forum</h3>
                <p class="text-gray-600">Forum akan muncul setelah Anda membuat kelas</p>
            </div>
        @endif
    </div>
</div>
@endsection
