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
        Request[PresensiRequest]
    end

    subgraph Business [Service Layer]
        Service[PresensiService]
    end

    subgraph Database [Eloquent Models]
        ModelSiswa[Siswa]
        ModelOrangTua[OrangTua]
        ModelPresensi[Presensi]
    end

    subgraph SideEffects [Observers & Mail]
        Observer[PresensiObserver]
        Mail[AttendanceNotification]
    end
    

    Frontend -- POST /api/presensi --> Http
    Http -- dependency injection --> Business
    Business -- CRUD --> Database
    Database -- Event --> Observer
    Observer -- triggers --> Mail
```mermaid
flowchart TB
    subgraph Frontend [Resources & Public]
        ViewScan[QR/scan.blade.php]
        Manifest[manifest.json]
        SW[sw.js]
    end

    subgraph Http [Http Layer]
        Controller[PresensiController]
        Request[PresensiRequest]
    end

    subgraph Business [Service Layer]
        Service[PresensiService]
    end

    subgraph Database [Eloquent Models]
        ModelSiswa[Siswa]
        ModelOrangTua[OrangTua]
        ModelPresensi[Presensi]
    end

    subgraph SideEffects [Observers & Mail]
        Observer[PresensiObserver]
        Mail[AttendanceNotification]
    end
    

    Frontend -- POST /api/presensi --> Http
    Http -- dependency injection --> Business
    Business -- CRUD --> Database
    Database -- Event --> Observer
    Observer -- triggers --> Mail
```mermaid
flowchart TB
    subgraph Frontend [Resources & Public]
        ViewScan[QR/scan.blade.php]
        Manifest[manifest.json]
        SW[sw.js]
    end

    subgraph Http [Http Layer]
        Controller[PresensiController]
        Request[PresensiRequest]
    end

    subgraph Business [Service Layer]
        Service[PresensiService]
    end

    subgraph Database [Eloquent Models]
        ModelSiswa[Siswa]
        ModelOrangTua[OrangTua]
        ModelPresensi[Presensi]
    end

    subgraph SideEffects [Observers & Mail]
        Observer[PresensiObserver]
        Mail[AttendanceNotification]
    end


    Frontend -- POST /api/presensi --> Http
    Http -- dependency injection --> Business
    Business -- CRUD --> Database
    Database -- Event --> Observer
    Observer -- triggers --> Mail
```mermaid
flowchart TB
    subgraph Frontend [Resources & Public]
        ViewScan[QR/scan.blade.php]
        Manifest[manifest.json]
        SW[sw.js]
    end

    subgraph Http [Http Layer]
        Controller[PresensiController]
        Request[PresensiRequest]
    end

    subgraph Business [Service Layer]
        Service[PresensiService]
    end

    subgraph Database [Eloquent Models]
        ModelSiswa[Siswa]
        ModelOrangTua[OrangTua]
        ModelPresensi[Presensi]
    end

    subgraph SideEffects [Observers & Mail]
        Observer[PresensiObserver]
        Mail[AttendanceNotification]
    end
```

    Frontend -- POST /api/presensi --> Http
    Http -- dependency injection --> Business
    Business -- CRUD --> Database
    Database -- Event --> Observer
    Observer -- triggers --> Mail
```mermaid
flowchart TB
    subgraph Frontend [Resources & Public]
        ViewScan[QR/scan.blade.php]
        Manifest[manifest.json]
        SW[sw.js]
    end

    subgraph Http [Http Layer]
        Controller[PresensiController]
        Request[PresensiRequest]
    end

    subgraph Business [Service Layer]
        Service[PresensiService]
    end

    subgraph Database [Eloquent Models]
        ModelSiswa[Siswa]
        ModelOrangTua[OrangTua]
        ModelPresensi[Presensi]
    end

    subgraph SideEffects [Observers & Mail]
        Observer[PresensiObserver]
        Mail[AttendanceNotification]
    end
``

    Frontend -- POST /api/presensi --> Http
    Http -- dependency injection --> Business
    Business -- CRUD --> Database
    Database -- Event --> Observer
    Observer -- triggers --> Mail
```mermaid
flowchart TB
    subgraph Frontend [Resources & Public]
        ViewScan[QR/scan.blade.php]
        Manifest[manifest.json]
        SW[sw.js]
    end

    subgraph Http [Http Layer]
        Controller[PresensiController]
        Request[PresensiRequest]
    end

    subgraph Business [Service Layer]
        Service[PresensiService]
    end

    subgraph Database [Eloquent Models]
        ModelSiswa[Siswa]
        ModelOrangTua[OrangTua]
        ModelPresensi[Presensi]
    end

    subgraph SideEffects [Observers & Mail]
        Observer[PresensiObserver]
        Mail[AttendanceNotification]
    end
