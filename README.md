# Sistem Pengelolaan Nilai Siswa

Aplikasi web berbasis **Laravel 13** untuk mengelola nilai siswa. Dibangun sebagai bagian dari sertifikasi **LSP Programmer Skema**.

---

## 🎯 Fitur Utama

- **Autentikasi berbasis peran** (Admin, Guru, Siswa)
- **CRUD lengkap** untuk data Siswa, Guru, dan Nilai oleh Admin
- **Input nilai** oleh Guru dengan perhitungan otomatis
- **Perhitungan nilai akhir** menggunakan rumus:
  ```
  Nilai Akhir = (30% × Tugas) + (30% × UTS) + (40% × UAS)
  ```
- **Status kelulusan** otomatis: ≥ 70 = Lulus, < 70 = Tidak Lulus
- **Laporan nilai** dengan filter kelas dan status
- **Tampilan cetak** laporan
- **Sidebar navigation** yang responsif

---

## 🛠️ Teknologi

| Komponen | Versi |
|----------|-------|
| PHP | 8.5 |
| Laravel Framework | 13.x |
| Tailwind CSS | 4.x (via CDN) |
| Database | SQLite |
| Testing | Pest 4 |

---

## 🚀 Instalasi

### 1. Clone repository dan install dependency

```bash
cd sistem-pengelolaan-nilai-laravel
composer install
```

### 2. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

Pastikan konfigurasi database di `.env` menggunakan SQLite:

```env
DB_CONNECTION=sqlite
# DB_DATABASE= absolute path ke database/database.sqlite
```

### 3. Buat file database

```bash
touch database/database.sqlite
```

### 4. Jalankan migrasi dan seeder

```bash
php artisan migrate:fresh --seed
```

### 5. Jalankan aplikasi

```bash
composer run dev
```

Aplikasi akan berjalan di:

- Aplikasi: `http://127.0.0.1:8000`
- Vite dev server: `http://localhost:5173`

---

## 👤 Akun Demo

Semua akun demo menggunakan password: **`password`**

| Peran | Email |
|-------|-------|
| Admin | `admin@sekolah.test` |
| Guru | `budisantoso@sekolah.test` |
| Guru | `anirahmawati@sekolah.test` |
| Guru | `dedikurniawan@sekolah.test` |
| Siswa | `andi@siswa.test` |
| Siswa | `bunga@siswa.test` |
| Siswa | `candra@siswa.test` |
| Siswa | `dewi@siswa.test` |
| Siswa | `eko@siswa.test` |
| Siswa | `fitri@siswa.test` |
| Siswa | `gilang@siswa.test` |
| Siswa | `hana@siswa.test` |
| Siswa | `irfan@siswa.test` |
| Siswa | `jasmine@siswa.test` |

---

## 📂 Struktur Fitur

| Role | Akses |
|------|-------|
| **Admin** | Dashboard, Kelola Siswa, Kelola Guru, Kelola Nilai, Laporan |
| **Guru** | Dashboard, Rekap Nilai, Input Nilai |
| **Siswa** | Dashboard Nilai Saya, Status Kelulusan |

---

## 🧪 Testing

Aplikasi ini dilengkapi dengan **80 test** menggunakan Pest:

```bash
# Jalankan semua test
php artisan test --compact

# Jalankan test tertentu
php artisan test --compact --filter=AuthTest
```

Hasil terakhir:

```text
80 tests passed, 160 assertions
```

---

## 🧮 Paradigma Pemrograman

Proyek ini menggabungkan dua paradigma pemrograman:

### 1. Pemrograman Terstruktur (Structured Programming)

Implementasi pada `app/Helpers/NilaiHelper.php`:

- `validasiNilai()` — validasi rentang nilai 0–100
- `hitungNilaiAkhir()` — perhitungan nilai akhir berdasarkan bobot
- `tentukanStatusKelulusan()` — menentukan lulus/tidak lulus
- `generateLaporan()` — membuat statistik laporan

### 2. Pemrograman Berorientasi Objek (OOP)

Implementasi pada model-model Eloquent:

- `User` — autentikasi dan relasi peran
- `Siswa` — data siswa dan laporan nilai pribadi
- `Guru` — data guru dan input nilai
- `Nilai` — data nilai dengan event `saving` untuk perhitungan otomatis

Model-model OOP memanggil fungsi-fungsi terstruktur dari `NilaiHelper`.

---

## 📁 Struktur File Penting

```
app/
├── Helpers/
│   └── NilaiHelper.php           # Fungsi terstruktur
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php   # CRUD admin
│   │   ├── Auth/
│   │   │   └── LoginController.php
│   │   ├── GuruController.php    # Fitur guru
│   │   ├── SiswaController.php   # Fitur siswa
│   │   └── LaporanController.php # Laporan
│   └── Middleware/
│       └── RoleMiddleware.php    # Middleware role-based
├── Models/
│   ├── User.php
│   ├── Siswa.php
│   ├── Guru.php
│   └── Nilai.php

database/seeders/
└── DatabaseSeeder.php            # Seeder akun demo

resources/views/
├── layouts/app.blade.php         # Layout sidebar
├── auth/login.blade.php
├── admin/                        # View admin
├── guru/                         # View guru
├── siswa/                        # View siswa
└── laporan/                      # View laporan

tests/
├── Feature/
│   ├── AuthTest.php
│   ├── AdminTest.php
│   ├── GuruTest.php
│   ├── SiswaTest.php
│   ├── LaporanTest.php
│   └── ModelsTest.php
└── Unit/
    └── NilaiHelperTest.php
```

---

## 📝 Dokumentasi Lengkap

Untuk dokumentasi teknis lengkap mencakup analisis sistem, desain database, diagram kelas, dan penjelasan pengujian, lihat file:

📄 [`DOKUMENTASI_SISTEM.md`](DOKUMENTASI_SISTEM.md)

---

## ⚠️ Catatan Penting

- Aplikasi menggunakan **Tailwind CSS via CDN**, bukan Vite build. Jika menjalankan `npm run dev`, Vite hanya sebagai development server, styling tetap dihandle CDN.
- Pastikan tidak ada file `public/hot` yang tertinggal jika beralih dari Vite ke CDN. Jika UI tampil putih, hapus dengan: `rm -f public/hot && rm -rf public/build`

---

## 📜 Lisensi

Proyek ini dibuat untuk keperluan pembelajaran dan sertifikasi LSP.
