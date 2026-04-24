# Perancangan Sistem Informasi

## 1. Pendahuluan

Sistem Presensi Siswa berbasis Progressive Web App (PWA) ini dirancang untuk mencatat kehadiran siswa menggunakan QR Code dan memberi notifikasi real-time kepada orang tua melalui email. Proyek ini mengintegrasikan antarmuka pengguna mobile-friendly, service worker untuk dukungan offline, serta endpoint API untuk memproses scan QR dan menyimpan presensi.

## 2. UML (Use Case & Class Diagram)

### Use Case

Aktor utama:
- Admin
- Siswa
- Orang Tua

Use case utama:
- Admin membuat dan mengelola data siswa
- Admin membuat dan mengelola data orang tua
- Siswa melakukan scan QR untuk absen
- Sistem memvalidasi QR Code
- Sistem menyimpan presensi harian
- Sistem mengirim email notifikasi ke orang tua

### Class Diagram (Ringkas)

Komponen utama sistem:
- `Siswa`
- `OrangTua`
- `Presensi`
- `User`
- `PresensiController`
- `AuthController`
- `SiswaController`
- `OrangTuaController`

Relasi penting:
- `Siswa` memiliki `orang_tua_id`
- `Presensi` berelasi ke `Siswa`
- `PresensiController` bertanggung jawab atas logika validasi scan dan pengiriman notifikasi via email.

## 3. ERD (Entity Relationship Diagram)

Entitas dan relasi:
- `users`
  - `id`
  - `name`
  - `email`
  - `password`

- `orang_tua`
  - `id`
  - `nama`
  - `email` (Nullable)

- `siswa`
  - `id`
  - `nama`
  - `nis`
  - `qr_code`
  - `orang_tua_id`

- `presensi`
  - `id`
  - `siswa_id`
  - `tanggal`
  - `waktu`

Relasi:
- `siswa.orang_tua_id` -> `orang_tua.id`
- `presensi.siswa_id` -> `siswa.id`

## 4. DFD (Data Flow Diagram)

### Level 0 (Context)

- Pengguna (Siswa) melakukan scan QR
- Sistem menerima QR Code dan mengirim respons JSON
- Sistem mengirim notifikasi email ke Orang Tua

### Level 1

Proses utama:
1. Input QR Code dari layar scan
2. Validasi QR Code terhadap tabel `siswa`
3. Cek apakah sudah absen pada tanggal yang sama
4. Simpan data presensi ke tabel `presensi`
5. Kirim email notifikasi melalui `AttendanceNotification`

Data store:
- `Siswa`
- `Presensi`
- `OrangTua`

## 5. Rancangan Database

Tabel dan kolom utama:

### users
- `id`
- `name`
- `email`
- `email_verified_at`
- `password`
- `remember_token`
- `created_at`
- `updated_at`

### orang_tua
- `id`
- `nama`
- `email` (Nullable)
- `created_at`
- `updated_at`

### siswa
- `id`
- `nama`
- `nis`
- `qr_code`
- `orang_tua_id`
- `created_at`
- `updated_at`

### presensi
- `id`
- `siswa_id`
- `tanggal`
- `waktu`
- `created_at`
- `updated_at`

Constraint penting:
- `nis` unik pada tabel `siswa`
- `qr_code` unik pada tabel `siswa`
- `orang_tua_id` mengacu ke `orang_tua.id`
- `siswa_id` mengacu ke `siswa.id`

## 6. Rancangan Arsitektur Sistem

### Lapisan Frontend
- Progressive Web App dengan `public/manifest.json` dan `public/sw.js`
- Halaman scan QR: `resources/views/QR/scan.blade.php`
- Halaman generate QR siswa: `resources/views/QR/generate.blade.php`
- Static assets: `resources/css/app.css`, `resources/js/app.js`

### Lapisan Backend
- Laravel 11 sebagai framework utama
- Controller dan API (KISS Pattern):
  - `App\Http\Controllers\Api\PresensiController`
  - `App\Http\Controllers\AuthController`
  - `App\Http\Controllers\SiswaController`
  - `App\Http\Controllers\OrangTuaController`
  - `App\Http\Controllers\DashboardController`
- Validasi data ditangani secara inline di dalam method Controller.
- Otomasi data di tingkat Model:
  - `App\Models\Siswa` (QR Code auto-generation via `booted()` method)
  - `App\Models\Presensi` (Logika query scope)

### Integrasi Notifikasi
- Email notifikasi menggunakan `App\Mail\AttendanceNotification`
- Saat presensi berhasil, sistem memanggil `Mail::to($orangTua->email)->send(new AttendanceNotification(...))`

### Infrastruktur Data
- Database relasional (MySQL sesuai `.env` proyek)
- Tabel `users`, `siswa`, `orang_tua`, dan `presensi`

## 7. Kesesuaian dengan Proyek

Rancangan ini sesuai dengan kebutuhan sistem presensi berbasis QR Code dan PWA karena:
- mendukung validasi pengguna dan manajemen admin
- memberikan alur backend yang terpisah dan mudah diuji
- menggunakan PWA untuk instalasi dan cache offline sederhana
- mengirim notifikasi kepada orang tua sekaligus mencatat presensi siswa

---

Dokumentasi ini melengkapi `Perancangan Sistem Informasi` dan mendukung implementasi proyek PresensiGo.