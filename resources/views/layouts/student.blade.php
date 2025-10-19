@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SMP Negeri 01 Namrole') }} - @yield('title', 'Student Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Smooth dropdown transitions */
        #content-dropdown, #course-dropdown {
            transition: all 0.2s ease-in-out;
        }
        
        /* Arrow rotation transition */
        #content-arrow, #course-arrow {
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
                        <h2 class="text-lg font-bold">Student Portal</h2>
                        <p class="text-xs text-primary-200">SMP Negeri 01 Namrole</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('student.dashboard') ? 'bg-primary-500' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    Dashboard
                </a>

                <!-- My Courses -->
                <div class="relative">
                    <button onclick="toggleDropdown('course')" class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('student.courses.*') ? 'bg-primary-500' : '' }}">
                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap w-5 h-5 mr-3"></i>
                            Kelas Saya
                        </div>
                        <i id="course-arrow" class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div id="course-dropdown" class="hidden ml-4 mt-2 space-y-1">
                        <a href="{{ route('student.courses.index') }}" class="block px-4 py-2 text-sm rounded-lg hover:bg-primary-500 transition-colors">
                            Daftar Kelas
                        </a>
                        <a href="{{ route('student.courses.enrolled') }}" class="block px-4 py-2 text-sm rounded-lg hover:bg-primary-500 transition-colors">
                            Kelas Terdaftar
                        </a>
                    </div>
                </div>

                <!-- Assignments -->
                <div class="relative">
                    <button onclick="toggleDropdown('assignment')" class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('student.assignments.*') ? 'bg-primary-500' : '' }}">
                        <div class="flex items-center">
                            <i class="fas fa-tasks w-5 h-5 mr-3"></i>
                            Tugas & Ujian
                        </div>
                        <i id="assignment-arrow" class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div id="assignment-dropdown" class="hidden ml-4 mt-2 space-y-1">
                        <a href="{{ route('student.assignments.index') }}" class="block px-4 py-2 text-sm rounded-lg hover:bg-primary-500 transition-colors">
                            Daftar Tugas
                        </a>
                        <a href="{{ route('student.assignments.submitted') }}" class="block px-4 py-2 text-sm rounded-lg hover:bg-primary-500 transition-colors">
                            Tugas Dikumpulkan
                        </a>
                        <a href="{{ route('student.assignments.graded') }}" class="block px-4 py-2 text-sm rounded-lg hover:bg-primary-500 transition-colors">
                            Hasil Penilaian
                        </a>
                    </div>
                </div>

                <!-- Forums -->
                <a href="{{ route('student.forums.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('student.forums.*') ? 'bg-primary-500' : '' }}">
                    <i class="fas fa-comments w-5 h-5 mr-3"></i>
                    Forum Diskusi
                </a>

                <!-- Grades -->
                <a href="{{ route('student.grades.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('student.grades.*') ? 'bg-primary-500' : '' }}">
                    <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                    Nilai & Rapor
                </a>

                <!-- Profile -->
                <a href="{{ route('student.profile') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('student.profile') ? 'bg-primary-500' : '' }}">
                    <i class="fas fa-user w-5 h-5 mr-3"></i>
                    Profil Saya
                </a>

                <!-- Divider -->
                <div class="border-t border-primary-500 pt-4 mt-4">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors">
                        <i class="fas fa-home w-5 h-5 mr-3"></i>
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
                            <button class="lg:hidden text-gray-600 hover:text-gray-900 mr-4" onclick="toggleSidebar()">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Student Dashboard')</h1>
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
                                        <p class="text-xs text-gray-500">{{ auth()->user()->class_level ?? 'Siswa' }}</p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400"></i>
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
                                                <p class="text-xs text-primary-600">{{ auth()->user()->class_level ?? 'Siswa' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('student.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user w-4 h-4 mr-3"></i>
                                        Profil Saya
                                    </a>
                                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home w-4 h-4 mr-3"></i>
                                        Lihat Website
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
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
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        {{ session('warning') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            function toggleSidebar() {
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            }

            // Make functions globally available
            window.toggleSidebar = toggleSidebar;
            window.openSidebar = openSidebar;
            window.closeSidebar = closeSidebar;

            // Overlay click
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 1024) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnMobileMenuButton = event.target.closest('[onclick="toggleSidebar()"]');
                    
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
                dropdown.classList.toggle('hidden');
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                const profileDropdown = document.getElementById('profile-dropdown');
                const profileButton = event.target.closest('[onclick="toggleProfileDropdown()"]');
                
                if (!profileButton && profileDropdown && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        });

        // Dropdown toggle function
        function toggleDropdown(dropdownName) {
            const dropdown = document.getElementById(dropdownName + '-dropdown');
            const arrow = document.getElementById(dropdownName + '-arrow');
            
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                dropdown.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</body>
</html>
