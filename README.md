# Inventory App (Inventory TIK)

## Deskripsi
Inventory App (Inventory TIK) adalah aplikasi berbasis web yang dikembangkan menggunakan framework Laravel.
Aplikasi ini digunakan untuk mengelola inventaris Teknologi Informasi dan Komunikasi (TIK), termasuk manajemen
barang, peminjaman, persetujuan (approval), serta pengelolaan pengguna dengan sistem role dan hak akses.

---

## Fitur Utama

### 🔐 Manajemen User & Role
- Manajemen pengguna (CRUD user)
- Sistem role & permission menggunakan **Spatie Laravel Permission**
- Role utama:
  - Super Admin
  - Admin
- Role user dengan dua profil:
  - Dosen
  - Mahasiswa

### 📦 Manajemen Inventory
- Pengelolaan data inventaris barang TIK
- Monitoring ketersediaan barang
- Manajemen data barang secara terpusat

### 🔄 Peminjaman & Approval
- Pengajuan peminjaman barang oleh user
- Proses approval peminjaman oleh Admin / Super Admin
- Monitoring status peminjaman barang

### 📊 Dashboard
- Dashboard overview untuk Admin & Super Admin
- Dashboard user (Dosen & Mahasiswa)
- Ringkasan data inventory dan peminjaman

### 📄 Upload Surat
- Upload surat pendukung peminjaman
- Penyimpanan file menggunakan storage Laravel

### 👤 Profil Pengguna
- Halaman profil pengguna
- Update data profil sesuai role

---

## Teknologi & Versi
- Laravel Framework: 12.38.1
- PHP: 8.3.16
- Database: MySQL

---

## Requirement Sistem
- PHP >= 8.3
- Composer
- Node.js & NPM
- Database MySQL
- Web Server (Apache / Nginx / Laravel Built-in Server)

> Perintah `npm run dev` diperlukan untuk menjalankan dan me-build asset frontend menggunakan Vite.

---

## Instalasi & Setup

1. Clone repository
```bash
git clone <repository-url>
cd inventory-app
````

2. Install dependensi backend

```bash
composer install
```

3. Install dependensi frontend

```bash
npm install
```

4. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

5. Konfigurasi database
   Sesuaikan pengaturan database pada file `.env`:

```env
DB_DATABASE=inventory_app
DB_USERNAME=root
DB_PASSWORD=
```

6. Migrasi database & seeder

```bash
php artisan migrate --seed
```

7. Jalankan asset frontend

```bash
npm run dev
```

8. Jalankan server aplikasi

```bash
php artisan serve
```

Akses aplikasi melalui:

```
http://127.0.0.1:8000
```

---

## Akun Default (Seeder)

Akun berikut tersedia secara default melalui database seeder:

| Role        | Email                                                   | Password |
| ----------- | ------------------------------------------------------- | -------- |
| Super Admin | [superadmin@example.com](mailto:superadmin@example.com) | password |
| Admin       | [admin@example.com](mailto:admin@example.com)           | password |
| Dosen       | [dosen@example.com](mailto:dosen@example.com)           | password |
| Mahasiswa   | [mahasiswa@example.com](mailto:mahasiswa@example.com)   | password |

> ⚠️ Disarankan untuk segera mengganti password setelah login pertama.

---

## Struktur Folder

```text
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controller aplikasi
│   │   ├── Middleware/      # Middleware (auth, role, dll)
│   │   └── Requests/        # Form request validation
│   ├── Models/              # Model Eloquent
│   └── Providers/           # Service providers
│
├── bootstrap/               # File bootstrap framework
│
├── config/                  # File konfigurasi aplikasi
│
├── database/
│   ├── migrations/          # File migrasi database
│   ├── seeders/             # Seeder akun default & role
│   └── factories/           # Factory model
│
├── public/
│   ├── css/                 # File CSS aplikasi
│   ├── js/                  # File JavaScript aplikasi
│   └── storage/             # Storage publik (symlink)
│
├── resources/
│   └── views/               # Blade templates
│
├── routes/
│   ├── web.php              # Route aplikasi web
│   └── api.php              # Route API (jika digunakan)
│
├── storage/
│   ├── app/                 # File upload (surat peminjaman)
│   ├── framework/           # Cache & session
│   └── logs/                # Log aplikasi
│
├── tests/                   # Unit & feature test
│
├── vendor/                  # Dependensi composer
│
├── .env                     # Konfigurasi environment
├── composer.json            # Konfigurasi Composer
├── package.json             # Konfigurasi NPM
├── vite.config.js           # Konfigurasi Vite
└── README.md                # Dokumentasi project
```

