@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran - PPDB')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4 leading-tight">
                    Cek Status Pendaftaran
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-white opacity-90 leading-relaxed">
                    Masukkan nomor pendaftaran untuk melihat status
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Search Form -->
            <form method="POST" action="{{ route('ppdb.check-status.post') }}" class="mb-8">
                @csrf
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Cari Status Pendaftaran</h2>
                    <p class="text-gray-600">Masukkan nomor pendaftaran Anda untuk melihat status pendaftaran</p>
                </div>
                
                <div class="max-w-md mx-auto">
                    <div class="flex gap-4">
                        <input type="text" name="registration_number" id="registration_number" 
                               placeholder="Masukkan nomor pendaftaran" 
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('registration_number') border-red-500 @enderror" 
                               value="{{ old('registration_number') }}" required>
                        <button type="submit" 
                                class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors">
                            Cari
                        </button>
                    </div>
                    @error('registration_number')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </form>

            <!-- Registration Status Result -->
            @if(isset($registration))
                @if($registration)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Status Pendaftaran</h3>
                            <div class="flex items-center">
                                @if($registration->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        Menunggu Review
                                    </span>
                                @elseif($registration->status == 'approved')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        Diterima
                                    </span>
                                @elseif($registration->status == 'rejected')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Data Siswa -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Data Siswa</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Nomor Pendaftaran:</span>
                                        <p class="text-gray-900 font-semibold">{{ $registration->registration_number }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Nama Lengkap:</span>
                                        <p class="text-gray-900">{{ $registration->student_name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir:</span>
                                        <p class="text-gray-900">{{ $registration->birth_place }}, {{ $registration->birth_date->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Jenis Kelamin:</span>
                                        <p class="text-gray-900">{{ $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Agama:</span>
                                        <p class="text-gray-900">{{ $registration->religion }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Orang Tua -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Data Orang Tua</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Nama Orang Tua:</span>
                                        <p class="text-gray-900">{{ $registration->parent_name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Nomor Telepon:</span>
                                        <p class="text-gray-900">{{ $registration->parent_phone }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Pekerjaan:</span>
                                        <p class="text-gray-900">{{ $registration->parent_occupation }}</p>
                                    </div>
                                    @if($registration->previous_school)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Sekolah Asal:</span>
                                        <p class="text-gray-900">{{ $registration->previous_school }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Alamat</h4>
                            <p class="text-gray-900">{{ $registration->address }}</p>
                        </div>

                        <!-- Notes from Admin -->
                        @if($registration->notes)
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Catatan dari Panitia</h4>
                            <p class="text-gray-700">{{ $registration->notes }}</p>
                        </div>
                        @endif

                        <!-- Status Information -->
                        <div class="mt-6 p-4 rounded-lg 
                            @if($registration->status == 'pending') bg-yellow-50 border border-yellow-200
                            @elseif($registration->status == 'approved') bg-green-50 border border-green-200
                            @elseif($registration->status == 'rejected') bg-red-50 border border-red-200
                            @endif">
                            @if($registration->status == 'pending')
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-yellow-800">Pendaftaran Sedang Diproses</h4>
                                        <p class="text-sm text-yellow-700 mt-1">Pendaftaran Anda sedang dalam proses review oleh panitia. Silakan tunggu konfirmasi lebih lanjut.</p>
                                    </div>
                                </div>
                            @elseif($registration->status == 'approved')
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-green-800">Selamat! Anda Diterima</h4>
                                        <p class="text-sm text-green-700 mt-1">Pendaftaran Anda telah disetujui. Silakan hubungi panitia untuk informasi lebih lanjut.</p>
                                    </div>
                                </div>
                            @elseif($registration->status == 'rejected')
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-red-800">Pendaftaran Ditolak</h4>
                                        <p class="text-sm text-red-700 mt-1">Maaf, pendaftaran Anda tidak dapat diproses. Silakan hubungi panitia untuk informasi lebih lanjut.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
                        <svg class="w-12 h-12 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-red-800 mb-2">Data Tidak Ditemukan</h3>
                        <p class="text-red-700">Nomor pendaftaran yang Anda masukkan tidak ditemukan. Silakan periksa kembali nomor pendaftaran Anda.</p>
                    </div>
                @endif
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                <a href="{{ route('ppdb.index') }}" 
                   class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold text-center hover:bg-primary-700 transition-colors">
                    Kembali ke PPDB
                </a>
                <a href="{{ route('home') }}" 
                   class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold text-center hover:bg-gray-200 transition-colors">
                    Ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
