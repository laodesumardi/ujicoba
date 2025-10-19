@extends('layouts.admin')

@section('title', 'Detail Visi & Misi Sekolah')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail Visi & Misi Sekolah</h1>
                <p class="text-gray-600 mt-1">Lihat detail visi dan misi sekolah</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.vision-missions.edit', $visionMission->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('admin.vision-missions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Vision Mission Details -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Vision Section -->
            <div class="p-8 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-eye text-blue-600 mr-3"></i>
                    Visi Sekolah
                </h3>
                <div class="bg-blue-50 p-6 rounded-lg">
                    <p class="text-gray-800 text-lg leading-relaxed">{{ $visionMission->vision }}</p>
                </div>
            </div>

            <!-- Missions Section -->
            <div class="p-8 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-bullseye text-green-600 mr-3"></i>
                    Misi Sekolah
                </h3>
                <div class="space-y-4">
                    @foreach($visionMission->missions ?? [] as $index => $mission)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold text-sm mr-4">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-800 text-lg leading-relaxed">{{ $mission }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Status and Info -->
            <div class="p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-purple-600 mr-3"></i>
                    Informasi
                </h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">Status</h4>
                        @if($visionMission->is_active)
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                <i class="fas fa-times-circle mr-2"></i>
                                Tidak Aktif
                            </span>
                        @endif
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">Jumlah Misi</h4>
                        <p class="text-gray-600">{{ count($visionMission->missions ?? []) }} misi</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">Dibuat</h4>
                        <p class="text-gray-600">{{ $visionMission->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">Diperbarui</h4>
                        <p class="text-gray-600">{{ $visionMission->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="border-t border-gray-200 p-8">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.vision-missions.edit', $visionMission->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Visi & Misi
                        </a>
                        <a href="{{ route('admin.vision-missions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-list mr-2"></i>
                            Daftar Visi & Misi
                        </a>
                    </div>
                    
                    <form action="{{ route('admin.vision-missions.destroy', $visionMission->id) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus visi & misi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


