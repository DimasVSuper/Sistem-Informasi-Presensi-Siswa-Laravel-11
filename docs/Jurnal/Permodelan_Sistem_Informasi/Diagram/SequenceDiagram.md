# Sequence Diagram

## Alur Interaksi Presensi Siswa

```mermaid
sequenceDiagram
    participant S as Siswa
    participant F as Frontend (PWA)
    participant C as PresensiController
    participant SRV as PresensiService
    participant DB as Database
    participant OBS as PresensiObserver
    participant M as Mail (SMTP)

    Note over S,F: QRCode Scanning Phase
    S->>F: Buka Halaman Scan & Arahkan Kamera
    F->>F: Menangkap QR Code
    F->>C: POST /api/presensi {qr_code}
    
    rect rgb(240, 240, 240)
        Note over C,SRV: Logic processing
        C->>SRV: processScan(qr_code)
        SRV->>DB: findSiswaByQrCode(qr_code)
        DB-->>SRV: Siswa Object
        SRV->>DB: hasAlreadyPresensiToday(siswa_id)
        DB-->>SRV: False (Belum Absen)
        SRV->>DB: createPresensiRecord()
        DB-->>SRV: Presensi Object
    end

    SRV-->>C: array [success: true, data: ...]
    
    rect rgb(230, 245, 230)
        Note over DB,M: Async Trigger (Observer)
        DB-->>OBS: Created Event
        OBS->>DB: Get OrangTua Email
        OBS->>M: Send AttendanceNotification
    end

    C-->>F: JSON Resource (201 Created)
    F-->>S: Tampilkan Pesan Berhasil & Detail
```

### Log Interaksi Pesan (Versi Tekstual)

1.  **Frontend (UI)** -> **Controller**: `POST /api/presensi` membawa `qr_code`.
2.  **Controller** -> **Service**: `processScan(qr_code)` memulai validasi.
3.  **Service** -> **Database**: Query `Siswa` berdasarkan QR.
4.  **Service** -> **Database**: Cek keberadaan `Presensi` untuk `siswa_id` pada tanggal hari ini.
5.  **Service** -> **Database**: `Insert` record baru ke tabel `presensi`.
6.  **Database** -> **Observer**: Event `created` terpanggil saat insert berhasil.
7.  **Observer** -> **Mail**: Membentuk objek `AttendanceNotification` dan mengirim via SMTP.
8.  **Service** -> **Controller**: Mengembalikan status `success`.
9.  **Controller** -> **Frontend (UI)**: Response JSON 201 ditampilkan sebagai alert sukses di layar.
