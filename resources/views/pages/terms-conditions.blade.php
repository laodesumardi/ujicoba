@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - SMP Negeri 01 Namrole')

@section('content')
<div class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Syarat & Ketentuan</h1>
            <p class="text-lg text-gray-600">SMP Negeri 01 Namrole</p>
            <p class="text-sm text-gray-500 mt-2">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>

        <!-- Content -->
        <div class="prose prose-lg max-w-none">
            <div class="bg-green-50 border-l-4 border-green-400 p-6 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            <strong>Penting:</strong> Dengan menggunakan website dan layanan SMP Negeri 01 Namrole, Anda menyetujui syarat dan ketentuan yang berlaku.
                        </p>
                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Penggunaan Website</h2>
            <p class="text-gray-700 mb-4">Website ini dimaksudkan untuk:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Menyediakan informasi tentang sekolah</li>
                <li>Mendukung proses pembelajaran online</li>
                <li>Memfasilitasi komunikasi sekolah-masyarakat</li>
                <li>Menyediakan akses ke layanan akademik</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. Kewajiban Pengguna</h2>
            <p class="text-gray-700 mb-4">Sebagai pengguna, Anda berkewajiban untuk:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Menyediakan informasi yang akurat dan benar</li>
                <li>Menjaga kerahasiaan akun dan password</li>
                <li>Menggunakan website sesuai dengan tujuan pendidikan</li>
                <li>Menghormati hak kekayaan intelektual</li>
                <li>Tidak melakukan aktivitas yang merugikan sistem</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Larangan Penggunaan</h2>
            <p class="text-gray-700 mb-4">Dilarang keras untuk:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Menggunakan website untuk tujuan ilegal</li>
                <li>Menyebarkan konten yang tidak pantas</li>
                <li>Melakukan hacking atau merusak sistem</li>
                <li>Menggunakan akun orang lain</li>
                <li>Menyebarkan virus atau malware</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Hak Kekayaan Intelektual</h2>
            <p class="text-gray-700 mb-4">Semua konten di website ini dilindungi oleh hak cipta, termasuk:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Materi pembelajaran dan kurikulum</li>
                <li>Logo dan identitas visual sekolah</li>
                <li>Dokumen dan publikasi resmi</li>
                <li>Foto dan video kegiatan sekolah</li>
                <li>Software dan aplikasi yang digunakan</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">5. Layanan E-Learning</h2>
            <p class="text-gray-700 mb-4">Untuk layanan e-learning, berlaku ketentuan tambahan:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Akses hanya untuk siswa dan guru yang terdaftar</li>
                <li>Materi pembelajaran hanya untuk keperluan pendidikan</li>
                <li>Dilarang membagikan materi kepada pihak luar</li>
                <li>Wajib mengikuti jadwal pembelajaran yang ditetapkan</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">6. PPDB (Penerimaan Peserta Didik Baru)</h2>
            <p class="text-gray-700 mb-4">Ketentuan khusus untuk pendaftaran siswa baru:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Data yang diisi harus benar dan dapat dipertanggungjawabkan</li>
                <li>Dokumen pendukung harus asli dan valid</li>
                <li>Mengikuti prosedur pendaftaran yang ditetapkan</li>
                <li>Mematuhi jadwal dan deadline yang ditentukan</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">7. Pembatasan Tanggung Jawab</h2>
            <p class="text-gray-700 mb-4">Sekolah tidak bertanggung jawab atas:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Kerugian akibat penggunaan yang tidak tepat</li>
                <li>Gangguan teknis di luar kendali sekolah</li>
                <li>Konten yang diunggah oleh pengguna</li>
                <li>Kehilangan data akibat faktor eksternal</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">8. Perubahan Ketentuan</h2>
            <p class="text-gray-700 mb-4">Sekolah berhak mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Diumumkan melalui website resmi</li>
                <li>Diberitahukan kepada pengguna terdaftar</li>
                <li>Mulai berlaku setelah diumumkan</li>
                <li>Menjadi tanggung jawab pengguna untuk mengetahuinya</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">9. Penyelesaian Sengketa</h2>
            <p class="text-gray-700 mb-4">Sengketa akan diselesaikan melalui:</p>
            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                <li>Musyawarah dan mufakat terlebih dahulu</li>
                <li>Mediasi oleh pihak yang berwenang</li>
                <li>Hukum yang berlaku di Indonesia</li>
                <li>Pengadilan yang berwenang di Maluku Tengah</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">10. Kontak</h2>
            <p class="text-gray-700 mb-4">Untuk pertanyaan tentang syarat dan ketentuan, hubungi:</p>
            <div class="bg-gray-50 p-6 rounded-lg">
                <p class="text-gray-700 mb-2"><strong>SMP Negeri 01 Namrole</strong></p>
                <p class="text-gray-700 mb-2">Jl. Pendidikan No. 123, Namrole, Maluku Tengah</p>
                <p class="text-gray-700 mb-2">Telepon: (0911) 123456</p>
                <p class="text-gray-700">Email: smp01namrole@email.com</p>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500 text-center">
                    Dengan menggunakan website ini, Anda dianggap telah membaca, memahami, dan menyetujui semua syarat dan ketentuan yang berlaku.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
