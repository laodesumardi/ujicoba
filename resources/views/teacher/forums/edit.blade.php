@extends('layouts.teacher')

@section('title', 'Edit Forum Diskusi')
@section('page-title', 'Edit Forum Diskusi')

@section('content')
<div class="space-y-6">
    <!-- Edit Forum Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Forum Diskusi</h1>
            <a href="{{ route('teacher.courses.forums.show', [$courseId, $forumId]) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Forum
            </a>
        </div>

        <form method="POST" action="{{ route('teacher.courses.forums.update', [$courseId, $forumId]) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Debug: Show form data -->
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                <strong>Debug Info:</strong><br>
                Course ID: {{ $courseId }}<br>
                Forum ID: {{ $forumId }}<br>
                Forum Type: {{ $forum->type ?? 'Not set' }}<br>
                Forum Title: {{ $forum->title ?? 'Not set' }}
            </div>
            
            <!-- Judul Forum -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Forum</label>
                <input type="text" id="title" name="title" value="{{ old('title', $forum->title ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                       placeholder="Masukkan judul forum diskusi" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Kategori -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select id="type" name="type" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('type') border-red-500 @enderror"
                        required>
                    <option value="discussion" {{ old('type', $forum->type ?? 'discussion') == 'discussion' ? 'selected' : '' }}>Diskusi Umum</option>
                    <option value="announcement" {{ old('type', $forum->type ?? 'discussion') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                    <option value="question" {{ old('type', $forum->type ?? 'discussion') == 'question' ? 'selected' : '' }}>Pertanyaan</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea id="description" name="description" rows="6"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                          placeholder="Jelaskan topik yang ingin didiskusikan..." required>{{ old('description', $forum->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Pengaturan -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Forum</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_pinned" name="is_pinned" value="1" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                   {{ old('is_pinned', $forum->is_pinned ?? false) ? 'checked' : '' }}>
                            <label for="is_pinned" class="ml-2 text-sm text-gray-700">Pin ke atas</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="is_locked" name="is_locked" value="1"
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                   {{ old('is_locked', $forum->is_locked ?? false) ? 'checked' : '' }}>
                            <label for="is_locked" class="ml-2 text-sm text-gray-700">Kunci forum</label>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Forum</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="radio" id="status_active" name="status" value="active" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                                   {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                            <label for="status_active" class="ml-2 text-sm text-gray-700">Aktif</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="status_closed" name="status" value="closed"
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                                   {{ old('status', 'active') == 'closed' ? 'checked' : '' }}>
                            <label for="status_closed" class="ml-2 text-sm text-gray-700">Ditutup</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('teacher.courses.forums.show', [$courseId, $forumId]) }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection