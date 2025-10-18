@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Detail Guru</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}" 
                     class="h-16 w-16 rounded-full object-cover mr-4 border-2 border-gray-200"
                     onerror="this.src='{{ asset('images/default-teacher.png') }}'">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $teacher->name }}</h2>
                    <p class="text-gray-600">{{ $teacher->position }}</p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $teacher->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $teacher->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">NIP</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->nip }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->phone ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->gender ? ucfirst($teacher->gender) : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->birth_date ? \Carbon\Carbon::parse($teacher->birth_date)->format('d F Y') : '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Professional Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Profesional</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Mata Pelajaran</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->subject ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pendidikan</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->education ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pendidikan Terakhir</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->education_level ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->position ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->join_date ? \Carbon\Carbon::parse($teacher->join_date)->format('d F Y') : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jenis</dt>
                            <dd class="text-sm text-gray-900">{{ $teacher->type ? ucfirst($teacher->type) : '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Address -->
            @if($teacher->address)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat</h3>
                    <p class="text-sm text-gray-900">{{ $teacher->address }}</p>
                </div>
            @endif

            <!-- Bio -->
            @if($teacher->bio)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Biografi</h3>
                    <p class="text-sm text-gray-900">{{ $teacher->bio }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
