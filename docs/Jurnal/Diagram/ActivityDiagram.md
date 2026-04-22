# Activity Diagram

## Aktivitas Utama Presensi QR Code

```mermaid
stateDiagram-v2
    [*] --> BukaHalamanScan: Siswa membuka halaman scan
    BukaHalamanScan --> ScanQRCode: Sistem memulai kamera
    ScanQRCode --> KirimAPI: Scan berhasil (QR Code didapat)
    
    state KirimAPI {
        [*] --> ValidasiRequest: PresensiRequest
        ValidasiRequest --> PanggilService: Data Valid
        PanggilService --> CariSiswa: Service mencari QR di DB
        
        CariSiswa --> SiswaDitemukan: Siswa Ada
        CariSiswa --> SiswaTidakAda: Siswa Tidak Ada
        
        SiswaTidakAda --> [*]: Return 404 (Error)
        
        SiswaDitemukan --> CekPresensiHariIni: Cek Double Scan
        CekPresensiHariIni --> BelumAbsen: Belum Ada
        CekPresensiHariIni --> SudahAbsen: Sudah Ada
        
        SudahAbsen --> [*]: Return 409 (Conflict)
        
        BelumAbsen --> SimpanPresensi: Buat Record Presensi
        SimpanPresensi --> TriggerObserver: Eloquent Created Event
        TriggerObserver --> [*]: Return 201 (Success)
    }

    state TriggerObserver {
        [*] --> AmbilDataOrangTua
        AmbilDataOrangTua --> KirimEmail: Email Tersedia
        KirimEmail --> [*]: AttendanceNotification Sent
    }

    KirimAPI --> TampilkanHasil: Response JSON
    TampilkanHasil --> [*]: Selesai
```

### Narasi Aktivitas (Versi Tekstual)
1.  **Awal**: Siswa membuka aplikasi di perangkat mobile (PWA).
2.  **Scan**: Kamera aktif, siswa mengarahkan ke QR Code.
3.  **Request**: Frontend mengekstrak payload QR dan mengirim `POST` ke `/api/presensi`.
4.  **Validasi**:
    *   Sistem mencari record siswa. Jika tidak ada -> Error 404.
    *   Sistem mengecek tabel presensi hari ini. Jika sudah ada -> Error 409.
5.  **Penyimpanan**: Jika lolos validasi, record presensi baru disimpan (ID siswa, tanggal, waktu, status).
6.  **Notifikasi**: `PresensiObserver` secara otomatis mendeteksi record baru dan mengirim email ke orang tua via SMTP.
7.  **Selesai**: Frontend menampilkan respon sukses ke siswa.
