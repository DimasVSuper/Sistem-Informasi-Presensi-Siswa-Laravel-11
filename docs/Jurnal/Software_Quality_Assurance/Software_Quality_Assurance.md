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
- Unit testing untuk service dan validasi logika bisnis.
- Feature testing untuk API endpoints dan alur pengguna.
- Manual testing untuk PWA dan email notifikasi.
- Regression testing setelah perbaikan bug.

### 2.3. Alat dan Lingkungan
- PHPUnit untuk unit dan feature tests.
- Laravel test environment dengan `RefreshDatabase`.
- Browser manual untuk menguji halaman PWA dan scan QR.
- SMTP lokal atau mail trap untuk menguji pengiriman email.

## 3. Test Case

### 3.1. Validasi QR Code
- TC-001: Tanpa parameter `qr_code` mengembalikan 422.
- TC-002: `qr_code` null mengembalikan 422.
- TC-003: `qr_code` tidak ditemukan mengembalikan 404.

### 3.2. Presensi Sukses
- TC-004: Siswa yang valid dan belum absen hari ini berhasil menyimpan presensi.
- TC-005: Sistem mengirim email notifikasi ke orang tua setelah presensi berhasil.

### 3.3. Presensi Ganda
- TC-006: Siswa yang sudah absen hari ini tidak dapat absen ulang.
- TC-007: Sistem menampilkan pesan `Sudah absen hari ini` atau respons error sesuai alur.

### 3.4. Manajemen Data
- TC-008: Admin dapat menambah siswa baru dengan `nis`, `nama`, dan `orang_tua_id`.
- TC-009: Admin dapat memperbarui data siswa.
- TC-010: Admin dapat menghapus siswa.
- TC-011: Admin dapat menambah, memperbarui, dan menghapus data orang tua.

### 3.5. Akses dan Keamanan
- TC-012: Halaman dashboard hanya dapat diakses oleh pengguna yang terautentikasi.
- TC-013: Login gagal dengan kredensial tidak valid.

## 4. Bug Report (Contoh Templat)

### Bug-001
- Deskripsi: QR Code valid tidak diproses saat data siswa tidak ditemukan.
- Langkah Reproduksi:
  1. Scan QR Code siswa yang terdaftar.
  2. Kirim request `POST /api/presensi`.
  3. Sistem mengembalikan 404.
- Status: Ditemukan.
- Prioritas: Tinggi.
- Tindakan: Periksa logika pencarian `Siswa` pada `PresensiService`.

### Bug-002
- Deskripsi: Email notifikasi tidak terkirim karena konfigurasi SMTP tidak benar.
- Langkah Reproduksi:
  1. Lakukan presensi siswa.
  2. Pantau email yang dikirim.
  3. Tidak ada email diterima.
- Status: Ditemukan.
- Prioritas: Sedang.
- Tindakan: Verifikasi konfigurasi mail driver dan gunakan `Mail::failures()` jika perlu.

### Bug-003
- Deskripsi: Pengguna belum login dapat mengakses halaman dashboard.
- Langkah Reproduksi:
  1. Buka `/dashboard` tanpa autentikasi.
  2. Halaman terbuka.
- Status: Ditemukan.
- Prioritas: Tinggi.
- Tindakan: Terapkan middleware `auth` pada route dashboard.

## 5. Hasil Uji Performa dan Keamanan

### 5.1. Performa
- Endpoint `POST /api/presensi` dioptimalkan dengan query sederhana pada tabel `siswa` dan `presensi`.
- Logika `PresensiService` menggunakan transaksional DB untuk memastikan integritas data.
- PWA memuat halaman scan cepat dengan asset yang dicache melalui `service worker`.

### 5.2. Keamanan
- Validasi request pada `PresensiRequest`, `SiswaRequest`, `OrangTuaRequest`, dan `AuthRequest`.
- Otentikasi untuk dashboard admin menggunakan Laravel Auth.
- Input `qr_code`, `nis`, `email`, dan `orang_tua_id` divalidasi untuk mencegah data tidak valid.
- Data sensitif pengguna disimpan dengan hashing pada `password`.

### 5.3. Rekomendasi Perbaikan
- Tambahkan monitoring email delivery untuk memastikan notifikasi ditransmisikan.
- Gunakan HTTPS dan CSP pada deployment produksi.
- Lengkapi logging untuk transaksi presensi dan kegagalan notifikasi.
- Pertimbangkan retry email jika pengiriman awal gagal.

## 6. Kesimpulan

Sistem telah didesain dengan pendekatan quality assurance yang mencakup pengujian fungsional, validasi keamanan, dan pemeriksaan kelayakan PWA. Dokumentasi ini menjadi pedoman agar setiap perubahan kode tetap terkontrol dan kualitas aplikasi tetap terjaga.