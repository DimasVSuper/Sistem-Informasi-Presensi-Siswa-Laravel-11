# Postman Testing Guide

Dokumentasi ini menjelaskan cara menguji endpoint API PresensiGo menggunakan Postman.

## 1. Persiapan
1. Pastikan server Laravel berjalan.
   - Contoh: `php artisan serve --host=127.0.0.1 --port=8000`
2. Pastikan `APP_URL` di `.env` sama dengan `http://127.0.0.1:8000` atau URL yang digunakan.
3. Pastikan database sudah terisi siswa dengan `qr_code` valid.
4. Jika menggunakan mail lokal, atur driver mail di `.env` ke `log` atau `smtp` sesuai kebutuhan.

## 2. Endpoint Utama
- URL: `POST {{base_url}}/api/presensi`
- Method: `POST`
- Auth: Tidak diperlukan untuk endpoint ini.

## 3. Environment Postman
Buat environment Postman berikut:
- `base_url` = `http://127.0.0.1:8000`

## 4. Request Body
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

## 5. Validasi Respons
### 5.1. Kasus Sukses
- Status: `201 Created`
- Response body:

```json
{
  "success": true,
  "message": "Presensi berhasil dicatat",
  "data": {
    "id": 1,
    "siswa_id": 1,
    "tanggal": "2026-05-05",
    "waktu": "07:45:21",
    "status": "Hadir"
  }
}
```

### 5.2. Kasus QR Code tidak valid
- Status: `404`
- Response body:

```json
{
  "success": false,
  "message": "Siswa tidak ditemukan.",
  "data": null
}
```

### 5.3. Kasus duplikat presensi hari ini
- Status: `409`
- Response body:

```json
{
  "success": false,
  "message": "Siswa sudah melakukan presensi hari ini.",
  "data": null
}
```

### 5.4. Kasus validasi gagal
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

## 6. Skrip Test Postman
Berikut contoh skrip test pada tab `Tests` di Postman:

```js
pm.test('Status code is 201', function () {
  pm.response.to.have.status(201);
});

pm.test('Response has success true', function () {
  const jsonData = pm.response.json();
  pm.expect(jsonData.success).to.eql(true);
});

pm.test('Response contains message', function () {
  const jsonData = pm.response.json();
  pm.expect(jsonData.message).to.be.a('string');
});
```

Untuk skenario error, gunakan skrip test yang sama tetapi periksa status yang diharapkan dan `success` false.

## 7. Langkah Pengujian
1. Buka Postman.
2. Buat request baru dengan method `POST`.
3. Masukkan URL: `{{base_url}}/api/presensi`.
4. Atur tab `Body` menjadi `raw` dan pilih `JSON`.
5. Tempel payload JSON.
6. Klik `Send`.
7. Periksa status code dan body respons.

## 8. Catatan Tambahan
- Email notifikasi dikirim ke `OrangTua.email`; bila mail driver belum dikonfigurasi, periksa log Laravel.
- Pastikan siswa yang diuji sudah memiliki `qr_code` valid di tabel `siswa`.
- Endpoint ini tidak memerlukan autentikasi, sehingga mudah diuji secara cepat.
