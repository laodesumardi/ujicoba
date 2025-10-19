<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SMP Negeri 01 Namrole') }} - @yield('title', 'Admin Dashboard')</title>

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

        /* Content persistent dropdown styling */
        .content-persistent {
            background-color: rgba(59, 130, 246, 0.1) !important;
            border-left: 3px solid #3b82f6 !important;
        }

        .content-persistent .content-arrow {
            color: #3b82f6 !important;
        }

        /* Sidebar scrollbar styling */
        #sidebar {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }

        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
            transition: background 0.2s ease;
        }

        #sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Smooth scrolling for sidebar */
        #sidebar {
            scroll-behavior: smooth;
        }

        /* Notification dropdown positioning and scrolling */
        #notification-dropdown {
            max-height: 400px; /* Fixed height for 3 notifications */
            top: 100%;
            right: 0;
            transform: translateY(8px);
        }

        /* Notification list scrolling - only scroll if more than 3 items */
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
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="fixed lg:sticky lg:top-0 inset-y-0 left-0 z-50 w-64 bg-primary-600 text-white flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:h-screen overflow-y-auto">
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

                <a href="{{ route('admin.messages.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.messages.*') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Pesan Masuk
                    @php
                        $unreadCount = \App\Models\Message::unread()->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $unreadCount }}</span>
                    @endif
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

                <a href="{{ route('admin.contact.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.contact.*') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Kelola Kontak
                </a>

                <a href="{{ route('admin.social-media.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.social-media.*') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 110 2h-1v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6H4a1 1 0 110-2h3zM9 6v10h6V6H9z"></path>
                    </svg>
                    Sosial Media
                </a>

                <a href="{{ route('admin.user-management.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.user-management.*') ? 'bg-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Manajemen User
                </a>


                <!-- Content Dropdown Menu -->
                <div class="space-y-1">
                    <button onclick="toggleContentDropdown()" class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.news.*', 'admin.academic-calendar.*', 'admin.gallery.*', 'admin.documents.*', 'admin.teachers.*', 'admin.achievements.*', 'admin.subjects.*', 'admin.libraries.*', 'admin.vision-missions.*') ? 'bg-primary-500' : '' }}">
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
                        
                        <a href="{{ route('admin.headmaster-greetings.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.headmaster-greetings.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm">Sambutan Kepala Sekolah</span>
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
                        
                        <a href="{{ route('admin.accreditations.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.accreditations.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">Akreditasi</span>
                        </a>
                        
                        <a href="{{ route('admin.facilities.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.facilities.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-sm">Fasilitas</span>
                        </a>
                        
                        <a href="{{ route('admin.subjects.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.subjects.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm">Mata Pelajaran</span>
                        </a>
                        
                        <a href="{{ route('admin.libraries.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.libraries.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm">Perpustakaan</span>
                        </a>
                        
                        <a href="{{ route('admin.vision-missions.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-primary-500 transition-colors {{ request()->routeIs('admin.vision-missions.*') ? 'bg-primary-500' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span class="text-sm">Visi & Misi</span>
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
                            
                            <!-- Notifications -->
                            <div class="relative">
                                <button onclick="toggleNotificationDropdown()" class="relative p-3 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors border border-gray-200 hover:border-gray-300">
                                    <!-- Bell Icon -->
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C13.1 2 14 2.9 14 4C14 4.1 14 4.2 14 4.3C16.2 4.9 17.5 6.8 17.5 9V10.5C17.5 11.2 17.7 11.8 18 12.3L19.5 15.5C19.7 15.9 19.5 16.4 19.1 16.6C18.7 16.8 18.2 16.6 18 16.2L16.5 13C16.2 12.4 16 11.7 16 11V9C16 7.3 14.7 6 13 6C12.7 6 12.4 5.9 12.1 5.8C11.4 5.5 10.6 5.5 9.9 5.8C9.6 5.9 9.3 6 9 6C7.3 6 6 7.3 6 9V11C6 11.7 5.8 12.4 5.5 13L4 16.2C3.8 16.6 3.3 16.8 2.9 16.6C2.5 16.4 2.3 15.9 2.5 15.5L4 12.3C4.3 11.8 4.5 11.2 4.5 10.5V9C4.5 6.8 5.8 4.9 8 4.3C8 4.2 8 4.1 8 4C8 2.9 8.9 2 10 2H12ZM12 4H10C9.4 4 9 4.4 9 5C9 5.6 9.4 6 10 6H12C12.6 6 13 5.6 13 5C13 4.4 12.6 4 12 4ZM12 20C13.7 20 15 18.7 15 17H9C9 18.7 10.3 20 12 20Z"/>
                                    </svg>
                                    <!-- Notification Badge -->
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
                                            <button onclick="clearAllNotifications()" class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors">Hapus</button>
                                        </div>
                                    </div>
                                    <div id="notification-list" class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 hover:scrollbar-thumb-gray-400">
                                        <!-- Notifications will be loaded here -->
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
                if (contentDropdown.classList.contains('hidden')) {
                    // Open dropdown
                    contentDropdown.classList.remove('hidden');
                    contentArrow.classList.add('rotate-180');
                    contentDropdown.classList.add('content-persistent');
                } else {
                    // Close dropdown
                    contentDropdown.classList.add('hidden');
                    contentArrow.classList.remove('rotate-180');
                    contentDropdown.classList.remove('content-persistent');
                }
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
                
                // Don't close Content dropdown if it's persistent
                if (contentDropdown && !contentDropdown.classList.contains('content-persistent')) {
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
                    // Check if it's a Content dropdown link
                    const contentDropdown = document.getElementById('content-dropdown');
                    const isContentLink = clickedLink.closest('#content-dropdown');
                    
                    if (isContentLink && contentDropdown) {
                        // Keep Content dropdown open after clicking link
                        contentDropdown.classList.remove('hidden');
                        contentDropdown.classList.add('content-persistent');
                        const contentArrow = document.getElementById('content-arrow');
                        contentArrow.classList.add('rotate-180');
                        
                        // Close PPDB dropdown if open
                        const ppdbDropdown = document.getElementById('ppdb-dropdown');
                        const ppdbArrow = document.getElementById('ppdb-arrow');
                        if (ppdbDropdown) {
                            ppdbDropdown.classList.add('hidden');
                            ppdbArrow.classList.remove('rotate-180');
                        }
                    } else {
                        // Normal behavior for other dropdowns
                        setTimeout(() => {
                            closeAllSidebarDropdowns();
                        }, 100);
                    }
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

        function adjustNotificationPosition() {
            const dropdown = document.getElementById('notification-dropdown');
            const rect = dropdown.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            
            // Check if dropdown goes below viewport
            if (rect.bottom > viewportHeight - 20) {
                // Position dropdown above the button
                dropdown.style.top = 'auto';
                dropdown.style.bottom = '100%';
                dropdown.style.transform = 'translateY(-8px)';
            } else {
                // Normal position below the button
                dropdown.style.top = '100%';
                dropdown.style.bottom = 'auto';
                dropdown.style.transform = 'translateY(8px)';
            }
        }

        function loadNotifications() {
            fetch('{{ route("admin.notifications.index") }}')
                .then(response => response.json())
                .then(data => {
                    updateNotificationBadge(data.unread_count);
                    // Limit to 3 notifications for initial display
                    const limitedNotifications = data.notifications.slice(0, 3);
                    renderNotifications(limitedNotifications);
                    
                    // Auto scroll to top after rendering
                    setTimeout(() => {
                        const container = document.getElementById('notification-list');
                        if (container) {
                            container.scrollTop = 0;
                        }
                    }, 50);
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                });
        }

        function updateNotificationBadge(count) {
            const badge = document.getElementById('notification-badge');
            if (count > 0) {
                badge.textContent = count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        function renderNotifications(notifications) {
            const container = document.getElementById('notification-list');
            
            if (notifications.length === 0) {
                container.innerHTML = `
                    <div class="p-4 text-center text-gray-500">
                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L19.5 4.5M15 3h5v5M4.5 4.5L19.5 19.5"></path>
                        </svg>
                        <p>Tidak ada notifikasi</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = notifications.map(notification => `
                <div class="notification-item p-4 border-b border-gray-100 hover:bg-gray-50 transition-all duration-200 ${notification.is_read ? 'opacity-60' : 'bg-blue-50 border-l-4 border-l-blue-400'}">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full ${notification.color_class} flex items-center justify-center shadow-sm">
                                <i class="${notification.icon_class} text-sm"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">${notification.title}</p>
                                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">${notification.message}</p>
                                    ${notification.action_url ? `
                                        <div class="mt-3">
                                            <a href="${notification.action_url}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                                ${notification.action_text || 'Lihat Detail'}
                                            </a>
                                        </div>
                                    ` : ''}
                                </div>
                                <div class="flex flex-col items-end space-y-1">
                                    <span class="text-xs text-gray-500 font-medium">${formatTime(notification.created_at)}</span>
                                    <button onclick="markNotificationAsRead(${notification.id})" class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function markNotificationAsRead(notificationId) {
            fetch(`{{ url('admin/notifications') }}/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }

        function markAllAsRead() {
            fetch('{{ route("admin.notifications.mark-all-as-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            })
            .catch(error => {
                console.error('Error marking all as read:', error);
            });
        }

        function clearAllNotifications() {
            if (confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')) {
                fetch('{{ route("admin.notifications.clear-all") }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadNotifications();
                    }
                })
                .catch(error => {
                    console.error('Error clearing notifications:', error);
                });
            }
        }

        function formatTime(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = now - date;
            
            if (diff < 60000) { // Less than 1 minute
                return 'Baru saja';
            } else if (diff < 3600000) { // Less than 1 hour
                const minutes = Math.floor(diff / 60000);
                return `${minutes} menit yang lalu`;
            } else if (diff < 86400000) { // Less than 1 day
                const hours = Math.floor(diff / 3600000);
                return `${hours} jam yang lalu`;
            } else {
                return date.toLocaleDateString('id-ID');
            }
        }

        // Load notifications on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications();
            
            // Refresh notifications every 30 seconds
            setInterval(loadNotifications, 30000);
        });

        // Adjust notification position on window resize
        window.addEventListener('resize', function() {
            const dropdown = document.getElementById('notification-dropdown');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                adjustNotificationPosition();
            }
        });

        // Close notification dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const notificationDropdown = document.getElementById('notification-dropdown');
            const notificationButton = event.target.closest('[onclick="toggleNotificationDropdown()"]');
            
            if (!notificationButton && !event.target.closest('#notification-dropdown')) {
                notificationDropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
