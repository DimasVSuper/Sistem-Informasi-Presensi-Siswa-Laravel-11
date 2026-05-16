# Postman Testing Guide

Dokumentasi ini menjelaskan cara menguji endpoint API PresensiGo menggunakan Postman.

## 1. Ruang Lingkup Pengujian
Postman cocok untuk menguji API dari sisi klien.
- Postman menguji request/response untuk endpoint `POST /api/presensi`.
- Postman dapat memverifikasi struktur JSON respons yang dihasilkan oleh `ApiResponser`.
- Postman juga dapat memeriksa status code, pesan error, dan payload data.

Namun, Postman tidak menguji logika internal kode PHP secara langsung. Untuk pengujian unit `ApiResponser` atau logika kontroler yang lebih detil, gunakan PHPUnit.

## 2. Persiapan
1. Pastikan server Laravel berjalan.
   - Contoh: `php artisan serve --host=127.0.0.1 --port=8000`
2. Pastikan `APP_URL` di `.env` sama dengan `http://127.0.0.1:8000` atau URL yang digunakan.
3. Pastikan database sudah terisi siswa dengan `qr_code` valid.
4. Jika menggunakan mail lokal, atur driver mail di `.env` ke `log` atau `smtp` sesuai kebutuhan.

## 3. Endpoint Utama
- URL: `POST {{base_url}}/api/presensi`
- Method: `POST`
- Auth: Tidak diperlukan.

## 4. Import Koleksi Postman
Gunakan file Postman collection dan environment template berikut:
- `postman/collections/PresensiGo.postman_collection.json`
- `postman/environments/PresensiGo.postman_environment.json`

Impor ke Postman melalui menu `File > Import` dan pilih kedua file tersebut.

## 4. Import Koleksi Insomnia
Gunakan file Insomnia berikut untuk mengimpor koleksi yang sama:
- `postman/insomnia/PresensiGo.insomnia.json`

Di Insomnia, pilih `Import/Export > Import Data > From File` lalu pilih file JSON tersebut.

## 5. Environment Postman
Buat environment Postman berikut jika belum menggunakan file template:
- `base_url` = `http://127.0.0.1:8000`

## 6. Format Request
Gunakan `raw` JSON pada tab `Body`:

```json
{
  "qr_code": "<qr_code_siswa>"
}
```

Contoh:

```json
{
  "qr_code": "f6e3a2d8-7ab4-4d09-bd8e-1e8f0265c9aa"
}
```

## 7. Format Respons Standar
Semua endpoint API PresensiGo menggunakan `ApiResponser` dengan struktur berikut:

```json
{
  "success": true | false,
  "message": "...",
  "data": object | array | null
}
```

Postman dapat memeriksa bahwa respons selalu konsisten pada struktur ini.

## 8. Skenario Pengujian
### 8.1. Kasus Sukses
- Status: `201 Created`
- Response body:

```json
{
  "success": true,
  "message": "Presensi berhasil dicatat. Notifikasi telah dikirim ke orang tua.",
  "data": {
    "nama": "Nama Siswa",
    "nis": "12345",
    "tanggal": "2026-05-05",
    "waktu": "07:45:21",
    "status": "Hadir"
  }
}
```

### 8.2. Kasus QR Code tidak valid
- Status: `404`
- Response body:

```json
{
  "success": false,
  "message": "Siswa tidak ditemukan. QR Code tidak valid.",
  "data": null
}
```

### 8.3. Kasus duplikat presensi hari ini
- Status: `409`
- Response body:

```json
{
  "success": false,
  "message": "Siswa <nama> sudah melakukan presensi hari ini.",
  "data": {
    "nama": "...",
    "nis": "..."
  }
}
```

### 8.4. Kasus validasi gagal
- Status: `422`
- Response body contoh:

```json
{
  "success": false,
  "message": "The given data was invalid.",
  "data": {
    "qr_code": [
      "The qr code field is required."
    ]
  }
}
```

## 9. Skrip Test Postman
Berikut contoh skrip test pada tab `Tests` di Postman:

```js
pm.test('Status code is 201', function () {
  pm.response.to.have.status(201);
});

pm.test('Response has correct JSON structure', function () {
  const jsonData = pm.response.json();
  pm.expect(jsonData).to.have.property('success');
  pm.expect(jsonData).to.have.property('message');
  pm.expect(jsonData).to.have.property('data');
});

pm.test('Response message is a string', function () {
  const jsonData = pm.response.json();
  pm.expect(jsonData.message).to.be.a('string');
});
```

Untuk skenario error, periksa status code yang diharapkan dan pastikan `jsonData.success` bernilai `false`.

## 10. Langkah Pengujian
### 10.1. Langkah Penggunaan Postman
1. Buka Postman.
2. Buat request baru atau gunakan request dari koleksi `PresensiGo API Tests`.
3. Pastikan environment `PresensiGo Local` aktif.
4. Masukkan URL: `{{base_url}}/api/presensi`.
5. Atur tab `Body` menjadi `raw` dan pilih `JSON`.
6. Tempel payload JSON.
7. Klik `Send`.
8. Periksa status code, body respons, dan hasil tests.

### 10.2. Langkah Penggunaan Insomnia
1. Buka Insomnia.
2. Impor file `postman/insomnia/PresensiGo.insomnia.json`.
3. Pastikan environment `Base Environment` sudah menggunakan `base_url` = `http://127.0.0.1:8000`.
4. Pilih request `Presensi Sukses`, `Invalid QR Code`, `Duplicate Presensi Hari Ini`, atau `Missing QR Code`.
5. Klik `Send`.
6. Periksa response status dan payload JSON.

Untuk panduan lengkap Insomnia, lihat `docs/Jurnal/Software_Quality_Assurance/Insomnia/Insomnia.md`.

## 11. Catatan Tambahan
- Email notifikasi dikirim ke `OrangTua.email`; bila mail driver belum dikonfigurasi, periksa log Laravel atau gunakan `MAIL_MAILER=log`.
- Pastikan siswa yang diuji sudah memiliki `qr_code` valid di tabel `siswa`.
- Endpoint ini tidak memerlukan autentikasi.
- Postman cukup untuk menguji flow scan presensi dan output API, tapi bukan pengganti PHPUnit untuk unit testing trait internal.
- Jika ingin menguji endpoint lain, tambahkan request baru ke koleksi Postman.
