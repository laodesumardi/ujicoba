@extends('layouts.teacher')

@section('title', 'Buat Materi Baru')
@section('page-title', 'Buat Materi Baru')

@section('content')
<div class="space-y-6">
    <!-- Course Info -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Buat Materi Baru</h1>
                <p class="text-sm text-gray-600">{{ $course->title }} • {{ $course->code }}</p>
                <p class="text-sm text-gray-500">Kelas: {{ $course->class_level }}{{ $course->class_section ? ' - ' . $course->class_section : '' }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Kembali ke Daftar Materi
                </a>
                <a href="{{ route('teacher.courses.show', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Kembali ke Kelas
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <form action="{{ route('teacher.courses.lessons.store', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Materi</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" 
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
                            <option value="lesson" {{ old('type') == 'lesson' ? 'selected' : '' }}>Materi Pembelajaran</option>
                            <option value="assignment" {{ old('type') == 'assignment' ? 'selected' : '' }}>Tugas</option>
                            <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>Kuis</option>
                            <option value="exam" {{ old('type') == 'exam' ? 'selected' : '' }}>Ujian</option>
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
                              placeholder="Deskripsikan materi ini secara singkat">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Materi</label>
                    <textarea name="content" id="content" rows="8" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror"
                              placeholder="Tuliskan konten materi yang akan dipelajari siswa...">{{ old('content') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Gunakan format yang jelas dan mudah dipahami siswa.</p>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Assignment/Quiz/Exam Details -->
                <div id="assignment-details" class="hidden space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Batas Waktu</label>
                            <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('due_date') border-red-500 @enderror">
                            @error('due_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="points" class="block text-sm font-medium text-gray-700 mb-2">Nilai Maksimal</label>
                            <input type="number" name="points" id="points" value="{{ old('points', 100) }}" min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('points') border-red-500 @enderror">
                            @error('points')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                <div>
                    <label for="attachments" class="block text-sm font-medium text-gray-700 mb-2">Lampiran (Opsional)</label>
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
                                       {{ old('allow_comments', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="allow_comments" class="ml-2 block text-sm text-gray-900">
                                    Izinkan komentar dari siswa
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="require_completion" id="require_completion" value="1" 
                                       {{ old('require_completion') ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="require_completion" class="ml-2 block text-sm text-gray-900">
                                    Wajib diselesaikan siswa
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="show_progress" id="show_progress" value="1" 
                                       {{ old('show_progress', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="show_progress" class="ml-2 block text-sm text-gray-900">
                                    Tampilkan progress siswa
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1" 
                                   {{ old('is_published') ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                Publikasikan materi ini sekarang
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-4">
                <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Buat Materi
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
