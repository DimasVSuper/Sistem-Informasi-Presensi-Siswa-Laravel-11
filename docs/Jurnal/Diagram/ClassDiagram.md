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

    class PresensiService {
        +processScan(qrCode)
        #findSiswaByQrCode()
        #hasAlreadyPresensiToday()
        #createPresensiRecord()
    }

    class PresensiController {
        +store(PresensiRequest)
    }

    class PresensiObserver {
        +created(Presensi)
    }

    Siswa "1" *-- "1" OrangTua : belongsTo
    Siswa "1" --* "n" Presensi : hasMany
    PresensiController ..> PresensiService : uses
    PresensiService ..> Siswa : manages
    PresensiService ..> Presensi : creates
    PresensiObserver ..> Presensi : observes
    PresensiObserver ..> OrangTua : notifies
```

### Struktur Detail Kelas (Versi Tekstual)
- **Model: Siswa**
    - Atribut: `id`, `nama`, `nis`, `qr_code`, `orang_tua_id`
    - Relasi: `belongsTo(OrangTua)`, `hasMany(Presensi)`
- **Model: OrangTua**
    - Atribut: `id`, `nama`, `email`
    - Relasi: `hasMany(Siswa)`
- **Model: Presensi**
    - Atribut: `id`, `siswa_id`, `tanggal`, `waktu`, `status`
    - Relasi: `belongsTo(Siswa)`
- **Service: PresensiService**
    - Metode Utama: `processScan(qrCode)` -> Mengembalikan array response.
- **Observer: PresensiObserver**
    - Trigger: `created(Presensi)` -> Mengirim email.
