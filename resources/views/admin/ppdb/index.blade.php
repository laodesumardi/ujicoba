@extends('layouts.admin')

@section('title', 'Kelola PPDB')
@section('page-title', 'Kelola PPDB')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-primary-900">Informasi PPDB</h2>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.ppdb.registrations') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Lihat Pendaftaran
                        </a>
                        <a href="{{ route('admin.ppdb.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Tambah Informasi PPDB
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if($ppdbInfo)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $ppdbInfo->title }}</h3>
                                <p class="text-gray-600 mt-1">
                                    Status: 
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $ppdbInfo->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $ppdbInfo->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.ppdb.edit', $ppdbInfo) }}" class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                    Edit
                                </a>
                                <a href="{{ route('admin.ppdb.show', $ppdbInfo) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Lihat
                                </a>
                                <form method="POST" action="{{ route('admin.ppdb.destroy', $ppdbInfo) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium" onclick="return confirm('Apakah Anda yakin ingin menghapus informasi PPDB ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-3">Informasi Dasar</h4>
                                <div class="space-y-2">
                                    @if($ppdbInfo->description)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Deskripsi:</span>
                                        <p class="text-gray-900 text-sm">{{ Str::limit($ppdbInfo->description, 100) }}</p>
                                    </div>
                                    @endif
                                    
                                    @if($ppdbInfo->registration_start && $ppdbInfo->registration_end)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Periode Pendaftaran:</span>
                                        <p class="text-gray-900 text-sm">
                                            {{ $ppdbInfo->registration_start->format('d M Y') }} - {{ $ppdbInfo->registration_end->format('d M Y') }}
                                        </p>
                                    </div>
                                    @endif
                                    
                                    @if($ppdbInfo->quota)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Kuota:</span>
                                        <p class="text-gray-900 text-sm">{{ number_format($ppdbInfo->quota) }} siswa</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-3">Kontak Panitia</h4>
                                <div class="space-y-2">
                                    @if($ppdbInfo->contact_person)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Nama:</span>
                                        <p class="text-gray-900 text-sm">{{ $ppdbInfo->contact_person }}</p>
                                    </div>
                                    @endif
                                    
                                    @if($ppdbInfo->contact_phone)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Telepon:</span>
                                        <p class="text-gray-900 text-sm">{{ $ppdbInfo->contact_phone }}</p>
                                    </div>
                                    @endif
                                    
                                    @if($ppdbInfo->contact_email)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Email:</span>
                                        <p class="text-gray-900 text-sm">{{ $ppdbInfo->contact_email }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Content Sections -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($ppdbInfo->requirements)
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Persyaratan</h4>
                                <p class="text-gray-700 text-sm">{{ Str::limit($ppdbInfo->requirements, 150) }}</p>
                            </div>
                            @endif
                            
                            @if($ppdbInfo->schedule)
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Jadwal</h4>
                                <p class="text-gray-700 text-sm">{{ Str::limit($ppdbInfo->schedule, 150) }}</p>
                            </div>
                            @endif
                            
                            @if($ppdbInfo->technical_guide)
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Petunjuk Teknis</h4>
                                <p class="text-gray-700 text-sm">{{ Str::limit($ppdbInfo->technical_guide, 150) }}</p>
                            </div>
                            @endif
                            
                            @if($ppdbInfo->faq)
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">FAQ</h4>
                                <p class="text-gray-700 text-sm">{{ Str::limit($ppdbInfo->faq, 150) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.206 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.794 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.794 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.206 18 16.5 18s-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Informasi PPDB</h3>
                        <p class="text-gray-600 mb-6">Silakan tambah informasi PPDB untuk memulai proses pendaftaran.</p>
                        <a href="{{ route('admin.ppdb.create') }}" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors">
                            Tambah Informasi PPDB
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
