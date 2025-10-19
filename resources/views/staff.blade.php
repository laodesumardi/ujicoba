@extends('layouts.app')

@section('title', 'Tenaga Pendidik & Kependidikan - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="text-white relative flex items-center justify-center" 
         style="background: linear-gradient(135deg, #14213d 0%, #1e3a8a 100%); min-height: 400px;">
        <!-- Overlay untuk kontras teks -->
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        
        <!-- Konten di tengah -->
        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4 text-white leading-tight">
                    Tenaga Pendidik & Kependidikan
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-white opacity-90 leading-relaxed">
                    SMP Negeri 01 Namrole - Tim Pendidik dan Kependidikan yang Berdedikasi
                </p>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Teachers Section -->
        @if($teachers->count() > 0)
        <div class="mb-16">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Tenaga Pendidik (Guru)</h2>
                </div>
            
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($teachers as $teacher)
                    <div class="bg-gray-50 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <!-- Photo Section -->
                        <div class="relative h-48 bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                            @if($teacher->photo && \Storage::disk('public')->exists($teacher->photo))
                                <img src="{{ \Storage::url($teacher->photo) }}" 
                                     alt="{{ $teacher->name }}" 
                                     class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                                <div class="w-24 h-24 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        
                            <!-- Status Badge -->
                            <div class="absolute top-4 right-4">
                                @if($teacher->is_active)
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        Aktif
                                    </span>
                                @else
                                    <span class="bg-gray-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Profile Information -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $teacher->name }}</h3>
                            
                            @if($teacher->subject)
                            <p class="text-primary-600 font-semibold mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $teacher->subject }}
                            </p>
                            @endif
                        
                            @if($teacher->position)
                            <p class="text-gray-600 mb-2 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                </svg>
                                {{ $teacher->position }}
                            </p>
                            @endif
                            
                            @if($teacher->education)
                            <p class="text-gray-600 mb-2 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                                {{ $teacher->education }}
                            </p>
                            @endif
                            
                            @if($teacher->employment_status)
                            <p class="text-gray-600 mb-2 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                                {{ $teacher->employment_status }}
                            </p>
                            @endif
                            
                            @if($teacher->experience_years)
                            <p class="text-gray-600 mb-2 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $teacher->experience_years }} tahun pengalaman
                            </p>
                            @endif
                            
                            @if($teacher->phone)
                            <p class="text-gray-600 mb-2 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $teacher->phone }}
                            </p>
                            @endif
                            
                            @if($teacher->email)
                            <p class="text-gray-600 mb-2 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $teacher->email }}
                            </p>
                            @endif
                            
                            @if($teacher->bio)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-gray-700 text-sm leading-relaxed">{{ $teacher->bio }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif


        <!-- No Staff Message -->
        @if($teachers->count() == 0)
        <div class="text-center py-16">
            <div class="text-gray-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Data Guru</h3>
            <p class="text-gray-600">Data tenaga pendidik belum tersedia.</p>
        </div>
        @endif

        <!-- Statistics -->
        @if($teachers->count() > 0)
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center mb-6">
                <div class="bg-primary-100 p-3 rounded-full mr-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Statistik Tenaga Pendidik</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg p-6 text-white text-center">
                    <div class="text-3xl font-bold mb-2">{{ $teachers->count() }}</div>
                    <div class="text-primary-100">Total Guru</div>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white text-center">
                    <div class="text-3xl font-bold mb-2">{{ $teachers->where('is_active', true)->count() }}</div>
                    <div class="text-green-100">Guru Aktif</div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
