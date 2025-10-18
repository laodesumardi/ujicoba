@extends('layouts.app')

@section('title', 'Download Center')
@section('content')
<!-- Hero Section -->
<div class="relative bg-primary-600 text-white py-20" 
     @if($section && $section->image)
     style="background-image: linear-gradient(rgba(20, 33, 61, 0.8), rgba(20, 33, 61, 0.8)), url('{{ $section->image_url }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
     @endif>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            @if($section && $section->is_active)
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4">{{ $section->title }}</h1>
                @if($section->subtitle)
                    <p class="text-base sm:text-lg lg:text-xl mb-6">{{ $section->subtitle }}</p>
                @endif
                @if($section->content)
                    <p class="text-lg opacity-90 max-w-3xl mx-auto">{{ $section->content }}</p>
                @endif
            @else
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4">Download Center</h1>
                <p class="text-base sm:text-lg lg:text-xl mb-6">Dokumen Resmi dan Formulir Sekolah</p>
                <p class="text-lg opacity-90 max-w-3xl mx-auto">Akses berbagai dokumen resmi, formulir, pedoman akademik, jadwal, dan laporan sekolah yang dapat diunduh secara gratis.</p>
            @endif
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('documents.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Dokumen</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                           placeholder="Ketik judul atau kata kunci..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Type Filter -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe File</label>
                    <select id="type" name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Tipe</option>
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Featured Documents -->
@if($featuredDocuments->count() > 0)
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Dokumen Unggulan</h2>
            <p class="text-lg text-gray-600">Dokumen penting yang wajib diketahui</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredDocuments as $document)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Unggulan
                            </span>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $document->title }}</h3>
                    @if($document->description)
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($document->description, 100) }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $document->category == 'surat_edaran' ? 'bg-blue-100 text-blue-800' : 
                                   ($document->category == 'formulir' ? 'bg-green-100 text-green-800' : 
                                   ($document->category == 'pedoman' ? 'bg-purple-100 text-purple-800' : 
                                   ($document->category == 'jadwal' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($document->category == 'kurikulum' ? 'bg-indigo-100 text-indigo-800' : 
                                   ($document->category == 'laporan' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))))) }}">
                                {{ $document->category_label }}
                            </span>
                        </div>
                        <a href="{{ route('documents.download', $document) }}" 
                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- All Documents -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Semua Dokumen</h2>
            <p class="text-lg text-gray-600">Koleksi lengkap dokumen sekolah</p>
        </div>

        @if($documents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($documents as $document)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $document->category == 'surat_edaran' ? 'bg-blue-100 text-blue-800' : 
                                       ($document->category == 'formulir' ? 'bg-green-100 text-green-800' : 
                                       ($document->category == 'pedoman' ? 'bg-purple-100 text-purple-800' : 
                                       ($document->category == 'jadwal' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($document->category == 'kurikulum' ? 'bg-indigo-100 text-indigo-800' : 
                                       ($document->category == 'laporan' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))))) }}">
                                    {{ $document->category_label }}
                                </span>
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $document->title }}</h3>
                        @if($document->description)
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($document->description, 100) }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>{{ $document->type_label }}</span>
                            <span>{{ $document->file_size_formatted }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                {{ $document->download_count }} download
                            </div>
                            <a href="{{ route('documents.download', $document) }}" 
                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $documents->appends(request()->query())->links() }}
            </div>
        @else
            <!-- No Documents -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada dokumen</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada dokumen yang tersedia saat ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection