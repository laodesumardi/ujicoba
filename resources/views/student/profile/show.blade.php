@extends('layouts.student')

@section('title', 'Profil Siswa')
@section('page-title', 'Profil Siswa')

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
                        <i class="fas fa-check-circle mr-1"></i>Aktif
                    </div>
                </div>
                
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $user->name }}</h1>
                    <p class="text-primary-100">{{ $user->email }}</p>
                    <p class="text-sm text-primary-200">
                        <i class="fas fa-id-card mr-1"></i>NIS: {{ $user->student_id ?? 'Belum diatur' }} • 
                        <i class="fas fa-calendar mr-1"></i>Terdaftar {{ $user->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
            
            <div class="hidden md:block">
                <a href="{{ route('student.profile.edit') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
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

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Informasi Dasar</h2>
                <a href="{{ route('student.profile.edit') }}" class="text-primary-600 hover:text-primary-700 font-medium">
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
                
                @if($user->student_id)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                    <p class="text-gray-900 font-mono">{{ $user->student_id }}</p>
                </div>
                @endif
                
                @if($user->phone)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <p class="text-gray-900">{{ $user->phone }}</p>
                </div>
                @endif
                
                @if($user->class_level)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <p class="text-gray-900">
                        Kelas {{ $user->class_level }}
                        @if($user->class_section)
                            - {{ $user->class_section }}
                        @endif
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Informasi Pribadi</h2>
                <a href="{{ route('student.profile.edit') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Edit
                </a>
            </div>
            
            <div class="space-y-4">
                @if($user->date_of_birth)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <p class="text-gray-900">{{ $user->date_of_birth->format('d M Y') }}</p>
                </div>
                @endif
                
                @if($user->gender)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <p class="text-gray-900">{{ $user->gender }}</p>
                </div>
                @endif
                
                @if($user->religion)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                    <p class="text-gray-900">{{ $user->religion }}</p>
                </div>
                @endif
                
                @if($user->address)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <p class="text-gray-900 text-sm">{{ $user->address }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Parent Information -->
    @if($user->parent_name || $user->parent_phone || $user->parent_email)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Informasi Orang Tua/Wali</h2>
            <a href="{{ route('student.profile.edit') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                Edit
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @if($user->parent_name)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua/Wali</label>
                <p class="text-gray-900 font-semibold">{{ $user->parent_name }}</p>
            </div>
            @endif
            
            @if($user->parent_phone)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <p class="text-gray-900">{{ $user->parent_phone }}</p>
            </div>
            @endif
            
            @if($user->parent_email)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <p class="text-gray-900">{{ $user->parent_email }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

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
@endsection
