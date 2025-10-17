@extends('layouts.admin')

@section('title', 'Detail Acara Kalender Akademik')
@section('page-title', 'Detail Acara Kalender Akademik')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-primary-900">Detail Acara Kalender Akademik</h2>
                        <p class="text-gray-600 mt-1">{{ $academicCalendar->title }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.academic-calendar.edit', $academicCalendar) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                        <a href="{{ route('admin.academic-calendar.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Event Details -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Info -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Judul Acara</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->title }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Jenis Acara</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1" 
                                          style="background-color: {{ $academicCalendar->color }}20; color: {{ $academicCalendar->color }}">
                                        {{ $academicCalendar->type_label }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Prioritas</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1 
                                        {{ $academicCalendar->priority == 'critical' ? 'bg-red-100 text-red-800' : 
                                           ($academicCalendar->priority == 'high' ? 'bg-orange-100 text-orange-800' : 
                                           ($academicCalendar->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ $academicCalendar->priority_label }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Status</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1 
                                        {{ $academicCalendar->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $academicCalendar->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Date & Time Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tanggal & Waktu</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tanggal Mulai</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->start_date->format('d M Y') }}</p>
                                </div>
                                @if($academicCalendar->end_date)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tanggal Selesai</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->end_date->format('d M Y') }}</p>
                                </div>
                                @endif
                                @if($academicCalendar->start_time)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Waktu Mulai</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->start_time->format('H:i') }}</p>
                                </div>
                                @endif
                                @if($academicCalendar->end_time)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Waktu Selesai</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->end_time->format('H:i') }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Durasi</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->duration }} hari</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Sepanjang Hari</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->is_all_day ? 'Ya' : 'Tidak' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Location & Organizer -->
                        @if($academicCalendar->location || $academicCalendar->organizer)
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Lokasi & Penyelenggara</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($academicCalendar->location)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Lokasi</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->location }}</p>
                                </div>
                                @endif
                                @if($academicCalendar->organizer)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Penyelenggara</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->organizer }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Description -->
                        @if($academicCalendar->description)
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi</h3>
                            <p class="text-sm text-gray-900 whitespace-pre-line">{{ $academicCalendar->description }}</p>
                        </div>
                        @endif

                        <!-- Notes -->
                        @if($academicCalendar->notes)
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
                            <p class="text-sm text-gray-900 whitespace-pre-line">{{ $academicCalendar->notes }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Color Preview -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Warna Acara</h3>
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-lg border-2 border-gray-300" 
                                     style="background-color: {{ $academicCalendar->color }}"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Kode Warna</p>
                                    <p class="text-sm text-gray-500">{{ $academicCalendar->color }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Publik</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $academicCalendar->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $academicCalendar->is_public ? 'Ya' : 'Tidak' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Dapat Diunduh</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $academicCalendar->is_downloadable ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $academicCalendar->is_downloadable ? 'Ya' : 'Tidak' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Aktif</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $academicCalendar->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $academicCalendar->is_active ? 'Ya' : 'Tidak' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- File Download -->
                        @if($academicCalendar->is_downloadable && $academicCalendar->file_path)
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">File Dokumen</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nama File</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ basename($academicCalendar->file_path) }}</p>
                                </div>
                                <div>
                                    <a href="{{ $academicCalendar->file_url }}" target="_blank" 
                                       class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-md hover:bg-primary-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download File
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Timestamps -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sistem</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Dibuat</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Diperbarui</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $academicCalendar->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
