@extends('layouts.admin')

@section('title', 'Tambah Visi & Misi Sekolah')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Visi & Misi Sekolah</h1>
                <p class="text-gray-600 mt-1">Buat visi dan misi baru untuk sekolah</p>
            </div>
            <a href="{{ route('admin.vision-missions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <form action="{{ route('admin.vision-missions.store') }}" method="POST" class="p-8">
                @csrf
                
                <!-- Vision -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-eye text-blue-600 mr-3"></i>
                        Visi Sekolah
                    </h3>
                    
                    <div>
                        <label for="vision" class="block text-sm font-medium text-gray-700 mb-2">
                            Visi <span class="text-red-500">*</span>
                        </label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('vision') border-red-500 @enderror" 
                                  id="vision" name="vision" rows="4" 
                                  placeholder="Masukkan visi sekolah...">{{ old('vision') }}</textarea>
                        @error('vision')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Missions -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-bullseye text-green-600 mr-3"></i>
                        Misi Sekolah
                    </h3>
                    
                    <div id="missions-container">
                        <div class="mission-item mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Misi 1 <span class="text-red-500">*</span></label>
                            <div class="flex">
                                <input type="text" 
                                       name="missions[]" 
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('missions.0') border-red-500 @enderror" 
                                       placeholder="Masukkan misi sekolah..." 
                                       value="{{ old('missions.0') }}" required>
                                <button type="button" onclick="removeMission(this)" class="ml-2 px-3 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @error('missions.0')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="button" onclick="addMission()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Misi
                    </button>
                    
                    @error('missions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-toggle-on text-purple-600 mr-3"></i>
                        Status
                    </h3>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                   id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                                Aktif
                            </label>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Centang untuk mengaktifkan visi & misi ini</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-8">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('admin.vision-missions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Visi & Misi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let missionCount = 1;

function addMission() {
    missionCount++;
    const container = document.getElementById('missions-container');
    const newMission = document.createElement('div');
    newMission.className = 'mission-item mb-4';
    newMission.innerHTML = `
        <label class="block text-sm font-medium text-gray-700 mb-2">Misi ${missionCount} <span class="text-red-500">*</span></label>
        <div class="flex">
            <input type="text" 
                   name="missions[]" 
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                   placeholder="Masukkan misi sekolah..." required>
            <button type="button" onclick="removeMission(this)" class="ml-2 px-3 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newMission);
}

function removeMission(button) {
    const missionItem = button.closest('.mission-item');
    if (document.querySelectorAll('.mission-item').length > 1) {
        missionItem.remove();
    } else {
        alert('Minimal harus ada 1 misi');
    }
}
</script>
@endpush


