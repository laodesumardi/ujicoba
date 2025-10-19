@extends('layouts.admin')

@section('title', 'Edit ' . $schoolProfile->title)
@section('page-title', 'Edit ' . $schoolProfile->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">{{ $schoolProfile->title }}</h3>
            <p class="text-sm text-gray-500">Edit {{ ucfirst(str_replace('-', ' ', $schoolProfile->section_key)) }} section</p>
        </div>
        
        <form enctype="multipart/form-data" action="{{ route('admin.school-profile.update', $schoolProfile) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Section Information -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Section</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $schoolProfile->title) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror" required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="section_key" class="block text-sm font-medium text-gray-700 mb-2">Section Key</label>
                        <input type="text" name="section_key" id="section_key" value="{{ old('section_key', $schoolProfile->section_key) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                        <p class="text-xs text-gray-500 mt-1">Section key cannot be changed</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Konten</h4>
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                    <textarea name="content" id="content" rows="8" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror" required>{{ old('content', $schoolProfile->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image Upload (for struktur section) -->
            @if($schoolProfile->section_key === 'struktur')
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Gambar Struktur Organisasi</h4>
                
                <!-- Current Image -->
                @if($schoolProfile->image)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset($schoolProfile->image) }}" alt="{{ $schoolProfile->title }}" class="h-32 w-48 object-cover rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600">{{ basename($schoolProfile->image) }}</p>
                            <p class="text-xs text-gray-500">Upload gambar baru untuk mengganti</p>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $schoolProfile->image ? 'Ganti Gambar' : 'Upload Gambar' }}
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Max size: 5MB. Supported formats: JPEG, PNG, JPG, GIF, SVG, WEBP</p>
                </div>
                
                <!-- Image Alt Text -->
                <div class="mt-4">
                    <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-2">Image Alt Text</label>
                    <input type="text" name="image_alt" id="image_alt" value="{{ old('image_alt', $schoolProfile->image_alt) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image_alt') border-red-500 @enderror"
                           placeholder="Alternative text for image">
                    @error('image_alt')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @endif

            <!-- Status -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Status</h4>
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $schoolProfile->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">Active (Tampilkan di halaman profil)</label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.school-profile.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    Update Section
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
