@extends('layouts.teacher')

@section('title', 'Detail Materi')
@section('page-title', 'Detail Materi')

@section('content')
<div class="space-y-6">
    <!-- Lesson Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $lesson->title }}</h1>
                <p class="text-sm text-gray-600 mb-2">{{ $course->title }} • {{ $course->code }}</p>
                <p class="text-sm text-gray-500">Kelas: {{ $course->class_level }}{{ $course->class_section ? ' - ' . $course->class_section : '' }}</p>
                @if($lesson->description)
                <p class="text-gray-700 mb-4">{{ $lesson->description }}</p>
                @endif
                
                <div class="flex items-center space-x-6 text-sm text-gray-500">
                    @if($lesson->due_date)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Due: {{ $lesson->due_date->format('d M Y, H:i') }}
                    </div>
                    @endif
                    @if($lesson->points)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ $lesson->points }} poin
                    </div>
                    @endif
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Urutan: {{ $lesson->order }}
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($lesson->type === 'lesson') bg-blue-100 text-blue-800
                    @elseif($lesson->type === 'assignment') bg-green-100 text-green-800
                    @elseif($lesson->type === 'quiz') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($lesson->type) }}
                </span>
                @if($lesson->is_published)
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                    Aktif
                </span>
                @else
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                    Draft
                </span>
                @endif
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('teacher.courses.lessons.edit', [$course, $lesson]) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                Edit Materi
            </a>
            
            <form action="{{ route('teacher.courses.lessons.toggle-published', [$course, $lesson]) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    @if($lesson->is_published)
                        Sembunyikan
                    @else
                        Publikasikan
                    @endif
                </button>
            </form>
            
            <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                Kembali ke Daftar Materi
            </a>
        </div>
    </div>

    <!-- Lesson Content -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Konten Materi</h2>
        <div class="prose max-w-none">
            {!! nl2br(e($lesson->content)) !!}
        </div>
    </div>

    <!-- Attachments -->
    @if($lesson->attachments && count($lesson->attachments) > 0)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Lampiran</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($lesson->attachments as $attachment)
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-300">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ basename($attachment) }}</p>
                        <p class="text-xs text-gray-500">Lampiran</p>
                    </div>
                    <a href="{{ Storage::url($attachment) }}" target="_blank" class="text-primary-600 hover:text-primary-700 text-sm">
                        Download
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Settings -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Pengaturan Materi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Status</h3>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Publikasi:</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                            @if($lesson->is_published) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $lesson->is_published ? 'Dipublikasikan' : 'Draft' }}
                        </span>
                    </div>
                    @if($lesson->published_at)
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Dipublikasikan pada:</span>
                        <span class="ml-2 text-sm text-gray-900">{{ $lesson->published_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Fitur</h3>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Komentar:</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                            @if($lesson->settings['allow_comments'] ?? false) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ($lesson->settings['allow_comments'] ?? false) ? 'Diizinkan' : 'Tidak diizinkan' }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Wajib diselesaikan:</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                            @if($lesson->settings['require_completion'] ?? false) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ($lesson->settings['require_completion'] ?? false) ? 'Ya' : 'Tidak' }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Tampilkan progress:</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                            @if($lesson->settings['show_progress'] ?? false) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ($lesson->settings['show_progress'] ?? false) ? 'Ya' : 'Tidak' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
