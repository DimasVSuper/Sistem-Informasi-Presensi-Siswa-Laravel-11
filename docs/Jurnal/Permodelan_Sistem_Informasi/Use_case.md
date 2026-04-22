# Use Case Sistem Presensi Siswa

## Aktor Utama
- Admin
- Siswa
- Orang Tua

## Tujuan Sistem
Menyediakan sistem presensi siswa berbasis QR Code yang mudah digunakan, cepat, dan dapat memberi notifikasi kepada orang tua setelah siswa melakukan absen.

## Use Case Utama

### 1. Admin membuat dan mengelola data siswa
- Aktor: Admin
- Deskripsi: Admin memasukkan data siswa baru termasuk nama, NIS, dan orang tua terkait. Sistem juga menghasilkan atau menyimpan QR Code unik untuk setiap siswa.
- Aliran utama:
  1. Admin membuka halaman master data siswa.
  2. Admin mengisi formulir pendaftaran siswa.
  3. Sistem menyimpan data siswa dan menautkan ke orang tua.

### 2. Admin membuat dan mengelola data orang tua
- Aktor: Admin
- Deskripsi: Admin menambah, mengubah, atau menghapus informasi orang tua siswa termasuk nama dan email.
- Aliran utama:
  1. Admin membuka halaman master data orang tua.
  2. Admin mengisi atau memperbarui data orang tua.
  3. Sistem menyimpan perubahan dan menampilkan data terbaru.

### 3. Siswa melakukan presensi dengan scan QR
- Aktor: Siswa
- Deskripsi: Siswa memindai QR Code pada halaman scan. Sistem memvalidasi QR Code dan mencatat presensi jika valid.
- Aliran utama:
  1. Siswa membuka halaman scan QR.
  2. Siswa memindai QR Code menggunakan kamera perangkat.
  3. Sistem menerima input QR Code dan mencari siswa terkait.
  4. Sistem memeriksa apakah siswa sudah melakukan presensi pada hari yang sama.
  5. Jika belum, sistem menyimpan catatan presensi dengan tanggal dan waktu.
  6. Sistem mengembalikan respons berhasil ke tampilan.

### 4. Sistem memvalidasi QR Code
- Aktor: Sistem
- Deskripsi: Setelah menerima nilai QR Code, sistem mencari data siswa di database untuk memastikan QR Code valid.
- Aliran utama:
  1. Sistem menerima parameter `qr_code` dari API.
  2. Sistem mencari siswa dengan nilai QR Code tersebut.
  3. Jika tidak ditemukan, sistem mengembalikan pesan kesalahan.

### 5. Sistem mencegah duplikasi presensi hari yang sama
- Aktor: Sistem
- Deskripsi: Sistem memastikan setiap siswa hanya dapat melakukan presensi satu kali per hari.
- Aliran utama:
  1. Sistem mencari rekaman presensi siswa pada tanggal saat ini.
  2. Jika ditemukan, sistem mengembalikan respons bahwa siswa sudah hadir hari ini.
  3. Jika tidak ditemukan, sistem melanjutkan proses penyimpanan presensi.

### 6. Sistem mengirim notifikasi email kepada orang tua
- Aktor: Sistem
- Deskripsi: Setelah presensi berhasil disimpan, sistem mengirimkan email pemberitahuan ke orang tua siswa terkait.
- Aliran utama:
  1. Sistem mengambil data siswa beserta orang tua.
  2. Sistem memeriksa apakah email orang tua tersedia.
  3. Sistem mengirim email notifikasi menggunakan `AttendanceNotification`.

## Skenario Ekstra

### Skenario Gagal: QR Code kosong atau tidak valid
- Kondisi: Input `qr_code` tidak dikirimkan atau tidak berupa string.
- Hasil: Sistem menolak permintaan dengan pesan validasi.

### Skenario Gagal: Siswa tidak ditemukan
- Kondisi: Nilai QR Code tidak cocok dengan data siswa di database.
- Hasil: Sistem mengembalikan respons error bahwa siswa tidak ditemukan.

### Skenario Gagal: Presensi duplikat
- Kondisi: Siswa sudah terdaftar hadir di hari yang sama.
- Hasil: Sistem menolak perekaman ulang dan memberi pesan bahwa presensi sudah tercatat.

## Ringkasan Use Case
Sistem menempatkan admin sebagai pengelola data siswa dan orang tua, sedangkan siswa menggunakan halaman scan QR untuk absensi. Sistem memastikan presensi hanya satu kali per hari dan secara otomatis memberitahu orang tua melalui email setelah presensi tercatat.
