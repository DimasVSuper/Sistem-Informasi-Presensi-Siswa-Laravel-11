# Logical Record Structure (LRS)

LRS menggambarkan struktur record pada tabel-tabel database beserta relasi kuncinya (Primary & Foreign Key).

```mermaid
classDiagram
    class users {
        +bigint id PK
        +string name
        +string email UK
        +string password
        +timestamps
    }

    class orang_tua {
        +bigint id PK
        +string nama
        +string email UK
        +timestamps
    }

    class siswa {
        +bigint id PK
        +string nama
        +string nis UK
        +string qr_code UK
        +bigint orang_tua_id FK
        +timestamps
    }

    class presensi {
        +bigint id PK
        +bigint siswa_id FK
        +date tanggal
        +time waktu
        +string status
        +timestamps
    }

    orang_tua "1" -- "*" siswa : id = orang_tua_id
    siswa "1" -- "*" presensi : id = siswa_id
```

## Spesifikasi Tabel:
- **users**: Menyimpan kredensial administrator.
- **orang_tua**: Tabel master data wali murid untuk tujuan pengiriman notifikasi email.
- **siswa**: Tabel master data siswa dengan `qr_code` sebagai pengenal unik saat scanning.
- **presensi**: Tabel transaksi yang mencatat log kehadiran harian.
