<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Admin Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="fixed lg:sticky lg:top-0 inset-y-0 left-0 z-50 w-64 bg-primary-600 text-white flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:h-screen">
            <!-- Logo -->
            <div class="p-6 border-b border-primary-500">
                <div class="flex items-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto mr-3">
                    <div>
                        <h2 class="text-lg font-bold">Admin Panel</h2>
                        <p class="text-xs text-primary-200">SMP Negeri 01 Namrole</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.home-sections.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.home-sections.*') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    Home Sections
                </a>

                <a href="{{ route('admin.school-profile.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.school-profile.*') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Profil Sekolah
                </a>

                <a href="{{ route('admin.teachers.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.teachers.*') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Guru & Staff
                </a>

                <a href="{{ route('admin.achievements.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.achievements.*') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    Prestasi
                </a>

                <!-- PPDB Dropdown Menu -->
                <div class="space-y-1">
                    <button onclick="togglePPDBDropdown()" class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.ppdb.*') || request()->routeIs('admin.ppdb-registrations.*') || request()->routeIs('admin.ppdb-export.*') ? 'bg-primary-500' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span class="font-medium">PPDB</span>
                        </div>
                        <svg id="ppdb-arrow" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- PPDB Dropdown Content -->
                    <div id="ppdb-dropdown" class="hidden ml-4 space-y-1">
                        <a href="{{ route('admin.ppdb.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.ppdb.index') || request()->routeIs('admin.ppdb.create') || request()->routeIs('admin.ppdb.edit') || request()->routeIs('admin.ppdb.show') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm">Kelola Informasi PPDB</span>
                        </a>
                        
                        <a href="{{ route('admin.ppdb.registrations') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.ppdb.registrations') || request()->routeIs('admin.ppdb.show-registration') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span class="text-sm">Data Pendaftaran</span>
                        </a>
                        
                        <a href="{{ route('admin.ppdb.export') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.ppdb.export') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm">Export CSV</span>
                        </a>
                    </div>
                </div>

                <div class="border-t border-primary-500 pt-4 mt-4">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Website
                    </a>
                </div>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-primary-500">
                <div class="flex items-center">
                    <div class="bg-primary-500 rounded-full p-2 mr-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ Auth::user()?->name ?? 'Guest' }}</p>
                        <p class="text-xs text-primary-200">{{ Auth::user()?->email ?? 'guest@example.com' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-xs text-primary-200 hover:text-white transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            <button id="mobile-menu-button" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500 hidden sm:block">{{ now()->format('d M Y, H:i') }}</span>
                            <!-- Mobile user menu -->
                            <div class="lg:hidden">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-600">{{ Auth::user()?->name ?? 'Guest' }}</span>
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            // Toggle sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            }

            // Close sidebar
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }

            // Event listeners
            mobileMenuButton.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);

            // Close sidebar when clicking on navigation links (mobile)
            const navLinks = sidebar.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });

            // PPDB Dropdown toggle
            window.togglePPDBDropdown = function() {
                const dropdown = document.getElementById('ppdb-dropdown');
                const arrow = document.getElementById('ppdb-arrow');
                
                dropdown.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            };

            // Auto-open PPDB dropdown if on PPDB pages
            const isPPDBPage = {{ request()->routeIs('admin.ppdb.*') || request()->routeIs('admin.ppdb-registrations.*') || request()->routeIs('admin.ppdb-export.*') ? 'true' : 'false' }};
            
            if (isPPDBPage) {
                const dropdown = document.getElementById('ppdb-dropdown');
                const arrow = document.getElementById('ppdb-arrow');
                
                dropdown.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            }
        });
    </script>
</body>
</html>
