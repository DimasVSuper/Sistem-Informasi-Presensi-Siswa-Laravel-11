# Jurnal Permodelan Sistem Informasi
## Arsitektur dan Alur Bisnis PresensiGo

---

### KATA PENGANTAR

Puji syukur kami panjatkan ke hadirat Tuhan Yang Maha Esa atas terselesaikannya dokumen **Permodelan Sistem Informasi** untuk proyek **PresensiGo**. Dokumen ini merangkum seluruh pemodelan proses bisnis, arsitektur teknis, dan interaksi aktor dalam sistem presensi berbasis PWA dan QR Code.

Pemodelan ini dirancang untuk memastikan bahwa implementasi kode program selaras dengan kebutuhan fungsional dan memiliki struktur yang kokoh serta mudah dikembangkan.

---

### DAFTAR ISI
1. [**BAB I: PENDAHULUAN**](#bab-i-pendahuluan)
    - [1.1. Latar Belakang Permodelan](#11-pendahuluan)
2. [**BAB II: PEMODELAN SISTEM**](#bab-ii-pemodelan-sistem)
    - [2.1. Alur Proses Bisnis (Flowchart)](#21-alur-proses-bisnis-flowchart)
    - [2.2. Komponen UML (Diagram Hub)](#22-komponen-permodelan-uml)
    - [2.3. Keselarasan Arsitektur & Kode](#23-keselarasan-dengan-proyek)
3. [**BAB III: PENUTUP**](#bab-iii-penutup)
    - [3.1. Kesimpulan](#31-kesimpulan)

---

## BAB I: PENDAHULUAN

### 1.1. Pendahuluan
Dokumen ini merangkum seluruh pemodelan proses bisnis dan arsitektur teknis dari aplikasi **PresensiGo**. Fokus utama dari pemodelan ini adalah automasi pencatatan kehadiran menggunakan teknologi *QR Code* yang terintegrasi langsung dengan sistem notifikasi email kepada orang tua siswa. Pemodelan ini berfungsi sebagai jembatan antara kebutuhan bisnis dan implementasi teknis di Laravel 11.

---

## BAB II: PEMODELAN SISTEM

### 2.1. Alur Proses Bisnis (Flowchart)
Diagram berikut menjelaskan alur kerja sistem dari saat siswa melakukan pemindaian hingga orang tua menerima notifikasi.

```mermaid
flowchart TD
    Start([Mulai]) --> Scan[Siswa Scan QR Code]
    Scan --> API[Request POST /api/presensi]
    
    subgraph Backend_Logic [Logika Backend Laravel 11]
        API --> Valid{Validasi QR?}
        Valid -- Tidak --> Err404[Error 404: Tidak Ditemukan]
        Valid -- Ya --> Double{Sudah Absen Hari Ini?}
        Double -- Ya --> Err409[Error 409: Sudah Absen]
        Double -- Tidak --> Save[Simpan Record Presensi]
    end
    
    Save --> Success[Tampilkan Sukses di UI]
    Save --> Mail[Kirim AttendanceNotification]
    
    subgraph Notification [Sistem Notifikasi]
        Mail --> Parent([Orang Tua Terima Email])
    end
    
    Success --> End([Selesai])
    Err404 --> End
    Err409 --> End
```

### 2.2. Komponen Permodelan UML
Sistem ini dimodelkan menggunakan standar UML (Unified Modeling Language) untuk memberikan gambaran komprehensif dari berbagai sudut pandang.

| Diagram | Deskripsi | Tautan Detail |
|:---|:---|:---|
| **Use Case Diagram** | Menggambarkan interaksi aktor (Siswa, Admin, Ortu) terhadap fitur sistem. | [Lihat Detail](../Diagram/UseCaseDiagram.md) |
| **Activity Diagram** | Alur kerja detail dari sisi pengguna dan interaksi antarmuka sistem. | [Lihat Detail](../Diagram/ActivityDiagram.md) |
| **Class Diagram** | Struktur database, model Eloquent, dan relasi antar entitas (Siswa, Ortu, Presensi). | [Lihat Detail](../Diagram/ClassDiagram.md) |
| **Sequence Diagram** | Detail interaksi pesan antar objek dalam satu siklus presensi secara kronologis. | [Lihat Detail](../Diagram/SequenceDiagram.md) |
| **Package Diagram** | Visualisasi layer arsitektur sistem (Frontend, Controller, Model, Notification). | [Lihat Detail](../Diagram/PackageDiagram.md) |

### 2.3. Keselarasan dengan Proyek
Pemodelan ini sepenuhnya mencerminkan implementasi pada kode sumber:
- **Unified Controller**: Menggunakan `PresensiController` untuk menangani seluruh alur data secara efisien tanpa redundansi.
- **Model Events**: Implementasi hook `booted()` pada model `Siswa` untuk otomatisasi pembuatan *QR Code* unik setiap kali data siswa dibuat.
- **Eloquent Relationships**: Memanfaatkan relasi `BelongsTo` dan `HasMany` untuk integritas data antara Siswa, Orang Tua, dan Log Presensi.
- **PWA Architecture**: Desain mendukung operasional *mobile-first* dengan aset manifest dan service worker yang tervalidasi.

---

## BAB III: PENUTUP

### 3.1. Kesimpulan
Pemodelan sistem PresensiGo memberikan kerangka kerja yang jelas bagi pengembang dan pemangku kepentingan. Dengan alur yang terdefinisi dengan baik, sistem mampu menangani proses absensi secara cepat, aman, dan transparan, sekaligus menjaga kemudahan pemeliharaan kode di masa depan.

---
*Terakhir diperbarui: 28 April 2026*