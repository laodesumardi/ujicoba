@extends('layouts.app')

@section('title', 'Kebijakan Privasi - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Kebijakan Privasi</h1>
            <p class="text-lg text-gray-600">SMP Negeri 01 Namrole</p>
            <p class="text-sm text-gray-500 mt-2">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>

        <!-- Content -->
        <div class="prose prose-lg max-w-none">
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Informasi Penting:</strong> Kebijakan privasi ini menjelaskan bagaimana SMP Negeri 01 Namrole mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.
                        </p>
                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Informasi yang Kami Kumpulkan</h2>
            <p class="text-gray-700 mb-4">Kami mengumpulkan informasi pribadi yang Anda berikan secara sukarela, termasuk namun tidak terbatas pada:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Nama lengkap dan data identitas</li>
                <li>Alamat email dan nomor telepon</li>
                <li>Informasi akademik dan prestasi</li>
                <li>Data pendaftaran siswa baru (PPDB)</li>
                <li>Informasi kontak orang tua/wali</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. Penggunaan Informasi</h2>
            <p class="text-gray-700 mb-4">Informasi yang kami kumpulkan digunakan untuk:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Proses administrasi sekolah</li>
                <li>Komunikasi dengan siswa dan orang tua</li>
                <li>Penyelenggaraan kegiatan akademik</li>
                <li>Pelaporan kepada instansi terkait</li>
                <li>Peningkatan kualitas layanan pendidikan</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Perlindungan Data</h2>
            <p class="text-gray-700 mb-4">Kami berkomitmen untuk melindungi informasi pribadi Anda dengan:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Menggunakan sistem keamanan yang memadai</li>
                <li>Membatasi akses hanya kepada pihak yang berwenang</li>
                <li>Melakukan backup data secara berkala</li>
                <li>Mengikuti standar keamanan data yang berlaku</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Berbagi Informasi</h2>
            <p class="text-gray-700 mb-4">Kami tidak akan membagikan informasi pribadi Anda kepada pihak ketiga, kecuali:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Dengan persetujuan tertulis dari Anda</li>
                <li>Untuk memenuhi kewajiban hukum</li>
                <li>Untuk melindungi hak dan keamanan sekolah</li>
                <li>Dengan instansi pemerintah yang berwenang</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">5. Hak Anda</h2>
            <p class="text-gray-700 mb-4">Anda memiliki hak untuk:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Mengakses informasi pribadi Anda</li>
                <li>Meminta koreksi data yang tidak akurat</li>
                <li>Meminta penghapusan data (dengan batasan tertentu)</li>
                <li>Menolak penggunaan data untuk tujuan tertentu</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">6. Kontak</h2>
            <p class="text-gray-700 mb-4">Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi:</p>
            <div class="bg-gray-50 p-6 rounded-lg">
                <p class="text-gray-700 mb-2"><strong>SMP Negeri 01 Namrole</strong></p>
                <p class="text-gray-700 mb-2">Jl. Pendidikan No. 123, Namrole, Maluku Tengah</p>
                <p class="text-gray-700 mb-2">Telepon: (0911) 123456</p>
                <p class="text-gray-700">Email: smp01namrole@email.com</p>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500 text-center">
                    Kebijakan privasi ini dapat diperbarui sewaktu-waktu. Perubahan akan diumumkan melalui website resmi sekolah.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
