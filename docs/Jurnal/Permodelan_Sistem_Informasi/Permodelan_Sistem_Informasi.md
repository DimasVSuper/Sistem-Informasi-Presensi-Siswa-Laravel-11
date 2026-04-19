# Permodelan Sistem Informasi

## 1. Pendahuluan

Dokumen ini menjelaskan pemodelan proses bisnis sistem Presensi Siswa berbasis Progressive Web App (PWA) dengan QR Code dan notifikasi orang tua. Fokus utama adalah menggambarkan alur proses presensi, komponen bisnis yang terlibat, dan simulasi pengiriman notifikasi.

## 2. BPMN (Business Process Model and Notation)

### Aktor Utama
- Siswa
- Admin
- Sistem Presensi
- Sistem Email
- Orang Tua

### Proses Utama
1. Siswa membuka halaman scan QR di aplikasi PWA.
2. Siswa memindai QR Code.
3. Sistem Presensi menerima data QR Code.
4. Sistem memvalidasi QR Code terhadap database siswa.
5. Jika QR Code tidak valid, sistem mengirimkan notifikasi kesalahan ke pengguna.
6. Jika QR Code valid:
   - sistem memeriksa apakah siswa sudah absen pada hari ini.
   - jika belum, sistem menyimpan data presensi.
   - sistem mengirim notifikasi email ke orang tua.
   - jika sudah, sistem menolak presensi ganda dan memberi pesan ke pengguna.

### Notasi BPMN (etape secara teks)
- Start Event: `Mulai Scan QR`
- Task: `Tampilkan Layar Scan`
- Task: `Scan QR Code`
- Task: `Validasi QR Code`
- Gateway Eksklusif: `QR Code Valid?`
  - True -> Task: `Cek Presensi Hari Ini`
  - False -> Task: `Tampilkan Pesan QR Tidak Valid`
- Gateway Eksklusif: `Sudah Absen Hari Ini?`
  - True -> Task: `Tampilkan Pesan Sudah Absen`
  - False -> Task: `Simpan Presensi`
- Task: `Kirim Notifikasi Email ke Orang Tua`
- End Event: `Presensi Selesai`

## 3. Flowchart Proses Bisnis

### Langkah-langkah flowchart
1. Mulai
2. Siswa membuka halaman scan QR
3. Siswa memindai QR Code
4. Sistem menerima nilai `qr_code`
5. Sistem mencari `siswa` dengan `qr_code`
6. Jika siswa tidak ditemukan -> tampilkan pesan kesalahan dan selesai
7. Jika ditemukan -> cek `presensi` pada tanggal hari ini
8. Jika sudah ada presensi -> tampilkan pesan "Sudah absen hari ini" dan selesai
9. Jika belum ada -> masukkan data `presensi`
10. Kirim notifikasi email ke `orang_tua`
11. Tampilkan pesan sukses
12. Selesai

### Decision points penting
- Validasi QR Code
- Cek presensi ganda per tanggal
- Pengiriman notifikasi email

## 4. Simulasi Alur Presensi dan Notifikasi

### Skenario 1: Presensi Berhasil
1. Siswa A datang ke sekolah dan membuka halaman scan.
2. Siswa A memindai QR Code unik miliknya.
3. Backend menerima request ke `/api/presensi`.
4. `PresensiService` mencari `Siswa` dengan `qr_code` tersebut.
5. Sistem menemukan `Siswa A` dan relasi `OrangTua`.
6. Sistem mengecek tabel `presensi` pada tanggal hari ini dan belum menemukan data.
7. Sistem menyimpan record baru ke tabel `presensi`.
8. Sistem mengirim email notifikasi ke `orang_tua.email` menggunakan `AttendanceNotification`.
9. Sistem mengembalikan respons sukses ke frontend.

### Skenario 2: QR Code Tidak Valid
1. Siswa memindai QR Code yang salah atau sudah kadaluwarsa.
2. Backend memanggil `PresensiService`.
3. `Siswa` tidak ditemukan dalam tabel `siswa`.
4. Sistem mengembalikan pesan error JSON dengan status `404`.
5. Frontend menampilkan pesan kesalahan kepada siswa.

### Skenario 3: Presensi Ganda
1. Siswa sudah melakukan presensi hari ini.
2. Siswa mencoba scan ulang QR Code.
3. Sistem menemukan `Siswa` tetapi juga menemukan entri `Presensi` dengan `tanggal` hari ini.
4. Sistem menolak pencatatan ulang dan mengembalikan pesan bahwa siswa sudah absen.

## 5. Komponen Pemodelan Basis Data

### Entitas & Atribut
- `Siswa`
  - `id`
  - `nama`
  - `nis`
  - `qr_code`
  - `orang_tua_id`

- `OrangTua`
  - `id`
  - `nama`
  - `email`

- `Presensi`
  - `id`
  - `siswa_id`
  - `tanggal`
  - `waktu`

- `User`
  - `id`
  - `name`
  - `email`
  - `password`

### Relasi bisnis
- `Siswa` milik satu `OrangTua`
- `Presensi` milik satu `Siswa`
- `User` sebagai admin yang mengelola data

## 6. Kesesuaian BPMN dan Simulasi dengan Aplikasi

Pemodelan ini cocok dengan proyek karena sudah mencakup:
- proses utama scan QR dan validasi
- pengecekan duplikasi presensi per hari
- perekaman data ke database
- pengiriman notifikasi ke orang tua
- penggunaan PWA untuk antarmuka yang responsif dan offline-light

## 7. Catatan Implementasi

- API endpoint scan: `POST /api/presensi`
- Validasi request: `App\Http\Requests\Api\PresensiRequest`
- Logika bisnis: `App\Services\PresensiService`
- Notifikasi email: `App\Mail\AttendanceNotification`
- Tabel master: `siswa`, `orang_tua`, `presensi`
- Halaman frontend utama: `resources/views/QR/scan.blade.php`

---

Dokumentasi ini melengkapi `Permodelan Sistem Informasi` untuk mendukung implementasi proses bisnis presensi siswa berbasis QR Code dan notifikasi orang tua.