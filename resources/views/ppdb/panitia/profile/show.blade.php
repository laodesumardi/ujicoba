@extends('layouts.ppdb-panitia')

@section('title', 'Profil Panitia PPDB')
@section('page-title', 'Profil Panitia PPDB')
@section('page-description', 'Kelola informasi profil Anda')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl shadow-lg text-white p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Avatar -->
                <div class="relative">
                    @if($user->photo)
                        <img src="{{ $user->photo_url }}" alt="Foto Profil" 
                             class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    @endif
                    <div class="w-20 h-20 bg-primary-200 rounded-full flex items-center justify-center shadow-lg {{ $user->photo ? 'hidden' : 'flex' }}">
                        <span class="text-primary-600 font-bold text-2xl">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <!-- Status Badge -->
                    <div class="absolute -bottom-2 -right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                        <i class="fas fa-graduation-cap mr-1"></i>Panitia PPDB
                    </div>
                </div>
                
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $user->name }}</h1>
                    <p class="text-primary-100">{{ $user->email }}</p>
                    <p class="text-sm text-primary-200">
                        <i class="fas fa-calendar mr-1"></i>Bergabung {{ $user->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
            
            <div class="hidden md:block">
                <a href="{{ route('ppdb.panitia.profile.edit') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Informasi Dasar</h2>
                <a href="{{ route('ppdb.panitia.profile.edit') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Edit
                </a>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 font-semibold">{{ $user->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>
                
                @if($user->phone)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <p class="text-gray-900">{{ $user->phone }}</p>
                </div>
                @endif
                
                @if($user->address)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <p class="text-gray-900 text-sm">{{ $user->address }}</p>
                </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-graduation-cap mr-1"></i>Panitia PPDB
                    </span>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Informasi Tambahan</h2>
                <a href="{{ route('ppdb.panitia.profile.edit') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Edit
                </a>
            </div>
            
            <div class="space-y-4">
                @if($user->bio)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                    <p class="text-gray-900 text-sm">{{ $user->bio }}</p>
                </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Akun</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>Aktif
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Login</label>
                    <p class="text-gray-900 text-sm">{{ $user->updated_at->format('d M Y, H:i') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bergabung Sejak</label>
                    <p class="text-gray-900 text-sm">{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- PPDB Statistics -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Statistik PPDB</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center p-4 bg-blue-50 rounded-xl">
                <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ \App\Models\PPDBRegistration::count() }}</p>
                <p class="text-sm text-gray-600">Total Pendaftaran</p>
            </div>
            
            <div class="text-center p-4 bg-yellow-50 rounded-xl">
                <div class="bg-yellow-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ \App\Models\PPDBRegistration::where('status', 'pending')->count() }}</p>
                <p class="text-sm text-gray-600">Menunggu Review</p>
            </div>
            
            <div class="text-center p-4 bg-green-50 rounded-xl">
                <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ \App\Models\PPDBRegistration::where('status', 'approved')->count() }}</p>
                <p class="text-sm text-gray-600">Diterima</p>
            </div>
            
            <div class="text-center p-4 bg-red-50 rounded-xl">
                <div class="bg-red-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ \App\Models\PPDBRegistration::where('status', 'rejected')->count() }}</p>
                <p class="text-sm text-gray-600">Ditolak</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('ppdb.panitia.dashboard') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-tachometer-alt text-blue-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-blue-900">Dashboard</p>
                    <p class="text-sm text-blue-600">Lihat dashboard</p>
                </div>
            </a>
            
            <a href="{{ route('ppdb.panitia.profile.edit') }}" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-user-edit text-green-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-green-900">Edit Profil</p>
                    <p class="text-sm text-green-600">Ubah informasi</p>
                </div>
            </a>
            
            <a href="{{ route('ppdb.panitia.index') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-list text-purple-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-purple-900">Data Pendaftaran</p>
                    <p class="text-sm text-purple-600">Kelola pendaftaran</p>
                </div>
            </a>
            
            <a href="{{ route('ppdb.panitia.export') }}" class="flex items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-download text-orange-600 text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-orange-900">Export Data</p>
                    <p class="text-sm text-orange-600">Download CSV</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
