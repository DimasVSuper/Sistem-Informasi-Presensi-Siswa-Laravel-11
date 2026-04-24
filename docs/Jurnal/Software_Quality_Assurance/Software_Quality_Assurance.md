# Software Quality Assurance (SQA)

## 1. Tujuan

Dokumen SQA ini menjelaskan strategi pengujian dan kualitas untuk Sistem Presensi Siswa berbasis Progressive Web App dengan QR Code dan notifikasi real-time. Ini mencakup rencana pengujian, test case, bug report, serta ringkasan uji performa dan keamanan.

## 2. Test Plan

### 2.1. Ruang Lingkup
- Validasi input QR Code dan endpoint API presensi.
- Pencatatan presensi siswa pada tanggal yang tepat.
- Penolakan presensi ganda dalam satu hari.
- Pengiriman notifikasi email ke orang tua.
- Fungsi PWA seperti manifest, service worker, dan tampilan scan.
- Keamanan akses dashboard admin.

### 2.2. Metode Pengujian
- Unit testing untuk model dan logika inti.
- Feature testing untuk API endpoints dan alur pengguna.
- Manual testing untuk PWA dan email notifikasi.
- Regression testing setelah perbaikan bug.

### 2.3. Alat dan Lingkungan
- PHPUnit untuk unit dan feature tests.
- Laravel test environment dengan `RefreshDatabase`.
- Browser manual untuk menguji halaman PWA dan scan QR.
- SMTP lokal atau mail trap untuk menguji pengiriman email.

## 3. Test Case

Daftar pengujian fungsionalitas sistem dibagi menjadi beberapa modul utama untuk memudahkan pelacakan:

- [TCL - Authentication (Login)](TCL.md)
- [TCS - Presence Scan (API & QR)](TCS.md)
- [TCD - Dashboard & Management](TCD.md)
- [TCP - Progressive Web App (PWA)](TCP.md)

## 4. Bug Report (Contoh Templat)

### Bug-001
- Deskripsi: QR Code valid tidak diproses saat data siswa tidak ditemukan.
- Status: Fixed.
- Tindakan: Perbaikan pada SiswaController untuk handle null student.

### Bug-002
- Deskripsi: Pencarian siswa tidak memfilter data.
- Status: Fixed.
- Tindakan: Implementasi query search pada `SiswaController@index`.

## 5. Hasil Uji Performa dan Keamanan

### 5.1. Performa
- Endpoint `POST /api/presensi` dioptimalkan dengan query sederhana.
- PWA menggunakan service worker untuk offline caching.

### 5.2. Keamanan
- Proteksi route dengan middleware `auth`.
- Validasi email orang tua menjadi nullable untuk fleksibilitas data.

## 6. Pemetaan Pengujian Otomatis (Feature Test)

| Modul | Dokumentasi | Feature Test (tests/Feature/) |
| :--- | :--- | :--- |
| **Authentication** | [TCL.md](TCL.md) | `TCLTest.php` |
| **Presence Scan** | [TCS.md](TCS.md) | `TCSTest.php` |
| **Management** | [TCD.md](TCD.md) | `TCDTest.php` |
| **PWA Check** | [TCP.md](TCP.md) | `TCPTest.php` |

## 7. Kesimpulan

Sistem telah didesain dengan pendekatan quality assurance yang mencakup pengujian fungsional, validasi keamanan, dan pemeriksaan kelayakan PWA. Dokumentasi ini menjadi pedoman agar setiap perubahan kode tetap terkontrol dan kualitas aplikasi tetap terjaga.