@extends('layouts.admin')

@section('title', 'Create Home Section')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold text-primary-900 mb-6">Create New Home Section</h2>

                <form method="POST" action="{{ route('admin.home-sections.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Section Key -->
                        <div>
                            <label for="section_key" class="block text-sm font-medium text-gray-700 mb-2">Section Key</label>
                            <input type="text" id="section_key" name="section_key" value="{{ old('section_key') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('section_key') border-red-500 @enderror"
                                   placeholder="e.g., hero, quick_info, about">
                            @error('section_key')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                                   placeholder="Section title">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subtitle -->
                        <div class="md:col-span-2">
                            <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                            <textarea id="subtitle" name="subtitle" rows="2" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('subtitle') border-red-500 @enderror"
                                      placeholder="Section subtitle">{{ old('subtitle') }}</textarea>
                            @error('subtitle')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                                      placeholder="Section description">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Upload - Only for Hero Section -->
                        <div class="md:col-span-2" id="image-fields" style="display: none;">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                            <input type="file" id="image" name="image" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror">
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Max size: 5MB. Supported formats: JPEG, PNG, JPG, GIF, SVG, WEBP</p>
                        </div>

                        <!-- Image Alt Text - Only for Hero Section -->
                        <div id="image-alt-field" style="display: none;">
                            <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-2">Image Alt Text</label>
                            <input type="text" id="image_alt" name="image_alt" value="{{ old('image_alt') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('image_alt') border-red-500 @enderror"
                                   placeholder="Alternative text for image">
                            @error('image_alt')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Position - Only for Hero Section -->
                        <div id="image-position-field" style="display: none;">
                            <label for="image_position" class="block text-sm font-medium text-gray-700 mb-2">Image Position</label>
                            <select id="image_position" name="image_position" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('image_position') border-red-500 @enderror">
                                <option value="center" {{ old('image_position', 'center') == 'center' ? 'selected' : '' }}>Center</option>
                                <option value="left" {{ old('image_position') == 'left' ? 'selected' : '' }}>Left</option>
                                <option value="right" {{ old('image_position') == 'right' ? 'selected' : '' }}>Right</option>
                                <option value="top" {{ old('image_position') == 'top' ? 'selected' : '' }}>Top</option>
                                <option value="bottom" {{ old('image_position') == 'bottom' ? 'selected' : '' }}>Bottom</option>
                            </select>
                            @error('image_position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Button Text -->
                        <div>
                            <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                            <input type="text" id="button_text" name="button_text" value="{{ old('button_text') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('button_text') border-red-500 @enderror"
                                   placeholder="e.g., Learn More, Get Started">
                            @error('button_text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Button Link -->
                        <div>
                            <label for="button_link" class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                            <input type="text" id="button_link" name="button_link" value="{{ old('button_link') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('button_link') border-red-500 @enderror"
                                   placeholder="e.g., /profil, #about">
                            @error('button_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Background Color -->
                        <div>
                            <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                            <input type="text" id="background_color" name="background_color" value="{{ old('background_color') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('background_color') border-red-500 @enderror"
                                   placeholder="e.g., bg-primary-500, bg-gray-100">
                            @error('background_color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Text Color -->
                        <div>
                            <label for="text_color" class="block text-sm font-medium text-gray-700 mb-2">Text Color</label>
                            <input type="text" id="text_color" name="text_color" value="{{ old('text_color') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('text_color') border-red-500 @enderror"
                                   placeholder="e.g., text-white, text-gray-900">
                            @error('text_color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('sort_order') border-red-500 @enderror"
                                   min="0">
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.home-sections.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700">
                            Create Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sectionKeyInput = document.getElementById('section_key');
    const imageFields = document.getElementById('image-fields');
    const imageAltField = document.getElementById('image-alt-field');
    const imagePositionField = document.getElementById('image-position-field');
    
    function toggleImageFields() {
        const sectionKey = sectionKeyInput.value.toLowerCase();
        if (sectionKey === 'hero') {
            imageFields.style.display = 'block';
            imageAltField.style.display = 'block';
            imagePositionField.style.display = 'block';
        } else {
            imageFields.style.display = 'none';
            imageAltField.style.display = 'none';
            imagePositionField.style.display = 'none';
        }
    }
    
    sectionKeyInput.addEventListener('input', toggleImageFields);
    
    // Check on page load
    toggleImageFields();
});
</script>
@endpush
