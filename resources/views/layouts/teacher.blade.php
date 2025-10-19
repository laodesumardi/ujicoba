@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SMP Negeri 01 Namrole') }} - @yield('title', 'Teacher Dashboard')</title>

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
            <div class="p-4 sm:p-6 border-b border-primary-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto mr-3">
                        <div>
                            <h2 class="text-lg font-bold">Teacher Panel</h2>
                            <p class="text-xs text-primary-200">SMP Negeri 01 Namrole</p>
                        </div>
                    </div>
                    <!-- Close button for mobile -->
                    <button class="lg:hidden text-primary-200 hover:text-white p-2 rounded-lg hover:bg-primary-500 transition-colors" onclick="closeSidebar()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 px-3 sm:px-4 py-4 sm:py-6 space-y-1 sm:space-y-2 overflow-y-auto">
                <a href="{{ route('teacher.dashboard') }}" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-primary-500 transition-colors text-sm sm:text-base {{ request()->routeIs('teacher.dashboard') ? 'bg-primary-500' : '' }}" onclick="closeSidebar()">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    <span class="truncate">Dashboard</span>
                </a>

                <a href="{{ route('teacher.courses.index') }}" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-primary-500 transition-colors text-sm sm:text-base {{ request()->routeIs('teacher.courses.*') ? 'bg-primary-500' : '' }}" onclick="closeSidebar()">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="truncate">Kelas Saya</span>
                </a>

                <a href="{{ route('teacher.courses.create') }}" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-primary-500 transition-colors text-sm sm:text-base {{ request()->routeIs('teacher.courses.create') ? 'bg-primary-500' : '' }}" onclick="closeSidebar()">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="truncate">Buat Kelas Baru</span>
                </a>

                <a href="{{ route('teacher.assignments.overview') }}" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-primary-500 transition-colors text-sm sm:text-base {{ request()->routeIs('teacher.assignments.*') ? 'bg-primary-500' : '' }}" onclick="closeSidebar()">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="truncate">Tugas & Penilaian</span>
                </a>

                <a href="{{ route('teacher.courses.index') }}?tab=forums" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-primary-500 transition-colors text-sm sm:text-base" onclick="closeSidebar()">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-2-2V10a2 2 0 012-2h2m3-4h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-2-2V6a2 2 0 012-2h2"></path>
                    </svg>
                    <span class="truncate">Forum Diskusi</span>
                </a>

                <a href="{{ route('teacher.dashboard') }}#statistics" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-primary-500 transition-colors text-sm sm:text-base" onclick="closeSidebar()">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="truncate">Laporan & Statistik</span>
                </a>

                <div class="border-t border-primary-500 pt-3 sm:pt-4 mt-3 sm:mt-4">
                    <a href="{{ route('home') }}" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-primary-500 transition-colors text-sm sm:text-base" onclick="closeSidebar()">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="truncate">Kembali ke Website</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 sm:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <button id="mobile-menu-button" class="lg:hidden text-gray-600 hover:text-gray-900 mr-4 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">@yield('page-title', 'Teacher Dashboard')</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500 hidden sm:block">{{ now()->format('d M Y, H:i') }}</span>
                            
                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button onclick="toggleProfileDropdown()" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                                    @if(auth()->user()->photo)
                                        <img src="{{ Storage::url(auth()->user()->photo) }}" 
                                             alt="{{ auth()->user()->name }}" 
                                             class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm">
                                    @else
                                        <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="text-left hidden sm:block">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->subject ?? 'Guru' }}</p>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Profile Dropdown Menu -->
                                <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <div class="flex items-center space-x-3">
                                            @if(auth()->user()->photo)
                                                <img src="{{ Storage::url(auth()->user()->photo) }}" 
                                                     alt="{{ auth()->user()->name }}" 
                                                     class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                                            @else
                                                <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center">
                                                    <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                                <p class="text-xs text-primary-600">{{ auth()->user()->subject ?? 'Guru' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('teacher.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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

            function openSidebar() {
                if (sidebar) {
                    sidebar.classList.remove('-translate-x-full');
                }
                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove('hidden');
                }
                document.body.classList.add('overflow-hidden');
            }

            function closeSidebar() {
                if (sidebar) {
                    sidebar.classList.add('-translate-x-full');
                }
                if (sidebarOverlay) {
                    sidebarOverlay.classList.add('hidden');
                }
                document.body.classList.remove('overflow-hidden');
            }

            function toggleSidebar() {
                if (sidebar && sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            }

            // Make functions globally available
            window.toggleSidebar = toggleSidebar;
            window.openSidebar = openSidebar;
            window.closeSidebar = closeSidebar;

            // Mobile menu button click
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Overlay click
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeSidebar();
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 1024) {
                    const isClickInsideSidebar = sidebar && sidebar.contains(event.target);
                    const isClickOnMobileMenuButton = mobileMenuButton && mobileMenuButton.contains(event.target);
                    
                    if (!isClickInsideSidebar && !isClickOnMobileMenuButton) {
                        closeSidebar();
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });

            // Profile Dropdown toggle
            window.toggleProfileDropdown = function() {
                const dropdown = document.getElementById('profile-dropdown');
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                }
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                const profileDropdown = document.getElementById('profile-dropdown');
                const profileButton = event.target.closest('[onclick="toggleProfileDropdown()"]');
                
                if (!profileButton && profileDropdown && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });

            // Prevent sidebar from closing when clicking inside it
            if (sidebar) {
                sidebar.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }
        });
    </script>
</body>
</html>
