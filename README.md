# PresensiGo - Sistem Presensi Siswa Digital (PWA)

PresensiGo adalah aplikasi berbasis web (PWA) yang dirancang untuk mengelola absensi siswa menggunakan sistem pemindaian QR Code yang cepat, aman, dan modern. Aplikasi ini menghubungkan sekolah secara langsung dengan orang tua melalui notifikasi email otomatis.

## 🚀 Fitur Utama
- **QR Code Scanner**: Pemindaian cepat di sisi klien menggunakan kamera device.
- **QR Code Generator**: Otomasi pembuatan identitas digital unik untuk setiap siswa.
- **Notifikasi OTP/Email**: Pengiriman email otomatis ke orang tua saat siswa melakukan presensi.
- **Progressive Web App (PWA)**: Aplikasi dapat diinstal di Android/iOS dan mendukung mode offline dasar.
- **Admin Dashboard**: Manajemen data Master Siswa dan Orang Tua yang intuitif.

## 🛠️ Tech Stack
- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Tailwind CSS (CDN), Vue.js 3 (CDN for reactivity)
- **Library Utama**:
  - `html5-qrcode`: Untuk mesin pemindaian kamera.
  - `qrcodejs`: Untuk pembuatan kode QR.
  - `feather-icons`: Untuk antarmuka yang bersih.

## 📂 Struktur Folder Proyek
Kami menggunakan arsitektur **Clean Laravel 11** dengan struktur ramping:

- `app/Http/Controllers`: Menangani navigasi, validasi data, dan logika inti (KISS Pattern).
- `app/Models`: Definisi skema database dan otomatisasi event (seperti generate QR otomatis di `Siswa.php`).
- `app/Traits`: Logika yang dapat digunakan berulang (seperti standarisasi JSON Response API).
- `resources/views`: Menggunakan *Unified Layout API* di `app.blade.php` untuk konsistensi desain.
- `public/`: Berisi aset PWA seperti `manifest.json` dan `sw.js` (Service Worker).

## 📖 Dokumentasi Detail
Silakan baca dokumen berikut untuk pemahaman lebih dalam:
- [Arsitektur & Logic Flow](docs/ARCHITECTURE.md)
- [Panduan Pengguna & Instalasi](docs/README.md)
- [Dokumen Jurnal Proyek](docs/Jurnal/Manajemen_Proyek_Sistem_Informasi/Manajemen_Proyek_Sistem_Informasi.md)

## 🔧 Cara Instalasi
1. Clone repository
2. Jalankan `composer install`
3. Jalankan `npm install`
4. Setup `.env` (Database & Mail trap)
5. Jalankan `php artisan key:generate`
6. Jalankan migrasi & seeder: `php artisan migrate --seed`
7. Jalankan server: `php artisan serve` & `npm run dev`
