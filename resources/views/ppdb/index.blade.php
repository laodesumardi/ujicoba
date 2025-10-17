@extends('layouts.app')

@section('title', 'PPDB - Penerimaan Peserta Didik Baru')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4 leading-tight">
                    Penerimaan Peserta Didik Baru (PPDB)
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-white opacity-90 leading-relaxed">
                    SMP Negeri 01 Namrole Tahun Ajaran 2024/2025
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($ppdb)
            <!-- PPDB Information -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Description -->
                    @if($ppdb->description)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Tentang PPDB</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($ppdb->description)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Requirements -->
                    @if($ppdb->requirements)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Persyaratan Pendaftaran</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($ppdb->requirements)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Schedule -->
                    @if($ppdb->schedule)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Jadwal Penting</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($ppdb->schedule)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Technical Guide -->
                    @if($ppdb->technical_guide)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Petunjuk Teknis</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($ppdb->technical_guide)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- FAQ -->
                    @if($ppdb->faq)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Frequently Asked Questions (FAQ)</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($ppdb->faq)) !!}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Registration Status -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Status Pendaftaran</h3>
                        @if($ppdb->isRegistrationOpen())
                            <div class="flex items-center mb-4">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-green-600 font-semibold">Pendaftaran Dibuka</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">
                                Periode: {{ $ppdb->registration_start ? $ppdb->registration_start->format('d M Y') : 'TBA' }} - 
                                {{ $ppdb->registration_end ? $ppdb->registration_end->format('d M Y') : 'TBA' }}
                            </p>
                            @if($ppdb->quota)
                            <p class="text-sm text-gray-600 mb-4">
                                Kuota: {{ number_format($ppdb->quota) }} siswa
                            </p>
                            @endif
                            <a href="{{ route('ppdb.register') }}" 
                               class="w-full bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold text-center block hover:bg-primary-700 transition-colors">
                                Daftar Sekarang
                            </a>
                        @else
                            <div class="flex items-center mb-4">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                                <span class="text-red-600 font-semibold">Pendaftaran Ditutup</span>
                            </div>
                            <p class="text-sm text-gray-600">
                                Pendaftaran belum dibuka atau sudah ditutup.
                            </p>
                        @endif
                    </div>

                    <!-- Contact Information -->
                    @if($ppdb->contact_person || $ppdb->contact_phone || $ppdb->contact_email)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Kontak Panitia</h3>
                        <div class="space-y-3">
                            @if($ppdb->contact_person)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-gray-700">{{ $ppdb->contact_person }}</span>
                            </div>
                            @endif
                            @if($ppdb->contact_phone)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <a href="tel:{{ $ppdb->contact_phone }}" class="text-primary-600 hover:text-primary-700">{{ $ppdb->contact_phone }}</a>
                            </div>
                            @endif
                            @if($ppdb->contact_email)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <a href="mailto:{{ $ppdb->contact_email }}" class="text-primary-600 hover:text-primary-700">{{ $ppdb->contact_email }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                        <div class="space-y-3">
                            <a href="{{ route('ppdb.check-status') }}" 
                               class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-center block hover:bg-gray-200 transition-colors">
                                Cek Status Pendaftaran
                            </a>
                            @if($ppdb->registration_link)
                            <a href="{{ $ppdb->registration_link }}" target="_blank"
                               class="w-full bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-center block hover:bg-blue-200 transition-colors">
                                Formulir Online
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No PPDB Information -->
            <div class="text-center py-12">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8">
                    <svg class="w-16 h-16 text-yellow-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Informasi PPDB Belum Tersedia</h2>
                    <p class="text-gray-600 mb-6">
                        Informasi Penerimaan Peserta Didik Baru (PPDB) akan segera diumumkan. 
                        Silakan kembali lagi nanti atau hubungi sekolah untuk informasi lebih lanjut.
                    </p>
                    <a href="{{ route('profil') }}" 
                       class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors">
                        Lihat Profil Sekolah
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
