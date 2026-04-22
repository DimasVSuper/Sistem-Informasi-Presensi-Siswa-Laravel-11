# Use Case Sistem Presensi Siswa

## Use Case Diagram

```mermaid
flowchart LR
    Admin((Admin))
    SiswaActor((Siswa))
    OrangTuaActor((Orang Tua))
    
    subgraph Sistem_PresensiGo [PresensiGo System]
        UC1(Kelola Data Siswa)
        UC2(Kelola Data Orang Tua)
        UC3(Login Dashboard)
        UC4(Scan QR Code Presensi)
        UC5(Validasi QR & Double Scan)
        UC6(Kirim Notifikasi Email)
        UC7(Lihat Riwayat Presensi)
    end
    
    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC7
    
    SiswaActor --> UC4
    
    UC4 ..> UC5 : << include >>
    UC5 ..> UC6 : << include >>
    
    UC6 --- OrangTuaActor
```

## Struktur Deskripsi Use Case (Versi Tekstual)

### 1. Absensi Siswa (Scanning)
- **Primary Actor**: Siswa
- **Pre-condition**: Siswa berada di halaman `/scan` dan memiliki QR Code valid.
- **Main Success Scenario**:
    1. Siswa scan QR.
    2. Sistem memvalidasi QR.
    3. Sistem memvalidasi presensi harian (mencegah ganda).
    4. Sistem mencatat waktu kehadiran.
    5. Sistem mengirim email notifikasi ke orang tua.
    6. Siswa melihat feedback "Berhasil".

### 2. Manajemen Data Master
- **Primary Actor**: Admin
- **Main Success Scenario**:
    1. Admin login ke dashboard.
    2. Admin menginput data Orang Tua (Email).
    3. Admin menginput data Siswa dan menautkannya ke Orang Tua.
    4. Sistem otomatis meng-generate QR Code unik untuk Siswa tersebut.

### 3. Monitoring Notifikasi
- **Primary Actor**: Sistem (Automation)
- **Description**: Menjamin setiap data presensi yang masuk diikuti dengan pengiriman bukti kehadiran ke email orang tua tanpa intervensi manual.
