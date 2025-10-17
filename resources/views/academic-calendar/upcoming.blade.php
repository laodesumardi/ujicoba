@extends('layouts.app')

@section('title', 'Acara Mendatang - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <!-- Hero Section with Full Width Image -->
    @if($academicCalendarSection && $academicCalendarSection->image)
    <div class="relative h-96 overflow-hidden">
        <img src="{{ asset('storage/' . $academicCalendarSection->image) }}" 
             alt="{{ $academicCalendarSection->image_alt }}" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Acara Mendatang</h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-4">Jadwal acara dan kegiatan sekolah dalam 30 hari ke depan</p>
                @if($academicCalendarSection->content)
                    <p class="text-lg text-gray-300 max-w-3xl mx-auto">{{ $academicCalendarSection->content }}</p>
                @endif
            </div>
        </div>
    </div>
    @else
    <!-- Fallback Hero Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Acara Mendatang</h1>
                <p class="text-xl text-primary-100">Jadwal acara dan kegiatan sekolah dalam 30 hari ke depan</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Navigation -->
    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-2xl font-bold text-gray-900">Acara 30 Hari Ke Depan</h2>
                    <p class="text-gray-600">Total {{ $events->count() }} acara</p>
                </div>

                <!-- View Options -->
                <div class="flex space-x-4">
                    <a href="{{ route('academic-calendar.index') }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        Daftar Acara
                    </a>
                    <a href="{{ route('academic-calendar.calendar') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Tampilan Kalender
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Events List -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($events->count() > 0)
                <div class="space-y-6">
                    @foreach($events as $event)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <!-- Event Info -->
                                <div class="flex-1 mb-4 md:mb-0">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <h3 class="text-xl font-semibold text-gray-900">{{ $event->title }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                              style="background-color: {{ $event->color }}20; color: {{ $event->color }}">
                                            {{ $event->type_label }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $event->priority == 'critical' ? 'bg-red-100 text-red-800' : 
                                               ($event->priority == 'high' ? 'bg-orange-100 text-orange-800' : 
                                               ($event->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ $event->priority_label }}
                                        </span>
                                    </div>

                                    @if($event->description)
                                    <p class="text-gray-600 mb-3">{{ $event->description }}</p>
                                    @endif

                                    <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-6">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $event->formatted_date }}
                                        </div>
                                        
                                        @if($event->location)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $event->location }}
                                        </div>
                                        @endif
                                        
                                        @if($event->organizer)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ $event->organizer }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Event Actions -->
                                <div class="flex items-center space-x-3">
                                    @if($event->is_downloadable && $event->file_path)
                                    <a href="{{ route('academic-calendar.download', $event->id) }}" 
                                       class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download
                                    </a>
                                    @endif
                                    
                                    <div class="text-right">
                                        <div class="text-sm text-gray-500">
                                            {{ $event->duration }} hari
                                        </div>
                                        @if($event->is_today())
                                        <div class="text-xs text-primary-600 font-medium">Hari ini!</div>
                                        @elseif($event->is_this_week())
                                        <div class="text-xs text-orange-600 font-medium">Minggu ini</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- No Events Found -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada acara mendatang</h3>
                    <p class="mt-1 text-sm text-gray-500">Tidak ada acara yang dijadwalkan dalam 30 hari ke depan.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
