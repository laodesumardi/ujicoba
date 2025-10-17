@extends('layouts.app')

@section('title', 'Beranda - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    @if(isset($sections['hero']) && $sections['hero']->is_active)
    <div class="{{ $sections['hero']->background_color ?? 'bg-gradient-to-r from-primary-500 to-primary-600' }} {{ $sections['hero']->text_color ?? 'text-white' }} py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <!-- Content -->
                <div class="lg:w-1/2 text-center lg:text-left mb-8 lg:mb-0">
                    <h1 class="text-5xl font-bold mb-6">{{ $sections['hero']->title ?? 'Selamat Datang di SMP Negeri 01 Namrole' }}</h1>
                    <p class="text-xl {{ $sections['hero']->text_color ?? 'text-primary-100' }} mb-8">{{ $sections['hero']->subtitle ?? 'Sekolah Unggul Berkarakter, Berprestasi, dan Berdaya Saing Global' }}</p>
                    @if($sections['hero']->button_text)
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ $sections['hero']->button_link ?? route('profil') }}" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-primary-50 transition-colors">
                            {{ $sections['hero']->button_text }}
                        </a>
                        @if($sections['hero']->description)
                        <a href="#" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition-colors">
                            Informasi Pendaftaran
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                
                <!-- Image -->
                @if($sections['hero']->image)
                <div class="lg:w-1/2 flex justify-center">
                    <img src="{{ asset($sections['hero']->image) }}" 
                         alt="{{ $sections['hero']->image_alt ?? 'Hero Image' }}" 
                         class="max-w-md w-full h-auto rounded-lg shadow-2xl">
                </div>
                @endif
            </div>
        </div>
    </div>
    @else
    <!-- Default Hero Section -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-6">Selamat Datang di SMP Negeri 01 Namrole</h1>
            <p class="text-xl text-primary-100 mb-8">Sekolah Unggul Berkarakter, Berprestasi, dan Berdaya Saing Global</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('profil') }}" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-primary-50 transition-colors">
                    Lihat Profil Sekolah
                </a>
                <a href="#" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition-colors">
                    Informasi Pendaftaran
                </a>
                                        </div>
                                    </div>
                                </div>
    @endif


    <!-- Admin Dashboard Section for Logged In Users -->
    @auth
    <div class="bg-primary-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-primary-900 mb-4">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-lg text-gray-600">Akses dashboard admin untuk mengelola website sekolah</p>
                                </div>

            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="text-center mb-6">
                        <div class="flex justify-center mb-4">
                            <div class="bg-primary-100 rounded-full p-4">
                                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-primary-900 mb-2">Admin Dashboard</h3>
                        <p class="text-gray-600">Kelola profil sekolah, guru, dan prestasi</p>
                                </div>

                    <div class="space-y-4">
                        <a href="{{ route('admin.dashboard') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                            </svg>
                            Buka Dashboard
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                                </div>
    @endauth

    <!-- Quick Info Section -->
    @if(isset($sections['quick_info']) && $sections['quick_info']->is_active)
    <div class="py-16 {{ $sections['quick_info']->background_color ?? 'bg-gray-50' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($sections['quick_info']->title)
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold {{ $sections['quick_info']->text_color ?? 'text-gray-900' }} mb-4">{{ $sections['quick_info']->title }}</h2>
                @if($sections['quick_info']->subtitle)
                <p class="text-lg {{ $sections['quick_info']->text_color ?? 'text-gray-600' }}">{{ $sections['quick_info']->subtitle }}</p>
                @endif
            </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Guru Berkualitas</h3>
                    <p class="text-gray-600">Tenaga pendidik berpengalaman dan berkompeten</p>
                                </div>

                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Akreditasi A</h3>
                    <p class="text-gray-600">Sekolah terakreditasi A dengan skor 95</p>
                </div>

                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Fasilitas Lengkap</h3>
                    <p class="text-gray-600">Fasilitas pembelajaran yang modern dan memadai</p>
                </div>
                                </div>
                            </div>
                        </div>
    @else
    <!-- Default Quick Info Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Guru Berkualitas</h3>
                    <p class="text-gray-600">Tenaga pendidik berpengalaman dan berkompeten</p>
                </div>

                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Akreditasi A</h3>
                    <p class="text-gray-600">Sekolah terakreditasi A dengan skor 95</p>
                </div>

                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Fasilitas Lengkap</h3>
                    <p class="text-gray-600">Fasilitas pembelajaran yang modern dan memadai</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
