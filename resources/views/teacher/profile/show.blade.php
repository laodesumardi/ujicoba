@extends('layouts.teacher')

@section('title', 'Profile Guru')
@section('page-title', 'Profile Saya')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="px-6 py-8">
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <!-- Profile Photo -->
                <div class="relative">
                    @if($teacher->photo)
                        <img src="{{ Storage::url($teacher->photo) }}" 
                             alt="{{ $teacher->name }}" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center border-4 border-white shadow-lg">
                            <span class="text-4xl font-bold text-white">{{ substr($teacher->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div class="absolute -bottom-2 -right-2">
                        <a href="{{ route('teacher.profile.edit') }}" 
                           class="bg-primary-600 hover:bg-primary-700 text-white p-2 rounded-full shadow-lg transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $teacher->name ?? 'Nama tidak tersedia' }}</h1>
                    <p class="text-lg text-gray-600 mb-1">{{ $teacher->subject ?? 'Mata Pelajaran belum diisi' }}</p>
                    <p class="text-sm text-gray-500 mb-4">
                        {{ $teacher->position ?? 'Jabatan belum diisi' }} • 
                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                            {{ $teacher->employment_status === 'Aktif' ? 'bg-green-100 text-green-800' : 
                               ($teacher->employment_status === 'Non-Aktif' ? 'bg-red-100 text-red-800' : 
                               'bg-yellow-100 text-yellow-800') }}">
                            {{ $teacher->employment_status ?? 'Status belum diisi' }}
                        </span>
                    </p>
                    
                    @if($teacher->bio)
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <p class="text-gray-700 italic">"{{ $teacher->bio }}"</p>
                        </div>
                    @else
                        <div class="bg-blue-50 rounded-lg p-4 mb-4">
                            <p class="text-blue-700 text-sm">Bio belum diisi. <a href="{{ route('teacher.profile.edit') }}" class="underline">Tambahkan bio</a> untuk melengkapi profil Anda.</p>
                        </div>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('teacher.profile.edit') }}" 
                           class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Edit Profile
                        </a>
                        @if($teacher->photo)
                            <form action="{{ route('teacher.profile.photo.delete') }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil?')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus Foto
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Dasar</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Nama Lengkap:</span>
                    <span class="text-sm text-gray-900">{{ $teacher->name ?? 'Belum diisi' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Email:</span>
                    <span class="text-sm text-gray-900">{{ $teacher->email ?? 'Belum diisi' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Telepon:</span>
                    <span class="text-sm {{ $teacher->phone ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->phone ?? 'Belum diisi' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Alamat:</span>
                    <span class="text-sm {{ $teacher->address ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->address ?? 'Belum diisi' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Tanggal Lahir:</span>
                    <span class="text-sm {{ $teacher->date_of_birth ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->date_of_birth ? \Carbon\Carbon::parse($teacher->date_of_birth)->format('d M Y') : 'Belum diisi' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Jenis Kelamin:</span>
                    <span class="text-sm {{ $teacher->gender ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->gender ?? 'Belum diisi' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Agama:</span>
                    <span class="text-sm {{ $teacher->religion ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->religion ?? 'Belum diisi' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Profesional</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Mata Pelajaran:</span>
                    <span class="text-sm {{ $teacher->subject ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->subject ?? 'Belum diisi' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Jabatan:</span>
                    <span class="text-sm {{ $teacher->position ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->position ?? 'Belum diisi' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Status Kepegawaian:</span>
                    <span class="text-sm {{ $teacher->employment_status ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->employment_status ?? 'Belum diisi' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Tanggal Bergabung:</span>
                    <span class="text-sm {{ $teacher->join_date ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->join_date ? \Carbon\Carbon::parse($teacher->join_date)->format('d M Y') : 'Belum diisi' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Pendidikan:</span>
                    <span class="text-sm {{ $teacher->education ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->education ?? 'Belum diisi' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Sertifikasi:</span>
                    <span class="text-sm {{ $teacher->certification ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->certification ?? 'Belum diisi' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-600">Pengalaman:</span>
                    <span class="text-sm {{ $teacher->experience_years ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $teacher->experience_years ? $teacher->experience_years . ' tahun' : 'Belum diisi' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Teaching Statistics -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-900">Statistik Mengajar</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center bg-blue-50 rounded-lg p-6">
                    <div class="text-3xl font-bold text-blue-600 mb-2">
                        {{ $teacher->courses ? $teacher->courses->count() : 0 }}
                    </div>
                    <div class="text-sm text-blue-700 font-medium">Total Kelas</div>
                    <div class="text-xs text-blue-600 mt-1">Semua kelas yang dibuat</div>
                </div>
                <div class="text-center bg-green-50 rounded-lg p-6">
                    <div class="text-3xl font-bold text-green-600 mb-2">
                        {{ $teacher->courses ? $teacher->courses->where('status', 'active')->count() : 0 }}
                    </div>
                    <div class="text-sm text-green-700 font-medium">Kelas Aktif</div>
                    <div class="text-xs text-green-600 mt-1">Kelas yang sedang berjalan</div>
                </div>
                <div class="text-center bg-purple-50 rounded-lg p-6">
                    <div class="text-3xl font-bold text-purple-600 mb-2">
                        {{ $teacher->courses ? $teacher->courses->sum(function($course) { return $course->enrollments->count(); }) : 0 }}
                    </div>
                    <div class="text-sm text-purple-700 font-medium">Total Siswa</div>
                    <div class="text-xs text-purple-600 mt-1">Siswa yang terdaftar</div>
                </div>
            </div>
            
            @if($teacher->courses && $teacher->courses->count() > 0)
            <div class="mt-8">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Kelas Terbaru</h4>
                <div class="space-y-3">
                    @foreach($teacher->courses->take(3) as $course)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <h5 class="font-medium text-gray-900">{{ $course->title }}</h5>
                            <p class="text-sm text-gray-600">{{ $course->subject }} - {{ $course->class_level }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $course->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($course->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($course->status) }}
                            </span>
                            <span class="text-sm text-gray-500">{{ $course->enrollments ? $course->enrollments->count() : 0 }} siswa</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="mt-8 text-center py-8">
                <div class="bg-blue-50 rounded-lg p-6">
                    <svg class="w-12 h-12 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Belum ada kelas</h3>
                    <p class="text-blue-700 mb-4">Anda belum membuat kelas apapun.</p>
                    <a href="{{ route('teacher.courses.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Buat Kelas Pertama
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
