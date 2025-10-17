@extends('layouts.admin')

@section('title', 'Profil Sekolah')
@section('page-title', 'Profil Sekolah')

@section('content')
<div class="space-y-6">
    @if($schoolProfile)
        <!-- Profile Overview -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Profil Sekolah</h3>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.school-profile.edit', $schoolProfile) }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                            Edit Profil
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            Lihat Website
                        </a>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Basic Info -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Nama Sekolah</label>
                                <p class="text-gray-900">{{ $schoolProfile->school_name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tahun Berdiri</label>
                                <p class="text-gray-900">{{ $schoolProfile->established_year }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Lokasi</label>
                                <p class="text-gray-900">{{ $schoolProfile->location }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status Akreditasi</label>
                                <p class="text-gray-900">{{ $schoolProfile->accreditation_status }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Headmaster Info -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Kepala Sekolah</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Nama</label>
                                <p class="text-gray-900">{{ $schoolProfile->headmaster_name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Jabatan</label>
                                <p class="text-gray-900">{{ $schoolProfile->headmaster_position }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Pendidikan</label>
                                <p class="text-gray-900">{{ $schoolProfile->headmaster_education }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vision & Mission -->
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Visi & Misi</h4>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-primary-50 rounded-lg p-4">
                            <h5 class="font-medium text-primary-800 mb-2">Visi</h5>
                            <p class="text-primary-700">{{ $schoolProfile->vision }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h5 class="font-medium text-gray-800 mb-2">Misi</h5>
                            <p class="text-gray-700">{{ $schoolProfile->mission }}</p>
                        </div>
                    </div>
                </div>

                <!-- History -->
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Sejarah Singkat</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700">{{ $schoolProfile->history }}</p>
                    </div>
                </div>

                <!-- Accreditation Details -->
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Detail Akreditasi</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-green-50 rounded-lg p-4">
                            <label class="text-sm font-medium text-green-700">Nomor Akreditasi</label>
                            <p class="text-green-900 font-semibold">{{ $schoolProfile->accreditation_number }}</p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <label class="text-sm font-medium text-blue-700">Tahun Akreditasi</label>
                            <p class="text-blue-900 font-semibold">{{ $schoolProfile->accreditation_year }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <label class="text-sm font-medium text-purple-700">Skor</label>
                            <p class="text-purple-900 font-semibold">{{ $schoolProfile->accreditation_score }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="text-sm font-medium text-gray-500">Berlaku Hingga</label>
                        <p class="text-gray-900">{{ $schoolProfile->accreditation_valid_until }}</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- No Profile -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 text-center">
                <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Profil Sekolah</h3>
                <p class="text-gray-500 mb-4">Silakan buat profil sekolah terlebih dahulu untuk mengisi informasi sekolah.</p>
                <a href="{{ route('admin.school-profile.create') }}" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors">
                    Buat Profil Sekolah
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
