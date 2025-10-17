@extends('layouts.app')

@section('title', 'Kalender Akademik - SMP Negeri 01 Namrole')

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
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    @if($academicCalendarSection->title)
                        {{ $academicCalendarSection->title }}
                    @else
                        Kalender Akademik
                    @endif
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-4">
                    @if($academicCalendarSection->subtitle)
                        {{ $academicCalendarSection->subtitle }}
                    @else
                        Tampilan kalender bulanan untuk jadwal sekolah
                    @endif
                </p>
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
                <h1 class="text-4xl font-bold mb-4">Kalender Akademik</h1>
                <p class="text-xl text-primary-100">Tampilan kalender bulanan untuk jadwal sekolah</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Navigation -->
    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <!-- Month/Year Navigation -->
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <a href="{{ route('academic-calendar.calendar', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}" 
                       class="bg-white border border-gray-300 rounded-lg px-3 py-2 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    
                    <h2 class="text-2xl font-bold text-gray-900">{{ $months[$month] }} {{ $year }}</h2>
                    
                    <a href="{{ route('academic-calendar.calendar', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}" 
                       class="bg-white border border-gray-300 rounded-lg px-3 py-2 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <!-- View Options -->
                <div class="flex space-x-4">
                    <a href="{{ route('academic-calendar.index') }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        Daftar Acara
                    </a>
                    <a href="{{ route('academic-calendar.upcoming') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Acara Mendatang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Calendar Header -->
                <div class="bg-gray-50 border-b border-gray-200">
                    <div class="grid grid-cols-7">
                        <div class="px-4 py-3 text-center text-sm font-medium text-gray-500">Minggu</div>
                        <div class="px-4 py-3 text-center text-sm font-medium text-gray-500">Senin</div>
                        <div class="px-4 py-3 text-center text-sm font-medium text-gray-500">Selasa</div>
                        <div class="px-4 py-3 text-center text-sm font-medium text-gray-500">Rabu</div>
                        <div class="px-4 py-3 text-center text-sm font-medium text-gray-500">Kamis</div>
                        <div class="px-4 py-3 text-center text-sm font-medium text-gray-500">Jumat</div>
                        <div class="px-4 py-3 text-center text-sm font-medium text-gray-500">Sabtu</div>
                    </div>
                </div>

                <!-- Calendar Body -->
                <div class="divide-y divide-gray-200">
                    @foreach($calendarData as $week)
                    <div class="grid grid-cols-7 divide-x divide-gray-200">
                        @foreach($week as $day)
                        <div class="min-h-32 p-2 {{ $day['is_current_month'] ? 'bg-white' : 'bg-gray-50' }} {{ $day['is_today'] ? 'bg-primary-50 border-l-4 border-primary-500' : '' }}">
                            <!-- Date -->
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium {{ $day['is_current_month'] ? 'text-gray-900' : 'text-gray-400' }} {{ $day['is_today'] ? 'text-primary-600' : '' }}">
                                    {{ $day['date']->format('d') }}
                                </span>
                                @if($day['is_today'])
                                <span class="text-xs bg-primary-600 text-white px-2 py-1 rounded-full">Hari ini</span>
                                @endif
                            </div>

                            <!-- Events -->
                            <div class="space-y-1">
                                @foreach($day['events'] as $event)
                                <div class="text-xs p-1 rounded truncate" 
                                     style="background-color: {{ $event->color }}20; color: {{ $event->color }}; border-left: 3px solid {{ $event->color }}">
                                    <div class="font-medium">{{ $event->title }}</div>
                                    @if($event->start_time)
                                    <div class="text-xs opacity-75">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Legend -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Keterangan Warna</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded mr-2" style="background-color: #10B981"></div>
                        <span class="text-sm text-gray-600">Semester</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded mr-2" style="background-color: #F59E0B"></div>
                        <span class="text-sm text-gray-600">Ujian</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded mr-2" style="background-color: #8B5CF6"></div>
                        <span class="text-sm text-gray-600">Libur</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded mr-2" style="background-color: #EF4444"></div>
                        <span class="text-sm text-gray-600">Hari Besar</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded mr-2" style="background-color: #06B6D4"></div>
                        <span class="text-sm text-gray-600">Kegiatan</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded mr-2" style="background-color: #3B82F6"></div>
                        <span class="text-sm text-gray-600">Lainnya</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
