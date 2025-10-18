@extends('layouts.student')

@section('title', $assignment->title)
@section('page-title', $assignment->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Assignment Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $assignment->title }}</h1>
                <p class="text-sm text-gray-600 mb-2">{{ $assignment->course->title }} • {{ $assignment->course->code }}</p>
                <p class="text-gray-700 mb-4">{{ $assignment->description }}</p>
                
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
            
            <div class="flex items-center space-x-3">
                @if($assignment->due_date && $assignment->due_date < now())
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">
                        Terlambat
                    </span>
                @elseif($assignment->due_date && $assignment->due_date->diffInDays(now()) <= 1)
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                        Deadline Mendekat
                    </span>
                @endif
                
                @if($submission)
                    @if($submission->status === 'submitted')
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                            Dikumpulkan
                        </span>
                    @elseif($submission->status === 'graded')
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                            Dinilai
                        </span>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Assignment Instructions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Instruksi Tugas</h2>
        <div class="prose max-w-none">
            {!! nl2br(e($assignment->instructions)) !!}
        </div>
    </div>

    <!-- Attachments -->
    @if($assignment->attachments && count($assignment->attachments) > 0)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Lampiran Tugas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($assignment->attachments as $attachment)
            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-paperclip text-gray-400"></i>
                        <div>
                            <p class="font-medium text-gray-900">{{ basename($attachment) }}</p>
                            <p class="text-sm text-gray-500">Lampiran tugas</p>
                        </div>
                    </div>
                    <a href="{{ route('student.assignments.download-attachment', [$assignment, basename($attachment)]) }}" 
                       class="text-primary-600 hover:text-primary-700 font-medium">
                        Download
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Submission Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">
            @if($submission)
                Edit Pengumpulan Tugas
            @else
                Kumpulkan Tugas
            @endif
        </h2>
        
        @if($assignment->due_date && $assignment->due_date < now() && !$submission)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                    <div>
                        <h3 class="text-sm font-medium text-red-800">Tugas Terlambat</h3>
                        <p class="text-sm text-red-600 mt-1">Deadline sudah lewat, tetapi Anda masih bisa mengumpulkan tugas.</p>
                    </div>
                </div>
            </div>
        @endif
        
        <form action="{{ route('student.assignments.submit', $assignment) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Jawaban Tugas <span class="text-red-500">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="10"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('content') border-red-500 @enderror"
                          placeholder="Tulis jawaban Anda di sini..."
                          required>{{ old('content', $submission->content ?? '') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Attachments -->
            <div class="mb-6">
                <label for="attachments" class="block text-sm font-medium text-gray-700 mb-2">
                    Lampiran (Opsional)
                </label>
                <input type="file" 
                       id="attachments" 
                       name="attachments[]" 
                       multiple
                       accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('attachments') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">
                    Format yang didukung: PDF, DOC, DOCX, TXT, JPG, JPEG, PNG. Maksimal 5 file, 10MB per file.
                </p>
                @error('attachments')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Current Attachments -->
            @if($submission && $submission->attachments && count($submission->attachments) > 0)
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran Saat Ini</label>
                <div class="space-y-2">
                    @foreach($submission->attachments as $attachment)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-paperclip text-gray-400"></i>
                            <span class="text-sm text-gray-900">{{ basename($attachment) }}</span>
                        </div>
                        <span class="text-xs text-gray-500">Lampiran sebelumnya</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Submit Button -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('student.assignments.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors duration-200">
                    @if($submission)
                        Update Pengumpulan
                    @else
                        Kumpulkan Tugas
                    @endif
                </button>
            </div>
        </form>
    </div>

    <!-- Submission Status -->
    @if($submission)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Status Pengumpulan</h2>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-calendar-check text-green-600"></i>
                    <div>
                        <p class="font-medium text-gray-900">Dikumpulkan</p>
                        <p class="text-sm text-gray-600">{{ $submission->submitted_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                    {{ ucfirst($submission->status) }}
                </span>
            </div>
            
            @if($submission->status === 'graded' && $submission->grade)
            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-star text-blue-600"></i>
                    <div>
                        <p class="font-medium text-gray-900">Nilai</p>
                        <p class="text-sm text-gray-600">{{ $submission->grade }}/{{ $assignment->points }}</p>
                    </div>
                </div>
                <span class="text-2xl font-bold text-blue-600">
                    {{ round(($submission->grade / $assignment->points) * 100) }}%
                </span>
            </div>
            @endif
            
            @if($submission->feedback)
            <div class="p-4 bg-yellow-50 rounded-lg">
                <h3 class="font-medium text-gray-900 mb-2">Feedback Guru</h3>
                <p class="text-sm text-gray-700">{{ $submission->feedback }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
