@extends('layouts.teacher')

@section('title', 'Edit Materi')
@section('page-title', 'Edit Materi')

@section('content')
<div class="space-y-6">
    <!-- Course Info -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Materi</h1>
                <p class="text-sm text-gray-600">{{ $course->title }} • {{ $course->code }}</p>
                <p class="text-sm text-gray-500">Kelas: {{ $course->class_level }}{{ $course->class_section ? ' - ' . $course->class_section : '' }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('teacher.courses.lessons.show', [$course, $lesson]) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Lihat Detail
                </a>
                <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Kembali ke Daftar Materi
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <form action="{{ route('teacher.courses.lessons.update', [$course, $lesson]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Materi</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $lesson->title) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                               placeholder="Masukkan judul materi">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Materi</label>
                        <select name="type" id="type" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('type') border-red-500 @enderror">
                            <option value="">Pilih jenis materi</option>
                            <option value="lesson" {{ old('type', $lesson->type) == 'lesson' ? 'selected' : '' }}>Materi Pembelajaran</option>
                            <option value="assignment" {{ old('type', $lesson->type) == 'assignment' ? 'selected' : '' }}>Tugas</option>
                            <option value="quiz" {{ old('type', $lesson->type) == 'quiz' ? 'selected' : '' }}>Kuis</option>
                            <option value="exam" {{ old('type', $lesson->type) == 'exam' ? 'selected' : '' }}>Ujian</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                              placeholder="Deskripsikan materi ini secara singkat">{{ old('description', $lesson->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Materi</label>
                    <textarea name="content" id="content" rows="8" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror"
                              placeholder="Tuliskan konten materi yang akan dipelajari siswa...">{{ old('content', $lesson->content) }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Gunakan format yang jelas dan mudah dipahami siswa.</p>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Assignment/Quiz/Exam Details -->
                <div id="assignment-details" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Batas Waktu</label>
                            <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date', $lesson->due_date ? $lesson->due_date->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('due_date') border-red-500 @enderror">
                            @error('due_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="points" class="block text-sm font-medium text-gray-700 mb-2">Nilai Maksimal</label>
                            <input type="number" name="points" id="points" value="{{ old('points', $lesson->points) }}" min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('points') border-red-500 @enderror">
                            @error('points')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Current Attachments -->
                @if($lesson->attachments && count($lesson->attachments) > 0)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran Saat Ini</label>
                    <div class="space-y-2">
                        @foreach($lesson->attachments as $attachment)
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

                <!-- Settings -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Pengaturan Materi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="allow_comments" id="allow_comments" value="1" 
                                       {{ old('allow_comments', $lesson->settings['allow_comments'] ?? true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="allow_comments" class="ml-2 block text-sm text-gray-900">
                                    Izinkan komentar dari siswa
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="require_completion" id="require_completion" value="1" 
                                       {{ old('require_completion', $lesson->settings['require_completion'] ?? false) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="require_completion" class="ml-2 block text-sm text-gray-900">
                                    Wajib diselesaikan siswa
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="show_progress" id="show_progress" value="1" 
                                       {{ old('show_progress', $lesson->settings['show_progress'] ?? true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="show_progress" class="ml-2 block text-sm text-gray-900">
                                    Tampilkan progress siswa
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1" 
                                   {{ old('is_published', $lesson->is_published) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                Publikasikan materi ini
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-4">
                <a href="{{ route('teacher.courses.lessons.show', [$course, $lesson]) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Update Materi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const assignmentDetails = document.getElementById('assignment-details');
    
    function toggleAssignmentDetails() {
        const selectedType = typeSelect.value;
        if (selectedType === 'assignment' || selectedType === 'quiz' || selectedType === 'exam') {
            assignmentDetails.classList.remove('hidden');
        } else {
            assignmentDetails.classList.add('hidden');
        }
    }
    
    typeSelect.addEventListener('change', toggleAssignmentDetails);
    toggleAssignmentDetails(); // Initial check
});
</script>
@endsection
