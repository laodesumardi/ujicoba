@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Detail Mata Pelajaran</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.subjects.edit', $subject) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.subjects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Detail Mata Pelajaran -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Mata Pelajaran</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Kode</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $subject->code }}
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $subject->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tingkat Pendidikan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $subject->level_label }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Jam per Minggu</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $subject->hours_per_week }} jam</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Warna</label>
                        <div class="mt-1 flex items-center">
                            <div class="w-4 h-4 rounded-full mr-2" style="background-color: {{ $subject->color }}"></div>
                            <span class="text-sm text-gray-900">{{ $subject->color }}</span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        <p class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $subject->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $subject->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Urutan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $subject->sort_order }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Dibuat</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $subject->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                
                @if($subject->description)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $subject->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Guru yang Mengajar -->
        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Guru yang Mengajar</h3>
                
                @if($teachers->count() > 0)
                    <div class="space-y-3">
                        @foreach($teachers as $teacher)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}" 
                                         class="h-10 w-10 rounded-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $teacher->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $teacher->nip }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('admin.teachers.show', $teacher) }}" 
                                       class="text-blue-600 hover:text-blue-900 text-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($teachers->hasPages())
                        <div class="mt-4">
                            {{ $teachers->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-chalkboard-teacher text-4xl text-gray-300 mb-2"></i>
                        <p class="text-sm text-gray-500">Belum ada guru yang mengajar mata pelajaran ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection




