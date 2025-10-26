@extends('layouts.ppdb-panitia')

@section('title', 'Dashboard Panitia PPDB')
@section('page-title', 'Dashboard')
@section('page-description', 'Kelola pendaftaran PPDB dengan mudah')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl shadow-lg p-6 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Selamat Datang di Dashboard Panitia PPDB</h1>
                <p class="text-primary-100">Kelola pendaftaran PPDB dengan mudah dan efisien</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <div class="text-right">
                    <p class="text-sm text-primary-100">Terakhir login</p>
                    <p class="font-semibold">{{ now()->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <!-- Total Pendaftaran -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pendaftaran</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_registrations']) }}</p>
                </div>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['pending_registrations']) }}</p>
                </div>
            </div>
        </div>

        <!-- Disetujui -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Disetujui</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['approved_registrations']) }}</p>
                </div>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-times-circle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['rejected_registrations']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pendaftaran Hari Ini -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pendaftaran Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['today_registrations']) }}</p>
                </div>
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-calendar-day text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pendaftaran Bulan Ini -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pendaftaran Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['this_month_registrations']) }}</p>
                </div>
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 shadow-lg">
                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Status Distribution Chart -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Status Pendaftaran</h3>
            <div class="space-y-4">
                @foreach($status_distribution as $status => $count)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full mr-3 
                            {{ $status === 'pending' ? 'bg-yellow-500' : 
                               ($status === 'approved' ? 'bg-green-500' : 'bg-red-500') }}">
                        </div>
                        <span class="text-sm font-medium text-gray-700 capitalize">
                            {{ $status === 'pending' ? 'Menunggu Verifikasi' : 
                               ($status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($count) }}</span>
                        <div class="w-20 bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full 
                                {{ $status === 'pending' ? 'bg-yellow-500' : 
                                   ($status === 'approved' ? 'bg-green-500' : 'bg-red-500') }}"
                                style="width: {{ $stats['total_registrations'] > 0 ? ($count / $stats['total_registrations']) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Registrations -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Pendaftaran Terbaru</h3>
                <a href="{{ route('ppdb.panitia.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Semua
                </a>
            </div>
            <div class="space-y-3">
                @forelse($recent_registrations as $registration)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $registration->student_name }}</p>
                            <p class="text-xs text-gray-500">{{ $registration->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($registration->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ $registration->status === 'pending' ? 'Menunggu' : 
                               ($registration->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                        </span>
                        <a href="{{ route('ppdb.panitia.show', $registration) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-users text-gray-400 text-4xl mb-2"></i>
                    <p class="text-gray-500">Belum ada pendaftaran</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
            <p class="text-sm text-gray-600 mt-1">Akses cepat ke fitur utama</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('ppdb.panitia.index', ['status' => 'pending']) }}" 
                   class="group flex items-center p-5 border border-gray-200 rounded-xl hover:border-yellow-300 hover:shadow-lg transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-4 mr-4 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-yellow-700 transition-colors">Verifikasi Pendaftaran</h4>
                        <p class="text-sm text-gray-600">{{ $stats['pending_registrations'] }} menunggu verifikasi</p>
                    </div>
                </a>

                <a href="{{ route('ppdb.panitia.export') }}" 
                   class="group flex items-center p-5 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-lg transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 mr-4 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        <i class="fas fa-download text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">Export Data</h4>
                        <p class="text-sm text-gray-600">Download laporan pendaftaran</p>
                    </div>
                </a>

                <a href="{{ route('ppdb.panitia.index') }}" 
                   class="group flex items-center p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-lg transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 mr-4 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        <i class="fas fa-list text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-green-700 transition-colors">Lihat Semua Data</h4>
                        <p class="text-sm text-gray-600">{{ $stats['total_registrations'] }} total pendaftaran</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
