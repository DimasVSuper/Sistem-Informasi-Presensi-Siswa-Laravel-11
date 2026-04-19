# Manajemen Proyek Sistem Informasi

## 1. Project Charter

### Judul Proyek
Pengembangan Sistem Presensi Siswa Berbasis Progressive Web App dengan QR Code dan Notifikasi Real-Time.

### Latar Belakang
Sekolah membutuhkan sistem presensi digital yang cepat, akurat, dan dapat terintegrasi dengan notifikasi kepada orang tua. PWA digunakan agar aplikasi dapat diakses di perangkat mobile dan desktop, sementara QR Code mempercepat proses absensi siswa.

### Tujuan Proyek
- Membangun sistem presensi siswa berbasis web yang responsif dan dapat diinstal sebagai PWA.
- Mengelola data siswa, orang tua, dan presensi dengan aman.
- Menghasilkan notifikasi email otomatis ke orang tua saat siswa melakukan presensi.
- Mengurangi kesalahan manual dalam pencatatan kehadiran.

### Lingkup Proyek
- Halaman scan QR Code untuk presensi.
- Manajemen data siswa dan orang tua melalui dashboard admin.
- API backend untuk memproses scanner dan menyimpan presensi.
- Fitur PWA dengan manifest dan service worker.
- Sistem notifikasi email ke orang tua.

### Tim Proyek
- Faqi — Project Manager
- Dimas — Fullstack Developer
- Shava — System Analyst
- Vina — Technical Writer
- Jamila — Technical Writer
- Maria — Quality Assurance

### Pemangku Kepentingan
- Sekolah sebagai pengguna utama.
- Orang tua siswa sebagai penerima notifikasi.
- Admin sekolah sebagai pengelola data.

### Waktu dan Anggaran
- Durasi estimasi: 6 minggu.
- Anggaran fokus pada pengembangan perangkat lunak, pengujian, dan dokumentasi.

## 2. Work Breakdown Structure (WBS)

### 2.1. Inisiasi
- Menentukan ruang lingkup proyek.
- Analisis kebutuhan pengguna.
- Penyusunan tim dan peran.

### 2.2. Perancangan Sistem
- Membuat UML, ERD, dan DFD.
- Merancang arsitektur sistem frontend dan backend.
- Menyusun dokumentasi desain.

### 2.3. Pengembangan
- Membangun model database dan migrasi.
- Mengembangkan backend Laravel.
- Mengembangkan frontend PWA dan halaman scan.
- Mengintegrasikan notifikasi email.

### 2.4. Pengujian
- Menyusun test case dan skenario.
- Melakukan unit test dan feature test.
- Validasi alur presensi dan notifikasi.

### 2.5. Dokumentasi dan Pelatihan
- Menyusun dokumentasi pengguna dan teknis.
- Menyusun laporan SQA.
- Menyiapkan materi presentasi.

### 2.6. Penyerahan
- Review akhir sistem.
- Perbaikan bug dan penyempurnaan.
- Serah terima sistem ke pihak sekolah.

## 3. Gantt Chart (Ringkasan)

| Tahap | Minggu 1 | Minggu 2 | Minggu 3 | Minggu 4 | Minggu 5 | Minggu 6 |
|---|---|---|---|---|---|---|
| Inisiasi & Analisis | x | x | | | | |
| Perancangan Sistem | | x | x | | | |
| Pengembangan Backend | | | x | x | | |
| Pengembangan Frontend | | | x | x | x | |
| Integrasi & Notifikasi | | | | x | x | |
| Pengujian & Perbaikan | | | | | x | x |
| Dokumentasi & Serah Terima | | | | | x | x |

> Catatan: Gantt chart ini bersifat ringkasan. Detil tugas mingguan dapat dilengkapi sesuai kebutuhan proyek.

## 4. Manajemen Risiko

### 4.1. Risiko Utama
- Keterlambatan pengembangan fitur.
- Bug pada workflow presensi dan notifikasi.
- Kegagalan penerimaan email oleh orang tua.
- Masalah kompatibilitas PWA pada perangkat tertentu.
- Ketergantungan pada koneksi internet.

### 4.2. Strategi Mitigasi
- Membagi pekerjaan menjadi modul kecil dan prioritas.
- Melakukan pengujian unit dan integrasi secara teratur.
- Menggunakan logging dan monitoring error.
- Menyediakan fallback pesan kesalahan jika email gagal.
- Menjamin caching dan fallback dasar melalui service worker.

### 4.3. Risiko Kualitas
- Validasi format QR Code dan input form.
- Akurasi pencatatan absensi per hari.
- Keamanan akses dashboard admin.
- Konsistensi data siswa dan orang tua.

## 5. Resource Allocation

### 5.1. Peran Tim
- Project Manager (Faqi): perencanaan, pengawasan jadwal, koordinasi tim.
- Fullstack Developer (Dimas): pengembangan backend dan frontend.
- System Analyst (Shava): analisis kebutuhan, pemodelan proses bisnis, desain sistem.
- Technical Writer (Vina & Jamila): dokumentasi teknis, laporan, dan manual.
- Quality Assurance (Maria): pengujian, review kualitas, dan bug tracking.

### 5.2. Sumber Daya Teknis
- Framework backend: Laravel 11.
- Frontend PWA: Blade + Tailwind + Vite.
- Database: MySQL atau database relasional serupa.
- Infrastruktur email: konfigurasi mail driver SMTP atau layanan pihak ketiga.

### 5.3. Kebutuhan Waktu
- Analisis & desain: 1–2 minggu.
- Pengembangan: 2–3 minggu.
- Pengujian & dokumentasi: 1–2 minggu.

## 6. Penutup

Dokumen manajemen proyek ini membantu memastikan proses pengembangan sistem presensi siswa berjalan terstruktur, terkontrol, dan sesuai tujuan. Dengan pembagian peran yang jelas dan manajemen risiko yang tepat, proyek dapat diselesaikan dengan kualitas yang baik.

