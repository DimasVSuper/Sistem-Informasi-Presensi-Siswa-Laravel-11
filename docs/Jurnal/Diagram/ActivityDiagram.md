# Activity Diagram

## Aktivitas Utama Presensi QR Code

```mermaid
stateDiagram-v2
    [*] --> BukaHalamanScan: Siswa membuka halaman scan
    BukaHalamanScan --> ScanQRCode: Sistem memulai kamera
    ScanQRCode --> PresensiController: Scan berhasil (QR Code didapat)
    
    state PresensiController {
        [*] --> ValidasiInline: Controller Request Check
        ValidasiInline --> CariSiswa: Valid
        
        CariSiswa --> SiswaDitemukan: Siswa Ada
        CariSiswa --> SiswaTidakAda: Siswa Tidak Ada
        
        SiswaTidakAda --> [*]: Return 404 (Error)
        
        SiswaDitemukan --> CekPresensiHariIni: Cek Double Scan
        CekPresensiHariIni --> BelumAbsen: Belum Ada
        CekPresensiHariIni --> SudahAbsen: Sudah Ada
        
        SudahAbsen --> [*]: Return 409 (Conflict)
        
        BelumAbsen --> SimpanPresensi: Buat Record Presensi
        SimpanPresensi --> KirimEmail: Langsung dari Controller
        KirimEmail --> [*]: Return 201 (Success)
    }

    PresensiController --> TampilkanHasil: Response JSON
    TampilkanHasil --> [*]: Selesai
```

### Narasi Aktivitas (Versi Tekstual)
1.  **Awal**: Siswa membuka aplikasi di perangkat mobile (PWA).
2.  **Scan**: Kamera aktif, siswa mengarahkan ke QR Code.
3.  **Request**: Frontend mengekstrak payload QR dan mengirim `POST` ke `/api/presensi`.
4.  **Proses di Controller**:
    *   Sistem mencari record siswa. Jika tidak ada -> Error 404.
    *   Sistem mengecek tabel presensi hari ini. Jika sudah ada -> Error 409.
5.  **Penyimpanan**: Jika lolos validasi, record presensi baru disimpan dalam database transaction.
6.  **Notifikasi**: Controller segera mengirim email `AttendanceNotification` ke orang tua setelah record berhasil disimpan.
7.  **Selesai**: Frontend menampilkan respon sukses ke siswa.
