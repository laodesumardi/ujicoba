@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Berita & Pengumuman - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <!-- Hero Section with Full Width Image -->
    @if($newsSection && $newsSection->image)
    <div class="relative h-96 overflow-hidden">
        <img src="{{ Storage::url($newsSection->image) }}" 
             alt="{{ $newsSection->image_alt }}" 
             class="w-full h-full object-cover"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        <div class="w-full h-full bg-gradient-to-r from-primary-600 to-primary-800 flex items-center justify-center hidden">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Berita & Pengumuman</h1>
                <p class="text-xl md:text-2xl text-gray-200">Informasi terbaru dari SMP Negeri 01 Namrole</p>
            </div>
        </div>
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    @if($newsSection->title)
                        {{ $newsSection->title }}
                    @else
                        Berita & Pengumuman
                    @endif
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-4">
                    @if($newsSection->subtitle)
                        {{ $newsSection->subtitle }}
                    @else
                        Informasi terbaru dari SMP Negeri 01 Namrole
                    @endif
                </p>
                @if($newsSection->content)
                    <p class="text-lg text-gray-300 max-w-3xl mx-auto">{{ $newsSection->content }}</p>
                @endif
            </div>
        </div>
    </div>
    @else
    <!-- Fallback Hero Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Berita & Pengumuman</h1>
                <p class="text-xl text-primary-100">Informasi terbaru dari SMP Negeri 01 Namrole</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari berita..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <!-- Category Filter -->
                <div>
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
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
                    <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Jenis</option>
                        <option value="news" {{ request('type') == 'news' ? 'selected' : '' }}>Berita</option>
                        <option value="announcement" {{ request('type') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                    </select>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                    Filter
                </button>
            </form>
        </div>
    </div>

    <!-- News Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($news->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($news as $article)
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <!-- Featured Image -->
                    @if($article->featured_image)
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ $article->featured_image_url }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-48 object-cover">
                    </div>
                    @else
                    <div class="w-full h-48 bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    @endif

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Category & Type -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                {{ $article->getCategoryLabel() }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->type == 'news' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $article->getTypeLabel() }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                            <a href="{{ route('news.show', $article->slug) }}" class="hover:text-primary-600 transition-colors">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ $article->excerpt }}
                        </p>

                        <!-- Meta Info -->
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $article->published_at->format('d M Y') }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ $article->views }} views
                                </span>
                            </div>
                            <span class="text-primary-600 font-medium">
                                {{ $article->reading_time }}
                            </span>
                        </div>

                        <!-- Read More Button -->
                        <div class="mt-4">
                            <a href="{{ route('news.show', $article->slug) }}" 
                               class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $news->links() }}
            </div>
        @else
            <!-- No News Found -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada berita ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Coba ubah filter pencarian Anda.</p>
            </div>
        @endif
    </div>

    <!-- Quick Links -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Kategori Berita</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($categories as $key => $label)
                    <a href="{{ route('news.index', ['category' => $key]) }}" 
                       class="bg-white rounded-lg p-4 text-center hover:shadow-md transition-shadow">
                        <div class="text-primary-600 font-semibold">{{ $label }}</div>
                        <div class="text-sm text-gray-500 mt-1">
                            {{ \App\Models\News::published()->byCategory($key)->count() }} artikel
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
