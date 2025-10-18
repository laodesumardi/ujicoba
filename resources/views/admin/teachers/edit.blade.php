@extends('layouts.admin')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Data Guru</h1>
        <a href="{{ route('admin.teachers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIP -->
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP *</label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip', $teacher->nip) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('nip') border-red-500 @enderror" required>
                    @error('nip')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $teacher->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $teacher->email) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('password') border-red-500 @enderror" 
                           placeholder="Kosongkan jika tidak ingin mengubah password">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('password_confirmation') border-red-500 @enderror" 
                           placeholder="Ulangi password baru">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $teacher->phone) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <select name="gender" id="gender" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('gender') border-red-500 @enderror">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birth Date -->
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $teacher->birth_date) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('birth_date') border-red-500 @enderror">
                    @error('birth_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</label>
                    <select name="subject" id="subject" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('subject') border-red-500 @enderror">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach(\App\Models\Subject::active()->ordered()->get() as $subjectOption)
                            <option value="{{ $subjectOption->name }}" {{ old('subject', $teacher->subject) == $subjectOption->name ? 'selected' : '' }}>
                                {{ $subjectOption->name }} ({{ $subjectOption->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('subject')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Classes -->
                <div>
                    <label for="classes" class="block text-sm font-medium text-gray-700 mb-2">Kelas yang Diampu</label>
                    <select name="classes[]" id="classes" multiple
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('classes') border-red-500 @enderror">
                        <option value="VII A" {{ in_array('VII A', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VII A</option>
                        <option value="VII B" {{ in_array('VII B', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VII B</option>
                        <option value="VII C" {{ in_array('VII C', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VII C</option>
                        <option value="VIII A" {{ in_array('VIII A', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VIII A</option>
                        <option value="VIII B" {{ in_array('VIII B', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VIII B</option>
                        <option value="VIII C" {{ in_array('VIII C', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VIII C</option>
                        <option value="IX A" {{ in_array('IX A', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>IX A</option>
                        <option value="IX B" {{ in_array('IX B', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>IX B</option>
                        <option value="IX C" {{ in_array('IX C', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>IX C</option>
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Tekan Ctrl/Cmd untuk memilih multiple kelas</p>
                    @error('classes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Education -->
                <div>
                    <label for="education" class="block text-sm font-medium text-gray-700 mb-2">Pendidikan *</label>
                    <select name="education" id="education" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('education') border-red-500 @enderror" required>
                        <option value="">Pilih Pendidikan</option>
                        <option value="S1" {{ old('education', $teacher->education) == 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                        <option value="S2" {{ old('education', $teacher->education) == 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                        <option value="S3" {{ old('education', $teacher->education) == 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                        <option value="D3" {{ old('education', $teacher->education) == 'D3' ? 'selected' : '' }}>D3 (Diploma)</option>
                        <option value="D4" {{ old('education', $teacher->education) == 'D4' ? 'selected' : '' }}>D4 (Diploma)</option>
                        <option value="SMA" {{ old('education', $teacher->education) == 'SMA' ? 'selected' : '' }}>SMA</option>
                    </select>
                    @error('education')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Education Level -->
                <div>
                    <label for="education_level" class="block text-sm font-medium text-gray-700 mb-2">Jurusan/Program Studi</label>
                    <input type="text" name="education_level" id="education_level" value="{{ old('education_level', $teacher->education_level) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('education_level') border-red-500 @enderror"
                           placeholder="e.g., Pendidikan Matematika, Teknik Informatika">
                    @error('education_level')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                    <select name="position" id="position" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('position') border-red-500 @enderror">
                        <option value="">Pilih Jabatan</option>
                        <option value="Guru" {{ old('position', $teacher->position) == 'Guru' ? 'selected' : '' }}>Guru</option>
                        <option value="Wali Kelas" {{ old('position', $teacher->position) == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
                        <option value="Kepala Sekolah" {{ old('position', $teacher->position) == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                        <option value="Wakil Kepala Sekolah" {{ old('position', $teacher->position) == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil Kepala Sekolah</option>
                        <option value="Kepala TU" {{ old('position', $teacher->position) == 'Kepala TU' ? 'selected' : '' }}>Kepala TU</option>
                        <option value="Staff TU" {{ old('position', $teacher->position) == 'Staff TU' ? 'selected' : '' }}>Staff TU</option>
                        <option value="Guru BK" {{ old('position', $teacher->position) == 'Guru BK' ? 'selected' : '' }}>Guru BK</option>
                        <option value="Guru Piket" {{ old('position', $teacher->position) == 'Guru Piket' ? 'selected' : '' }}>Guru Piket</option>
                    </select>
                    @error('position')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Employment Status -->
                <div>
                    <label for="employment_status" class="block text-sm font-medium text-gray-700 mb-2">Status Kepegawaian</label>
                    <select name="employment_status" id="employment_status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('employment_status') border-red-500 @enderror">
                        <option value="">Pilih Status</option>
                        <option value="PNS" {{ old('employment_status', $teacher->employment_status) == 'PNS' ? 'selected' : '' }}>PNS (Pegawai Negeri Sipil)</option>
                        <option value="CPNS" {{ old('employment_status', $teacher->employment_status) == 'CPNS' ? 'selected' : '' }}>CPNS (Calon Pegawai Negeri Sipil)</option>
                        <option value="Guru Honorer" {{ old('employment_status', $teacher->employment_status) == 'Guru Honorer' ? 'selected' : '' }}>Guru Honorer</option>
                        <option value="Guru Kontrak" {{ old('employment_status', $teacher->employment_status) == 'Guru Kontrak' ? 'selected' : '' }}>Guru Kontrak</option>
                        <option value="Guru Bantu" {{ old('employment_status', $teacher->employment_status) == 'Guru Bantu' ? 'selected' : '' }}>Guru Bantu</option>
                    </select>
                    @error('employment_status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Join Date -->
                <div>
                    <label for="join_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bergabung</label>
                    <input type="date" name="join_date" id="join_date" value="{{ old('join_date', $teacher->join_date) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('join_date') border-red-500 @enderror">
                    @error('join_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis *</label>
                    <select name="type" id="type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('type') border-red-500 @enderror" required>
                        <option value="">Pilih Jenis</option>
                        <option value="teacher" {{ old('type', $teacher->type) == 'teacher' ? 'selected' : '' }}>Guru</option>
                        <option value="staff" {{ old('type', $teacher->type) == 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="md:col-span-2">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                    <div class="mb-2">
                        <img id="current-photo" src="{{ $teacher->photo ? Storage::url('teachers/' . $teacher->photo) : asset('images/default-teacher.png') }}" alt="{{ $teacher->name }}" 
                             class="h-20 w-20 rounded-full object-cover border-2 border-gray-200">
                        <p class="text-sm text-gray-500 mt-1">Foto saat ini</p>
                    </div>
                    <div class="mb-2">
                        <img id="photo-preview" src="" alt="Preview" 
                             class="h-20 w-20 rounded-full object-cover border-2 border-gray-200 hidden">
                        <p id="photo-preview-text" class="text-sm text-gray-500">Pilih foto baru untuk preview</p>
                    </div>
                    <input type="file" name="photo" id="photo" accept="image/*" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('photo') border-red-500 @enderror"
                           onchange="previewImage(this)">
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="address" id="address" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('address') border-red-500 @enderror">{{ old('address', $teacher->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div class="md:col-span-2">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Biografi</label>
                    <textarea name="bio" id="bio" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('bio') border-red-500 @enderror">{{ old('bio', $teacher->bio) }}</textarea>
                    @error('bio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $teacher->is_active) ? 'checked' : '' }} 
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Guru Aktif
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.teachers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('photo-preview');
    const previewText = document.getElementById('photo-preview-text');
    const currentPhoto = document.getElementById('current-photo');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            previewText.classList.add('hidden');
            currentPhoto.style.opacity = '0.5';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
        previewText.classList.remove('hidden');
        currentPhoto.style.opacity = '1';
    }
}

// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    
    function validatePassword() {
        if (password.value !== passwordConfirmation.value) {
            passwordConfirmation.setCustomValidity('Password confirmation does not match');
        } else {
            passwordConfirmation.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validatePassword);
    passwordConfirmation.addEventListener('input', validatePassword);
});
</script>
@endsection
