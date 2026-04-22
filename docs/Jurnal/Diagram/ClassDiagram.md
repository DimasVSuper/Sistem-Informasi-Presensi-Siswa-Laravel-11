# Class Diagram

## Struktur Kelas Sistem PresensiGo

```mermaid
classDiagram
    class Siswa {
        +int id
        +string nama
        +string nis
        +string qr_code
        +int orang_tua_id
        +orangTua() BelongsTo
        +presensi() HasMany
    }

    class OrangTua {
        +int id
        +string nama
        +string email
        +siswa() HasMany
    }

    class Presensi {
        +int id
        +int siswa_id
        +date tanggal
        +time waktu
        +string status
        +siswa() BelongsTo
        +scopeForSiswaOnDate()
    }

    class User {
        +int id
        +string name
        +string email
        +string password
    }

    class PresensiController {
        +store(Request)
        #successResponse()
        #errorResponse()
    }

    class ApiResponser {
        <<trait>>
        +successResponse()
        +errorResponse()
    }

    Siswa "1" *-- "1" OrangTua : belongsTo
    Siswa "1" --* "n" Presensi : hasMany
    PresensiController ..> Siswa : queries
    PresensiController ..> Presensi : creates
    PresensiController ..> ApiResponser : uses
```

### Struktur Detail Kelas (Versi Tekstual)
- **Model: Siswa**
    - Atribut: `id`, `nama`, `nis`, `qr_code`, `orang_tua_id`
    - Relasi: `belongsTo(OrangTua)`, `hasMany(Presensi)`
    - Event: `booted()` -> Otomatis generate `qr_code` saat create.
- **Model: OrangTua**
    - Atribut: `id`, `nama`, `email`
    - Relasi: `hasMany(Siswa)`
- **Model: Presensi**
    - Atribut: `id`, `siswa_id`, `tanggal`, `waktu`, `status`
    - Relasi: `belongsTo(Siswa)`
- **Controller: PresensiController**
    - Method: `store(Request)` -> Validasi, Simpan, dan Kirim Email.
    - Trait: `ApiResponser` -> Standarisasi JSON.
