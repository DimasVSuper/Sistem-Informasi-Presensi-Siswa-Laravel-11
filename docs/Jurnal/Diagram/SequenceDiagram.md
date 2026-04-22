# Sequence Diagram

## Alur Interaksi Presensi Siswa

```mermaid
sequenceDiagram
    participant S as Siswa
    participant F as Frontend (PWA)
    participant C as PresensiController
    participant DB as Database
    participant M as Mail (SMTP)

    Note over S,F: QRCode Scanning Phase
    S->>F: Buka Halaman Scan & Arahkan Kamera
    F->>F: Menangkap QR Code
    F->>C: POST /api/presensi {qr_code}
    
    rect rgb(240, 240, 240)
        Note over C,DB: logic processing
        C->>DB: findSiswaByQrCode(qr_code)
        DB-->>C: Siswa Object
        C->>DB: hasAlreadyPresensiToday(siswa_id)
        DB-->>C: False (Belum Absen)
        C->>DB: createPresensiRecord()
        DB-->>C: Presensi Object
    end

    rect rgb(240, 240, 240)
        Note over C,M: notification processing
        C->>M: Send AttendanceNotification
    end

    C-->>F: JSON Resource (201 Created)
    F-->>S: Tampilkan Pesan Berhasil & Detail
```

### Log Interaksi Pesan (Versi Tekstual)

1.  **Frontend (UI)** -> **Controller**: `POST /api/presensi` membawa `qr_code`.
2.  **Controller** -> **Database**: Query `Siswa` berdasarkan QR.
3.  **Controller** -> **Database**: Cek keberadaan `Presensi` untuk `siswa_id` pada tanggal hari ini.
4.  **Controller** -> **Database**: `Insert` record baru ke tabel `presensi`.
5.  **Controller** -> **Mail**: Membentuk objek `AttendanceNotification` dan mengirim via SMTP langsung setelah simpan berhasil.
6.  **Controller** -> **Frontend (UI)**: Response JSON 201 ditampilkan sebagai alert sukses di layar.
