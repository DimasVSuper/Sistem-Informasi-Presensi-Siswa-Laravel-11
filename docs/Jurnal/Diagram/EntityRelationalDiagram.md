# Entity Relational Diagram (ERD)

Diagram ini menggambarkan hubungan antar entitas data dalam sistem PresensiGo.

```mermaid
erDiagram
    USER ||--o{ LOGS : manages
    ORANG_TUA ||--o{ SISWA : has
    SISWA ||--o{ PRESENSI : performs

    USER {
        bigint id PK
        string name
        string email
        timestamp email_verified_at
        string password
        string remember_token
        timestamps timestamps
    }

    ORANG_TUA {
        bigint id PK
        string nama
        string email UK
        timestamps timestamps
    }

    SISWA {
        bigint id PK
        string nama
        string nis UK
        string qr_code UK
        bigint orang_tua_id FK
        timestamps timestamps
    }

    PRESENSI {
        bigint id PK
        bigint siswa_id FK
        date tanggal
        time waktu
        string status
        timestamps timestamps
    }
```

## Deskripsi Hubungan:
1.  **Orang Tua ke Siswa**: Hubungan *One-to-Many*. Satu orang tua dapat memiliki lebih dari satu siswa yang terdaftar di sistem.
2.  **Siswa ke Presensi**: Hubungan *One-to-Many*. Satu siswa akan memiliki banyak catatan presensi seiring berjalannya waktu.
3.  **User (Admin)**: Bertindak sebagai pengelola seluruh data master (Siswa & Orang Tua) serta memantau log presensi.
