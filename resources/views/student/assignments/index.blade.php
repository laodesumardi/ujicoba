@extends('layouts.student')

@section('title', 'Daftar Tugas')
@section('page-title', 'Daftar Tugas')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Daftar Tugas & Ujian</h1>
                <p class="text-gray-600 mt-1">Tugas dan ujian dari semua kelas Anda</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('student.assignments.submitted') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Tugas Dikumpulkan
                </a>
                <a href="{{ route('student.assignments.graded') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Hasil Penilaian
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
            <button class="flex-1 py-2 px-4 text-sm font-medium rounded-md bg-white text-gray-900 shadow-sm">
                Semua Tugas
            </button>
            <button class="flex-1 py-2 px-4 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">
                Mendatang
            </button>
            <button class="flex-1 py-2 px-4 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">
                Terlambat
            </button>
            <button class="flex-1 py-2 px-4 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">
                Selesai
            </button>
        </div>
    </div>

    <!-- Assignments List -->
    @if($assignments->count() > 0)
        <div class="space-y-4">
            @foreach($assignments as $assignment)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $assignment->title }}</h3>
                                @if($assignment->due_date && $assignment->due_date < now())
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                        Terlambat
                                    </span>
                                @elseif($assignment->due_date && $assignment->due_date->diffInDays(now()) <= 1)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        Deadline Mendekat
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-2">{{ $assignment->course->title }} • {{ $assignment->course->code }}</p>
                            <p class="text-gray-700 mb-4">{{ Str::limit($assignment->description, 150) }}</p>
                            
                            <div class="flex items-center space-x-6 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    @if($assignment->due_date)
                                        Deadline: {{ $assignment->due_date->format('d M Y, H:i') }}
                                    @else
                                        Tidak ada deadline
                                    @endif
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-star mr-2"></i>
                                    {{ $assignment->points }} poin
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $assignment->estimated_time ?? 'Tidak ditentukan' }} menit
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end space-y-2">
                            @if($assignment->submissions->count() > 0)
                                @php
                                    $submission = $assignment->submissions->first();
                                @endphp
                                @if($submission->status === 'submitted')
                                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>
                                        Dikumpulkan
                                    </span>
                                @elseif($submission->status === 'graded')
                                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-star mr-1"></i>
                                        Dinilai
                                    </span>
                                @endif
                            @else
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Belum Dikumpulkan
                                </span>
                            @endif
                            
                            <a href="{{ route('student.assignments.show', $assignment) }}" 
                               class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                @if($assignment->submissions->count() > 0)
                                    Lihat Tugas
                                @else
                                    Kerjakan Tugas
                                @endif
                            </a>
                        </div>
                    </div>
                    
                    @if($assignment->attachments && count($assignment->attachments) > 0)
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Lampiran:</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($assignment->attachments as $attachment)
                            <a href="{{ route('student.assignments.download-attachment', [$assignment, basename($attachment)]) }}" 
                               class="inline-flex items-center px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                                <i class="fas fa-paperclip mr-2"></i>
                                {{ basename($attachment) }}
                            </a>
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
            {{ $assignments->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
            <i class="fas fa-tasks text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada tugas</h3>
            <p class="text-gray-600 mb-6">Tugas akan muncul setelah Anda mendaftar ke kelas dan guru memberikan tugas.</p>
            <a href="{{ route('student.courses.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                Lihat Kelas Tersedia
            </a>
        </div>
    @endif
</div>
@endsection
