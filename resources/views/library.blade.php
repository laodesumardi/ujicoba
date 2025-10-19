@extends('layouts.app')

@section('title', 'Perpustakaan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Perpustakaan Sekolah</h1>
            <p class="text-lg text-gray-600">SMP Negeri 01 Namrole</p>
        </div>

        @if($library)
            <!-- Library Profile -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Organization Chart Section -->
                @if($library->organization_chart)
                <div class="bg-white p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Struktur Organisasi Perpustakaan</h2>
                    <div class="text-center">
                        <img src="{{ $library->organization_chart_url }}" alt="Struktur Organisasi Perpustakaan" 
                             class="mx-auto rounded-lg shadow-lg max-w-full h-auto" style="max-height: 500px;">
                    </div>
                </div>
                @endif

                <!-- Library Information -->
                <div class="p-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Informasi Perpustakaan</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Nama Perpustakaan</h4>
                                    <p class="text-gray-700">{{ $library->name }}</p>
                                </div>

                                @if($library->description)
                                <div>
                                    <h4 class="font-semibold text-gray-900">Deskripsi</h4>
                                    <p class="text-gray-700">{{ $library->description }}</p>
                                </div>
                                @endif

                                @if($library->location)
                                <div>
                                    <h4 class="font-semibold text-gray-900">Lokasi</h4>
                                    <p class="text-gray-700">{{ $library->location }}</p>
                                </div>
                                @endif

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @if($library->phone)
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Telepon</h4>
                                        <p class="text-gray-700">{{ $library->phone }}</p>
                                    </div>
                                    @endif

                                    @if($library->email)
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Email</h4>
                                        <p class="text-gray-700">{{ $library->email }}</p>
                                    </div>
                                    @endif
                                </div>

                                @if($library->opening_hours)
                                <div>
                                    <h4 class="font-semibold text-gray-900">Jam Operasional</h4>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <pre class="text-gray-700 whitespace-pre-wrap">{{ $library->opening_hours }}</pre>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Services and Facilities -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Layanan & Fasilitas</h3>
                            
                            <div class="space-y-6">
                                @if($library->services)
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Layanan yang Tersedia</h4>
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <pre class="text-gray-700 whitespace-pre-wrap">{{ $library->services }}</pre>
                                    </div>
                                </div>
                                @endif

                                @if($library->facilities)
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Fasilitas</h4>
                                    <div class="bg-green-50 p-4 rounded-lg">
                                        <pre class="text-gray-700 whitespace-pre-wrap">{{ $library->facilities }}</pre>
                                    </div>
                                </div>
                                @endif

                                @if($library->collection_info)
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Informasi Koleksi</h4>
                                    <div class="bg-purple-50 p-4 rounded-lg">
                                        <pre class="text-gray-700 whitespace-pre-wrap">{{ $library->collection_info }}</pre>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Rules and Membership -->
                    <div class="mt-8 grid md:grid-cols-2 gap-8">
                        @if($library->rules)
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Peraturan Perpustakaan</h3>
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                                <pre class="text-gray-700 whitespace-pre-wrap">{{ $library->rules }}</pre>
                            </div>
                        </div>
                        @endif

                        @if($library->membership_info)
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Keanggotaan</h3>
                            <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 rounded-lg">
                                <pre class="text-gray-700 whitespace-pre-wrap">{{ $library->membership_info }}</pre>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Librarian Information -->
                    @if($library->librarian_name || $library->librarian_phone || $library->librarian_email)
                    <div class="mt-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Informasi Pustakawan</h3>
                        
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="grid md:grid-cols-3 gap-6">
                                @if($library->librarian_name)
                                <div>
                                    <h4 class="font-semibold text-gray-900">Nama Pustakawan</h4>
                                    <p class="text-gray-700">{{ $library->librarian_name }}</p>
                                </div>
                                @endif

                                @if($library->librarian_phone)
                                <div>
                                    <h4 class="font-semibold text-gray-900">Telepon</h4>
                                    <p class="text-gray-700">{{ $library->librarian_phone }}</p>
                                </div>
                                @endif

                                @if($library->librarian_email)
                                <div>
                                    <h4 class="font-semibold text-gray-900">Email</h4>
                                    <p class="text-gray-700">{{ $library->librarian_email }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        @else
            <!-- No Library Profile -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Profil Perpustakaan Belum Tersedia</h2>
                <p class="text-gray-600">Informasi perpustakaan sedang dalam proses pengembangan. Silakan kembali lagi nanti.</p>
            </div>
        @endif
    </div>
</div>
@endsection
