# Unified Modeling Language (UML)

Dokumen ini berisi kumpulan diagram UML untuk sistem PresensiGo.

## 1. Use Case Diagram
Menggambarkan interaksi aktor (Admin & Siswa) dengan sistem.

```mermaid
flowchart LR
    subgraph Sistem_PresensiGo["Sistem PresensiGo"]
        UC1["Login Admin"]
        UC2["Kelola Data Siswa"]
        UC3["Kelola Data Orang Tua"]
        UC4["Scan QR Code"]
        UC5["Kirim Notifikasi Email"]
        UC6["Lihat Laporan Presensi"]
    end

    Admin["Admin"] --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC6

    Siswa["Siswa"] --> UC4
    UC4 -.-> UC5
```

---

## 2. Class Diagram
Menggambarkan struktur kelas controller, model, dan hubungannya.

```mermaid
classDiagram
    class Siswa {
        +string nama
        +string nis
        +string qr_code
        +booted()
    }
    
    class PresensiController {
        +store(Request)
    }
    
    class AttendanceNotification {
        +__construct(Siswa, Presensi)
        +envelope()
        +content()
    }
    
    class Mail {
        +to(email)
        +send(Mailable)
    }
    
    PresensiController ..> Siswa : uses
    PresensiController ..> AttendanceNotification : creates
    PresensiController ..> Mail : triggers
    AttendanceNotification --> Siswa : contains
```

---

## 3. Sequence Diagram (Proses Presensi)
Menggambarkan urutan pesan antar objek saat proses scanning berlangsung.

```mermaid
sequenceDiagram
    participant S as Kamera (Vue.js)
    participant C as PresensiController
    participant M as Siswa (Model)
    participant DB as Database
    participant E as Mail System

    S->>C: POST /api/presensi (qr_code)
    activate C
    C->>M: findByQrCode(qr_code)
    M->>DB: query student data
    DB-->>M: return data
    M-->>C: object Siswa
    
    alt Siswa Ditemukan
        C->>DB: Insert into presensi
        DB-->>C: success
        C->>E: Send AttendanceNotification
        E-->>C: mail sent
        C-->>S: 201 Created (Success JSON)
    else Siswa Tidak Ditemukan
        C-->>S: 404 Not Found (Error JSON)
    end
    deactivate C
```
