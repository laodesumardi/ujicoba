@extends('layouts.student')

@section('title', 'Tugas Dikumpulkan')
@section('page-title', 'Tugas Dikumpulkan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tugas Dikumpulkan</h1>
                <p class="text-gray-600 mt-1">Tugas yang sudah Anda kumpulkan</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('student.assignments.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Semua Tugas
                </a>
                <a href="{{ route('student.assignments.graded') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Hasil Penilaian
                </a>
            </div>
        </div>
    </div>

    <!-- Submissions List -->
    @if($submissions->count() > 0)
        <div class="space-y-4">
            @foreach($submissions as $submission)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $submission->assignment->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $submission->assignment->course->title }} • {{ $submission->assignment->course->code }}</p>
                            <p class="text-gray-700 mb-4">{{ Str::limit($submission->assignment->description, 150) }}</p>
                            
                            <div class="flex items-center space-x-6 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Dikumpulkan: {{ $submission->submitted_at->format('d M Y, H:i') }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-star mr-2"></i>
                                    {{ $submission->assignment->points }} poin
                                </div>
                                @if($submission->assignment->due_date)
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    Deadline: {{ $submission->assignment->due_date->format('d M Y, H:i') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end space-y-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>
                                Dikumpulkan
                            </span>
                            
                            @if($submission->status === 'graded')
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-star mr-1"></i>
                                    Dinilai
                                </span>
                            @endif
                            
                            <a href="{{ route('student.assignments.show', $submission->assignment) }}" 
                               class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    
                    <!-- Submission Content Preview -->
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Jawaban Anda:</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700">{{ Str::limit($submission->content, 200) }}</p>
                        </div>
                    </div>
                    
                    <!-- Attachments -->
                    @if($submission->attachments && count($submission->attachments) > 0)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Lampiran:</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($submission->attachments as $attachment)
                            <span class="inline-flex items-center px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg">
                                <i class="fas fa-paperclip mr-2"></i>
                                {{ basename($attachment) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Grade Information -->
                    @if($submission->status === 'graded' && $submission->grade)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Nilai</h4>
                                <p class="text-sm text-gray-600">{{ $submission->grade }}/{{ $submission->assignment->points }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ round(($submission->grade / $submission->assignment->points) * 100) }}%
                                </p>
                            </div>
                        </div>
                        
                        @if($submission->feedback)
                        <div class="mt-3 p-3 bg-yellow-50 rounded-lg">
                            <h5 class="text-sm font-medium text-gray-900 mb-1">Feedback Guru:</h5>
                            <p class="text-sm text-gray-700">{{ $submission->feedback }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $submissions->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
            <i class="fas fa-check-circle text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada tugas dikumpulkan</h3>
            <p class="text-gray-600 mb-6">Mulai mengerjakan tugas untuk melihatnya di sini.</p>
            <a href="{{ route('student.assignments.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                Lihat Semua Tugas
            </a>
        </div>
    @endif
</div>
@endsection
