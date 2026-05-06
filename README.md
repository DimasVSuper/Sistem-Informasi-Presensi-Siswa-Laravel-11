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
- [Dokumentasi utama](docs/README.md)
- [Dokumentasi SQA](docs/Jurnal/Software_Quality_Assurance/Software_Quality_Assurance.md)

## 🔧 Cara Instalasi
1. Clone repository
2. Jalankan `composer install`
3. Jalankan `npm install`
4. Setup `.env` (Database & Mail trap)
5. Jalankan `php artisan key:generate`
6. Jalankan migrasi & seeder: `php artisan migrate --seed`
7. Jalankan server: `php artisan serve` & `npm run dev`

## ⚡ Performance Testing dengan K6
1. Install K6 di mesin Anda: https://k6.io/docs/getting-started/installation/
2. Pastikan aplikasi berjalan di http://localhost atau `http://projek3.test`
3. Jalankan:
   ```bash
   K6_BASE_URL=http://localhost k6 run tests/K6/load_testing.js
   ```
4. Jika Anda punya beberapa QR Code test, beri environment variable:
   ```bash
   K6_BASE_URL=http://localhost K6_QR_CODES=QR-API-TEST,QR-API-TEST2 k6 run tests/K6/load_testing.js
   ```

### Hasil Load Test Saat Ini
- Tes valid secara fungsional: semua respons `201`, `409`, `404`, atau `422` terverifikasi.
- Latensi rata-rata: `2.62s`
- `p(95)`: `5.34s`
- Threshold saat ini (`p(95)<3s` dan `avg<1.2s`) belum terpenuhi.

Untuk detail analisis SQA dan rekomendasi optimasi, lihat [Dokumentasi SQA](docs/Jurnal/Software_Quality_Assurance/Software_Quality_Assurance.md)
