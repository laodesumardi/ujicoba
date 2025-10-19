@extends('layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Detail Profil Sekolah')
@section('page-title', 'Detail Profil Sekolah')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $schoolProfile->title ?: 'Detail Profil Sekolah' }}</h3>
                    <p class="text-sm text-gray-500">{{ $schoolProfile->section_key ? 'Section: ' . $schoolProfile->section_key : 'Profil Sekolah' }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.school-profile.edit', $schoolProfile) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Edit
                    </a>
                    <a href="{{ route('admin.school-profile.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- Basic Information -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah</label>
                        <p class="text-gray-900">{{ $schoolProfile->school_name ?: 'Tidak diisi' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Berdiri</label>
                        <p class="text-gray-900">{{ $schoolProfile->established_year ?: 'Tidak diisi' }}</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                        <p class="text-gray-900">{{ $schoolProfile->location ?: 'Tidak diisi' }}</p>
                    </div>
                </div>
            </div>

            <!-- Section Information -->
            @if($schoolProfile->section_key)
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Section</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Section Key</label>
                        <p class="text-gray-900">{{ $schoolProfile->section_key }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <p class="text-gray-900">{{ $schoolProfile->title ?: 'Tidak diisi' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                        <p class="text-gray-900">{{ $schoolProfile->subtitle ?: 'Tidak diisi' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $schoolProfile->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $schoolProfile->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                        <div class="text-gray-900 prose max-w-none">
                            {!! $schoolProfile->content ?: 'Tidak ada konten' !!}
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <p class="text-gray-900">{{ $schoolProfile->description ?: 'Tidak diisi' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Image Information -->
            @if($schoolProfile->image)
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Gambar</h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Utama</label>
                        <div class="flex items-center space-x-4">
                            <img src="{{ Storage::url($schoolProfile->image) }}" 
                                 alt="{{ $schoolProfile->image_alt ?: $schoolProfile->title }}" 
                                 class="h-32 w-48 object-cover rounded-lg border"
                                 onerror="this.src='{{ asset('images/default-section.png') }}'">
                            <div>
                                <p class="text-sm text-gray-600">Path: {{ $schoolProfile->image }}</p>
                                <p class="text-sm text-blue-600">URL: {{ Storage::url($schoolProfile->image) }}</p>
                                @if($schoolProfile->image_alt)
                                <p class="text-sm text-gray-600">Alt Text: {{ $schoolProfile->image_alt }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Hero Image Information -->
            @if($schoolProfile->hero_image)
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Hero Image</h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hero Image</label>
                        <div class="flex items-center space-x-4">
                            <img src="{{ Storage::url($schoolProfile->hero_image) }}" 
                                 alt="Hero Image" 
                                 class="h-32 w-48 object-cover rounded-lg border"
                                 onerror="this.src='{{ asset('images/default-hero.png') }}'">
                            <div>
                                <p class="text-sm text-gray-600">Path: {{ $schoolProfile->hero_image }}</p>
                                <p class="text-sm text-blue-600">URL: {{ Storage::url($schoolProfile->hero_image) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Logo Information -->
            @if($schoolProfile->logo)
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Logo</h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                        <div class="flex items-center space-x-4">
                            <img src="{{ Storage::url($schoolProfile->logo) }}" 
                                 alt="Logo" 
                                 class="h-32 w-32 object-cover rounded-lg border"
                                 onerror="this.src='{{ asset('images/default-logo.png') }}'">
                            <div>
                                <p class="text-sm text-gray-600">Path: {{ $schoolProfile->logo }}</p>
                                <p class="text-sm text-blue-600">URL: {{ Storage::url($schoolProfile->logo) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Additional Information -->
            @if($schoolProfile->button_text || $schoolProfile->button_link)
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($schoolProfile->button_text)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                        <p class="text-gray-900">{{ $schoolProfile->button_text }}</p>
                    </div>
                    @endif
                    
                    @if($schoolProfile->button_link)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                        <p class="text-gray-900">
                            <a href="{{ $schoolProfile->button_link }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                {{ $schoolProfile->button_link }}
                            </a>
                        </p>
                    </div>
                    @endif
                    
                    @if($schoolProfile->background_color)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded border" style="background-color: {{ $schoolProfile->background_color }}"></div>
                            <span class="text-gray-900">{{ $schoolProfile->background_color }}</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($schoolProfile->text_color)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Text Color</label>
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded border" style="background-color: {{ $schoolProfile->text_color }}"></div>
                            <span class="text-gray-900">{{ $schoolProfile->text_color }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- System Information -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sistem</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                        <p class="text-gray-900">{{ $schoolProfile->sort_order ?: '0' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Created At</label>
                        <p class="text-gray-900">{{ $schoolProfile->created_at ? $schoolProfile->created_at->format('d M Y H:i:s') : 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Updated At</label>
                        <p class="text-gray-900">{{ $schoolProfile->updated_at ? $schoolProfile->updated_at->format('d M Y H:i:s') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
