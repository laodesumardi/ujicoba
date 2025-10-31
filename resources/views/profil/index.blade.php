@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Profil Sekolah - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="text-white relative flex items-center justify-center" 
         @if(isset($profilData['hero_background']) && $profilData['hero_background'])
         style="background-image: url('{{ $profilData['hero_background'] }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 500px;"
         @else
         style="background: linear-gradient(135deg, #14213d 0%, #1e3a8a 100%); min-height: 500px;"
         @endif>
        <!-- Overlay untuk kontras teks -->
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        
        <!-- Konten di tengah -->
        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4 text-white leading-tight">
                    {{ $profilData['hero_title'] ?? 'Profil Sekolah' }}
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-white opacity-90 leading-relaxed">
                    {{ $profilData['hero_subtitle'] ?? 'SMP Negeri 01 Namrole - Sekolah Unggul Berkarakter' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex justify-center space-x-8 overflow-x-auto" aria-label="Tabs">
                <button onclick="showSection('sejarah')" class="tab-button active py-4 px-4 border-b-2 border-primary-500 text-primary-600 font-medium text-sm sm:text-base whitespace-nowrap">
                    Sejarah
                </button>
                <button onclick="showSection('visi-misi')" class="tab-button py-4 px-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm sm:text-base whitespace-nowrap">
                    Visi & Misi
                </button>
                <button onclick="showSection('struktur')" class="tab-button py-4 px-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm sm:text-base whitespace-nowrap">
                    Struktur Organisasi
                </button>
                <button onclick="showSection('akreditasi')" class="tab-button py-4 px-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm sm:text-base whitespace-nowrap">
                    Akreditasi & Prestasi
                </button>
            </nav>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Sejarah Section -->
        <div id="sejarah" class="content-section">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">{{ $profilData['sejarah']['judul'] ?? 'Sejarah Sekolah' }}</h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <p class="text-gray-700 leading-relaxed text-lg mb-6">{{ $profilData['sejarah']['konten'] ?? 'Sejarah sekolah akan segera diisi.' }}</p>
                        
                        <div class="bg-primary-50 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-primary-800 mb-4">Informasi Sekolah</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    </svg>
                                    <span class="text-gray-700"><strong>Tahun Berdiri:</strong> {{ $profilData['sejarah']['tahun_berdiri'] ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-gray-700"><strong>Lokasi:</strong> {{ $profilData['sejarah']['lokasi'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Visi Misi Section -->
        <div id="visi-misi" class="content-section hidden">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-8">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Visi & Misi Sekolah</h2>
                </div>


                <!-- Gambar Visi Misi -->
                @php $images = $profilData['visi_misi']['images'] ?? []; @endphp
                @if(count($images) > 0)
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Dokumentasi Visi & Misi</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($images as $idx => $img)
                            <div class="bg-gray-50 rounded-xl p-4 hover:shadow-lg transition-shadow">
                                <button onclick="openImageModal('{{ $img }}', 'Visi & Misi — Gambar {{ $idx + 1 }}')" class="block focus:outline-none w-full">
                                    <img src="{{ $img }}" alt="Visi & Misi Sekolah — Gambar {{ $idx + 1 }}" class="w-full h-48 object-cover rounded-lg border-2 border-gray-200 hover:border-primary-300 transition-colors" onerror="this.src='{{ asset('images/default-image.png') }}'" />
                                </button>
                                <p class="text-sm text-gray-600 mt-3 text-center">Klik untuk melihat penuh — Gambar {{ $idx + 1 }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-8 text-center">
                    <div class="bg-yellow-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">Dokumentasi Visi & Misi</h3>
                    <p class="text-yellow-700">Gambar dokumentasi visi & misi akan segera ditambahkan. Silakan hubungi admin untuk mengatur konten ini.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Struktur Organisasi Section -->
        <div id="struktur" class="content-section hidden">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">{{ $profilData['struktur_organisasi']['judul'] ?? 'Struktur Organisasi' }}</h2>
                </div>

                <!-- Struktur Organisasi Image -->
                <div class="text-center">
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <img src="{{ $profilData['struktur_organisasi']['gambar'] ?? asset('images/default-struktur.png') }}" 
                             alt="{{ $profilData['struktur_organisasi']['judul'] ?? 'Struktur Organisasi' }}" 
                             class="max-w-full h-auto mx-auto rounded-lg shadow-lg"
                             onerror="this.src='{{ asset('images/default-struktur.png') }}'">
                    </div>
                    <p class="text-gray-600 text-lg">{{ $profilData['struktur_organisasi']['deskripsi'] ?? 'Struktur organisasi sekolah akan segera diisi.' }}</p>
                </div>
            </div>
        </div>


        <!-- Akreditasi & Prestasi Section -->
        <div id="akreditasi" class="content-section hidden">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Akreditasi & Prestasi</h2>
                </div>

                <!-- Akreditasi -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Akreditasi Sekolah</h3>
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-2xl font-bold">{{ $profilData['akreditasi']['status'] ?? 'Akreditasi A' }}</h4>
                                <p class="text-green-100">Tahun: {{ $profilData['akreditasi']['tahun_akreditasi'] ?? '2023' }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-4xl font-bold">{{ $profilData['akreditasi']['skor'] ?? '95' }}</div>
                                <div class="text-green-100">Skor Akreditasi</div>
                                <div class="text-sm text-green-200">Berlaku: {{ $profilData['akreditasi']['masa_berlaku'] ?? '2023-2028' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prestasi -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Prestasi Akademik -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Prestasi Akademik
                        </h3>
                        <div class="space-y-4">
                            @forelse($profilData['prestasi']['akademik'] ?? [] as $prestasi)
                            <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 mb-1">{{ $prestasi['prestasi'] }}</h4>
                                        @if($prestasi['participant'])
                                        <p class="text-sm text-gray-600 mb-2">{{ $prestasi['participant'] }}</p>
                                        @endif
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $prestasi['level'] }}
                                            </span>
                                            <span class="text-sm text-gray-600">Tahun {{ $prestasi['tahun'] }}</span>
                                            @if($prestasi['position'])
                                            <span class="text-sm font-medium text-gray-900">{{ $prestasi['position'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="bg-blue-500 text-white rounded-full p-2 ml-4">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                <p class="mt-2">Belum ada prestasi akademik</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Prestasi Non-Akademik -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Prestasi Non-Akademik
                        </h3>
                        <div class="space-y-4">
                            @forelse($profilData['prestasi']['non_akademik'] ?? [] as $prestasi)
                            <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 mb-1">{{ $prestasi['prestasi'] }}</h4>
                                        @if($prestasi['participant'])
                                        <p class="text-sm text-gray-600 mb-2">{{ $prestasi['participant'] }}</p>
                                        @endif
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $prestasi['level'] }}
                                            </span>
                                            <span class="text-sm text-gray-600">Tahun {{ $prestasi['tahun'] }}</span>
                                            @if($prestasi['position'])
                                            <span class="text-sm font-medium text-gray-900">{{ $prestasi['position'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="bg-green-500 text-white rounded-full p-2 ml-4">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                <p class="mt-2">Belum ada prestasi non-akademik</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Fullscreen Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50 transition-opacity duration-300">
    <div class="w-full h-full flex flex-col">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 bg-black bg-opacity-50">
            <div class="text-white">
                <h3 id="modalTitle" class="text-xl font-semibold"></h3>
                <p id="modalSubtitle" class="text-sm text-gray-300"></p>
            </div>
            <button onclick="closeImageModal()" class="bg-red-500 hover:bg-red-600 text-white rounded-full w-10 h-10 flex items-center justify-center transition-colors duration-200 shadow-lg" aria-label="Tutup">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Content -->
        <div class="flex-1 overflow-auto" id="imageContainer" style="height: calc(100vh - 200px); overflow-x: auto; overflow-y: auto;">
            <div class="flex justify-center p-4" style="min-height: 100%;">
                <img id="modalImage" src="" alt="" class="rounded-lg shadow-2xl transition-transform duration-300 cursor-grab active:cursor-grabbing" 
                     style="transform-origin: center; transform: scale(1); max-width: none; max-height: none; width: auto; height: auto;"
                     onmousedown="startDrag(event)" 
                     onmousemove="drag(event)" 
                     onmouseup="endDrag(event)"
                     onwheel="zoom(event)">
            </div>
            
            <!-- Navigation Arrows -->
            <button id="prevBtn" onclick="navigateImage(-1)" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-40 text-white rounded-full w-12 h-12 flex items-center justify-center transition-all duration-200 backdrop-blur-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button id="nextBtn" onclick="navigateImage(1)" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-40 text-white rounded-full w-12 h-12 flex items-center justify-center transition-all duration-200 backdrop-blur-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Footer -->
        <div class="p-4 bg-black bg-opacity-50 text-center">
            <div id="modalCaption" class="text-white text-lg mb-2"></div>
            <div class="text-white text-sm mb-3 opacity-75">
                💡 Gunakan <kbd class="bg-white bg-opacity-20 px-2 py-1 rounded">Ctrl + Scroll</kbd> untuk zoom, atau scroll normal untuk melihat gambar
            </div>
            <div class="flex justify-center space-x-2">
                <button onclick="resetZoom()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.005 12.3M20 12v5h-.582m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Reset Zoom</span>
                </button>
                <button onclick="downloadImage()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Download</span>
                </button>
                <button onclick="shareImage()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                    <span>Share</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced JavaScript for Tab Navigation & Image Modal -->
<script>
// Global variables for image navigation
let currentImageIndex = 0;
let imageList = [];

// Global variables for zoom and pan
let isDragging = false;
let startX = 0;
let startY = 0;
let currentScale = 1;
let currentTranslateX = 0;
let currentTranslateY = 0;

function showSection(sectionId, buttonElement = null) {
    // Hide all content sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.classList.add('hidden');
    });

    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.tab-button');
    tabs.forEach(tab => {
        tab.classList.remove('active', 'border-primary-500', 'text-primary-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected section
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.remove('hidden');

        // Add active class to clicked tab or find by section ID
        if (buttonElement) {
            buttonElement.classList.add('active', 'border-primary-500', 'text-primary-600');
            buttonElement.classList.remove('border-transparent', 'text-gray-500');
        } else if (window.event && window.event.target) {
            window.event.target.classList.add('active', 'border-primary-500', 'text-primary-600');
            window.event.target.classList.remove('border-transparent', 'text-gray-500');
        } else {
            // Find button by section ID
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(btn => {
                const onclick = btn.getAttribute('onclick');
                if (onclick && onclick.includes(sectionId)) {
                    btn.classList.add('active', 'border-primary-500', 'text-primary-600');
                    btn.classList.remove('border-transparent', 'text-gray-500');
                }
            });
        }
    }
}

function openImageModal(url, caption) {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('modalImage');
    const title = document.getElementById('modalTitle');
    const subtitle = document.getElementById('modalSubtitle');
    const cap = document.getElementById('modalCaption');
    
    // Set image and captions
    img.src = url;
    img.alt = caption || '';
    title.textContent = 'Dokumentasi Visi & Misi';
    subtitle.textContent = 'SMP Negeri 01 Namrole';
    cap.textContent = caption || '';
    
    // Find all images in current section for navigation
    const currentSection = document.querySelector('.content-section:not(.hidden)');
    const images = currentSection.querySelectorAll('img[onclick*="openImageModal"]');
    imageList = Array.from(images).map(img => ({
        src: img.src,
        caption: img.alt
    }));
    
    // Find current image index
    currentImageIndex = imageList.findIndex(item => item.src === url);
    
    // Update navigation buttons
    updateNavigationButtons();
    
    // Show modal with animation
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('modalImage');
    
    // Hide modal
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    
    // Clear image
    img.src = '';
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

function navigateImage(direction) {
    if (imageList.length <= 1) return;
    
    currentImageIndex += direction;
    
    // Loop around
    if (currentImageIndex >= imageList.length) {
        currentImageIndex = 0;
    } else if (currentImageIndex < 0) {
        currentImageIndex = imageList.length - 1;
    }
    
    // Update image
    const img = document.getElementById('modalImage');
    const cap = document.getElementById('modalCaption');
    const currentImage = imageList[currentImageIndex];
    
    img.src = currentImage.src;
    img.alt = currentImage.caption;
    cap.textContent = currentImage.caption;
    
    // Update navigation buttons
    updateNavigationButtons();
}

function updateNavigationButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (imageList.length <= 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'flex';
        nextBtn.style.display = 'flex';
    }
}

function downloadImage() {
    const img = document.getElementById('modalImage');
    const link = document.createElement('a');
    link.href = img.src;
    link.download = `visi-misi-${Date.now()}.jpg`;
    link.click();
}

function shareImage() {
    const img = document.getElementById('modalImage');
    const caption = document.getElementById('modalCaption').textContent;
    
    if (navigator.share) {
        navigator.share({
            title: 'Dokumentasi Visi & Misi - SMP Negeri 01 Namrole',
            text: caption,
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(`${caption} - ${window.location.href}`).then(() => {
            alert('Link telah disalin ke clipboard!');
        });
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (document.getElementById('imageModal').classList.contains('flex')) {
        switch(e.key) {
            case 'Escape':
                closeImageModal();
                break;
            case 'ArrowLeft':
                navigateImage(-1);
                break;
            case 'ArrowRight':
                navigateImage(1);
                break;
        }
    }
});

// Click outside to close
document.getElementById('imageModal')?.addEventListener('click', function(e) {
    if (e.target.id === 'imageModal') closeImageModal();
});

// Touch/swipe support for mobile
let touchStartX = 0;
let touchEndX = 0;

document.getElementById('imageModal')?.addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
});

document.getElementById('imageModal')?.addEventListener('touchend', function(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            // Swipe left - next image
            navigateImage(1);
        } else {
            // Swipe right - previous image
            navigateImage(-1);
        }
    }
}

// Zoom and Pan Functions
function zoom(event) {
    // Check if Ctrl key is pressed for zoom, otherwise allow normal scrolling
    if (event.ctrlKey || event.metaKey) {
        event.preventDefault();
        const img = document.getElementById('modalImage');
        const delta = event.deltaY > 0 ? 0.9 : 1.1;
        const newScale = Math.max(0.5, Math.min(5, currentScale * delta));
        
        currentScale = newScale;
        img.style.transform = `scale(${currentScale}) translate(${currentTranslateX}px, ${currentTranslateY}px)`;
    }
    // If not Ctrl+scroll, allow normal page scrolling
}

function startDrag(event) {
    if (currentScale > 1) {
        isDragging = true;
        startX = event.clientX - currentTranslateX;
        startY = event.clientY - currentTranslateY;
        event.preventDefault();
    }
}

function drag(event) {
    if (isDragging && currentScale > 1) {
        currentTranslateX = event.clientX - startX;
        currentTranslateY = event.clientY - startY;
        
        const img = document.getElementById('modalImage');
        img.style.transform = `scale(${currentScale}) translate(${currentTranslateX}px, ${currentTranslateY}px)`;
    }
}

function endDrag(event) {
    isDragging = false;
}

function resetZoom() {
    const img = document.getElementById('modalImage');
    currentScale = 1;
    currentTranslateX = 0;
    currentTranslateY = 0;
    img.style.transform = 'scale(1) translate(0px, 0px)';
}

// Reset zoom when opening new image
function openImageModal(url, caption) {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('modalImage');
    const title = document.getElementById('modalTitle');
    const subtitle = document.getElementById('modalSubtitle');
    const cap = document.getElementById('modalCaption');
    
    // Reset zoom first
    resetZoom();
    
    // Set image and captions
    img.src = url;
    img.alt = caption || '';
    title.textContent = 'Dokumentasi Visi & Misi';
    subtitle.textContent = 'SMP Negeri 01 Namrole';
    cap.textContent = caption || '';
    
    // Wait for image to load, then adjust size
    img.onload = function() {
        // Force image to show at natural size for scrolling
        img.style.maxWidth = 'none';
        img.style.maxHeight = 'none';
        img.style.width = 'auto';
        img.style.height = 'auto';
        
        // Ensure container can scroll
        const container = document.getElementById('imageContainer');
        container.style.overflow = 'auto';
        container.style.overflowX = 'auto';
        container.style.overflowY = 'auto';
    };
    
    // Find all images in current section for navigation
    const currentSection = document.querySelector('.content-section:not(.hidden)');
    const images = currentSection.querySelectorAll('img[onclick*="openImageModal"]');
    imageList = Array.from(images).map(img => ({
        src: img.src,
        caption: img.alt
    }));
    
    // Find current image index
    currentImageIndex = imageList.findIndex(item => item.src === url);
    
    // Update navigation buttons
    updateNavigationButtons();
    
    // Show modal with animation
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

// Handle hash anchor navigation
function handleHashNavigation() {
    const hash = window.location.hash.substring(1); // Remove the # symbol
    if (hash) {
        const validSections = ['sejarah', 'visi-misi', 'struktur', 'akreditasi'];
        if (validSections.includes(hash)) {
            // Show the section (this will also update the active tab)
            showSection(hash);
            
            // Scroll to the section
            setTimeout(() => {
                const element = document.getElementById(hash);
                if (element) {
                    const navHeight = document.querySelector('.bg-white.shadow-sm')?.offsetHeight || 0;
                    const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
                    const offsetPosition = elementPosition - navHeight - 20;
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }, 100);
        }
    }
}

// Call on page load
document.addEventListener('DOMContentLoaded', function() {
    handleHashNavigation();
});

// Handle hash change when clicking links with hash
window.addEventListener('hashchange', function() {
    handleHashNavigation();
});

</script>
@endsection
