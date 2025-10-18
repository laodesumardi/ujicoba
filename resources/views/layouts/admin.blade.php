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
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Smooth dropdown transitions */
        #content-dropdown, #ppdb-dropdown {
            transition: all 0.2s ease-in-out;
        }
        
        /* Arrow rotation transition */
        #content-arrow, #ppdb-arrow {
            transition: transform 0.2s ease-in-out;
        }
    </style>
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


                <!-- Content Dropdown Menu -->
                <div class="space-y-1">
                    <button onclick="toggleContentDropdown()" class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.news.*', 'admin.academic-calendar.*', 'admin.gallery.*', 'admin.documents.*', 'admin.teachers.*', 'admin.achievements.*', 'admin.subjects.*') ? 'bg-primary-500' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            <span class="font-medium">Content</span>
                        </div>
                        <svg id="content-arrow" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Content Dropdown Content -->
                    <div id="content-dropdown" class="hidden ml-4 space-y-1">
                        <a href="{{ route('admin.news.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.news.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            <span class="text-sm">Berita & Pengumuman</span>
                        </a>
                        
                        <a href="{{ route('admin.academic-calendar.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.academic-calendar.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm">Kalender Akademik</span>
                        </a>
                        
                        <a href="{{ route('admin.gallery.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.gallery.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm">Galeri Foto & Video</span>
                        </a>
                        
                        <a href="{{ route('admin.documents.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.documents.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm">Download Center</span>
                        </a>
                        
                        <a href="{{ route('admin.teachers.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.teachers.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span class="text-sm">Data Guru</span>
                        </a>
                        
                        <a href="{{ route('admin.achievements.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.achievements.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <span class="text-sm">Prestasi</span>
                        </a>
                        
                        <a href="{{ route('admin.subjects.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.subjects.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm">Mata Pelajaran</span>
                        </a>
                    </div>
                </div>

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
                            
                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button onclick="toggleProfileDropdown()" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="text-left hidden sm:block">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">Administrator</p>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Profile Dropdown Menu -->
                                <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Profile Settings
                                    </a>
                                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        View Website
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            // Content Management Dropdown toggle
            window.toggleContentDropdown = function() {
                const contentDropdown = document.getElementById('content-dropdown');
                const contentArrow = document.getElementById('content-arrow');
                const ppdbDropdown = document.getElementById('ppdb-dropdown');
                const ppdbArrow = document.getElementById('ppdb-arrow');
                
                // Close PPDB dropdown if open
                if (ppdbDropdown && !ppdbDropdown.classList.contains('hidden')) {
                    ppdbDropdown.classList.add('hidden');
                    ppdbArrow.classList.remove('rotate-180');
                }
                
                // Toggle Content dropdown
                contentDropdown.classList.toggle('hidden');
                contentArrow.classList.toggle('rotate-180');
            };

            // PPDB Dropdown toggle
            window.togglePPDBDropdown = function() {
                const ppdbDropdown = document.getElementById('ppdb-dropdown');
                const ppdbArrow = document.getElementById('ppdb-arrow');
                const contentDropdown = document.getElementById('content-dropdown');
                const contentArrow = document.getElementById('content-arrow');
                
                // Close Content dropdown if open
                if (contentDropdown && !contentDropdown.classList.contains('hidden')) {
                    contentDropdown.classList.add('hidden');
                    contentArrow.classList.remove('rotate-180');
                }
                
                // Toggle PPDB dropdown
                ppdbDropdown.classList.toggle('hidden');
                ppdbArrow.classList.toggle('rotate-180');
            };

            // Auto-open dropdowns based on current page (only one at a time)
            const isContentPage = {{ request()->routeIs('admin.news.*', 'admin.academic-calendar.*', 'admin.gallery.*', 'admin.documents.*', 'admin.teachers.*', 'admin.achievements.*', 'admin.subjects.*') ? 'true' : 'false' }};
            const isPPDBPage = {{ request()->routeIs('admin.ppdb.*') || request()->routeIs('admin.ppdb-registrations.*') || request()->routeIs('admin.ppdb-export.*') ? 'true' : 'false' }};
            
            // Only auto-open if user is on a page within the dropdown
            if (isContentPage) {
                const contentDropdown = document.getElementById('content-dropdown');
                const contentArrow = document.getElementById('content-arrow');
                
                // Close PPDB dropdown first
                const ppdbDropdown = document.getElementById('ppdb-dropdown');
                const ppdbArrow = document.getElementById('ppdb-arrow');
                if (ppdbDropdown) {
                    ppdbDropdown.classList.add('hidden');
                    ppdbArrow.classList.remove('rotate-180');
                }
                
                // Open Content dropdown
                contentDropdown.classList.remove('hidden');
                contentArrow.classList.add('rotate-180');
            } else if (isPPDBPage) {
                const ppdbDropdown = document.getElementById('ppdb-dropdown');
                const ppdbArrow = document.getElementById('ppdb-arrow');
                
                // Close Content dropdown first
                const contentDropdown = document.getElementById('content-dropdown');
                const contentArrow = document.getElementById('content-arrow');
                if (contentDropdown) {
                    contentDropdown.classList.add('hidden');
                    contentArrow.classList.remove('rotate-180');
                }
                
                // Open PPDB dropdown
                ppdbDropdown.classList.remove('hidden');
                ppdbArrow.classList.add('rotate-180');
            }

            // Function to close all sidebar dropdowns
            function closeAllSidebarDropdowns() {
                const contentDropdown = document.getElementById('content-dropdown');
                const contentArrow = document.getElementById('content-arrow');
                const ppdbDropdown = document.getElementById('ppdb-dropdown');
                const ppdbArrow = document.getElementById('ppdb-arrow');
                
                if (contentDropdown) {
                    contentDropdown.classList.add('hidden');
                    contentArrow.classList.remove('rotate-180');
                }
                if (ppdbDropdown) {
                    ppdbDropdown.classList.add('hidden');
                    ppdbArrow.classList.remove('rotate-180');
                }
            }

            // Profile Dropdown toggle
            window.toggleProfileDropdown = function() {
                const dropdown = document.getElementById('profile-dropdown');
                dropdown.classList.toggle('hidden');
            }

            // Auto-collapse dropdowns when clicking on links
            document.addEventListener('click', function(event) {
                // Check if clicked element is a link inside dropdown
                const clickedLink = event.target.closest('a[href]');
                if (clickedLink) {
                    // Add small delay for smooth transition
                    setTimeout(() => {
                        closeAllSidebarDropdowns();
                    }, 100);
                }
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                const profileDropdown = document.getElementById('profile-dropdown');
                const profileButton = event.target.closest('[onclick="toggleProfileDropdown()"]');
                const contentButton = event.target.closest('[onclick="toggleContentDropdown()"]');
                const ppdbButton = event.target.closest('[onclick="togglePPDBDropdown()"]');
                
                // Close profile dropdown if clicking outside
                if (!profileButton && profileDropdown && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
                
                // Close sidebar dropdowns if clicking outside sidebar
                if (!contentButton && !ppdbButton && !event.target.closest('#sidebar')) {
                    closeAllSidebarDropdowns();
                }
            });
        });
    </script>
</body>
</html>
