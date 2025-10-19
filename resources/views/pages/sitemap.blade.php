@extends('layouts.app')

@section('title', 'Peta Situs - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Peta Situs</h1>
            <p class="text-lg text-gray-600">SMP Negeri 01 Namrole</p>
            <p class="text-sm text-gray-500 mt-2">Navigasi lengkap website sekolah</p>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Halaman Utama -->
            <div class="bg-blue-50 rounded-lg p-6">
                <h2 class="text-xl font-bold text-blue-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Halaman Utama
                </h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-blue-700 hover:text-blue-900 transition-colors">Beranda</a></li>
                </ul>
            </div>

            <!-- Profil Sekolah -->
            <div class="bg-green-50 rounded-lg p-6">
                <h2 class="text-xl font-bold text-green-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-6a1 1 0 00-1-1H9a1 1 0 00-1 1v6a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"></path>
                    </svg>
                    Profil Sekolah
                </h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('profil') }}" class="text-green-700 hover:text-green-900 transition-colors">Profil Sekolah</a></li>
                    <li><a href="{{ route('staff') }}" class="text-green-700 hover:text-green-900 transition-colors">Tenaga Pendidik</a></li>
                    <li><a href="{{ route('facilities') }}" class="text-green-700 hover:text-green-900 transition-colors">Fasilitas</a></li>
                </ul>
            </div>

            <!-- PPDB -->
            <div class="bg-purple-50 rounded-lg p-6">
                <h2 class="text-xl font-bold text-purple-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    PPDB
                </h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('ppdb.index') }}" class="text-purple-700 hover:text-purple-900 transition-colors">Informasi PPDB</a></li>
                    <li><a href="{{ route('ppdb.register') }}" class="text-purple-700 hover:text-purple-900 transition-colors">Daftar Online</a></li>
                    <li><a href="{{ route('ppdb.check-status') }}" class="text-purple-700 hover:text-purple-900 transition-colors">Cek Status</a></li>
                </ul>
            </div>

            <!-- Informasi -->
            <div class="bg-orange-50 rounded-lg p-6">
                <h2 class="text-xl font-bold text-orange-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Informasi
                </h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('news.index') }}" class="text-orange-700 hover:text-orange-900 transition-colors">Berita & Pengumuman</a></li>
                    <li><a href="{{ route('academic-calendar.index') }}" class="text-orange-700 hover:text-orange-900 transition-colors">Kalender Akademik</a></li>
                    <li><a href="https://asesmen.erlanggaonline.co.id/" target="_blank" class="text-orange-700 hover:text-orange-900 transition-colors">Asesmen Online</a></li>
                </ul>
            </div>

            <!-- Media -->
            <div class="bg-pink-50 rounded-lg p-6">
                <h2 class="text-xl font-bold text-pink-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                    Media
                </h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('gallery.index') }}" class="text-pink-700 hover:text-pink-900 transition-colors">Galeri Foto</a></li>
                    <li><a href="{{ route('documents.index') }}" class="text-pink-700 hover:text-pink-900 transition-colors">Download Center</a></li>
                    <li><a href="{{ route('library') }}" class="text-pink-700 hover:text-pink-900 transition-colors">Perpustakaan</a></li>
                </ul>
            </div>

            <!-- E-Learning -->
            <div class="bg-indigo-50 rounded-lg p-6">
                <h2 class="text-xl font-bold text-indigo-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                    </svg>
                    E-Learning
                </h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('login') }}" class="text-indigo-700 hover:text-indigo-900 transition-colors">Login Siswa</a></li>
                    <li><a href="{{ route('login') }}" class="text-indigo-700 hover:text-indigo-900 transition-colors">Login Guru</a></li>
                    <li><a href="{{ route('register') }}" class="text-indigo-700 hover:text-indigo-900 transition-colors">Daftar Siswa</a></li>
                </ul>
            </div>

            <!-- Layanan Eksternal -->
            <div class="bg-teal-50 rounded-lg p-6">
                <h2 class="text-xl font-bold text-teal-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.567 1.05l-1.5 6a1 1 0 01-.567.95l-4 2a1 1 0 01-1.382-.95l1.5-6a1 1 0 01.567-.95l4-2zM4.5 5.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM3.05 13.316a1 1 0 011.05-.567l6 1.5a1 1 0 01.95.567l2 4a1 1 0 01-.95 1.382l-6-1.5a1 1 0 01-.95-.567l-2-4a1 1 0 01.95-1.382z" clip-rule="evenodd"></path>
                    </svg>
                    Layanan Eksternal
                </h2>
                <ul class="space-y-2">
                    <li><a href="https://saranaguru.erlanggaonline.co.id/user/login" target="_blank" class="text-teal-700 hover:text-teal-900 transition-colors">Sarana Guru</a></li>
                    <li><a href="https://e-library.erlanggaonline.co.id/user/TWpVMk56RT0" target="_blank" class="text-teal-700 hover:text-teal-900 transition-colors">E-Library</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div class="bg-red-50 rounded-lg p-6">
                <h2 class="text-xl font-bold text-red-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    Kontak
                </h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('contact.index') }}" class="text-red-700 hover:text-red-900 transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- Halaman Legal -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                    </svg>
                    Halaman Legal
                </h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('privacy-policy') }}" class="text-gray-700 hover:text-gray-900 transition-colors">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('terms-conditions') }}" class="text-gray-700 hover:text-gray-900 transition-colors">Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('sitemap') }}" class="text-gray-700 hover:text-gray-900 transition-colors">Peta Situs</a></li>
                </ul>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-4">
                    Peta situs ini membantu Anda menemukan semua halaman dan layanan yang tersedia di website SMP Negeri 01 Namrole.
                </p>
                <p class="text-xs text-gray-400">
                    Terakhir diperbarui: {{ date('d F Y') }} | Total halaman: 25+
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
