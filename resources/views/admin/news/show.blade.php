@extends('layouts.admin')

@section('title', 'Detail Berita')
@section('page-title', 'Detail Berita')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-primary-900">Detail Berita</h2>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.news.edit', $news) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Edit
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- Basic Information -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Judul Berita</label>
                                <p class="text-gray-900 font-semibold">{{ $news->title }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status</label>
                                <div class="mt-1">
                                    @if($news->status == 'published')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Dipublikasikan
                                        </span>
                                    @elseif($news->status == 'draft')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Draft
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Diarsipkan
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Kategori</label>
                                <p class="text-gray-900">{{ $news->getCategoryLabel() }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Jenis</label>
                                <p class="text-gray-900">{{ $news->getTypeLabel() }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tanggal Dibuat</label>
                                <p class="text-gray-900">{{ $news->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tanggal Publikasi</label>
                                <p class="text-gray-900">{{ $news->published_at ? $news->published_at->format('d M Y, H:i') : '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Views</label>
                                <p class="text-gray-900">{{ number_format($news->views) }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Reading Time</label>
                                <p class="text-gray-900">{{ $news->reading_time }}</p>
                            </div>
                        </div>
                        
                        <!-- Options -->
                        <div class="mt-4 flex space-x-4">
                            @if($news->is_featured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Featured
                            </span>
                            @endif
                            @if($news->is_pinned)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Pinned
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if($news->featured_image)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Gambar Utama</h3>
                        <div class="text-center">
                            <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="max-w-full h-auto mx-auto rounded-lg shadow-lg">
                        </div>
                    </div>
                    @endif

                    <!-- Excerpt -->
                    @if($news->excerpt)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $news->excerpt }}</p>
                    </div>
                    @endif

                    <!-- Content -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Konten Lengkap</h3>
                        <div class="prose max-w-none">
                            {!! $news->content !!}
                        </div>
                    </div>

                    <!-- Author Information -->
                    @if($news->author_name || $news->author_email)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Informasi Penulis</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($news->author_name)
                            <div>
                                <label class="text-sm font-medium text-blue-700">Nama Penulis</label>
                                <p class="text-blue-900">{{ $news->author_name }}</p>
                            </div>
                            @endif
                            @if($news->author_email)
                            <div>
                                <label class="text-sm font-medium text-blue-700">Email Penulis</label>
                                <p class="text-blue-900">{{ $news->author_email }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Tags -->
                    @if($news->tags && count($news->tags) > 0)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
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

                    <!-- Statistics -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary-600">{{ number_format($news->views) }}</div>
                                <div class="text-sm text-gray-500">Total Views</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $news->reading_time }}</div>
                                <div class="text-sm text-gray-500">Waktu Baca</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $news->created_at->diffForHumans() }}</div>
                                <div class="text-sm text-gray-500">Dibuat</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
