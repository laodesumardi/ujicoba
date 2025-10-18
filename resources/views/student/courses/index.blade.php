@extends('layouts.student')

@section('title', 'Daftar Kelas')
@section('page-title', 'Daftar Kelas')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Daftar Kelas Tersedia</h1>
                <p class="text-gray-600 mt-1">Pilih kelas yang ingin Anda ikuti</p>
            </div>
            <a href="{{ route('student.courses.enrolled') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                Kelas Saya
            </a>
        </div>
    </div>

    <!-- Courses Grid -->
    @if($availableCourses->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($availableCourses as $course)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $course->code }}</p>
                            <p class="text-gray-700 text-sm mb-4">{{ Str::limit($course->description, 100) }}</p>
                        </div>
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                            Tersedia
                        </span>
                    </div>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-user mr-2"></i>
                            <span>{{ $course->teacher->name }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-book mr-2"></i>
                            <span>{{ $course->subject }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>Kelas {{ $course->class_level }}{{ $course->class_section ? ' - ' . $course->class_section : '' }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-users mr-2"></i>
                            <span>{{ $course->enrollments()->where('status', 'approved')->count() }} siswa</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            @if($course->start_date)
                                Dimulai: {{ $course->start_date->format('d M Y') }}
                            @endif
                        </div>
                        <form action="{{ route('student.courses.enroll', $course) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                Daftar Kelas
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $availableCourses->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
            <i class="fas fa-graduation-cap text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada kelas tersedia</h3>
            <p class="text-gray-600 mb-6">Semua kelas sudah penuh atau tidak tersedia untuk pendaftaran.</p>
            <a href="{{ route('student.courses.enrolled') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                Lihat Kelas Saya
            </a>
        </div>
    @endif
</div>
@endsection
