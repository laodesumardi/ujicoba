@extends('layouts.app')

@section('title', $news->title . ' - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <!-- Breadcrumb -->
    <div class="bg-gray-50 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('news.index') }}" class="ml-4 text-gray-500 hover:text-gray-700">Berita</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-4 text-gray-500">{{ $news->getCategoryLabel() }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- News Section Full Width Image -->
    @if($newsSection && $newsSection->image)
    <div class="relative h-96 overflow-hidden">
        <img src="{{ asset('storage/' . $newsSection->image) }}" 
             alt="{{ $newsSection->image_alt }}" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    @if($newsSection->title)
                        {{ $newsSection->title }}
                    @else
                        Berita & Pengumuman
                    @endif
                </h1>
                @if($newsSection->subtitle)
                    <p class="text-lg md:text-xl text-gray-200">{{ $newsSection->subtitle }}</p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Article Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <article class="prose prose-lg max-w-none">
            <!-- Article Header -->
            <header class="mb-8">
                <!-- Category & Type -->
                <div class="flex items-center space-x-4 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                        {{ $news->getCategoryLabel() }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $news->type == 'news' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        {{ $news->getTypeLabel() }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ $news->title }}</h1>

                <!-- Meta Info -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-500 mb-6">
                    <div class="flex items-center space-x-6">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $news->published_at->format('d M Y, H:i') }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ $news->views }} views
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $news->reading_time }}
                        </span>
                    </div>
                    @if($news->author_name)
                    <div class="mt-2 sm:mt-0">
                        <span class="text-gray-700">Oleh: {{ $news->author_name }}</span>
                    </div>
                    @endif
                </div>

                <!-- Featured Image -->
                @if($news->featured_image)
                <div class="mb-8">
                    <img src="{{ $news->featured_image_url }}" 
                         alt="{{ $news->title }}" 
                         class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg">
                </div>
                @endif

                <!-- Excerpt -->
                @if($news->excerpt)
                <div class="text-xl text-gray-600 leading-relaxed mb-8">
                    {{ $news->excerpt }}
                </div>
                @endif
            </header>

            <!-- Article Content -->
            <div class="prose prose-lg max-w-none">
                {!! $news->content !!}
            </div>

            <!-- Tags -->
            @if($news->tags && count($news->tags) > 0)
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tag</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($news->tags as $tag)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800">
                        #{{ $tag }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif
        </article>
    </div>

    <!-- Related News -->
    @if($relatedNews->count() > 0)
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Berita Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedNews as $related)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    @if($related->featured_image)
                    <img src="{{ $related->featured_image_url }}" 
                         alt="{{ $related->title }}" 
                         class="w-full h-32 object-cover">
                    @else
                    <div class="w-full h-32 bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('news.show', $related->slug) }}" class="hover:text-primary-600">
                                {{ $related->title }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500">{{ $related->published_at->format('d M Y') }}</p>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
