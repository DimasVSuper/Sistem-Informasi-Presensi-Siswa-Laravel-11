# Arsitektur PresensiGo

Dokumen ini menjelaskan alur teknis dan keputusan arsitektural yang diambil dalam pengembangan aplikasi PresensiGo.

## 🏛️ Pola Desain (Design Patterns)

### 1. Service Layer Pattern
Kami memindahkan logika berat dari Controller ke kelas Service di `app/Services/`.
- **Manfaat**: Controller tetap ramping (*Skinny*), kode mudah dites, dan logika bisnis dapat dipanggil dari berbagai tempat (misal: dari API maupun Command Line).

### 2. Form Request Validation
Setiap data yang masuk divalidasi oleh kelas Request khusus di `app/Http/Requests/`.
- **Manfaat**: Memastikan Controller hanya menerima data yang sudah "bersih" dan sah.

### 3. ApiResponser Trait
Digunakan untuk menstandarisasi output API di `app/Traits/ApiResponser.php`.
- **Format**:
  ```json
  {
    "success": true,
    "message": "...",
    "data": { ... }
  }
  ```

## 🔄 Alur Presensi (Scanning Flow)

1. **Frontend (Vue.js + html5-qrcode)**:
   - Scanner menangkap teks dari QR Code.
   - Mengirim POST request ke `/api/presensi`.
2. **Backend (PresensiController)**:
   - Menerima request dan divalidasi oleh `PresensiRequest`.
   - Mengalihkan eksekusi ke `PresensiService`.
3. **Logika Bisnis (PresensiService)**:
   - Memeriksa keabsahan kode QR di database.
   - Memeriksa apakah siswa sudah absen hari ini (mencegah double scan).
   - Mencatat data presensi dalam tabel `presensi`.
4. **Notifikasi (Observer)**:
   - `PresensiObserver` akan merespon event `created` pada model `Presensi`.
   - Setelah presensi tercatat, observer mengirimkan `AttendanceNotification` ke email orang tua yang terdaftar.

## 🧩 Observer Pattern
Selain Service Layer, aplikasi ini juga menggunakan model observers untuk memisahkan efek samping:
- `SiswaObserver` mengisi `qr_code` secara otomatis saat record `Siswa` dibuat.
- `PresensiObserver` mengirim email notifikasi setelah record `Presensi` berhasil tersimpan.

## 📱 Progressive Web App (PWA)

Aplikasi ini menggunakan:
- **`manifest.json`**: Mengatur nama aplikasi, icon, dan warna tema saat diinstal di homescreen.
- **`sw.js` (Service Worker)**: Mendukung *Cache-First strategy* untuk aset statis agar aplikasi tetap terbuka meski koneksi internet lambat.

---
[Kembali ke README Utama](../README.md)
