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
- **Frontend**: Tailwind CSS (Vite Engine), Vue.js 3 (CDN for reactivity)
- **Library Utama**:
  - `html5-qrcode`: Untuk mesin pemindaian kamera.
  - `qrcodejs`: Untuk pembuatan kode QR.
  - `feather-icons`: Untuk antarmuka yang bersih.

## 📂 Struktur Folder Proyek
Kami menggunakan arsitektur **Clean Code** dengan pemisahan tanggung jawab yang jelas:

- `app/Http/Controllers`: Menangani navigasi dan aliran data primer (KISS Pattern).
- `app/Http/Requests`: Menampung seluruh aturan validasi form secara terpusat.
- `app/Services`: **Jantung Aplikasi**. Seluruh logika bisnis (seperti proses scan, kirim email, dan generate QR unik) ada di sini.
- `app/Traits`: Logika yang dapat digunakan berulang (seperti standarisasi JSON Response API).
- `resources/views`: Menggunakan *Unified Layout API* di `app.blade.php` untuk konsistensi desain.
- `public/`: Berisi aset PWA seperti `manifest.json` dan `sw.js` (Service Worker).

## 📖 Dokumentasi Detail
Silakan baca dokumen berikut untuk pemahaman lebih dalam:
- [Arsitektur & Logic Flow](docs/ARCHITECTURE.md)
- [Panduan Pengguna & Instalasi](docs/README.md)

## 🔧 Cara Instalasi
1. Clone repository
2. Jalankan `composer install`
3. Jalankan `npm install`
4. Setup `.env` (Database & Mail trap)
5. Jalankan `php artisan key:generate`
6. Jalankan migrasi & seeder: `php artisan migrate --seed`
7. Jalankan server: `php artisan serve` & `npm run dev`
