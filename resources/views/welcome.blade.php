@extends('layouts.app')

@section('title', 'Beranda - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    @if(isset($sections['hero']) && $sections['hero']->is_active)
        @php
            $heroBgStyle = '';
            $heroClasses = 'py-24 relative overflow-hidden';
            $textColorClass = $sections['hero']->text_color ?? 'text-white';
            $hasImage = false;

            if ($sections['hero']->image) {
                $imageUrl = asset($sections['hero']->image);
                $heroBgStyle = "background-image: url('{$imageUrl}'); background-size: cover; background-position: center; background-repeat: no-repeat;";
                $hasImage = true;
            } else {
                $heroClasses .= ' ' . ($sections['hero']->background_color ?? 'bg-gradient-to-r from-primary-500 to-primary-600');
            }
        @endphp
    <div class="{{ $heroClasses }} {{ $textColorClass }}" @if($hasImage) style="{{ $heroBgStyle }}" @endif>
        @if($hasImage)
            {{-- Overlay for background image --}}
            <div class="absolute inset-0 bg-black opacity-50 z-10"></div>
        @endif
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
            <div class="text-center">
                <!-- Logo Sekolah -->
                <div class="mb-8">
                    <img src="{{ asset('logo.png') }}" alt="Logo SMP Negeri 01 Namrole" class="mx-auto h-20 w-auto">
                        </div>
                
                <!-- Content -->
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4 leading-tight">{{ $sections['hero']->title ?? 'Selamat Datang di SMP Negeri 01 Namrole' }}</h1>
                    <p class="text-base sm:text-lg lg:text-xl {{ $sections['hero']->text_color ?? 'text-primary-100' }} mb-8 leading-relaxed">{{ $sections['hero']->subtitle ?? 'Sekolah Unggul Berkarakter, Berprestasi, dan Berdaya Saing Global' }}</p>
                    
                    @if($sections['hero']->button_text)
                    <div class="flex flex-col sm:flex-row gap-6 justify-center">
                        <a href="{{ $sections['hero']->button_link ?? route('profil') }}" class="bg-white text-primary-600 px-10 py-4 rounded-lg font-semibold text-lg hover:bg-primary-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            {{ $sections['hero']->button_text }}
                        </a>
                        @if($sections['hero']->description)
                        <a href="#" class="border-2 border-white text-white px-10 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-primary-600 transition-all duration-300 transform hover:scale-105">
                            Informasi Pendaftaran
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
                                </div>
    @else
    <!-- Default Hero Section -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Logo Sekolah -->
            <div class="mb-8">
                <img src="{{ asset('logo.png') }}" alt="Logo SMP Negeri 01 Namrole" class="mx-auto h-20 w-auto">
                                        </div>

            <div class="max-w-4xl mx-auto">
                <h1 class="text-6xl font-bold mb-6 leading-tight">Selamat Datang di SMP Negeri 01 Namrole</h1>
                <p class="text-2xl text-primary-100 mb-12 leading-relaxed">Sekolah Unggul Berkarakter, Berprestasi, dan Berdaya Saing Global</p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('profil') }}" class="bg-white text-primary-600 px-10 py-4 rounded-lg font-semibold text-lg hover:bg-primary-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Lihat Profil Sekolah
                    </a>
                    <a href="#" class="border-2 border-white text-white px-10 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-primary-600 transition-all duration-300 transform hover:scale-105">
                        Informasi Pendaftaran
                    </a>
                </div>
                                        </div>
                                    </div>
                                </div>
    @endif

    <!-- Quick Info Section -->
    @if(isset($sections['quick_info']) && $sections['quick_info']->is_active)
    <div class="{{ $sections['quick_info']->background_color ?? 'bg-gray-50' }} {{ $sections['quick_info']->text_color ?? 'text-gray-900' }} py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">{{ $sections['quick_info']->title ?? 'Keunggulan Sekolah Kami' }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ $sections['quick_info']->subtitle ?? 'Mengapa memilih SMP Negeri 01 Namrole?' }}</p>
                                </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Guru Berkualitas -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-6">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ isset($sections['guru_berkualitas']) && $sections['guru_berkualitas']->is_active ? $sections['guru_berkualitas']->title : 'Guru Berkualitas' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ isset($sections['guru_berkualitas']) && $sections['guru_berkualitas']->is_active ? $sections['guru_berkualitas']->subtitle : 'Tenaga pendidik berpengalaman dan berkompeten' }}
                    </p>
                    @if(isset($sections['guru_berkualitas']) && $sections['guru_berkualitas']->is_active && $sections['guru_berkualitas']->description)
                    <p class="text-sm text-gray-500 mt-4">{{ $sections['guru_berkualitas']->description }}</p>
                    @endif
                                </div>

                <!-- Akreditasi A -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-6">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                                </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ isset($sections['akreditasi_a']) && $sections['akreditasi_a']->is_active ? $sections['akreditasi_a']->title : 'Akreditasi A' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ isset($sections['akreditasi_a']) && $sections['akreditasi_a']->is_active ? $sections['akreditasi_a']->subtitle : 'Sekolah terakreditasi A dengan skor 95' }}
                    </p>
                    @if(isset($sections['akreditasi_a']) && $sections['akreditasi_a']->is_active && $sections['akreditasi_a']->description)
                    <p class="text-sm text-gray-500 mt-4">{{ $sections['akreditasi_a']->description }}</p>
                    @endif
                                </div>

                <!-- Fasilitas Lengkap -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-6">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ isset($sections['fasilitas_lengkap']) && $sections['fasilitas_lengkap']->is_active ? $sections['fasilitas_lengkap']->title : 'Fasilitas Lengkap' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ isset($sections['fasilitas_lengkap']) && $sections['fasilitas_lengkap']->is_active ? $sections['fasilitas_lengkap']->subtitle : 'Fasilitas pembelajaran yang modern dan memadai' }}
                    </p>
                    @if(isset($sections['fasilitas_lengkap']) && $sections['fasilitas_lengkap']->is_active && $sections['fasilitas_lengkap']->description)
                    <p class="text-sm text-gray-500 mt-4">{{ $sections['fasilitas_lengkap']->description }}</p>
                    @endif
                </div>
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
                @if(auth()->user()->role === 'admin')
                    <p class="text-lg text-gray-600">Akses dashboard admin untuk mengelola website sekolah</p>
                @elseif(auth()->user()->role === 'teacher')
                    <p class="text-lg text-gray-600">Akses dashboard guru untuk mengelola kelas dan pembelajaran</p>
                @elseif(auth()->user()->role === 'student')
                    <p class="text-lg text-gray-600">Akses dashboard siswa untuk melihat pembelajaran dan tugas</p>
                @else
                    <p class="text-lg text-gray-600">Akses dashboard untuk mengelola akun Anda</p>
                @endif
            </div>

            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="text-center mb-6">
                        <div class="flex justify-center mb-4">
                            <div class="bg-primary-100 rounded-full p-4">
                                @if(auth()->user()->role === 'admin')
                                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                @elseif(auth()->user()->role === 'teacher')
                                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                @elseif(auth()->user()->role === 'student')
                                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        @if(auth()->user()->role === 'admin')
                            <h3 class="text-2xl font-bold text-primary-900 mb-2">Admin Dashboard</h3>
                            <p class="text-gray-600">Kelola profil sekolah, guru, dan prestasi</p>
                        @elseif(auth()->user()->role === 'teacher')
                            <h3 class="text-2xl font-bold text-primary-900 mb-2">Dashboard Guru</h3>
                            <p class="text-gray-600">Kelola kelas, materi, dan penilaian siswa</p>
                        @elseif(auth()->user()->role === 'student')
                            <h3 class="text-2xl font-bold text-primary-900 mb-2">Dashboard Siswa</h3>
                            <p class="text-gray-600">Lihat pembelajaran, tugas, dan nilai</p>
                        @else
                            <h3 class="text-2xl font-bold text-primary-900 mb-2">Dashboard</h3>
                            <p class="text-gray-600">Kelola akun dan informasi Anda</p>
                        @endif
                    </div>

                    <div class="space-y-4">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                                Buka Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'teacher')
                            <a href="{{ route('teacher.dashboard') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Buka Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'student')
                            <a href="{{ route('student.dashboard') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                                Buka Dashboard
                            </a>
                        @endif
                        
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

    <!-- News Section -->
    @if($latestNews->count() > 0)
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                @if(isset($sections['news']) && $sections['news']->is_active)
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $sections['news']->title }}</h2>
                    @if($sections['news']->subtitle)
                        <p class="text-lg text-gray-600 mb-4">{{ $sections['news']->subtitle }}</p>
                    @endif
                    @if($sections['news']->content)
                        <p class="text-gray-600">{{ $sections['news']->content }}</p>
                    @endif
                @else
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Berita & Pengumuman Terbaru</h2>
                    <p class="text-lg text-gray-600">Informasi terkini dari SMP Negeri 01 Namrole</p>
                @endif
            </div>

            <!-- Featured News -->
            @if($featuredNews->count() > 0)
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Berita Utama</h3>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    @foreach($featuredNews as $news)
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        @if($news->featured_image)
                        <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="w-full h-48 object-cover">
                        @else
                        <div class="w-full h-48 bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    {{ $news->getCategoryLabel() }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $news->type == 'news' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $news->getTypeLabel() }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                                <a href="{{ route('news.show', $news->slug) }}" class="hover:text-primary-600 transition-colors">
                                    {{ $news->title }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $news->excerpt }}</p>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $news->published_at->format('d M Y') }}</span>
                                <span>{{ $news->views }} views</span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Latest News -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Berita Terbaru</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($latestNews->take(6) as $news)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        @if($news->featured_image)
                        <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="w-full h-32 object-cover">
                        @else
                        <div class="w-full h-32 bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        @endif
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    {{ $news->getCategoryLabel() }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $news->published_at->format('d M Y') }}</span>
                            </div>
                            
                            <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="{{ route('news.show', $news->slug) }}" class="hover:text-primary-600 transition-colors">
                                    {{ $news->title }}
                                </a>
                            </h4>
                            
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $news->excerpt }}</p>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>

            <!-- View All News Button -->
            <div class="text-center">
                <a href="{{ route('news.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    Lihat Semua Berita
                </a>
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

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
