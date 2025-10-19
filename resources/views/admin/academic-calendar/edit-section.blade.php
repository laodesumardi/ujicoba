@extends('layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Edit Section Kalender Akademik')
@section('page-title', 'Edit Section Kalender Akademik')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-primary-900">Edit Section Kalender Akademik</h2>
                        <p class="text-gray-600 mt-1">Edit konten section yang ditampilkan di halaman kalender akademik</p>
                    </div>
                    <a href="{{ route('admin.academic-calendar.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.academic-calendar.update-section') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column - Form Fields -->
                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul Section <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title', $section->title) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                                       placeholder="Masukkan judul section" required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subtitle -->
                            <div>
                                <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                                    Subtitle
                                </label>
                                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $section->subtitle) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('subtitle') border-red-500 @enderror"
                                       placeholder="Masukkan subtitle section">
                                @error('subtitle')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konten
                                </label>
                                <textarea name="content" id="content" rows="6" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror"
                                          placeholder="Masukkan konten section">{{ old('content', $section->content) }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar Section
                                </label>
                                @if($section->image)
                                <div class="mb-3">
                                    <img src="{{ Storage::url($section->image) }}" alt="{{ $section->image_alt }}" 
                                         class="w-32 h-20 object-cover rounded-lg border border-gray-300"
                                         onerror="this.src='{{ asset('images/default-section.png') }}'">
                                    <p class="text-sm text-gray-500 mt-1">Gambar saat ini</p>
                                    <p class="text-xs text-blue-600">URL: {{ Storage::url($section->image) }}</p>
                                </div>
                                @endif
                                <input type="file" name="image" id="image" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror"
                                       accept="image/*">
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPEG, PNG, JPG, GIF, WebP (Max: 5MB)</p>
                            </div>

                            <!-- Image Alt Text -->
                            <div>
                                <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alt Text Gambar
                                </label>
                                <input type="text" name="image_alt" id="image_alt" value="{{ old('image_alt', $section->image_alt) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('image_alt') border-red-500 @enderror"
                                       placeholder="Masukkan alt text untuk gambar">
                                @error('image_alt')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Position -->
                            <div>
                                <label for="image_position" class="block text-sm font-medium text-gray-700 mb-2">
                                    Posisi Gambar
                                </label>
                                <select name="image_position" id="image_position" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('image_position') border-red-500 @enderror">
                                    <option value="">Pilih posisi gambar</option>
                                    <option value="left" {{ old('image_position', $section->image_position) == 'left' ? 'selected' : '' }}>Kiri</option>
                                    <option value="right" {{ old('image_position', $section->image_position) == 'right' ? 'selected' : '' }}>Kanan</option>
                                    <option value="center" {{ old('image_position', $section->image_position) == 'center' ? 'selected' : '' }}>Tengah</option>
                                    <option value="top" {{ old('image_position', $section->image_position) == 'top' ? 'selected' : '' }}>Atas</option>
                                    <option value="bottom" {{ old('image_position', $section->image_position) == 'bottom' ? 'selected' : '' }}>Bawah</option>
                                </select>
                                @error('image_position')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Active Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Aktifkan Section
                                </label>
                            </div>
                        </div>

                        <!-- Right Column - Preview -->
                        <div class="space-y-6">
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Section</h3>
                                <div class="bg-white border border-gray-200 rounded-lg p-4">
                                    <h4 class="text-xl font-bold text-gray-900 mb-2" id="preview-title">
                                        {{ $section->title }}
                                    </h4>
                                    <p class="text-gray-600 mb-3" id="preview-subtitle">
                                        {{ $section->subtitle }}
                                    </p>
                                    <p class="text-gray-700 text-sm" id="preview-content">
                                        {{ $section->content }}
                                    </p>
                                    @if($section->image)
                                    <div class="mt-4">
                                        <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->image_alt }}" 
                                             class="w-full h-32 object-cover rounded-lg">
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Section Info -->
                            <div class="bg-blue-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-blue-900 mb-4">Informasi Section</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Section Key:</span>
                                        <span class="text-blue-900 font-medium">academic-calendar</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Status:</span>
                                        <span class="text-blue-900 font-medium">{{ $section->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Sort Order:</span>
                                        <span class="text-blue-900 font-medium">{{ $section->sort_order }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Dibuat:</span>
                                        <span class="text-blue-900 font-medium">{{ $section->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Diperbarui:</span>
                                        <span class="text-blue-900 font-medium">{{ $section->updated_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('admin.academic-calendar.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-md text-sm font-medium transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Real-time preview update
document.getElementById('title').addEventListener('input', function() {
    document.getElementById('preview-title').textContent = this.value;
});

document.getElementById('subtitle').addEventListener('input', function() {
    document.getElementById('preview-subtitle').textContent = this.value;
});

document.getElementById('content').addEventListener('input', function() {
    document.getElementById('preview-content').textContent = this.value;
});

// Image preview
document.getElementById('image').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewContainer = document.querySelector('.bg-white.border.border-gray-200.rounded-lg.p-4');
            let imgElement = previewContainer.querySelector('img');
            if (!imgElement) {
                imgElement = document.createElement('img');
                imgElement.className = 'w-full h-32 object-cover rounded-lg mt-4';
                previewContainer.appendChild(imgElement);
            }
            imgElement.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
