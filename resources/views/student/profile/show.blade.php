@extends('layouts.student')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Profile Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center space-x-6">
            @if($user->photo && Storage::disk('public')->exists($user->photo))
                <img src="{{ Storage::url($user->photo) }}" alt="Foto Profil" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg">
            @else
                <div class="w-20 h-20 bg-primary-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-2xl">{{ substr($user->name, 0, 1) }}</span>
                </div>
            @endif
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-gray-600">{{ $user->email }}</p>
                <p class="text-sm text-gray-500 mt-1">Siswa • Terdaftar sejak {{ $user->created_at->format('d M Y') }}</p>
            </div>
            <div>
                <a href="{{ route('student.profile.edit') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Dasar</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <p class="text-gray-900">{{ $user->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <p class="text-gray-900">{{ $user->email }}</p>
            </div>
            
            @if($user->student_id)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">NIS</label>
                <p class="text-gray-900">{{ $user->student_id }}</p>
            </div>
            @endif
            
            @if($user->phone)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <p class="text-gray-900">{{ $user->phone }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Class Information -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Kelas</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kelas</label>
                <p class="text-gray-900">
                    @if($user->class_level)
                        {{ $user->class_level }}
                        @if($user->class_section)
                            - {{ $user->class_section }}
                        @endif
                    @else
                        <span class="text-gray-400">Belum diatur</span>
                    @endif
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <p class="text-gray-900">Siswa Aktif</p>
            </div>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pribadi</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($user->date_of_birth)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                <p class="text-gray-900">{{ $user->date_of_birth->format('d M Y') }}</p>
            </div>
            @endif
            
            @if($user->gender)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                <p class="text-gray-900">{{ $user->gender }}</p>
            </div>
            @endif
            
            @if($user->religion)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                <p class="text-gray-900">{{ $user->religion }}</p>
            </div>
            @endif
            
            @if($user->address)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <p class="text-gray-900">{{ $user->address }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Parent Information -->
    @if($user->parent_name || $user->parent_phone || $user->parent_email)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Orang Tua</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($user->parent_name)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua/Wali</label>
                <p class="text-gray-900">{{ $user->parent_name }}</p>
            </div>
            @endif
            
            @if($user->parent_phone)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <p class="text-gray-900">{{ $user->parent_phone }}</p>
            </div>
            @endif
            
            @if($user->parent_email)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <p class="text-gray-900">{{ $user->parent_email }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Learning Statistics -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Statistik Pembelajaran</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $user->enrollments()->where('status', 'approved')->count() }}</p>
                <p class="text-sm text-gray-600">Kelas Diikuti</p>
            </div>
            
            <div class="text-center">
                <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-tasks text-green-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $user->submissions()->where('status', 'submitted')->count() }}</p>
                <p class="text-sm text-gray-600">Tugas Dikumpulkan</p>
            </div>
            
            <div class="text-center">
                <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-star text-purple-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $user->submissions()->where('status', 'graded')->count() }}</p>
                <p class="text-sm text-gray-600">Tugas Dinilai</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h2>
        
        <div class="space-y-4">
            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                <div class="bg-blue-100 rounded-full w-10 h-10 flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900">Mendaftar ke kelas</p>
                    <p class="text-sm text-gray-600">2 hari yang lalu</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                <div class="bg-green-100 rounded-full w-10 h-10 flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900">Mengumpulkan tugas</p>
                    <p class="text-sm text-gray-600">3 hari yang lalu</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                <div class="bg-purple-100 rounded-full w-10 h-10 flex items-center justify-center">
                    <i class="fas fa-comments text-purple-600"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900">Berpartisipasi di forum</p>
                    <p class="text-sm text-gray-600">5 hari yang lalu</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
