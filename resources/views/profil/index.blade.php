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
         style="background-image: url('{{ Storage::url($profilData['hero_background']) }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 500px;"
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
            <nav class="flex space-x-8 overflow-x-auto" aria-label="Tabs">
                <button onclick="showSection('sejarah')" class="tab-button active py-4 px-1 border-b-2 border-primary-500 text-primary-600 font-medium text-sm whitespace-nowrap">
                    Sejarah
                </button>
                <button onclick="showSection('visi-misi')" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm whitespace-nowrap">
                    Visi & Misi
                </button>
                <button onclick="showSection('struktur')" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm whitespace-nowrap">
                    Struktur Organisasi
                </button>
                <button onclick="showSection('akreditasi')" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm whitespace-nowrap">
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
                    <h2 class="text-3xl font-bold text-gray-900">{{ $profilData['sejarah']['judul'] }}</h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <p class="text-gray-700 leading-relaxed text-lg mb-6">{{ $profilData['sejarah']['konten'] }}</p>
                        
                        <div class="bg-primary-50 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-primary-800 mb-4">Informasi Sekolah</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-700"><strong>Tahun Berdiri:</strong> {{ $profilData['sejarah']['tahun_berdiri'] }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-gray-700"><strong>Lokasi:</strong> {{ $profilData['sejarah']['lokasi'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:col-span-1">
                        <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg p-6 text-white">
                            <h3 class="text-xl font-semibold mb-4">Fakta Menarik</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm">Sekolah Berakreditasi A</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm">Fasilitas Lengkap</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm">Guru Berpengalaman</span>
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
                <div class="flex items-center mb-6">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Visi & Misi Sekolah</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Visi -->
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg p-6 text-white">
                        <h3 class="text-2xl font-bold mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Visi
                        </h3>
                        <p class="text-lg leading-relaxed">{{ $profilData['visi_misi']['visi'] }}</p>
                    </div>

                    <!-- Misi -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-2xl font-bold mb-4 text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Misi
                        </h3>
                        <ul class="space-y-3">
                            @foreach($profilData['visi_misi']['misi'] as $index => $misi)
                            <li class="flex items-start">
                                <span class="bg-primary-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5">{{ $index + 1 }}</span>
                                <span class="text-gray-700">{{ $misi }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Struktur Organisasi Section -->
        <div id="struktur" class="content-section hidden">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">{{ $profilData['struktur_organisasi']['judul'] }}</h2>
                </div>

                <!-- Struktur Organisasi Image -->
                <div class="text-center">
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <img src="{{ Storage::url($profilData['struktur_organisasi']['gambar']) }}" 
                             alt="{{ $profilData['struktur_organisasi']['judul'] }}" 
                             class="max-w-full h-auto mx-auto rounded-lg shadow-lg"
                             onerror="this.src='{{ asset('images/default-section.png') }}'">
                    </div>
                    <p class="text-gray-600 text-lg">{{ $profilData['struktur_organisasi']['deskripsi'] }}</p>
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
                                <h4 class="text-2xl font-bold">{{ $profilData['akreditasi']['status'] }}</h4>
                                <p class="text-green-100">Nomor: {{ $profilData['akreditasi']['nomor_akreditasi'] }}</p>
                                <p class="text-green-100">Tahun: {{ $profilData['akreditasi']['tahun_akreditasi'] }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-4xl font-bold">{{ $profilData['akreditasi']['skor'] }}</div>
                                <div class="text-green-100">Skor Akreditasi</div>
                                <div class="text-sm text-green-200">Berlaku: {{ $profilData['akreditasi']['masa_berlaku'] }}</div>
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
                            @forelse($profilData['prestasi']['akademik'] as $prestasi)
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
                            @forelse($profilData['prestasi']['non_akademik'] as $prestasi)
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

<!-- JavaScript for Tab Navigation -->
<script>
function showSection(sectionId) {
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
    document.getElementById(sectionId).classList.remove('hidden');

    // Add active class to clicked tab
    event.target.classList.add('active', 'border-primary-500', 'text-primary-600');
    event.target.classList.remove('border-transparent', 'text-gray-500');
}
</script>
@endsection
