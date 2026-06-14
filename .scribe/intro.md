# Introduction

API untuk Sistem Pengelolaan Nilai Siswa berbasis Laravel 13.

<aside>
    <strong>Base URL</strong>: <code>http://localhost:8000</code>
</aside>

Dokumentasi API untuk Sistem Pengelolaan Nilai Siswa.

API ini menggunakan autentikasi berbasis session. Untuk mengakses endpoint yang memerlukan autentikasi, login terlebih dahulu melalui `POST /api/login`.

Role yang tersedia:
- **admin**: Kelola siswa, guru, nilai, dan laporan
- **guru**: Input nilai dan melihat rekap
- **siswa**: Melihat nilai dan status kelulusan

