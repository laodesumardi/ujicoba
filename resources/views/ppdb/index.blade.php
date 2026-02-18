@extends('layouts.app')

@section('title', 'PPDB - Penerimaan Peserta Didik Baru')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="py-16 text-white bg-gradient-to-r from-primary-500 to-primary-600">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="mb-3 text-3xl font-bold leading-tight sm:text-4xl lg:text-5xl md:mb-4">
                    Penerimaan Peserta Didik Baru (PPDB)
                </h1>
                <p class="text-base leading-relaxed text-white sm:text-lg lg:text-xl opacity-90">
                    SMP Negeri 01 Namrole Tahun Ajaran 2025/2026
                </p>
            </div>
        </div>
    </div>

    <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @if($ppdb)
            <!-- PPDB Information -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Main Content -->
                <div class="space-y-8 lg:col-span-2">
                    <!-- Description -->
                    @if($ppdb->description)
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">Tentang PPDB.</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($ppdb->description)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Requirements -->
                    @if($ppdb->requirements)
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">Persyaratan Pendaftaran</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($ppdb->requirements)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Schedule -->
                    @if($ppdb->schedule)
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">Jadwal Penting</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($ppdb->schedule)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Technical Guide -->
                    @if($ppdb->technical_guide)
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">Petunjuk Teknis</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($ppdb->technical_guide)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- FAQ -->
                    @if($ppdb->faq)
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">Frequently Asked Questions (FAQ)</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($ppdb->faq)) !!}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Registration Status -->
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <h3 class="mb-4 text-xl font-bold text-gray-900">Status Pendaftaran</h3>
                        @if($ppdb->isRegistrationOpen())
                            <div class="flex items-center mb-4">
                                <div class="w-3 h-3 mr-3 bg-green-500 rounded-full"></div>
                                <span class="font-semibold text-green-600">Pendaftaran Dibuka</span>
                            </div>
                            <p class="mb-4 text-sm text-gray-600">
                                Periode: {{ $ppdb->registration_start ? $ppdb->registration_start->format('d M Y') : 'TBA' }} -
                                {{ $ppdb->registration_end ? $ppdb->registration_end->format('d M Y') : 'TBA' }}
                            </p>
                            @if($ppdb->quota)
                            <p class="mb-4 text-sm text-gray-600">
                                Kuota: {{ number_format($ppdb->quota) }} siswa
                            </p>
                            @endif
                            <a href="{{ route('ppdb.register') }}"
                               class="block w-full px-6 py-3 font-semibold text-center text-white transition-colors rounded-lg bg-primary-600 hover:bg-primary-700">
                                Daftar Sekarang
                            </a>
                        @else
                            <div class="flex items-center mb-4">
                                <div class="w-3 h-3 mr-3 bg-red-500 rounded-full"></div>
                                <span class="font-semibold text-red-600">Pendaftaran Ditutup</span>
                            </div>
                            <p class="text-sm text-gray-600">
                                Pendaftaran belum dibuka atau sudah ditutup.
                            </p>
                        @endif
                    </div>

                    <!-- Contact Information -->
                    @if($ppdb->contact_person || $ppdb->contact_phone || $ppdb->contact_email)
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <h3 class="mb-4 text-xl font-bold text-gray-900">Kontak Panitia</h3>
                        <div class="space-y-3">
                            @if($ppdb->contact_person)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-gray-700">{{ $ppdb->contact_person }}</span>
                            </div>
                            @endif
                            @if($ppdb->contact_phone)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <a href="tel:{{ $ppdb->contact_phone }}" class="text-primary-600 hover:text-primary-700">{{ $ppdb->contact_phone }}</a>
                            </div>
                            @endif
                            @if($ppdb->contact_email)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <a href="mailto:{{ $ppdb->contact_email }}" class="text-primary-600 hover:text-primary-700">{{ $ppdb->contact_email }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <h3 class="mb-4 text-xl font-bold text-gray-900">Aksi Cepat</h3>
                        <div class="space-y-3">
                            <a href="{{ route('ppdb.check-status') }}"
                               class="block w-full px-4 py-2 text-center text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200">
                                Cek Status Pendaftaran
                            </a>
                            @if($ppdb->registration_link)
                            <a href="{{ $ppdb->registration_link }}" target="_blank"
                               class="block w-full px-4 py-2 text-center text-blue-700 transition-colors bg-blue-100 rounded-lg hover:bg-blue-200">
                                Formulir Online
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No PPDB Information -->
            <div class="py-12 text-center">
                <div class="p-8 border border-yellow-200 rounded-lg bg-yellow-50">
                    <svg class="w-16 h-16 mx-auto mb-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h2 class="mb-2 text-2xl font-bold text-gray-900">Informasi PPDB Belum Tersedia</h2>
                    <p class="mb-6 text-gray-600">
                        Informasi Penerimaan Peserta Didik Baru (PPDB) akan segera diumumkan.
                        Silakan kembali lagi nanti atau hubungi sekolah untuk informasi lebih lanjut.
                    </p>
                    <a href="{{ route('profil') }}"
                       class="px-6 py-3 font-semibold text-white transition-colors rounded-lg bg-primary-600 hover:bg-primary-700">
                        Lihat Profil Sekolah
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
