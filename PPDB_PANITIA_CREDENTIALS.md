# Kredensial Login Panitia PPDB

## Informasi Login

Berikut adalah kredensial untuk mengakses dashboard panitia PPDB:

### 1. Dr. Siti Aminah, M.Pd (Kepala Sekolah)
- **Email**: `panitia1@smpnegeri01namrole.sch.id`
- **Password**: `panitia123`
- **Role**: Panitia PPDB
- **Jabatan**: Kepala Sekolah

### 2. Budi Santoso, S.Pd (Wakil Kepala Sekolah)
- **Email**: `panitia2@smpnegeri01namrole.sch.id`
- **Password**: `panitia123`
- **Role**: Panitia PPDB
- **Jabatan**: Wakil Kepala Sekolah Bidang Kesiswaan

### 3. Sari Indah, S.Pd (Guru BK)
- **Email**: `panitia3@smpnegeri01namrole.sch.id`
- **Password**: `panitia123`
- **Role**: Panitia PPDB
- **Jabatan**: Guru Bimbingan Konseling

### 4. Ahmad Rizki, S.Pd (Guru Matematika)
- **Email**: `panitia4@smpnegeri01namrole.sch.id`
- **Password**: `panitia123`
- **Role**: Panitia PPDB
- **Jabatan**: Guru Matematika

### 5. Maya Sari, S.Pd (Guru Bahasa Indonesia)
- **Email**: `panitia5@smpnegeri01namrole.sch.id`
- **Password**: `panitia123`
- **Role**: Panitia PPDB
- **Jabatan**: Guru Bahasa Indonesia / Sekretaris Panitia

## Cara Mengakses

1. Buka browser dan kunjungi: `http://127.0.0.1:8000/login`
2. Masukkan email dan password dari salah satu akun di atas
3. Setelah login, Anda akan diarahkan ke dashboard panitia PPDB
4. URL dashboard: `http://127.0.0.1:8000/ppdb/panitia/dashboard`

## Fitur yang Tersedia

### Dashboard
- Statistik pendaftaran PPDB
- Data pendaftaran terbaru
- Quick actions untuk akses cepat

### Manajemen Pendaftaran
- Lihat semua data pendaftaran
- Filter berdasarkan status (pending, approved, rejected)
- Update status pendaftaran
- Hapus pendaftaran
- Export data ke CSV

### Profile Management
- Lihat dan edit profil
- Upload foto profil
- Ubah password

### Notifikasi
- Sistem notifikasi real-time
- Badge counter untuk notifikasi baru

## Catatan Penting

- **Password Default**: Semua akun menggunakan password `panitia123`
- **Keamanan**: Disarankan untuk mengubah password setelah login pertama kali
- **Role**: Semua akun memiliki role `ppdb_panitia` dengan akses penuh ke dashboard panitia
- **Foto Profil**: Setiap akun memiliki foto profil default yang dapat diubah

## Troubleshooting

Jika mengalami masalah login:
1. Pastikan server Laravel berjalan (`php artisan serve`)
2. Pastikan database sudah di-migrate (`php artisan migrate`)
3. Pastikan seeder sudah dijalankan (`php artisan db:seed --class=PPDBPanitiaSeeder`)
4. Cek koneksi database di file `.env`

## Support

Untuk bantuan teknis, hubungi administrator sistem.
