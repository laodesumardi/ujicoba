@extends('layouts.student')

@section('title', 'Hasil Penilaian')
@section('page-title', 'Hasil Penilaian')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Hasil Penilaian</h1>
                <p class="text-gray-600 mt-1">Tugas yang sudah dinilai oleh guru</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('student.assignments.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Semua Tugas
                </a>
                <a href="{{ route('student.assignments.submitted') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Tugas Dikumpulkan
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                    <i class="fas fa-star text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Dinilai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $submissions->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Rata-rata</p>
                    <p class="text-2xl font-bold text-gray-900">
                        @if($submissions->count() > 0)
                            {{ round($submissions->avg('grade')) }}
                        @else
                            0
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                    <i class="fas fa-trophy text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Nilai Tertinggi</p>
                    <p class="text-2xl font-bold text-gray-900">
                        @if($submissions->count() > 0)
                            {{ $submissions->max('grade') }}
                        @else
                            0
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Graded Submissions List -->
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
                                    Dinilai: {{ $submission->graded_at->format('d M Y, H:i') }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $submission->assignment->points }} poin
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end space-y-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                <i class="fas fa-star mr-1"></i>
                                Dinilai
                            </span>
                            
                            <div class="text-right">
                                <p class="text-3xl font-bold text-blue-600">
                                    {{ $submission->grade }}/{{ $submission->assignment->points }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ round(($submission->grade / $submission->assignment->points) * 100) }}%
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grade Details -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Detail Penilaian</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Nilai:</span>
                                        <span class="font-medium">{{ $submission->grade }}/{{ $submission->assignment->points }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Persentase:</span>
                                        <span class="font-medium">{{ round(($submission->grade / $submission->assignment->points) * 100) }}%</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-medium text-green-600">Selesai</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Progress</h4>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($submission->grade / $submission->assignment->points) * 100 }}%"></div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">
                                    {{ round(($submission->grade / $submission->assignment->points) * 100) }}% dari nilai maksimal
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Feedback -->
                    @if($submission->feedback)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Feedback Guru</h4>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-gray-700">{{ $submission->feedback }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Submission Content -->
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Jawaban Anda</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700">{{ Str::limit($submission->content, 300) }}</p>
                        </div>
                    </div>
                    
                    <!-- Attachments -->
                    @if($submission->attachments && count($submission->attachments) > 0)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Lampiran Anda</h4>
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
            <i class="fas fa-star text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada hasil penilaian</h3>
            <p class="text-gray-600 mb-6">Hasil penilaian akan muncul setelah guru menilai tugas Anda.</p>
            <a href="{{ route('student.assignments.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                Lihat Semua Tugas
            </a>
        </div>
    @endif
</div>
@endsection
