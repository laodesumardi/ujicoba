@extends('layouts.admin')

@section('title', 'Detail Pendaftaran PPDB')
@section('page-title', 'Detail Pendaftaran PPDB')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-primary-900">Detail Pendaftaran</h2>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.ppdb.registrations') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Kembali ke Daftar
                        </a>
                        <button onclick="updateStatus('{{ $registration->id }}', '{{ $registration->status }}')" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Update Status
                        </button>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Student Information -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Siswa</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nomor Pendaftaran</label>
                                    <p class="text-gray-900 font-semibold">{{ $registration->registration_number }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Status</label>
                                    <div class="mt-1">
                                        @if($registration->status == 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu Review
                                            </span>
                                        @elseif($registration->status == 'approved')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Diterima
                                            </span>
                                        @elseif($registration->status == 'rejected')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                                    <p class="text-gray-900">{{ $registration->student_name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</label>
                                    <p class="text-gray-900">{{ $registration->birth_place }}, {{ $registration->birth_date->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                                    <p class="text-gray-900">{{ $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Agama</label>
                                    <p class="text-gray-900">{{ $registration->religion }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-sm font-medium text-gray-500">Alamat</label>
                                    <p class="text-gray-900">{{ $registration->address }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nomor Telepon</label>
                                    <p class="text-gray-900">{{ $registration->phone_number }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Email</label>
                                    <p class="text-gray-900">{{ $registration->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Parent Information -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Orang Tua/Wali</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nama Orang Tua</label>
                                    <p class="text-gray-900">{{ $registration->parent_name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nomor Telepon Orang Tua</label>
                                    <p class="text-gray-900">{{ $registration->parent_phone }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-sm font-medium text-gray-500">Pekerjaan Orang Tua</label>
                                    <p class="text-gray-900">{{ $registration->parent_occupation }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Akademik</h3>
                            <div class="space-y-4">
                                @if($registration->previous_school)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Sekolah Asal</label>
                                    <p class="text-gray-900">{{ $registration->previous_school }}</p>
                                </div>
                                @endif
                                
                                @if($registration->achievements)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Prestasi</label>
                                    <p class="text-gray-900">{{ $registration->achievements }}</p>
                                </div>
                                @endif
                                
                                @if($registration->motivation)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Motivasi Masuk Sekolah</label>
                                    <p class="text-gray-900">{{ $registration->motivation }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Admin Notes -->
                        @if($registration->notes)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-blue-900 mb-4">Catatan Admin</h3>
                            <p class="text-blue-800">{{ $registration->notes }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Registration Info -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pendaftaran</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Tanggal Daftar</label>
                                    <p class="text-gray-900">{{ $registration->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Terakhir Diupdate</label>
                                    <p class="text-gray-900">{{ $registration->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen</h3>
                            <div class="space-y-3">
                                @if($registration->photo)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Foto Siswa</label>
                                    <div class="mt-1">
                                        <a href="{{ route('admin.ppdb.download-document', [$registration, 'photo']) }}" 
                                           class="text-primary-600 hover:text-primary-700 text-sm">
                                            📷 Download Foto
                                        </a>
                                    </div>
                                </div>
                                @endif
                                
                                @if($registration->birth_certificate)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Akte Kelahiran</label>
                                    <div class="mt-1">
                                        <a href="{{ route('admin.ppdb.download-document', [$registration, 'birth_certificate']) }}" 
                                           class="text-primary-600 hover:text-primary-700 text-sm">
                                            📄 Download Akte
                                        </a>
                                    </div>
                                </div>
                                @endif
                                
                                @if($registration->family_card)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Kartu Keluarga</label>
                                    <div class="mt-1">
                                        <a href="{{ route('admin.ppdb.download-document', [$registration, 'family_card']) }}" 
                                           class="text-primary-600 hover:text-primary-700 text-sm">
                                            🏠 Download KK
                                        </a>
                                    </div>
                                </div>
                                @endif
                                
                                @if($registration->report_card)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Raport</label>
                                    <div class="mt-1">
                                        <a href="{{ route('admin.ppdb.download-document', [$registration, 'report_card']) }}" 
                                           class="text-primary-600 hover:text-primary-700 text-sm">
                                            📊 Download Raport
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                            <div class="space-y-3">
                                <button onclick="updateStatus('{{ $registration->id }}', '{{ $registration->status }}')" 
                                        class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-700 transition-colors">
                                    Update Status
                                </button>
                                <a href="{{ route('admin.ppdb.registrations') }}" 
                                   class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors text-center block">
                                    Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status Pendaftaran</h3>
                <form id="statusForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            <option value="pending">Menunggu Review</option>
                            <option value="approved">Diterima</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" placeholder="Masukkan catatan...">{{ $registration->notes }}</textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateStatus(registrationId, currentStatus) {
    document.getElementById('statusForm').action = `/admin/ppdb-registrations/${registrationId}/status`;
    document.getElementById('status').value = currentStatus;
    document.getElementById('statusModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('statusModal').classList.add('hidden');
}
</script>
@endsection
