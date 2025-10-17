@extends('layouts.admin')

@section('title', 'Edit Section Galeri - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Section Galeri</h1>
            <p class="text-gray-600">Edit section galeri yang ditampilkan di halaman galeri</p>
        </div>
        <a href="{{ route('admin.gallery.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.gallery.update-section') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Section <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title', $section->title) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                       placeholder="Masukkan judul section">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subtitle -->
            <div>
                <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                    Subtitle
                </label>
                <input type="text" 
                       name="subtitle" 
                       id="subtitle" 
                       value="{{ old('subtitle', $section->subtitle) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('subtitle') border-red-500 @enderror"
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
                <textarea name="content" 
                          id="content" 
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror"
                          placeholder="Masukkan konten section">{{ old('content', $section->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Background Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Background
                </label>
                
                @if($section->image)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Gambar Background Saat Ini:</p>
                    <img src="{{ asset('storage/' . $section->image) }}" 
                         alt="{{ $section->image_alt }}" 
                         class="w-full h-48 object-cover rounded-lg border border-gray-300">
                </div>
                @endif
                
                <input type="file" 
                       name="image" 
                       id="image" 
                       accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF, WebP. Maksimal 5MB</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Alt Text -->
            <div>
                <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-2">
                    Alt Text Gambar
                </label>
                <input type="text" 
                       name="image_alt" 
                       id="image_alt" 
                       value="{{ old('image_alt', $section->image_alt) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image_alt') border-red-500 @enderror"
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
                <select name="image_position" 
                        id="image_position" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image_position') border-red-500 @enderror">
                    <option value="center" {{ old('image_position', $section->image_position) == 'center' ? 'selected' : '' }}>Center</option>
                    <option value="top" {{ old('image_position', $section->image_position) == 'top' ? 'selected' : '' }}>Top</option>
                    <option value="bottom" {{ old('image_position', $section->image_position) == 'bottom' ? 'selected' : '' }}>Bottom</option>
                    <option value="left" {{ old('image_position', $section->image_position) == 'left' ? 'selected' : '' }}>Left</option>
                    <option value="right" {{ old('image_position', $section->image_position) == 'right' ? 'selected' : '' }}>Right</option>
                </select>
                @error('image_position')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active" 
                       value="1"
                       {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                    Aktif (Section akan ditampilkan di halaman galeri)
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.gallery.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition-colors">
                    Simpan Section
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
