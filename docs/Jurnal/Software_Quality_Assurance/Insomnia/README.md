# Insomnia Testing Guide

Dokumentasi ini menjelaskan cara menguji endpoint API PresensiGo menggunakan Insomnia.

## 1. Ruang Lingkup Pengujian
Insomnia menguji API dari sisi klien, sama seperti Postman:
- mengecek request/response untuk endpoint `POST /api/presensi`
- memverifikasi format respons JSON standar `ApiResponser`
- memastikan status code dan payload sesuai dengan ekspektasi

## 2. Persiapan
1. Pastikan server Laravel berjalan.
   - Contoh: `php artisan serve --host=127.0.0.1 --port=8000`
2. Pastikan `APP_URL` di `.env` sama dengan `http://127.0.0.1:8000` atau URL yang digunakan.
3. Pastikan database sudah berisi siswa dengan `qr_code` valid.
4. Atur mail driver jika perlu, misalnya `MAIL_MAILER=log`.

## 3. Import Koleksi Insomnia
Unduh file Insomnia berikut dari repository:
- `insomnia/PresensiGo.insomnia.json`

Setelah file diunduh, buka Insomnia dan pilih `Import/Export > Import Data > From File`, lalu pilih file JSON tersebut.

## 4. Environment Insomnia
Setelah import, periksa environment dasar:
- `base_url` = `http://127.0.0.1:8000`

## 5. Daftar Request
Koleksi Insomnia ini berisi request berikut:
- `Presensi Sukses`
- `Invalid QR Code`
- `Duplicate Presensi Hari Ini`
- `Missing QR Code`

## 6. Penggunaan Request
### 6.1. Presensi Sukses
1. Pilih request `Presensi Sukses`.
2. Pastikan URL `{{ base_url }}/api/presensi`.
3. Pastikan body JSON berisi `qr_code` valid.
4. Klik `Send`.
5. Verifikasi respon `201 Created` dan `success: true`.

### 6.2. Invalid QR Code
1. Pilih request `Invalid QR Code`.
2. Klik `Send`.
3. Verifikasi respon `404` dan `success: false`.

### 6.3. Duplicate Presensi Hari Ini
1. Pilih request `Duplicate Presensi Hari Ini`.
2. Klik `Send`.
3. Verifikasi respon `409` dan `success: false`.

### 6.4. Missing QR Code
1. Pilih request `Missing QR Code`.
2. Klik `Send`.
3. Verifikasi respon `422` dan error validasi `qr_code`.

## 7. Struktur Respons Standar
Semua respons menggunakan format `ApiResponser`:

```json
{
  "success": true | false,
  "message": "...",
  "data": object | array | null
}
```

## 8. Catatan Tambahan
- Insomnia dapat digunakan sebagai alternatif Postman untuk pengujian API.
- Jika ingin menguji endpoint lain, tambahkan request baru ke workspace.
- Untuk pengujian logika internal trait dan controller, gunakan PHPUnit.
