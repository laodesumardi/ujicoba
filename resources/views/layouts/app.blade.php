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
        <header class="bg-primary-500 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="{{ asset('logo.png') }}" alt="Logo SMP Negeri 01 Namrole" class="h-12 w-auto mr-4">
                        <div>
                            <h1 class="text-white text-xl font-bold">SMP NEGERI 01 NAMROLE</h1>
                            <p class="text-primary-100 text-sm">Sekolah Menengah Pertama Negeri</p>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="hidden md:flex space-x-8">
                        <a href="{{ route('home') }}" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">Beranda</a>
                        <a href="{{ route('profil') }}" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">Profil</a>
                        <a href="#" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">Akademik</a>
                        <a href="#" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">Prestasi</a>
                        <a href="#" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">Berita</a>
                        <a href="#" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">Kontak</a>
                    </nav>

                    <!-- Auth Links -->
                    <div class="hidden md:flex items-center space-x-4">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Admin Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-white text-primary-600 hover:bg-primary-50 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Daftar
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="text-white hover:text-primary-200 focus:outline-none focus:text-primary-200" id="mobile-menu-button">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-primary-600 rounded-lg mt-2">
                        <!-- Main Navigation -->
                        <a href="{{ route('home') }}" class="text-white hover:text-primary-200 block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
                        <a href="{{ route('profil') }}" class="text-white hover:text-primary-200 block px-3 py-2 rounded-md text-base font-medium">Profil</a>
                        <a href="#" class="text-white hover:text-primary-200 block px-3 py-2 rounded-md text-base font-medium">Akademik</a>
                        <a href="#" class="text-white hover:text-primary-200 block px-3 py-2 rounded-md text-base font-medium">Prestasi</a>
                        <a href="#" class="text-white hover:text-primary-200 block px-3 py-2 rounded-md text-base font-medium">Berita</a>
                        <a href="#" class="text-white hover:text-primary-200 block px-3 py-2 rounded-md text-base font-medium">Kontak</a>
                        
                        <!-- Auth Section -->
                        <div class="border-t border-primary-500 pt-2 mt-2">
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="bg-primary-700 hover:bg-primary-800 text-white block px-3 py-2 rounded-md text-base font-medium mb-2">
                                    Admin Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="text-white hover:text-primary-200 w-full text-left px-3 py-2 rounded-md text-base font-medium">
                                        Logout
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-white hover:text-primary-200 block px-3 py-2 rounded-md text-base font-medium">Login</a>
                                <a href="{{ route('register') }}" class="bg-white text-primary-600 hover:bg-primary-50 block px-3 py-2 rounded-md text-base font-medium">Daftar</a>
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
    </script>
</body>
</html>