`

    Frontend -- POST /api/presensi --> Http
    Http -- dependency injection --> Business
    Business -- CRUD --> Database
    Database -- Event --> Observer
    Observer -- triggers --> Mail
```mermaid
flowchart TB
    subgraph Frontend [Resources & Public]
        ViewScan[QR/scan.blade.php]
        Manifest[manifest.json]
        SW[sw.js]
    end

    subgraph Http [Http Layer]
        Controller[PresensiController]
        Request[PresensiRequest]
    end

    subgraph Business [Service Layer]
        Service[PresensiService]
    end

    subgraph Database [Eloquent Models]
        ModelSiswa[Siswa]
        ModelOrangTua[OrangTua]
        ModelPresensi[Presensi]
    end

    subgraph SideEffects [Observers & Mail]
        Observer[PresensiObserver]
        Mail[AttendanceNotification]
    end


    Frontend -- POST /api/presensi --> Http
    Http -- dependency injection --> Business
    Business -- CRUD --> Database
    Database -- Event --> Observer
    Observer -- triggers --> Mail
```mermaid
flowchart TB
    subgraph Frontend [Resources & Public]
        ViewScan[QR/scan.blade.php]
        Manifest[manifest.json]
        SW[sw.js]
    end

    subgraph Http [Http Layer]
        Controller[PresensiController]
        Request[PresensiRequest]
    end

    subgraph Business [Service Layer]
        Service[PresensiService]
    end

    subgraph Database [Eloquent Models]
        ModelSiswa[Siswa]
        ModelOrangTua[OrangTua]
        ModelPresensi[Presensi]
    end

    subgraph SideEffects [Observers & Mail]
        Observer[PresensiObserver]
        Mail[AttendanceNotification]
    end
    

    Frontend -- POST /api/presensi --> Http
    Http -- dependency injection --> Business
    Business -- CRUD --> Database
    Database -- Event --> Observer
    Observer -- triggers --> Mail
```mermaid
flowchart TB
    subgraph Frontend [Resources & Public]
        ViewScan[QR/scan.blade.php]
        Manifest[manifest.json]
        SW[sw.js]
    end

    subgraph Http [Http Layer]
        Controller[PresensiController]
        Request[PresensiRequest]
    end

    subgraph Business [Service Layer]
        Service[PresensiService]
    end

    subgraph Database [Eloquent Models]
        ModelSiswa[Siswa]
        ModelOrangTua[OrangTua]
        ModelPresensi[Presensi]
    end

    subgraph SideEffects [Observers & Mail]
        Observer[PresensiObserver]
        Mail[AttendanceNotification]
    end

    Frontend -- POST /api/presensi --> Http
    Http -- dependency injection --> Business
    Business -- CRUD --> Database
    Database -- Event --> Observer
    Observer -- triggers --> Mail
```

### Daftar Komponen & Dependensi (Versi Tekstual)

- **Frontend (PWA)**:
    - `QR Scanner (Blade)` -> Entry point utama pemindaian.
    - `sw.js` -> Service worker untuk dukungan offline.
- **Backend (HTTP Layer)**:
    - `PresensiController` -> Menghubungkan API ke Service.
    - `PresensiRequest` -> Validasi data `qr_code`.
- **Logic (Service Layer)**:
    - `PresensiService` -> Jantung aplikasi; verifikasi QR & cegah double presensi.
- **Data (Eloquent Models)**:
    - `Siswa`, `OrangTua`, `Presensi`, `User`.
- **Events (Observers)**:
    - `PresensiObserver` -> Trigger otomatis kirim email setelah data masuk di `Presensi`.
