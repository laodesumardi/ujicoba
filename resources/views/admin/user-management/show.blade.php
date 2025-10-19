@extends('layouts.admin')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Detail User</h1>
                        <p class="text-sm text-gray-500">Informasi lengkap {{ $user->name }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.user-management.edit', $user) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit User
                    </a>
                    <a href="{{ route('admin.user-management.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Basic Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Informasi Dasar</h2>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Peran (Role)</label>
                            <div class="mt-1">
                                @if($user->role === 'admin')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Admin</span>
                                @elseif($user->role === 'teacher')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Guru</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Siswa</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <div class="mt-1">
                                @if($user->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Terakhir Login</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Dibuat</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Picture & Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Foto Profil</h2>
                </div>
                <div class="px-6 py-4 text-center">
                    <div class="mx-auto h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl font-semibold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Inisial nama</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Aksi</h2>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <a href="{{ route('admin.user-management.edit', $user) }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit User
                    </a>
                    
                    <form action="{{ route('admin.user-management.toggle-active', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} user ini?');">
                        @csrf
                        @method('POST')
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium {{ $user->is_active ? 'text-red-700 bg-red-100 hover:bg-red-200' : 'text-green-700 bg-green-100 hover:bg-green-200' }} border border-transparent rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            @if($user->is_active)
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2A9 9 0 111 12a9 9 0 0118 0z"></path>
                                </svg>
                                Nonaktifkan User
                            @else
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Aktifkan User
                            @endif
                        </button>
                    </form>

                    <form action="{{ route('admin.user-management.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-red-700 bg-red-100 border border-transparent rounded-md shadow-sm hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    @if($user->phone || $user->address || $user->date_of_birth || $user->gender || $user->religion)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Informasi Tambahan</h2>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @if($user->phone)
                <div>
                    <label class="block text-sm font-medium text-gray-500">No. Telepon</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->phone }}</p>
                </div>
                @endif

                @if($user->address)
                <div>
                    <label class="block text-sm font-medium text-gray-500">Alamat</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->address }}</p>
                </div>
                @endif

                @if($user->date_of_birth)
                <div>
                    <label class="block text-sm font-medium text-gray-500">Tanggal Lahir</label>
                    <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($user->date_of_birth)->format('d M Y') }}</p>
                </div>
                @endif

                @if($user->gender)
                <div>
                    <label class="block text-sm font-medium text-gray-500">Jenis Kelamin</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->gender }}</p>
                </div>
                @endif

                @if($user->religion)
                <div>
                    <label class="block text-sm font-medium text-gray-500">Agama</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->religion }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Role Specific Information -->
    @if($user->role === 'teacher' && ($user->nip || $user->employment_status))
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Informasi Guru</h2>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($user->nip)
                <div>
                    <label class="block text-sm font-medium text-gray-500">NIP</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->nip }}</p>
                </div>
                @endif

                @if($user->employment_status)
                <div>
                    <label class="block text-sm font-medium text-gray-500">Status Kepegawaian</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->employment_status }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if($user->role === 'student' && ($user->student_id || $user->class))
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Informasi Siswa</h2>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($user->student_id)
                <div>
                    <label class="block text-sm font-medium text-gray-500">NIS</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->student_id }}</p>
                </div>
                @endif

                @if($user->class)
                <div>
                    <label class="block text-sm font-medium text-gray-500">Kelas</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->class }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
