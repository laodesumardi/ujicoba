<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SMP Negeri 01 Namrole') }} - @yield('title', 'Dashboard Panitia PPDB')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet" />
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom scrollbar */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Custom scrollbar for notifications */
        #notification-list {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        #notification-list::-webkit-scrollbar {
            width: 6px;
        }

        #notification-list::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 3px;
        }

        #notification-list::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
            transition: background 0.2s ease;
        }

        #notification-list::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Smooth scrolling */
        #notification-list {
            scroll-behavior: smooth;
        }

        /* Notification item hover effects */
        .notification-item {
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            transform: translateX(2px);
        }

        /* Notification dropdown positioning and scrolling */
        #notification-dropdown {
            max-height: 400px; /* Fixed height for 3 notifications */
            top: 100%;
            right: 0;
            transform: translateY(8px);
        }

        #notification-list {
            max-height: 300px; /* Fixed height for 3 notifications */
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        #notification-list::-webkit-scrollbar {
            width: 6px;
        }

        #notification-list::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 3px;
        }

        #notification-list::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
            transition: background 0.2s ease;
        }

        #notification-list::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Responsive notification dropdown */
        @media (max-height: 600px) {
            #notification-dropdown {
                max-height: 350px;
            }
            
            #notification-list {
                max-height: 250px;
            }
        }

        @media (max-height: 400px) {
            #notification-dropdown {
                max-height: 300px;
            }
            
            #notification-list {
                max-height: 200px;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="fixed lg:sticky lg:top-0 inset-y-0 left-0 z-50 w-64 bg-primary-600 text-white flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:h-screen overflow-y-auto">
            <!-- Logo -->
            <div class="p-6 border-b border-primary-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto mr-3">
                        <div>
                            <h2 class="text-lg font-bold">Panitia PPDB</h2>
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
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('ppdb.panitia.dashboard') }}" 
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('ppdb.panitia.dashboard') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('ppdb.panitia.index') }}" 
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('ppdb.panitia.index') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Data Pendaftaran
                </a>

                <a href="{{ route('ppdb.panitia.index', ['status' => 'pending']) }}" 
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request('status') == 'pending' ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Menunggu Verifikasi
                </a>

                <a href="{{ route('ppdb.panitia.index', ['status' => 'approved']) }}" 
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request('status') == 'approved' ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Disetujui
                </a>

                <a href="{{ route('ppdb.panitia.index', ['status' => 'rejected']) }}" 
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request('status') == 'rejected' ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Ditolak
                </a>

                <div class="border-t border-primary-500 pt-4 mt-4">
                    <a href="{{ route('ppdb.panitia.export') }}" 
                       class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Data
                    </a>
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
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-primary-200">Panitia PPDB</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-sm text-primary-200 hover:text-white transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard Panitia PPDB')</h1>
                            <p class="text-sm text-gray-500 mt-1">@yield('page-description', 'Kelola pendaftaran PPDB dengan mudah')</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button onclick="toggleNotificationDropdown()" class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                    <!-- Bell Icon -->
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C13.1 2 14 2.9 14 4C14 4.1 14 4.2 14 4.3C16.2 4.9 17.5 6.8 17.5 9V10.5C17.5 11.2 17.7 11.8 18 12.3L19.5 15.5C19.7 15.9 19.5 16.4 19.1 16.6C18.7 16.8 18.2 16.6 18 16.2L16.5 13C16.2 12.4 16 11.7 16 11V9C16 7.3 14.7 6 13 6C12.7 6 12.4 5.9 12.1 5.8C11.4 5.5 10.6 5.5 9.9 5.8C9.6 5.9 9.3 6 9 6C7.3 6 6 7.3 6 9V11C6 11.7 5.8 12.4 5.5 13L4 16.2C3.8 16.6 3.3 16.8 2.9 16.6C2.5 16.4 2.3 15.9 2.5 15.5L4 12.3C4.3 11.8 4.5 11.2 4.5 10.5V9C4.5 6.8 5.8 4.9 8 4.3C8 4.2 8 4.1 8 4C8 2.9 8.9 2 10 2H12ZM12 4H10C9.4 4 9 4.4 9 5C9 5.6 9.4 6 10 6H12C12.6 6 13 5.6 13 5C13 4.4 12.6 4 12 4ZM12 20C13.7 20 15 18.7 15 17H9C9 18.7 10.3 20 12 20Z"/>
                                    </svg>
                                    <span id="notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden font-semibold">0</span>
                                </button>
                                
                                <!-- Notification Dropdown -->
                                <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 z-50 overflow-hidden flex flex-col">
                                    <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100 flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C13.1 2 14 2.9 14 4C14 4.1 14 4.2 14 4.3C16.2 4.9 17.5 6.8 17.5 9V10.5C17.5 11.2 17.7 11.8 18 12.3L19.5 15.5C19.7 15.9 19.5 16.4 19.1 16.6C18.7 16.8 18.2 16.6 18 16.2L16.5 13C16.2 12.4 16 11.7 16 11V9C16 7.3 14.7 6 13 6C12.7 6 12.4 5.9 12.1 5.8C11.4 5.5 10.6 5.5 9.9 5.8C9.6 5.9 9.3 6 9 6C7.3 6 6 7.3 6 9V11C6 11.7 5.8 12.4 5.5 13L4 16.2C3.8 16.6 3.3 16.8 2.9 16.6C2.5 16.4 2.3 15.9 2.5 15.5L4 12.3C4.3 11.8 4.5 11.2 4.5 10.5V9C4.5 6.8 5.8 4.9 8 4.3C8 4.2 8 4.1 8 4C8 2.9 8.9 2 10 2H12ZM12 4H10C9.4 4 9 4.4 9 5C9 5.6 9.4 6 10 6H12C12.6 6 13 5.6 13 5C13 4.4 12.6 4 12 4ZM12 20C13.7 20 15 18.7 15 17H9C9 18.7 10.3 20 12 20Z"/>
                                            </svg>
                                            <h3 class="text-lg font-semibold text-gray-900">Notifikasi</h3>
                                        </div>
                                        <div class="flex space-x-1">
                                            <button onclick="markAllAsRead()" class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">Tandai Semua</button>
                                            <button onclick="clearAllNotifications()" class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">Hapus Semua</button>
                                        </div>
                                    </div>
                                    <div id="notification-list" class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 hover:scrollbar-thumb-gray-400">
                                        <!-- Loading state -->
                                        <div class="p-4 text-center text-gray-500">
                                            <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L19.5 4.5M15 3h5v5M4.5 4.5L19.5 19.5"></path>
                                            </svg>
                                            <p>Memuat notifikasi...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button onclick="toggleProfileDropdown()" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                                    <img src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                    <div class="text-left hidden sm:block">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">Panitia PPDB</p>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    <a href="{{ route('ppdb.panitia.profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-6 py-8">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                {{ session('warning') }}
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Auto-hide flash messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100, .bg-yellow-100');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);

        // Mobile sidebar functionality
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
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', toggleSidebar);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

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
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                }
            });
        });

        // Notification functions
        function toggleNotificationDropdown() {
            const dropdown = document.getElementById('notification-dropdown');
            dropdown.classList.toggle('hidden');
            
            if (!dropdown.classList.contains('hidden')) {
                loadNotifications();
                // Auto scroll to top when dropdown opens
                setTimeout(() => {
                    const container = document.getElementById('notification-list');
                    if (container) {
                        container.scrollTop = 0;
                    }
                }, 100);
                
                // Adjust position if dropdown goes off screen
                adjustNotificationPosition();
            }
        }

        function loadNotifications() {
            const container = document.getElementById('notification-list');
            
            // Simulate loading notifications
            setTimeout(() => {
                container.innerHTML = `
                    <div class="p-4 text-center text-gray-500">
                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L19.5 4.5M15 3h5v5M4.5 4.5L19.5 19.5"></path>
                        </svg>
                        <p>Tidak ada notifikasi baru</p>
                    </div>
                `;
                
                // Update badge
                const badge = document.getElementById('notification-badge');
                badge.textContent = '0';
                badge.classList.add('hidden');
            }, 500);
        }

        function markAllAsRead() {
            // Simulate marking all as read
            const badge = document.getElementById('notification-badge');
            badge.classList.add('hidden');
            
            // Show success message
            const container = document.getElementById('notification-list');
            container.innerHTML = `
                <div class="p-4 text-center text-green-600">
                    <svg class="mx-auto h-8 w-8 text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p>Semua notifikasi telah ditandai sebagai dibaca</p>
                </div>
            `;
        }

        function clearAllNotifications() {
            // Simulate clearing all notifications
            const badge = document.getElementById('notification-badge');
            badge.classList.add('hidden');
            
            // Show success message
            const container = document.getElementById('notification-list');
            container.innerHTML = `
                <div class="p-4 text-center text-gray-500">
                    <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <p>Semua notifikasi telah dihapus</p>
                </div>
            `;
        }

        function adjustNotificationPosition() {
            const dropdown = document.getElementById('notification-dropdown');
            const rect = dropdown.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            
            if (rect.bottom > viewportHeight) {
                dropdown.style.top = 'auto';
                dropdown.style.bottom = '100%';
                dropdown.style.transform = 'translateY(-8px)';
            } else {
                dropdown.style.top = '100%';
                dropdown.style.bottom = 'auto';
                dropdown.style.transform = 'translateY(8px)';
            }
        }

        // Profile dropdown functions
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const notificationButton = event.target.closest('[onclick="toggleNotificationDropdown()"]');
            const profileButton = event.target.closest('[onclick="toggleProfileDropdown()"]');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const profileDropdown = document.getElementById('profile-dropdown');
            
            // Close notification dropdown if clicking outside
            if (!notificationButton && notificationDropdown && !notificationDropdown.contains(event.target)) {
                notificationDropdown.classList.add('hidden');
            }
            
            // Close profile dropdown if clicking outside
            if (!profileButton && profileDropdown && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
