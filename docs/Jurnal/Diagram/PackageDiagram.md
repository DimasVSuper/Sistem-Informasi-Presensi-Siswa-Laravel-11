# Package Diagram

## Arsitektur Paket PresensiGo

```mermaid
flowchart TB
    subgraph Frontend [Resources & Public]
        ViewScan[QR/scan.blade.php]
        Manifest[manifest.json]
        SW[sw.js]
    end

    subgraph Http [Http Layer]
        Controller[PresensiController]
        Trait[ApiResponser]
    end

    subgraph Database [Eloquent Models]
        ModelSiswa[Siswa]
        ModelOrangTua[OrangTua]
        ModelPresensi[Presensi]
    end

    subgraph SideEffects [Mail]
        Mail[AttendanceNotification]
    end

    Frontend -- "POST /api/presensi" --> Http
    Http -- "Standardization" --> Trait
    Http -- "Logic & CRUD" --> Database
    Http -- "Direct Mail" --> Mail
```

### Daftar Komponen & Dependensi (Versi Tekstual)

- **Frontend (PWA)**:
    - `QR Scanner (Blade)` -> Entry point utama pemindaian.
    - `sw.js` -> Service worker untuk dukungan offline.
- **Backend (HTTP Layer)**:
    - `PresensiController` -> Menangani request, validasi, dan alur data utama (KISS).
    - `ApiResponser` -> Trait untuk standarisasi format output JSON.
- **Data (Eloquent Models)**:
    - `Siswa`, `OrangTua`, `Presensi`, `User`.
- **Side Effects (Mail)**:
    - `AttendanceNotification` -> Email yang dikirim langsung dari Controller setelah presensi berhasil dicatat.
