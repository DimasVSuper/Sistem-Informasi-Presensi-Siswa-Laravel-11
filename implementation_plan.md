# Implementation Plan - Student Attendance System (PWA)

This plan outlines the steps to build a simple student attendance system using Laravel, MySQL, and PWA features.

## 1. Database & Models
- **Migrations**:
    - `create_orang_tua_table`: `id`, `nama`, `email`, `timestamps`.
    - `create_siswa_table`: `id`, `nama`, `nis`, `qr_code`, `orang_tua_id` (FK), `timestamps`.
    - `create_presensi_table`: `id`, `siswa_id` (FK), `tanggal`, `waktu`, `status`, `timestamps`.
- **Models**:
    - `OrangTua`: Has many `Siswa`.
    - `Siswa`: Belongs to `OrangTua`, Has many `Presensi`.
    - `Presensi`: Belongs to `Siswa`.

## 2. API Backend
- **Controller**: `PresensiController`
    - Method `store(Request $request)`:
        - Validate `qr_code`.
        - Find student by `qr_code`.
        - Check if student already attended today.
        - Save attendance record.
        - Trigger Email notification to parent.
- **Routes**:
    - `POST /api/presensi`: Mark attendance.

## 3. Email Notification
- Create `AttendanceNotification` Mailable.
- Simple HTML template for the email content.

## 4. Frontend (PWA)
- **Manifest**: `public/manifest.json`.
- **Service Worker**: `public/sw.js`.
- **QR Scanner Page**:
    - Use `html5-qrcode` library.
    - Vue.js (CDN) for handling scans and API calls.
    - Responsive UI for mobile users.

## 5. Setup & Configuration
- Configure `.env` for Database and Mail (Gmail SMTP).
- Run migrations and seeders (for testing).
