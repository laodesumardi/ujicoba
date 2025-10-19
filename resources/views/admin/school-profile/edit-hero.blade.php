@extends('layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Edit Hero Section')
@section('page-title', 'Edit Hero Section')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-primary-900">Edit Hero Section</h2>
                    <a href="{{ route('admin.school-profile.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Back to School Profile
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.school-profile.update-hero') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $heroSection->title) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                                   placeholder="Hero section title">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subtitle -->
                        <div class="md:col-span-2">
                            <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                            <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $heroSection->subtitle) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('subtitle') border-red-500 @enderror"
                                   placeholder="Hero section subtitle">
                            @error('subtitle')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="md:col-span-2">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                            <textarea id="content" name="content" rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror"
                                      placeholder="Hero section content">{{ old('content', $heroSection->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                                      placeholder="Hero section description">{{ old('description', $heroSection->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($heroSection->image)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ Storage::url($heroSection->image) }}" alt="{{ $heroSection->image_alt }}" 
                                     class="h-32 w-48 object-cover rounded-lg"
                                     onerror="this.src='{{ asset('images/default-hero.png') }}'">
                                <div>
                                    <p class="text-sm text-gray-600">{{ basename($heroSection->image) }}</p>
                                    <p class="text-xs text-gray-500">Upload new image to replace</p>
                                    <p class="text-xs text-blue-600">URL: {{ Storage::url($heroSection->image) }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Image Upload -->
                        <div class="md:col-span-2">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $heroSection->image ? 'Replace Image' : 'Upload Image' }}
                            </label>
                            <input type="file" id="image" name="image" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror">
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Max size: 5MB. Supported formats: JPEG, PNG, JPG, GIF, SVG, WEBP</p>
                        </div>

                        <!-- Image Alt Text -->
                        <div>
                            <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-2">Image Alt Text</label>
                            <input type="text" id="image_alt" name="image_alt" value="{{ old('image_alt', $heroSection->image_alt) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('image_alt') border-red-500 @enderror"
                                   placeholder="Alternative text for image">
                            @error('image_alt')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Button Text -->
                        <div>
                            <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                            <input type="text" id="button_text" name="button_text" value="{{ old('button_text', $heroSection->button_text) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('button_text') border-red-500 @enderror"
                                   placeholder="e.g., Learn More, Get Started">
                            @error('button_text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Button Link -->
                        <div>
                            <label for="button_link" class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                            <input type="text" id="button_link" name="button_link" value="{{ old('button_link', $heroSection->button_link) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('button_link') border-red-500 @enderror"
                                   placeholder="e.g., /profil, #about">
                            @error('button_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Background Color -->
                        <div>
                            <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                            <input type="text" id="background_color" name="background_color" value="{{ old('background_color', $heroSection->background_color) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('background_color') border-red-500 @enderror"
                                   placeholder="e.g., bg-primary-500, bg-gray-100">
                            @error('background_color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Text Color -->
                        <div>
                            <label for="text_color" class="block text-sm font-medium text-gray-700 mb-2">Text Color</label>
                            <input type="text" id="text_color" name="text_color" value="{{ old('text_color', $heroSection->text_color) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('text_color') border-red-500 @enderror"
                                   placeholder="e.g., text-white, text-gray-900">
                            @error('text_color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="md:col-span-2 flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $heroSection->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.school-profile.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700">
                            Update Hero Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
