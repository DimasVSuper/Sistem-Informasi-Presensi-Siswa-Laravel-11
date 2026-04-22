# Permodelan Sistem Informasi PresensiGo

## 1. Pendahuluan
Dokumen ini merangkum seluruh pemodelan proses bisnis dan arsitektur teknis dari aplikasi **PresensiGo**. Fokus sistem adalah automasi pencatatan kehadiran menggunakan QR Code dengan integrasi notifikasi email ke orang tua.

## 2. Alur Proses Bisnis (Flowchart)

```mermaid
flowchart TD
    Start([Mulai]) --> Scan[Siswa Scan QR Code]
    Scan --> API[Request POST /api/presensi]
    
    subgraph Backend_Logic [Logika Backend]
        API --> Valid{Validasi QR?}
        Valid -- Tidak --> Err404[Error 404: Tidak Ditemukan]
        Valid -- Ya --> Double{Sudah Absen Hari Ini?}
        Double -- Ya --> Err409[Error 409: Sudah Absen]
        Double -- Tidak --> Save[Simpan Record Presensi]
    end
    
    Save --> Success[Tampilkan Sukses di UI]
    Save --> Observer[Trigger Observer]
    
    subgraph Notification [Sistem Notifikasi]
        Observer --> Mail[Kirim AttendanceNotification]
        Mail --> Parent([Orang Tua Terima Email])
    end
    
    Success --> End([Selesai])
    Err404 --> End
    Err409 --> End
```

## 3. Komponen Permodelan
Sistem ini dimodelkan menggunakan standar UML yang terdiri dari:

1.  **[Activity Diagram](ActivityDiagram.md)**: Menggambarkan alur kerja detail dari sisi pengguna dan sistem.
2.  **[Class Diagram](ClassDiagram.md)**: Peta struktur database, model Eloquent, dan relasi antar entitas.
3.  **[Package Diagram](PackageDiagram.md)**: Visualisasi layer arsitektur (Frontend, Controller, Service, Model).
4.  **[Sequence Diagram](SequenceDiagram.md)**: Detail interaksi pesan antar objek dalam satu siklus presensi.
5.  **[Use Case Diagram](Use_case.md)**: Gambaran interaksi aktor (Siswa, Admin, Orang Tua) terhadap fitur sistem.

## 4. Keselarasan dengan Projek
Pemodelan ini sepenuhnya mencerminkan implementasi pada kode sumber:
- **Service Layer**: Menggunakan `PresensiService` untuk memisahkan logika dari controller.
- **Eloquent Observers**: Menggunakan `PresensiObserver` untuk menangani *side-effect* kirim email agar tidak menghambat response time API.
- **Relasi Database**: Menggunakan relasi `BelongsTo` antara Siswa dan Orang Tua, serta Siswa dan Presensi.
- **PWA Ready**: Mendukung operasional mobile-first dengan antarmuka scanner yang responsif.

---
*Terakhir diperbarui: 22 April 2026*