@extends('layouts.admin')

@section('title', 'Detail Informasi PPDB')
@section('page-title', 'Detail Informasi PPDB')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-primary-900">Detail Informasi PPDB</h2>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.ppdb.edit', $ppdb) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Edit
                        </a>
                        <a href="{{ route('admin.ppdb.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- Basic Information -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Judul PPDB</label>
                                <p class="text-gray-900 font-semibold">{{ $ppdb->title }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status</label>
                                <div class="mt-1">
                                    @if($ppdb->is_active)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tanggal Mulai</label>
                                <p class="text-gray-900">{{ $ppdb->registration_start ? $ppdb->registration_start->format('d M Y') : '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tanggal Selesai</label>
                                <p class="text-gray-900">{{ $ppdb->registration_end ? $ppdb->registration_end->format('d M Y') : '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Kuota</label>
                                <p class="text-gray-900">{{ $ppdb->quota ? number_format($ppdb->quota) : '-' }} siswa</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status Pendaftaran</label>
                                <div class="mt-1">
                                    @if($ppdb->isRegistrationOpen())
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Pendaftaran Dibuka
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Pendaftaran Ditutup
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($ppdb->description)
                        <div class="mt-4">
                            <label class="text-sm font-medium text-gray-500">Deskripsi</label>
                            <p class="text-gray-900 mt-1">{{ $ppdb->description }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Content Sections -->
                    @if($ppdb->requirements)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Persyaratan Pendaftaran</h3>
                        <div class="prose max-w-none">
                            <pre class="whitespace-pre-wrap text-gray-700">{{ $ppdb->requirements }}</pre>
                        </div>
                    </div>
                    @endif

                    @if($ppdb->schedule)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Jadwal Penting</h3>
                        <div class="prose max-w-none">
                            <pre class="whitespace-pre-wrap text-gray-700">{{ $ppdb->schedule }}</pre>
                        </div>
                    </div>
                    @endif

                    @if($ppdb->technical_guide)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Petunjuk Teknis</h3>
                        <div class="prose max-w-none">
                            <pre class="whitespace-pre-wrap text-gray-700">{{ $ppdb->technical_guide }}</pre>
                        </div>
                    </div>
                    @endif

                    @if($ppdb->faq)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Frequently Asked Questions (FAQ)</h3>
                        <div class="prose max-w-none">
                            <pre class="whitespace-pre-wrap text-gray-700">{{ $ppdb->faq }}</pre>
                        </div>
                    </div>
                    @endif

                    <!-- Contact Information -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Informasi Kontak</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($ppdb->contact_person)
                            <div>
                                <label class="text-sm font-medium text-blue-700">Nama Panitia</label>
                                <p class="text-blue-900">{{ $ppdb->contact_person }}</p>
                            </div>
                            @endif
                            
                            @if($ppdb->contact_phone)
                            <div>
                                <label class="text-sm font-medium text-blue-700">Nomor Telepon</label>
                                <p class="text-blue-900">{{ $ppdb->contact_phone }}</p>
                            </div>
                            @endif
                            
                            @if($ppdb->contact_email)
                            <div>
                                <label class="text-sm font-medium text-blue-700">Email</label>
                                <p class="text-blue-900">{{ $ppdb->contact_email }}</p>
                            </div>
                            @endif
                            
                            @if($ppdb->registration_link)
                            <div>
                                <label class="text-sm font-medium text-blue-700">Link Formulir Online</label>
                                <p class="text-blue-900">
                                    <a href="{{ $ppdb->registration_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                        {{ $ppdb->registration_link }}
                                    </a>
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Registration Statistics -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Pendaftaran</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary-600">{{ \App\Models\PPDBRegistration::count() }}</div>
                                <div class="text-sm text-gray-500">Total Pendaftar</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ \App\Models\PPDBRegistration::approved()->count() }}</div>
                                <div class="text-sm text-gray-500">Diterima</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-yellow-600">{{ \App\Models\PPDBRegistration::pending()->count() }}</div>
                                <div class="text-sm text-gray-500">Menunggu Review</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
