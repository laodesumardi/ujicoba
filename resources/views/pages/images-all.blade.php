@extends('layouts.app')

@section('title', 'Semua Gambar')

@section('content')
<div class="bg-white">
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-3xl font-bold">Semua Gambar di Website</h1>
            <p class="text-primary-100 mt-2">Daftar gambar dari folder public/images, root public, dan storage publik</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10 space-y-10">
        <!-- Ringkasan -->
        <div class="bg-primary-50 border border-primary-100 rounded-xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <div class="text-sm text-gray-500">Gambar di Root Public</div>
                    <div class="text-2xl font-bold text-gray-900">{{ count($rootImages) }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <div class="text-sm text-gray-500">Public Images (/images)</div>
                    <div class="text-2xl font-bold text-gray-900">{{ count($publicImages) }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <div class="text-sm text-gray-500">Storage Images (/storage)</div>
                    <div class="text-2xl font-bold text-gray-900">{{ count($storageImages) }}</div>
                </div>
            </div>
        </div>

        <!-- Root Public Images -->
        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Gambar di Root Public</h2>
            @if(count($rootImages) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($rootImages as $img)
                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <div class="aspect-square bg-gray-50">
                                <img src="{{ $img['url'] }}" alt="{{ $img['name'] }}" class="w-full h-full object-contain"
                                     onerror="this.alt='ERROR'; this.style.border='2px solid red';">
                            </div>
                            <div class="p-2">
                                <div class="text-xs text-gray-700 truncate">{{ $img['name'] }}</div>
                                <div class="text-[10px] text-gray-500 truncate">{{ $img['path'] }}</div>
                                <div class="text-[10px] text-blue-600 truncate"><a href="{{ $img['url'] }}" target="_blank">Buka</a></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500">Tidak ada gambar di root public.</div>
            @endif
        </div>

        <!-- Public Images (/public/images) -->
        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Public Images (/images)</h2>
            @if(count($publicImages) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($publicImages as $img)
                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <div class="aspect-square bg-gray-50">
                                <img src="{{ $img['url'] }}" alt="{{ $img['name'] }}" class="w-full h-full object-cover"
                                     onerror="this.alt='ERROR'; this.style.border='2px solid red';">
                            </div>
                            <div class="p-2">
                                <div class="text-xs text-gray-700 truncate">{{ $img['name'] }}</div>
                                <div class="text-[10px] text-gray-500 truncate">{{ $img['path'] }}</div>
                                <div class="text-[10px] text-blue-600 truncate"><a href="{{ $img['url'] }}" target="_blank">Buka</a></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500">Tidak ada gambar di folder public/images.</div>
            @endif
        </div>

        <!-- Storage Images (/storage) -->
        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Storage Images (/storage)</h2>
            @if(count($storageImages) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($storageImages as $img)
                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <div class="aspect-square bg-gray-50">
                                <img src="{{ $img['url'] }}" alt="{{ $img['name'] }}" class="w-full h-full object-cover"
                                     onerror="this.alt='ERROR'; this.style.border='2px solid red';">
                            </div>
                            <div class="p-2">
                                <div class="text-xs text-gray-700 truncate">{{ $img['name'] }}</div>
                                <div class="text-[10px] text-gray-500 truncate">{{ $img['path'] }}</div>
                                <div class="text-[10px] text-blue-600 truncate"><a href="{{ $img['url'] }}" target="_blank">Buka</a></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500">Tidak ada gambar di storage publik.</div>
            @endif
        </div>

        <!-- Catatan -->
        <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4 text-sm text-yellow-900">
            - Halaman ini menampilkan gambar statis (public/images, root public) dan file di storage publik yang memiliki ekstensi gambar.
            - Untuk gambar model (misalnya fasilitas, home-sections), pengambilan di halaman-halaman terkait dilakukan via rute `image.serve.model` dengan cache-busting.
        </div>
    </div>
</div>
@endsection