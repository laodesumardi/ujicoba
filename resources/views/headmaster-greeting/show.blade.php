@extends('layouts.app')

@section('title', 'Sambutan Kepala Sekolah')
@section('page-title', 'Sambutan Kepala Sekolah')
@section('page-description', 'Sambutan dari Kepala SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-4 sm:px-6 py-6 sm:py-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl sm:text-3xl font-bold">Sambutan Kepala Sekolah</h1>
                    <p class="text-primary-100 mt-2 text-sm sm:text-base">Sambutan dari Kepala SMP Negeri 01 Namrole</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <a href="{{ route('home') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg font-semibold transition-colors flex items-center justify-center text-sm sm:text-base">
                        <i class="fas fa-home mr-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">Sambutan Kepala Sekolah</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Headmaster Profile Header -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-8 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row items-center lg:items-start space-y-6 lg:space-y-0 lg:space-x-8">
                    <!-- Headmaster Photo -->
                    <div class="flex-shrink-0">
                        <div class="relative">
                            @if($headmasterGreeting->photo)
                                <img src="{{ $headmasterGreeting->photo_url }}" 
                                     alt="Foto {{ $headmasterGreeting->headmaster_name }}" 
                                     class="w-32 h-32 lg:w-40 lg:h-40 rounded-full object-cover border-4 border-white shadow-xl"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            @endif
                            <div class="w-32 h-32 lg:w-40 lg:h-40 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center shadow-xl {{ $headmasterGreeting->photo ? 'hidden' : 'flex' }}">
                                <span class="text-white font-bold text-3xl lg:text-4xl">{{ substr($headmasterGreeting->headmaster_name, 0, 1) }}</span>
                            </div>
                            <!-- Status Badge -->
                            <div class="absolute -bottom-2 -right-2 bg-primary-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                <i class="fas fa-crown mr-1"></i>Kepala Sekolah
                            </div>
                        </div>
                    </div>
                    
                    <!-- Headmaster Info -->
                    <div class="flex-1 text-center lg:text-left">
                        <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">{{ $headmasterGreeting->headmaster_name }}</h2>
                        <p class="text-lg text-primary-600 font-semibold mb-3">Kepala Sekolah</p>
                        <p class="text-gray-600 text-sm lg:text-base leading-relaxed">
                            Kepala Sekolah SMP Negeri 01 Namrole yang berdedikasi tinggi dalam memajukan pendidikan dan membentuk karakter siswa yang unggul.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Greeting Content -->
            <div class="px-6 py-8">
                <div class="prose prose-lg max-w-none">
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-6 border-l-4 border-primary-500">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-quote-left text-primary-500 mr-3"></i>
                            Sambutan Kepala Sekolah
                        </h3>
                        <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $headmasterGreeting->greeting_message }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="px-6 py-6 border-t border-gray-200 bg-gray-50">
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-primary-500 mr-3"></i>
                        Informasi Tambahan
                    </h4>
                    <div class="text-gray-700 leading-relaxed">
                        <p class="mb-4">
                            <strong>Nama Lengkap:</strong> {{ $headmasterGreeting->headmaster_name }}
                        </p>
                        <p class="mb-4">
                            <strong>Jabatan:</strong> Kepala Sekolah SMP Negeri 01 Namrole
                        </p>
                        <p class="mb-4">
                            <strong>Status:</strong> 
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Links -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tautan Terkait</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('profil') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="bg-primary-100 rounded-full p-2">
                            <i class="fas fa-school text-primary-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Profil Sekolah</h4>
                            <p class="text-sm text-gray-600">Pelajari lebih lanjut tentang sekolah kami</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('staff') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="bg-green-100 rounded-full p-2">
                            <i class="fas fa-chalkboard-teacher text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Tenaga Pendidik</h4>
                            <p class="text-sm text-gray-600">Kenali tim pengajar kami</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('contact.index') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-100 rounded-full p-2">
                            <i class="fas fa-phone text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Kontak Kami</h4>
                            <p class="text-sm text-gray-600">Hubungi kami untuk informasi lebih lanjut</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
