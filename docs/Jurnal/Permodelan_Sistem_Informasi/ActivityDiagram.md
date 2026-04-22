# Activity Diagram

## Aktivitas Utama Presensi QR Code

### Alur Aktivitas
1. Siswa membuka halaman scan QR.
2. Sistem memulai kamera dan menunggu pemindaian.
3. Siswa memindai QR Code.
4. Sistem menerima kode QR dan mengirim request ke API.
5. Sistem memvalidasi apakah `qr_code` ada di tabel `siswa`.
6. Jika tidak valid:
   - Sistem mengirim pesan error ke pengguna.
   - Proses berakhir.
7. Jika valid:
   - Sistem memeriksa apakah siswa sudah absen pada tanggal hari ini.
   - Jika sudah, sistem menampilkan pesan "Sudah absen hari ini".
   - Jika belum, sistem menyimpan entri `presensi`.
   - Sistem mengirim notifikasi email ke orang tua.
   - Sistem menampilkan pesan sukses.
8. Proses selesai.

## Node Aktivitas
- Start
- Buka Halaman Scan
- Pindai QR Code
- Validasi QR Code
- Cek Presensi Harian
- Simpan Presensi
- Kirim Notifikasi Email
- Tampilkan Hasil
- End
