# Package Diagram

## Paket Sistem

### Frontend
- `QR Scanner`
- `Dashboard`
- `Master Data Siswa`
- `Master Data Orang Tua`

### Backend
- `API`
  - `POST /api/presensi`
- `Controllers`
  - `PresensiController`
  - `AuthController`
- `Services`
  - `PresensiService`
  - `SiswaService`
  - `OrangTuaService`
- `Models`
  - `Siswa`
  - `OrangTua`
  - `Presensi`
  - `User`
- `Requests`
  - `PresensiRequest`
  - `SiswaRequest`
  - `OrangTuaRequest`

## Dependensi Paket
- `Frontend` bergantung pada `API` untuk perekaman presensi.
- `Controllers` meneruskan permintaan ke `Services`.
- `Services` berinteraksi dengan `Models` untuk membaca dan menulis data.
- `Requests` memvalidasi input sebelum logika dijalankan.
