@extends('layouts.teacher')

@section('title', 'Edit Tugas')
@section('page-title', 'Edit Tugas')

@section('content')
<div class="space-y-6">
    <!-- Course Info -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Tugas</h1>
                <p class="text-sm text-gray-600">{{ $course->title }} • {{ $course->code }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('teacher.courses.assignments.show', [$course, $assignment]) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Lihat Detail
                </a>
                <a href="{{ route('teacher.courses.assignments.index', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Kembali ke Daftar Tugas
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <form action="{{ route('teacher.courses.assignments.update', [$course, $assignment]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Tugas</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $assignment->title) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                               placeholder="Masukkan judul tugas">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Tugas</label>
                        <select name="type" id="type" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('type') border-red-500 @enderror">
                            <option value="">Pilih jenis tugas</option>
                            <option value="assignment" {{ old('type', $assignment->type) == 'assignment' ? 'selected' : '' }}>Tugas</option>
                            <option value="quiz" {{ old('type', $assignment->type) == 'quiz' ? 'selected' : '' }}>Kuis</option>
                            <option value="exam" {{ old('type', $assignment->type) == 'exam' ? 'selected' : '' }}>Ujian</option>
                            <option value="project" {{ old('type', $assignment->type) == 'project' ? 'selected' : '' }}>Proyek</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                              placeholder="Deskripsikan tugas ini">{{ old('description', $assignment->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">Instruksi</label>
                    <textarea name="instructions" id="instructions" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('instructions') border-red-500 @enderror"
                              placeholder="Berikan instruksi yang jelas untuk siswa">{{ old('instructions', $assignment->instructions) }}</textarea>
                    @error('instructions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Assignment Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="points" class="block text-sm font-medium text-gray-700 mb-2">Nilai Maksimal</label>
                        <input type="number" name="points" id="points" value="{{ old('points', $assignment->points) }}" min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('points') border-red-500 @enderror">
                        @error('points')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Batas Waktu</label>
                        <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date', $assignment->due_date->format('Y-m-d\TH:i')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="late_penalty" class="block text-sm font-medium text-gray-700 mb-2">Penalti Keterlambatan (%)</label>
                        <input type="number" name="late_penalty" id="late_penalty" value="{{ old('late_penalty', $assignment->late_penalty) }}" min="0" max="100"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('late_penalty') border-red-500 @enderror">
                        @error('late_penalty')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Options -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="allow_late_submission" id="allow_late_submission" value="1" 
                               {{ old('allow_late_submission', $assignment->allow_late_submission) ? 'checked' : '' }}
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="allow_late_submission" class="ml-2 block text-sm text-gray-900">
                            Izinkan pengumpulan terlambat
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_published" id="is_published" value="1" 
                               {{ old('is_published', $assignment->is_published) ? 'checked' : '' }}
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_published" class="ml-2 block text-sm text-gray-900">
                            Publikasikan tugas ini
                        </label>
                    </div>
                </div>

                <!-- Current Attachments -->
                @if($assignment->attachments && count($assignment->attachments) > 0)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran Saat Ini</label>
                    <div class="space-y-2">
                        @foreach($assignment->attachments as $attachment)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ basename($attachment) }}</span>
                            <a href="{{ Storage::url($attachment) }}" target="_blank" class="ml-auto text-primary-600 hover:text-primary-700 text-sm">
                                Download
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- New Attachments -->
                <div>
                    <label for="attachments" class="block text-sm font-medium text-gray-700 mb-2">Tambah Lampiran Baru (Opsional)</label>
                    <input type="file" name="attachments[]" id="attachments" multiple
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('attachments') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Format yang didukung: PDF, DOC, DOCX, PPT, PPTX, JPG, JPEG, PNG, GIF (Maks 10MB per file)</p>
                    @error('attachments')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-4">
                <a href="{{ route('teacher.courses.assignments.show', [$course, $assignment]) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Update Tugas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
