# Website SMP Negeri 01 Namrole

Website resmi SMP Negeri 01 Namrole yang dibangun dengan Laravel dan Tailwind CSS.

## 🚀 Fitur Utama

### Frontend (Public)
- **Homepage** - Halaman utama dengan informasi sekolah
- **Profil Sekolah** - Sejarah, visi-misi, struktur organisasi
- **Tenaga Pendidik** - Daftar guru dan staff
- **Prestasi** - Pencapaian sekolah
- **Akreditasi** - Informasi akreditasi sekolah

### Backend (Admin)
- **Dashboard Admin** - Panel kontrol untuk mengelola konten
- **School Profile Management** - Kelola profil sekolah
- **Teacher Management** - Kelola data guru dan staff
- **Achievement Management** - Kelola prestasi sekolah
- **Authentication** - Sistem login/register yang aman

## 🛠️ Teknologi yang Digunakan

- **Laravel 11** - PHP Framework
- **Tailwind CSS** - CSS Framework
- **Laravel Breeze** - Authentication scaffolding
- **Vite** - Build tool
- **MySQL** - Database
- **Blade Templates** - Templating engine

## 🎨 Design Features

- **Responsive Design** - Mobile-first approach
- **Custom Color Scheme** - Warna konsisten #14213d
- **Professional Layout** - Clean dan modern
- **User-Friendly Navigation** - Intuitive menu system
- **Admin Dashboard** - Easy content management

## 📦 Instalasi

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL

### Setup
1. Clone repository:
```bash
git clone https://github.com/laodesumardi/namrole.git
cd namrole
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Setup environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=namrole
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations:
```bash
php artisan migrate
```

6. Create admin user:
```bash
php artisan admin:create "Admin SMP Namrole" admin@smpnamrole.com admin123
```

7. Build assets:
```bash
npm run build
```

8. Start server:
```bash
php artisan serve
```

## 🔐 Login Admin

**Email:** `admin@smpnamrole.com`  
**Password:** `admin123`

## 📁 Struktur Project

```
namrole/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   └── ProfilController.php
│   └── Models/             # Eloquent models
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   ├── views/
│   │   ├── admin/         # Admin views
│   │   ├── auth/         # Authentication views
│   │   ├── layouts/      # Layout templates
│   │   └── profil/       # Public views
│   └── css/app.css       # Tailwind CSS
├── routes/
│   ├── web.php           # Web routes
│   └── auth.php          # Auth routes
└── public/
    ├── logo.png          # School logo
    └── build/            # Compiled assets
```

## 🎯 Fitur Admin Dashboard

### School Profile Management
- Edit informasi sekolah
- Update visi dan misi
- Kelola struktur organisasi
- Update data akreditasi

### Teacher Management
- Tambah/edit data guru
- Kelola staff sekolah
- Update informasi pendidikan

### Achievement Management
- Tambah prestasi baru
- Edit prestasi existing
- Kategorisasi prestasi

## 🚀 Deployment

### Production Build
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Environment Setup
- Set `APP_ENV=production`
- Configure database credentials
- Set up web server (Apache/Nginx)
- Configure SSL certificate

## 📱 Responsive Design

Website fully responsive untuk:
- **Desktop** (1024px+)
- **Tablet** (768px - 1023px)
- **Mobile** (320px - 767px)

## 🎨 Customization

### Colors
Primary color: `#14213d` (dapat diubah di `tailwind.config.js`)

### Logo
Ganti file `public/logo.png` dengan logo sekolah

### Content
Semua konten dapat diubah melalui admin dashboard

## 📞 Support

Untuk pertanyaan atau bantuan, silakan hubungi:
- **Email:** admin@smpnamrole.com
- **Website:** [SMP Negeri 01 Namrole](http://localhost:8000)

## 📄 License

This project is licensed under the MIT License.

---

**Dibuat dengan ❤️ untuk SMP Negeri 01 Namrole**