@extends('layouts.app')

@section('title', 'Beranda - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-6">Selamat Datang di SMP Negeri 01 Namrole</h1>
            <p class="text-xl text-primary-100 mb-8">Sekolah Unggul Berkarakter, Berprestasi, dan Berdaya Saing Global</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('profil') }}" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-primary-50 transition-colors">
                    Lihat Profil Sekolah
                </a>
                <a href="{{ route('ppdb.index') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition-colors">
                    Informasi Pendaftaran
                </a>
                <a href="{{ route('ppdb.panitia.dashboard') }}" class="bg-yellow-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-yellow-600 transition-colors flex items-center justify-center">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Dashboard Panitia PPDB
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Info Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Guru Berkualitas</h3>
                    <p class="text-gray-600">Tenaga pendidik berpengalaman dan berkompeten</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Akreditasi A</h3>
                    <p class="text-gray-600">Sekolah terakreditasi A dengan skor 95</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Fasilitas Lengkap</h3>
                    <p class="text-gray-600">Fasilitas pembelajaran yang modern dan memadai</p>
                </div>
            </div>
        </div>
    </div>

    <!-- PPDB Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Penerimaan Peserta Didik Baru (PPDB)</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Bergabunglah dengan keluarga besar SMP Negeri 01 Namrole. Daftarkan putra-putri Anda untuk menjadi bagian dari sekolah unggul berkarakter.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Pendaftaran Online -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 text-center">
                    <div class="bg-blue-500 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-laptop text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pendaftaran Online</h3>
                    <p class="text-gray-600 mb-4">Daftar secara online dengan mudah dan praktis</p>
                    <a href="{{ route('ppdb.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Daftar Sekarang
                    </a>
                </div>

                <!-- Informasi PPDB -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 text-center">
                    <div class="bg-green-500 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-info-circle text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Informasi Lengkap</h3>
                    <p class="text-gray-600 mb-4">Pelajari syarat dan ketentuan pendaftaran</p>
                    <a href="{{ route('ppdb.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-book mr-2"></i>
                        Lihat Informasi
                    </a>
                </div>

                <!-- Dashboard Panitia -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-6 text-center">
                    <div class="bg-yellow-500 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Dashboard Panitia</h3>
                    <p class="text-gray-600 mb-4">Akses dashboard untuk mengelola pendaftaran</p>
                    <a href="{{ route('ppdb.panitia.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Masuk Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
