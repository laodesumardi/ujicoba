@extends('layouts.admin')

@section('title', 'Edit Visi & Misi Sekolah')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Visi & Misi Sekolah</h1>
                <p class="text-gray-600 mt-1">Perbarui visi dan misi sekolah</p>
            </div>
            <a href="{{ route('admin.vision-missions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <form action="{{ route('admin.vision-missions.update', $visionMission->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')
                
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
                                  placeholder="Masukkan visi sekolah...">{{ old('vision', $visionMission->vision) }}</textarea>
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
                        @if(old('missions'))
                            @foreach(old('missions') as $index => $mission)
                                <div class="mission-item mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Misi {{ $index + 1 }} <span class="text-red-500">*</span></label>
                                    <div class="flex">
                                        <input type="text" 
                                               name="missions[]" 
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('missions.' . $index) border-red-500 @enderror" 
                                               placeholder="Masukkan misi sekolah..." 
                                               value="{{ $mission }}" required>
                                        <button type="button" onclick="removeMission(this)" class="ml-2 px-3 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @error('missions.' . $index)
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        @else
                            @foreach($visionMission->missions ?? [] as $index => $mission)
                                <div class="mission-item mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Misi {{ $index + 1 }} <span class="text-red-500">*</span></label>
                                    <div class="flex">
                                        <input type="text" 
                                               name="missions[]" 
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                               placeholder="Masukkan misi sekolah..." 
                                               value="{{ $mission }}" required>
                                        <button type="button" onclick="removeMission(this)" class="ml-2 px-3 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <button type="button" onclick="addMission()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Misi
                    </button>
                    
                    @error('missions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Images -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-image text-pink-600 mr-3"></i>
                        Gambar Visi & Misi
                    </h3>
                    <p class="text-xs text-gray-500 mb-4">Masukkan path gambar di folder public, contoh: <code>/images/visi-1.jpg</code></p>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <label for="image_one" class="block text-sm font-medium text-gray-700 mb-2">Gambar 1</label>
                            <input type="text" id="image_one" name="image_one" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_one') border-red-500 @enderror" value="{{ old('image_one', $visionMission->image_one) }}" placeholder="/images/visi-1.jpg">
                            @error('image_one')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <label for="image_one_name" class="block text-xs font-medium text-gray-600 mt-3 mb-1">Nama Gambar 1 (opsional)</label>
                            <input type="text" id="image_one_name" name="image_one_name" value="{{ old('image_one_name', $visionMission->image_one_name) }}" placeholder="Contoh: Upacara Bendera" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_one_name') border-red-500 @enderror">
                            @error('image_one_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @php $preview1 = old('image_one', $visionMission->image_one_url); @endphp
                            @if($preview1)
                                <img src="{{ $preview1 }}" alt="Preview Gambar 1" class="mt-2 w-full h-32 object-cover rounded border">
                            @endif
                        </div>
                        <div>
                            <label for="image_two" class="block text-sm font-medium text-gray-700 mb-2">Gambar 2</label>
                            <input type="text" id="image_two" name="image_two" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_two') border-red-500 @enderror" value="{{ old('image_two', $visionMission->image_two) }}" placeholder="/images/visi-2.jpg">
                            @error('image_two')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <label for="image_two_name" class="block text-xs font-medium text-gray-600 mt-3 mb-1">Nama Gambar 2 (opsional)</label>
                            <input type="text" id="image_two_name" name="image_two_name" value="{{ old('image_two_name', $visionMission->image_two_name) }}" placeholder="Contoh: Kegiatan Pramuka" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_two_name') border-red-500 @enderror">
                            @error('image_two_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @php $preview2 = old('image_two', $visionMission->image_two_url); @endphp
                            @if($preview2)
                                <img src="{{ $preview2 }}" alt="Preview Gambar 2" class="mt-2 w-full h-32 object-cover rounded border">
                            @endif
                        </div>
                        <div>
                            <label for="image_three" class="block text-sm font-medium text-gray-700 mb-2">Gambar 3</label>
                            <input type="text" id="image_three" name="image_three" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_three') border-red-500 @enderror" value="{{ old('image_three', $visionMission->image_three) }}" placeholder="/images/visi-3.jpg">
                            @error('image_three')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <label for="image_three_name" class="block text-xs font-medium text-gray-600 mt-3 mb-1">Nama Gambar 3 (opsional)</label>
                            <input type="text" id="image_three_name" name="image_three_name" value="{{ old('image_three_name', $visionMission->image_three_name) }}" placeholder="Contoh: Kegiatan Olahraga" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_three_name') border-red-500 @enderror">
                            @error('image_three_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @php $preview3 = old('image_three', $visionMission->image_three_url); @endphp
                            @if($preview3)
                                <img src="{{ $preview3 }}" alt="Preview Gambar 3" class="mt-2 w-full h-32 object-cover rounded border">
                            @endif
                        </div>
                    </div>
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
                                   {{ old('is_active', $visionMission->is_active) ? 'checked' : '' }}>
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
                            Perbarui Visi & Misi
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
let missionCount = {{ count($visionMission->missions ?? []) }};

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


