<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'SMP Negeri 01 Namrole')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-primary-500/95 backdrop-blur-sm shadow-lg sticky top-0 z-50 transition-all duration-300" style="transform: translateY(0);">
            <div class="max-w-8xl mx-auto px-6 sm:px-8 lg:px-12">
                <div class="flex justify-between items-center py-2">
                    <!-- Logo -->
                    <div class="flex items-center ml-4">
                        <img src="{{ asset('logo.png') }}" alt="Logo SMP Negeri 01 Namrole" class="h-12 w-auto mr-4">
                        <div>
                            <h1 class="text-white text-xl font-bold leading-none">SMP NEGERI 01</h1>
                            <h2 class="text-white text-xs font-medium mt-0.5">NAMROLE</h2>
                        </div>
                    </div>

                    <!-- Navigation -->
                <nav class="hidden lg:flex space-x-10 ml-20">
                    <a href="{{ route('home') }}" class="text-white hover:text-primary-200 px-3 py-2 text-base font-bold transition-colors {{ request()->routeIs('home') ? 'text-primary-200' : '' }}">Beranda</a>
                    
                    <!-- Profil Dropdown -->
                    <div class="relative group">
                        <button class="text-white hover:text-primary-200 px-3 py-2 text-base font-bold transition-colors flex items-center {{ request()->routeIs('profil') ? 'text-primary-200' : '' }}">
                            Profil
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('profil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Sekolah</a>
                        </div>
                    </div>

                    <a href="{{ route('ppdb.index') }}" class="text-white hover:text-primary-200 px-3 py-2 text-base font-bold transition-colors {{ request()->routeIs('ppdb.*') ? 'text-primary-200' : '' }}">PPDB</a>
                    
                    <!-- Informasi Dropdown -->
                    <div class="relative group">
                        <button class="text-white hover:text-primary-200 px-3 py-2 text-base font-bold transition-colors flex items-center {{ request()->routeIs('academic-calendar.*', 'news.*') ? 'text-primary-200' : '' }}">
                            Informasi
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('academic-calendar.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kalender Akademik</a>
                            <a href="{{ route('news.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Berita & Pengumuman</a>
                        </div>
                    </div>

                    <!-- Media Dropdown -->
                    <div class="relative group">
                        <button class="text-white hover:text-primary-200 px-3 py-2 text-base font-bold transition-colors flex items-center {{ request()->routeIs('gallery.*', 'documents.*') ? 'text-primary-200' : '' }}">
                            Media
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('gallery.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Galeri Foto</a>
                            <a href="{{ route('documents.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Download Center</a>
                        </div>
                    </div>

                    <a href="{{ route('contact') }}" class="text-white hover:text-primary-200 px-3 py-2 text-base font-bold transition-colors {{ request()->routeIs('contact') ? 'text-primary-200' : '' }}">Kontak</a>
                </nav>

                    <!-- Auth Links -->
                    <div class="hidden md:flex items-center space-x-8 mr-12">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded-md text-base font-bold transition-colors">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Admin Dashboard
                                </a>
                            @elseif(auth()->user()->role === 'teacher')
                                <a href="{{ route('teacher.dashboard') }}" class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded-md text-base font-bold transition-colors">
                                    <i class="fas fa-chalkboard-teacher mr-2"></i>Dashboard Guru
                                </a>
                            @elseif(auth()->user()->role === 'student')
                                <a href="{{ route('student.dashboard') }}" class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded-md text-base font-bold transition-colors">
                                    <i class="fas fa-user-graduate mr-2"></i>Dashboard Siswa
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-primary-200 px-3 py-2 text-base font-bold transition-colors">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-white text-primary-600 hover:bg-primary-50 px-4 py-2 rounded-md text-base font-bold transition-colors">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden mr-6">
                        <button type="button" class="text-white hover:text-primary-200 focus:outline-none focus:text-primary-200" id="mobile-menu-button">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div class="lg:hidden hidden" id="mobile-menu">
                    <div class="px-4 pt-4 pb-4 space-y-2 sm:px-4 bg-primary-600 rounded-lg mt-3">
                        <!-- Main Navigation -->
                        <a href="{{ route('home') }}" class="text-white hover:text-primary-200 block px-4 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-primary-600' : '' }}">Beranda</a>
                        
                        <!-- Profil Section -->
                        <div class="space-y-1">
                            <button onclick="toggleMobileDropdown('profil')" class="w-full text-left text-primary-200 text-sm font-semibold px-4 py-1 flex items-center justify-between">
                                Profil
                                <svg id="profil-arrow" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="profil-dropdown" class="hidden ml-4 space-y-1">
                                <a href="{{ route('profil') }}" class="text-white hover:text-primary-200 block px-6 py-1.5 rounded-md text-sm font-medium {{ request()->routeIs('profil') ? 'bg-primary-600' : '' }}">Profil Sekolah</a>
                            </div>
                        </div>
                        
                        <a href="{{ route('ppdb.index') }}" class="text-white hover:text-primary-200 block px-4 py-2 rounded-md text-base font-medium {{ request()->routeIs('ppdb.*') ? 'bg-primary-600' : '' }}">PPDB</a>
                        
                        <!-- Informasi Section -->
                        <div class="space-y-1">
                            <button onclick="toggleMobileDropdown('informasi')" class="w-full text-left text-primary-200 text-sm font-semibold px-4 py-1 flex items-center justify-between">
                                Informasi
                                <svg id="informasi-arrow" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="informasi-dropdown" class="hidden ml-4 space-y-1">
                                <a href="{{ route('academic-calendar.index') }}" class="text-white hover:text-primary-200 block px-6 py-1.5 rounded-md text-sm font-medium {{ request()->routeIs('academic-calendar.*') ? 'bg-primary-600' : '' }}">Kalender Akademik</a>
                                <a href="{{ route('news.index') }}" class="text-white hover:text-primary-200 block px-6 py-1.5 rounded-md text-sm font-medium {{ request()->routeIs('news.*') ? 'bg-primary-600' : '' }}">Berita & Pengumuman</a>
                            </div>
                        </div>
                        
                        <!-- Media Section -->
                        <div class="space-y-1">
                            <button onclick="toggleMobileDropdown('media')" class="w-full text-left text-primary-200 text-sm font-semibold px-4 py-1 flex items-center justify-between">
                                Media
                                <svg id="media-arrow" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="media-dropdown" class="hidden ml-4 space-y-1">
                                <a href="{{ route('gallery.index') }}" class="text-white hover:text-primary-200 block px-6 py-1.5 rounded-md text-sm font-medium {{ request()->routeIs('gallery.*') ? 'bg-primary-600' : '' }}">Galeri Foto</a>
                                <a href="{{ route('documents.index') }}" class="text-white hover:text-primary-200 block px-6 py-1.5 rounded-md text-sm font-medium {{ request()->routeIs('documents.*') ? 'bg-primary-600' : '' }}">Download Center</a>
                            </div>
                        </div>
                        
                        <a href="{{ route('contact') }}" class="text-white hover:text-primary-200 block px-4 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'bg-primary-600' : '' }}">Kontak</a>
                        
                        <!-- Auth Section -->
                        <div class="border-t border-primary-500 pt-2 mt-2">
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="bg-primary-700 hover:bg-primary-800 text-white block px-4 py-2 rounded-md text-base font-medium mb-2">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Admin Dashboard
                                    </a>
                                @elseif(auth()->user()->role === 'teacher')
                                    <a href="{{ route('teacher.dashboard') }}" class="bg-primary-700 hover:bg-primary-800 text-white block px-4 py-2 rounded-md text-base font-medium mb-2">
                                        <i class="fas fa-chalkboard-teacher mr-2"></i>Dashboard Guru
                                    </a>
                                @elseif(auth()->user()->role === 'student')
                                    <a href="{{ route('student.dashboard') }}" class="bg-primary-700 hover:bg-primary-800 text-white block px-4 py-2 rounded-md text-base font-medium mb-2">
                                        <i class="fas fa-user-graduate mr-2"></i>Dashboard Siswa
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="text-white hover:text-primary-200 w-full text-left px-4 py-2 rounded-md text-base font-medium">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-white hover:text-primary-200 block px-4 py-2 rounded-md text-base font-medium mb-2">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                                </a>
                                <a href="{{ route('register') }}" class="bg-white text-primary-600 hover:bg-primary-50 block px-4 py-2 rounded-md text-base font-medium">
                                    <i class="fas fa-user-plus mr-2"></i>Daftar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-primary-600 text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- School Info -->
                    <div>
                        <div class="flex items-center mb-4">
                            <img src="{{ asset('logo.png') }}" alt="Logo SMP Negeri 01 Namrole" class="h-10 w-auto mr-3">
                            <h3 class="text-lg font-semibold">SMP Negeri 01 Namrole</h3>
                        </div>
                        <p class="text-primary-100 text-sm leading-relaxed">
                            Sekolah Menengah Pertama yang berkomitmen untuk memberikan pendidikan berkualitas 
                            dan membentuk karakter siswa yang unggul.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Menu Cepat</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-primary-100 hover:text-white transition-colors">Beranda</a></li>
                            <li><a href="{{ route('profil') }}" class="text-primary-100 hover:text-white transition-colors">Profil Sekolah</a></li>
                            <li><a href="#" class="text-primary-100 hover:text-white transition-colors">Visi & Misi</a></li>
                            <li><a href="#" class="text-primary-100 hover:text-white transition-colors">Struktur Organisasi</a></li>
                            <li><a href="#" class="text-primary-100 hover:text-white transition-colors">Prestasi</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Kontak Kami</h3>
                        <div class="space-y-2 text-sm">
                            <p class="text-primary-100">
                                <span class="font-medium">Alamat:</span><br>
                                Jl. Pendidikan No. 123<br>
                                Namrole, Maluku Tengah
                            </p>
                            <p class="text-primary-100">
                                <span class="font-medium">Telepon:</span> (0911) 123456
                            </p>
                            <p class="text-primary-100">
                                <span class="font-medium">Email:</span> smp01namrole@email.com
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-primary-500 mt-8 pt-8 text-center">
                    <p class="text-primary-100 text-sm">
                        &copy; {{ date('Y') }} SMP Negeri 01 Namrole. Semua hak dilindungi.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Mobile Menu Script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Mobile dropdown toggle function
        window.toggleMobileDropdown = function(dropdownId) {
            const dropdown = document.getElementById(dropdownId + '-dropdown');
            const arrow = document.getElementById(dropdownId + '-arrow');
            
            dropdown.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        };

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        let lastScrollTop = 0;
        const header = document.querySelector('header');
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                header.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                header.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        });
    </script>
</body>
</html>
