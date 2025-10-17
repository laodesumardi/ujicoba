@extends('layouts.admin')

@section('title', 'Detail Home Section - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Home Section</h1>
            <p class="text-gray-600">{{ $homeSection->title }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.home-sections.edit', $homeSection) }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors">
                Edit Section
            </a>
            <a href="{{ route('admin.home-sections.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <!-- Section Info -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Section Details -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Section</h3>
                        
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Judul</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $homeSection->title }}</dd>
                            </div>
                            
                            @if($homeSection->subtitle)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Subtitle</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $homeSection->subtitle }}</dd>
                            </div>
                            @endif
                            
                            @if($homeSection->content)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Konten</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $homeSection->content }}</dd>
                            </div>
                            @endif
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Section Key</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $homeSection->section_key }}
                                    </span>
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Urutan Tampil</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $homeSection->sort_order }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $homeSection->created_at->format('d M Y H:i') }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Diperbarui</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $homeSection->updated_at->format('d M Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <!-- Options -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                @if($homeSection->is_active)
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-gray-900">Aktif</span>
                                @else
                                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-gray-900">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Section Image -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Gambar Section</h3>
                    @if($homeSection->image)
                        <img src="{{ $homeSection->image_url }}" 
                             alt="{{ $homeSection->image_alt }}" 
                             class="w-full h-64 object-cover rounded-lg border border-gray-300">
                        @if($homeSection->image_alt)
                        <p class="mt-2 text-sm text-gray-600">
                            <strong>Alt Text:</strong> {{ $homeSection->image_alt }}
                        </p>
                        @endif
                        @if($homeSection->image_position)
                        <p class="mt-1 text-sm text-gray-600">
                            <strong>Posisi:</strong> {{ ucfirst($homeSection->image_position) }}
                        </p>
                        @endif
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg border border-gray-300 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mt-2 text-sm">Tidak ada gambar</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Section -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Preview Section</h3>
        </div>
        <div class="p-6">
            <div class="bg-gray-50 rounded-lg p-6">
                @if($homeSection->is_active)
                    <div class="text-center">
                        @if($homeSection->image)
                        <div class="mb-4">
                            <img src="{{ $homeSection->image_url }}" 
                                 alt="{{ $homeSection->image_alt }}" 
                                 class="mx-auto max-w-full h-48 object-cover rounded-lg border border-gray-300">
                        </div>
                        @endif
                        
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $homeSection->title }}</h2>
                        
                        @if($homeSection->subtitle)
                        <p class="text-lg text-gray-600 mb-4">{{ $homeSection->subtitle }}</p>
                        @endif
                        
                        @if($homeSection->content)
                        <p class="text-gray-600">{{ $homeSection->content }}</p>
                        @endif
                    </div>
                @else
                    <div class="text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                        </svg>
                        <p class="text-sm">Section tidak aktif</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
