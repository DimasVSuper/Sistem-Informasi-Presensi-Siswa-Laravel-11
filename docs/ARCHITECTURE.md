# Arsitektur PresensiGo

Dokumen ini menjelaskan alur teknis dan keputusan arsitektural yang diambil dalam pengembangan aplikasi PresensiGo.

## 🏛️ Pola Desain (Design Patterns)

### 1. Unified Controller Logic
Kami menggunakan pendekatan **KISS (Keep It Simple, St*pid)** dengan menempatkan logika bisnis langsung di Controller.
- **Manfaat**: Mempercepat pengembangan, mempermudah pelacakan alur data untuk aplikasi skala menengah, dan mengurangi kompleksitas file.

### 2. ApiResponser Trait
Digunakan untuk menstandarisasi output API di `app/Traits/ApiResponser.php`.
- **Format**:
  ```json
  {
    "success": true,
    "message": "...",
    "data": { ... }
  }
  ```

### 3. Model Events (Eloquent Lifecycle)
Otomasi data ditangani langsung oleh Model untuk menjamin integritas data:
- `Siswa.php`: Mengisi `qr_code` unik secara otomatis melalui method `booted()` saat record baru dibuat.

## 🔄 Alur Presensi (Scanning Flow)

1. **Frontend (Vue.js + html5-qrcode)**:
   - Scanner menangkap teks dari QR Code.
   - Mengirim POST request ke `/api/presensi`.
2. **Backend (PresensiController)**:
   - Menerima request dan melakukan validasi inline.
   - Menggunakan `DB::transaction` untuk memastikan integritas pencatatan.
   - Memeriksa keabsahan kode QR di database.
   - Memeriksa apakah siswa sudah absen hari ini.
   - Mencatat data presensi dalam tabel `presensi`.
   - Mengirimkan `AttendanceNotification` ke email orang tua secara langsung setelah record berhasil disimpan.

## 📱 Progressive Web App (PWA)

Aplikasi ini menggunakan:
- **`manifest.json`**: Mengatur nama aplikasi, icon, dan warna tema saat diinstal di homescreen.
- **`sw.js` (Service Worker)**: Mendukung *Cache-First strategy* untuk aset statis agar aplikasi tetap terbuka meski koneksi internet lambat.

---
[Kembali ke README Utama](../README.md)
