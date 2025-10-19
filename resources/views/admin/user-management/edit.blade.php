@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Edit User</h1>
                        <p class="text-sm text-gray-500">Edit data {{ $user->name }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
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

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.user-management.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Informasi Dasar</h2>
                <p class="text-sm text-gray-500 mt-1">Detail akun dan peran user</p>
            </div>

            <div class="px-6 py-4 space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap user">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                           placeholder="Masukkan alamat email user">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input type="password" id="password" name="password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Kosongkan jika tidak ingin mengubah">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Peran (Role) <span class="text-red-500">*</span></label>
                    <select id="role" name="role" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        <option value="">Pilih Peran</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="teacher" {{ old('role', $user->role) == 'teacher' ? 'selected' : '' }}>Guru</option>
                        <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Siswa</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm font-medium text-gray-900">Aktif</label>
                </div>
            </div>

            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Informasi Tambahan (Opsional)</h2>
                <p class="text-sm text-gray-500 mt-1">Detail lebih lanjut tentang user</p>
            </div>

            <div class="px-6 py-4 space-y-6">
                <!-- Phone & Address -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Contoh: +6281234567890">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Masukkan alamat lengkap">
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Date of Birth & Gender -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_of_birth') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <select id="gender" name="gender"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('gender') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Religion -->
                <div>
                    <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                    <select id="religion" name="religion"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('religion') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('religion', $user->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen Protestan" {{ old('religion', $user->religion) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                        <option value="Kristen Katolik" {{ old('religion', $user->religion) == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                        <option value="Hindu" {{ old('religion', $user->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('religion', $user->religion) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('religion', $user->religion) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('religion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teacher Specific Fields -->
                <div id="teacher-fields" class="{{ old('role', $user->role) == 'teacher' ? '' : 'hidden' }} space-y-6">
                    <div>
                        <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip', $user->nip) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nip') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Masukkan NIP guru">
                        @error('nip')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="employment_status" class="block text-sm font-medium text-gray-700 mb-2">Status Kepegawaian</label>
                        <select id="employment_status" name="employment_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('employment_status') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            <option value="">Pilih Status</option>
                            <option value="PNS" {{ old('employment_status', $user->employment_status) == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="Honorer" {{ old('employment_status', $user->employment_status) == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                            <option value="Kontrak" {{ old('employment_status', $user->employment_status) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                        </select>
                        @error('employment_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Student Specific Fields -->
                <div id="student-fields" class="{{ old('role', $user->role) == 'student' ? '' : 'hidden' }} space-y-6">
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">NIS (Nomor Induk Siswa)</label>
                        <input type="text" id="student_id" name="student_id" value="{{ old('student_id', $user->student_id) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('student_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Masukkan NIS siswa">
                        @error('student_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="class" class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                        <input type="text" id="class" name="class" value="{{ old('class', $user->class) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('class') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Contoh: VII A">
                        @error('class')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('admin.user-management.index') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const teacherFields = document.getElementById('teacher-fields');
        const studentFields = document.getElementById('student-fields');

        function toggleRoleSpecificFields() {
            const selectedRole = roleSelect.value;

            if (selectedRole === 'teacher') {
                teacherFields.classList.remove('hidden');
                studentFields.classList.add('hidden');
            } else if (selectedRole === 'student') {
                teacherFields.classList.add('hidden');
                studentFields.classList.remove('hidden');
            } else {
                teacherFields.classList.add('hidden');
                studentFields.classList.add('hidden');
            }
        }

        roleSelect.addEventListener('change', toggleRoleSpecificFields);

        // Initial call to set visibility based on old input or current user role
        toggleRoleSpecificFields();
    });
</script>
@endsection
