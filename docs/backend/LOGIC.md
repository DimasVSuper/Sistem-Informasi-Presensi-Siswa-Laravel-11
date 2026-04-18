# Dokumentasi Backend (Logic & Arsitektur)

PresensiGo menggunakan pola **Service Layer** untuk memisahkan logika bisnis dari Controller. Berikut adalah detail komponen backend:

## 1. Models & Database
- **User**: Menyimpan data administrator untuk login dashboard.
- **Siswa**: Menyimpan identitas siswa (`nama`, `nis`) dan atribut unik `qr_code`.
- **OrangTua**: Menyimpan data orang tua (`nama`, `email`) yang akan dikirimi notifikasi.
- **Presensi**: Mencatat log kehadiran (`siswa_id`, `tanggal`, `waktu`).

## 2. Service Layer (`app/Services`)
Ini adalah tempat semua "keajaiban" algoritma terjadi:
- **`SiswaService`**: Menangani pembuatan QR Code unik secara otomatis dengan pengecekan redudansi data di database.
- **`PresensiService`**: Unit pemroses utama scanner. Menangani validasi ganda (siswa tidak bisa absen 2x dalam sehari) dan integrasi email.
- **`OrangTuaService`**: Manajemen CRUD relasi orang tua dan siswa.

## 3. Form Requests (`app/Http/Requests`)
Sentralisasi validasi untuk keamanan data:
- `SiswaRequest`: Memastikan NIS unik dan Orang Tua ID harus ada di database.
- `OrangTuaRequest`: Memastikan format email valid dan unik.
- `AuthRequest`: Validasi kredensial login admin.

## 4. API Response (`app/Traits`)
Kami menggunakan `ApiResponser.php` untuk memastikan setiap endpoint API mengembalikan struktur JSON yang identik, memudahkan debugging dan integrasi frontend.

---
[Kembali ke Dokumentasi Utama](../README.md)
