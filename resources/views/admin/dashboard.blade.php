@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-lg shadow-lg p-6 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Selamat Datang di Dashboard Admin</h1>
                <p class="text-primary-100">Kelola semua aspek website sekolah dengan mudah</p>
                </div>
            <div class="mt-4 sm:mt-0">
                <div class="text-right">
                    <p class="text-sm text-primary-100">Terakhir login</p>
                    <p class="font-semibold">{{ now()->format('d M Y, H:i') }}</p>
                </div>
                </div>
            </div>
        </div>

    <!-- Main Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pengguna</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalUsers }}</p>
                    <p class="text-xs text-gray-500">{{ $teachersCount }} Guru, {{ $studentsCount }} Siswa</p>
                </div>
            </div>
        </div>

        <!-- PPDB Registrations -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">PPDB</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $ppdbRegistrationsCount }}</p>
                    <p class="text-xs text-gray-500">{{ $ppdbPendingCount }} Pending</p>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <div class="flex items-center">
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pesan</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $messagesCount }}</p>
                    <p class="text-xs text-gray-500">{{ $unreadMessagesCount }} Belum dibaca</p>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <div class="flex items-center">
                <div class="bg-red-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L19.5 4.5M15 3h5v5M4.5 4.5L19.5 19.5"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Notifikasi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $notificationsCount }}</p>
                    <p class="text-xs text-gray-500">{{ $unreadNotificationsCount }} Belum dibaca</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Content Overview -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 rounded-lg p-2 mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Statistik Konten</h3>
                            <p class="text-blue-100 text-sm">Distribusi dan status konten website</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Chart Section -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-base font-semibold text-gray-800">Distribusi Konten</h4>
                        <div class="flex items-center space-x-4 text-xs">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-600 rounded mr-2"></div>
                                <span class="text-gray-600">Aktif</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-300 rounded mr-2"></div>
                                <span class="text-gray-600">Tidak Aktif</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-end justify-between h-48 space-x-3">
                            <!-- Berita -->
                            <div class="flex flex-col items-center flex-1 group">
                                <div class="w-full flex flex-col justify-end h-40 mb-3 relative">
                                    <div class="bg-blue-600 rounded-t transition-all duration-300 group-hover:bg-blue-700" 
                                         style="height: {{ $newsCount > 0 ? ($activeNews / $newsCount) * 100 : 0 }}%"></div>
                                    <div class="bg-blue-300 rounded-b transition-all duration-300 group-hover:bg-blue-400" 
                                         style="height: {{ $newsCount > 0 ? (($newsCount - $activeNews) / $newsCount) * 100 : 0 }}%"></div>
                                    <!-- Tooltip -->
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        Aktif: {{ $activeNews }} | Total: {{ $newsCount }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium text-gray-800">Berita</div>
                                    <div class="text-lg font-bold text-blue-600">{{ $newsCount }}</div>
                                </div>
                            </div>

                            <!-- Prestasi -->
                            <div class="flex flex-col items-center flex-1 group">
                                <div class="w-full flex flex-col justify-end h-40 mb-3 relative">
                                    <div class="bg-blue-600 rounded-t transition-all duration-300 group-hover:bg-blue-700" style="height: 100%"></div>
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        Total: {{ $achievementsCount }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium text-gray-800">Prestasi</div>
                                    <div class="text-lg font-bold text-blue-600">{{ $achievementsCount }}</div>
                                </div>
                            </div>

                            <!-- Fasilitas -->
                            <div class="flex flex-col items-center flex-1 group">
                                <div class="w-full flex flex-col justify-end h-40 mb-3 relative">
                                    <div class="bg-blue-600 rounded-t transition-all duration-300 group-hover:bg-blue-700" 
                                         style="height: {{ $facilitiesCount > 0 ? ($activeFacilities / $facilitiesCount) * 100 : 0 }}%"></div>
                                    <div class="bg-blue-300 rounded-b transition-all duration-300 group-hover:bg-blue-400" 
                                         style="height: {{ $facilitiesCount > 0 ? (($facilitiesCount - $activeFacilities) / $facilitiesCount) * 100 : 0 }}%"></div>
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        Aktif: {{ $activeFacilities }} | Total: {{ $facilitiesCount }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium text-gray-800">Fasilitas</div>
                                    <div class="text-lg font-bold text-blue-600">{{ $facilitiesCount }}</div>
                                </div>
                            </div>

                            <!-- Galeri -->
                            <div class="flex flex-col items-center flex-1 group">
                                <div class="w-full flex flex-col justify-end h-40 mb-3 relative">
                                    <div class="bg-blue-600 rounded-t transition-all duration-300 group-hover:bg-blue-700" style="height: 100%"></div>
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        Total: {{ $galleryCount }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium text-gray-800">Galeri</div>
                                    <div class="text-lg font-bold text-blue-600">{{ $galleryCount }}</div>
                                </div>
                            </div>

                            <!-- Staff -->
                            <div class="flex flex-col items-center flex-1 group">
                                <div class="w-full flex flex-col justify-end h-40 mb-3 relative">
                                    <div class="bg-blue-600 rounded-t transition-all duration-300 group-hover:bg-blue-700" style="height: 100%"></div>
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        Total: {{ $staffCount }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium text-gray-800">Staff</div>
                                    <div class="text-lg font-bold text-blue-600">{{ $staffCount }}</div>
                                </div>
                            </div>

                            <!-- Dokumen -->
                            <div class="flex flex-col items-center flex-1 group">
                                <div class="w-full flex flex-col justify-end h-40 mb-3 relative">
                                    <div class="bg-blue-600 rounded-t transition-all duration-300 group-hover:bg-blue-700" style="height: 100%"></div>
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        Total: {{ $documentsCount }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium text-gray-800">Dokumen</div>
                                    <div class="text-lg font-bold text-blue-600">{{ $documentsCount }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Section -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4 text-center border border-blue-200">
                            <div class="text-2xl font-bold text-blue-700 mb-1">
                                {{ $newsCount + $achievementsCount + $facilitiesCount + $galleryCount + $staffCount + $documentsCount }}
                            </div>
                            <div class="text-sm text-blue-600 font-medium">Total Konten</div>
                        </div>
                        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4 text-center border border-green-200">
                            <div class="text-2xl font-bold text-green-700 mb-1">{{ $activeNews + $activeFacilities }}</div>
                            <div class="text-sm text-green-600 font-medium">Konten Aktif</div>
                        </div>
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-4 text-center border border-gray-200">
                            <div class="text-2xl font-bold text-gray-700 mb-1">
                                {{ $newsCount + $achievementsCount + $facilitiesCount + $galleryCount + $staffCount + $documentsCount - ($activeNews + $activeFacilities) }}
                            </div>
                            <div class="text-sm text-gray-600 font-medium">Tidak Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Statistics -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Statistik Akademik</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $subjectsCount }}</div>
                        <div class="text-sm text-gray-600">Mata Pelajaran</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $assignmentsCount }}</div>
                        <div class="text-sm text-gray-600">Tugas</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $lessonsCount }}</div>
                        <div class="text-sm text-gray-600">Materi</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $coursesCount }}</div>
                        <div class="text-sm text-gray-600">Kursus</div>
                    </div>
                    <div class="text-center p-4 bg-indigo-50 rounded-lg">
                        <div class="text-2xl font-bold text-indigo-600">{{ $forumsCount }}</div>
                        <div class="text-sm text-gray-600">Forum</div>
                    </div>
                    <div class="text-center p-4 bg-pink-50 rounded-lg">
                        <div class="text-2xl font-bold text-pink-600">{{ $librariesCount }}</div>
                        <div class="text-sm text-gray-600">Perpustakaan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PPDB Status -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Status PPDB</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600">{{ $ppdbPendingCount }}</div>
                    <div class="text-sm text-gray-600">Pending</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $ppdbApprovedCount }}</div>
                    <div class="text-sm text-gray-600">Disetujui</div>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <div class="text-2xl font-bold text-red-600">{{ $ppdbRejectedCount }}</div>
                    <div class="text-sm text-gray-600">Ditolak</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Aksi Cepat</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <a href="{{ route('admin.school-profile.index') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <div class="bg-primary-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 text-sm">Profil Sekolah</h4>
                    <p class="text-xs text-gray-500">Kelola informasi</p>
                </a>

                <a href="{{ route('admin.news.index') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <div class="bg-blue-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 text-sm">Berita</h4>
                    <p class="text-xs text-gray-500">Kelola berita</p>
                </a>

                <a href="{{ route('admin.achievements.index') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <div class="bg-green-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 text-sm">Prestasi</h4>
                    <p class="text-xs text-gray-500">Kelola prestasi</p>
                </a>

                <a href="{{ route('admin.facilities.index') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <div class="bg-purple-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 text-sm">Fasilitas</h4>
                    <p class="text-xs text-gray-500">Kelola fasilitas</p>
                </a>

                <a href="{{ route('admin.ppdb.index') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <div class="bg-yellow-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 text-sm">PPDB</h4>
                    <p class="text-xs text-gray-500">Kelola pendaftaran</p>
                </a>

                <a href="{{ route('admin.messages.index') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <div class="bg-indigo-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 text-sm">Pesan</h4>
                    <p class="text-xs text-gray-500">Kelola pesan</p>
                </a>

                <a href="{{ route('admin.gallery.index') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <div class="bg-pink-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 text-sm">Galeri</h4>
                    <p class="text-xs text-gray-500">Kelola galeri</p>
                </a>

                <a href="{{ route('home') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <div class="bg-gray-100 rounded-full p-3 mb-3">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 text-sm">Website</h4>
                    <p class="text-xs text-gray-500">Lihat website</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Pengguna Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @forelse($recentUsers as $user)
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-full p-2 mr-3">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($user->role) }} • {{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Tidak ada pengguna terbaru</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent News -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Berita Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @forelse($recentNews as $news)
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-full p-2 mr-3">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ Str::limit($news->title, 30) }}</p>
                            <p class="text-xs text-gray-500">{{ $news->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Tidak ada berita terbaru</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
