@extends('layouts.ppdb-panitia')

@section('title', 'Detail Pendaftaran - ' . $registration->name)
@section('page-title', 'Detail Pendaftaran')
@section('page-description', 'Lihat dan kelola detail pendaftaran siswa')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('ppdb.panitia.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('ppdb.panitia.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Data Pendaftaran</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Detail Pendaftaran</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('ppdb.panitia.index') }}" 
               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">Status:</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                       ($registration->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                    {{ $registration->status === 'pending' ? 'Menunggu Verifikasi' : 
                       ($registration->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                </span>
            </div>
        </div>
        
        <div class="flex items-center space-x-2">
            @if($registration->status === 'pending')
            <button onclick="updateStatus('approved')" 
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                <i class="fas fa-check mr-2"></i>
                Setujui
            </button>
            <button onclick="updateStatus('rejected')" 
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                <i class="fas fa-times mr-2"></i>
                Tolak
            </button>
            @endif
            
            @if($registration->status === 'approved' && !$registration->userByEmail)
            <form method="POST" action="{{ route('ppdb.panitia.create-manual-account', $registration) }}" class="inline">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                    <i class="fas fa-user-plus mr-2"></i>
                    Buat Akun Siswa
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Student Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Siswa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIS</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->student_id ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->date_of_birth ? \Carbon\Carbon::parse($registration->date_of_birth)->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->gender ? ucfirst($registration->gender) : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Agama</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->religion ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kelas</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->class ?? '-' }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $registration->address ?? '-' }}</p>
                </div>
            </div>

            <!-- Parent Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Orang Tua</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Orang Tua</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->parent_name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Telepon Orang Tua</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->parent_phone ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Email Orang Tua</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->parent_email ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sekolah Asal</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->previous_school ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->graduation_year ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alasan Pindah</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->transfer_reason ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Registration Info -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pendaftaran</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Daftar</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($registration->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ $registration->status === 'pending' ? 'Menunggu Verifikasi' : 
                               ($registration->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                        </span>
                    </div>
                    @if($registration->processed_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Diproses</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($registration->processed_at)->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                    @if($registration->processed_by)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Diproses Oleh</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $registration->processedBy->name ?? 'Admin' }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Account Status -->
            @if($registration->userByEmail)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Akun</h3>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-sm text-gray-900">Akun siswa sudah dibuat</span>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.user-management.show', $registration->userByEmail) }}" 
                       class="text-sm text-blue-600 hover:text-blue-800">
                        Lihat profil siswa →
                    </a>
                </div>
            </div>
            @else
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Akun</h3>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-exclamation-circle text-yellow-500"></i>
                    <span class="text-sm text-gray-900">Belum ada akun siswa</span>
                </div>
                @if($registration->status === 'approved')
                <div class="mt-3">
                    <form method="POST" action="{{ route('ppdb.panitia.create-manual-account', $registration) }}">
                        @csrf
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                            <i class="fas fa-user-plus mr-2"></i>
                            Buat Akun Siswa
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endif

            <!-- Notes -->
            @if($registration->notes)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
                <p class="text-sm text-gray-900">{{ $registration->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <form id="statusForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status Pendaftaran</h3>
                    
                    <div class="mb-4">
                        <label for="modal_status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="modal_status" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending">Menunggu Verifikasi</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Tambahkan catatan jika diperlukan...">{{ $registration->notes }}</textarea>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" onclick="closeStatusModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStatus(status) {
    const form = document.getElementById('statusForm');
    const modal = document.getElementById('statusModal');
    const statusSelect = document.getElementById('modal_status');
    
    form.action = `{{ route('ppdb.panitia.update-status', $registration) }}`;
    statusSelect.value = status;
    modal.classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeStatusModal();
    }
});
</script>
@endsection
