@extends('layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Edit Section Berita')
@section('page-title', 'Edit Section Berita')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-primary-900">Edit Section Berita</h2>
                        <p class="text-gray-600 mt-1">Kelola tampilan section berita di homepage</p>
                    </div>
                    <a href="{{ route('admin.news.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.news.update-section') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Section Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Section</h3>
                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Section *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $newsSection->title) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror" 
                                       placeholder="Masukkan judul section..." required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subtitle -->
                            <div>
                                <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $newsSection->subtitle) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('subtitle') border-red-500 @enderror" 
                                       placeholder="Masukkan subtitle section...">
                                @error('subtitle')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Section</label>
                                <textarea name="content" id="content" rows="4" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror" 
                                          placeholder="Masukkan deskripsi section...">{{ old('content', $newsSection->content) }}</textarea>
                                @error('content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Image Settings -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Gambar Section</h3>
                        <div class="space-y-6">
                            <!-- Current Image -->
                            @if($newsSection->image)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ Storage::url($newsSection->image) }}" alt="{{ $newsSection->image_alt }}" 
                                         class="h-24 w-24 object-cover rounded-lg"
                                         onerror="this.src='{{ asset('images/default-section.png') }}'">
                                    <div>
                                        <p class="text-sm text-gray-600">Gambar section saat ini</p>
                                        <p class="text-xs text-gray-500">Upload gambar baru untuk mengganti</p>
                                        <p class="text-xs text-blue-600">URL: {{ Storage::url($newsSection->image) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Image Upload -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $newsSection->image ? 'Ganti Gambar Section' : 'Upload Gambar Section' }}
                                </label>
                                <input type="file" name="image" id="image" accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror">
                                @error('image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF, WebP. Maksimal 5MB.</p>
                            </div>

                            <!-- Image Alt Text -->
                            <div>
                                <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-2">Alt Text Gambar</label>
                                <input type="text" name="image_alt" id="image_alt" value="{{ old('image_alt', $newsSection->image_alt) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image_alt') border-red-500 @enderror" 
                                       placeholder="Masukkan alt text untuk gambar...">
                                @error('image_alt')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Position -->
                            <div>
                                <label for="image_position" class="block text-sm font-medium text-gray-700 mb-2">Posisi Gambar</label>
                                <select name="image_position" id="image_position" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image_position') border-red-500 @enderror">
                                    <option value="top" {{ old('image_position', $newsSection->image_position) == 'top' ? 'selected' : '' }}>Atas</option>
                                    <option value="center" {{ old('image_position', $newsSection->image_position) == 'center' ? 'selected' : '' }}>Tengah</option>
                                    <option value="bottom" {{ old('image_position', $newsSection->image_position) == 'bottom' ? 'selected' : '' }}>Bawah</option>
                                </select>
                                @error('image_position')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Display Settings -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Tampilan</h3>
                        <div class="space-y-4">
                            <!-- Active Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $newsSection->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm font-medium text-gray-900">
                                    Tampilkan Section di Homepage
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Section (Full Width)</h3>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden">
                            <!-- Full Width Preview -->
                            <div id="preview-image-container" class="relative h-64 overflow-hidden">
                                @if($newsSection->image)
                                    <img id="preview-image" src="{{ asset('storage/' . $newsSection->image) }}" alt="{{ $newsSection->image_alt }}" class="w-full h-full object-cover">
                                @else
                                    <div id="preview-image-placeholder" class="w-full h-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <div class="text-center text-white px-4">
                                        <h2 class="text-2xl md:text-3xl font-bold mb-2" id="preview-title">
                                            {{ $newsSection->title }}
                                        </h2>
                                        <p class="text-lg md:text-xl text-gray-200 mb-2" id="preview-subtitle">
                                            {{ $newsSection->subtitle }}
                                        </p>
                                        <p class="text-sm md:text-base text-gray-300 max-w-2xl mx-auto" id="preview-content">
                                            {{ $newsSection->content }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.news.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const subtitleInput = document.getElementById('subtitle');
    const contentInput = document.getElementById('content');
    const imageInput = document.getElementById('image');
    
    const previewTitle = document.getElementById('preview-title');
    const previewSubtitle = document.getElementById('preview-subtitle');
    const previewContent = document.getElementById('preview-content');
    const previewImageContainer = document.getElementById('preview-image-container');
    
    function updatePreview() {
        previewTitle.textContent = titleInput.value || 'Berita & Pengumuman Terbaru';
        previewSubtitle.textContent = subtitleInput.value || 'Informasi terkini dari SMP Negeri 01 Namrole';
        previewContent.textContent = contentInput.value || 'Dapatkan informasi terbaru tentang kegiatan sekolah, pengumuman penting, dan berita terkini dari SMP Negeri 01 Namrole.';
    }
    
    function updateImagePreview() {
        const file = imageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById('preview-image');
                const previewImagePlaceholder = document.getElementById('preview-image-placeholder');
                
                if (previewImage) {
                    previewImage.src = e.target.result;
                } else {
                    // Create new image element for full width
                    const newImage = document.createElement('img');
                    newImage.id = 'preview-image';
                    newImage.src = e.target.result;
                    newImage.alt = 'Preview image';
                    newImage.className = 'w-full h-full object-cover';
                    
                    if (previewImagePlaceholder) {
                        previewImagePlaceholder.replaceWith(newImage);
                    } else {
                        previewImageContainer.innerHTML = '';
                        previewImageContainer.appendChild(newImage);
                    }
                }
            };
            reader.readAsDataURL(file);
        }
    }
    
    titleInput.addEventListener('input', updatePreview);
    subtitleInput.addEventListener('input', updatePreview);
    contentInput.addEventListener('input', updatePreview);
    imageInput.addEventListener('change', updateImagePreview);
});
</script>
@endsection
