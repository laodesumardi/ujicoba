@extends('layouts.student')

@section('title', $lesson->title)
@section('page-title', $lesson->title)

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="space-y-6">
    <!-- Lesson Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $lesson->title }}</h1>
                <p class="text-sm text-gray-600 mb-2">{{ $course->title }} • {{ $course->code }}</p>
                <p class="text-gray-700 mb-4">{{ $lesson->description }}</p>
                
                <div class="flex items-center space-x-6 text-sm text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2"></i>
                        {{ $course->teacher->name }}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-book mr-2"></i>
                        {{ $course->subject }}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Kelas {{ $course->class_level }}
                    </div>
                    @if($lesson->due_date)
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Deadline: {{ $lesson->due_date->format('d M Y, H:i') }}
                    </div>
                    @endif
                    @if($lesson->points)
                    <div class="flex items-center">
                        <i class="fas fa-star mr-2"></i>
                        {{ $lesson->points }} poin
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($lesson->type === 'lesson') bg-blue-100 text-blue-800
                    @elseif($lesson->type === 'assignment') bg-green-100 text-green-800
                    @elseif($lesson->type === 'quiz') bg-yellow-100 text-yellow-800
                    @elseif($lesson->type === 'exam') bg-red-100 text-red-800
                    @else bg-purple-100 text-purple-800
                    @endif">
                    {{ ucfirst($lesson->type) }}
                </span>
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                    <i class="fas fa-check mr-1"></i>
                    Tersedia
                </span>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">
            <form action="{{ route('student.courses.lessons.complete', [$course, $lesson]) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-check mr-2"></i>
                    Tandai Selesai
                </button>
            </form>
            
            <a href="{{ route('student.courses.show', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Kelas
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
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Lampiran Materi</h2>
            <span class="text-sm text-gray-500">{{ count($lesson->attachments) }} file tersedia</span>
        </div>
        
        <div class="space-y-3">
            @foreach($lesson->attachments as $attachment)
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md hover:border-primary-300 transition-all duration-300 bg-gradient-to-r from-white to-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <!-- File Icon based on extension -->
                        @php
                            $extension = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
                        @endphp
                        
                        @if(in_array($extension, ['pdf']))
                            <div class="bg-red-100 rounded-lg p-3 mr-4">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @elseif(in_array($extension, ['doc', 'docx']))
                            <div class="bg-blue-100 rounded-lg p-3 mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        @elseif(in_array($extension, ['ppt', 'pptx']))
                            <div class="bg-orange-100 rounded-lg p-3 mr-4">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                            <div class="bg-green-100 rounded-lg p-3 mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @else
                            <div class="bg-gray-100 rounded-lg p-3 mr-4">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ basename($attachment) }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ $extension }} • Lampiran Materi</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('student.courses.lessons.attachments.download', [$course, $lesson, basename($attachment)]) }}" 
                           class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Navigation -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                @if($previousLesson)
                <a href="{{ route('student.courses.lessons.show', [$course, $previousLesson]) }}" class="flex items-center text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <div>
                        <p class="text-sm font-medium">Materi Sebelumnya</p>
                        <p class="text-xs">{{ $previousLesson->title }}</p>
                    </div>
                </a>
                @endif
            </div>
            
            <div>
                @if($nextLesson)
                <a href="{{ route('student.courses.lessons.show', [$course, $nextLesson]) }}" class="flex items-center text-gray-600 hover:text-gray-800">
                    <div class="text-right">
                        <p class="text-sm font-medium">Materi Selanjutnya</p>
                        <p class="text-xs">{{ $nextLesson->title }}</p>
                    </div>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
