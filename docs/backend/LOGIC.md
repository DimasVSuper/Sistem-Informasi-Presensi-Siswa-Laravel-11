# Dokumentasi Backend (Logic & Arsitektur)

PresensiGo menggunakan pola **Service Layer** untuk memisahkan logika bisnis dari Controller. Berikut adalah detail komponen backend:

## 1. Models & Database
- **User**: Menyimpan data administrator untuk login dashboard.
- **Siswa**: Menyimpan identitas siswa (`nama`, `nis`) dan atribut unik `qr_code` (Generated otomatis di model).
- **OrangTua**: Menyimpan data orang tua (`nama`, `email`) yang akan dikirimi notifikasi.
- **Presensi**: Mencatat log kehadiran (`siswa_id`, `tanggal`, `waktu`).

## 2. Controller Logic (`app/Http/Controllers`)
Logika bisnis dikonsolidasikan dalam Controller untuk efisiensi:
- **`PresensiController`**: Menangani endpoint API `/api/presensi`. Melakukan validasi QR, pengecekan duplikasi harian, pencatatan database dalam transaksi, dan pengiriman email notifikasi.
- **`SiswaController`**: Manajemen CRUD data siswa.
- **`OrangTuaController`**: Manajemen CRUD data orang tua.

## 3. API Response (`app/Traits`)
Kami menggunakan `ApiResponser.php` untuk memastikan setiap endpoint API mengembalikan struktur JSON yang identik, memudahkan debugging dan integrasi frontend.

## 4. Model Events
Otomatisasi dijalankan di tingkat database melalui Eloquent Events:
- **`Siswa` Model**: Menggunakan method `booted()` dengan hook `creating` untuk memastikan setiap siswa memiliki `qr_code` unik sebelum tersimpan ke database.

---
[Kembali ke Dokumentasi Utama](../README.md)
