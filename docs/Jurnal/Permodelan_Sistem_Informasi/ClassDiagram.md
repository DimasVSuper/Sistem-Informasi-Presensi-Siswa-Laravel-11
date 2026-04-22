# Class Diagram

## Kelas Utama Sistem

### Siswa
- `id`
- `nama`
- `nis`
- `qr_code`
- `orang_tua_id`

### OrangTua
- `id`
- `nama`
- `email`

### Presensi
- `id`
- `siswa_id`
- `tanggal`
- `waktu`
- `status`

### User
- `id`
- `name`
- `email`
- `password`

### Service
- `PresensiService`
- `SiswaService`
- `OrangTuaService`

### Controller
- `PresensiController`
- `AuthController`

## Relasi Antar Kelas
- `Siswa` -> `OrangTua` (belongsTo)
- `OrangTua` -> `Siswa` (hasMany)
- `Presensi` -> `Siswa` (belongsTo)
- `PresensiService` menggunakan `Presensi`, `Siswa`, dan `OrangTua`
