@extends('layouts.teacher')

@section('title', 'Buat Forum Diskusi')
@section('page-title', 'Buat Forum Diskusi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Buat Forum Diskusi</h1>
                <p class="text-gray-600">Buat forum diskusi baru untuk kelas {{ $course->title }}</p>
            </div>
            <a href="{{ route('teacher.courses.show', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Kelas
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <form action="{{ route('teacher.courses.forums.store', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Forum <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('title') border-red-500 @enderror"
                       placeholder="Masukkan judul forum diskusi"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Forum <span class="text-red-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('description') border-red-500 @enderror"
                          placeholder="Jelaskan topik atau tujuan forum diskusi ini"
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Forum <span class="text-red-500">*</span>
                </label>
                <select id="type" 
                        name="type" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('type') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Jenis Forum</option>
                    <option value="discussion" {{ old('type') == 'discussion' ? 'selected' : '' }}>Diskusi Umum</option>
                    <option value="announcement" {{ old('type') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                    <option value="question" {{ old('type') == 'question' ? 'selected' : '' }}>Pertanyaan</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="is_pinned" class="flex items-center">
                        <input type="checkbox" 
                               id="is_pinned" 
                               name="is_pinned" 
                               value="1"
                               {{ old('is_pinned') ? 'checked' : '' }}
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Pasang di atas (Pinned)</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500">Forum akan ditampilkan di bagian atas daftar</p>
                </div>

                <div>
                    <label for="is_locked" class="flex items-center">
                        <input type="checkbox" 
                               id="is_locked" 
                               name="is_locked" 
                               value="1"
                               {{ old('is_locked') ? 'checked' : '' }}
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Kunci forum (Locked)</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500">Siswa tidak bisa membalas di forum ini</p>
                </div>
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
                       accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('attachments') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Format yang didukung: PDF, DOC, DOCX, PPT, PPTX, JPG, JPEG, PNG, GIF</p>
                @error('attachments')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('teacher.courses.show', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Forum
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
