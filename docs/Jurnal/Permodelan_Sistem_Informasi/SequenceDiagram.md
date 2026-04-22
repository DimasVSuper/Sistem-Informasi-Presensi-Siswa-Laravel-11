# Sequence Diagram

## Alur Interaksi untuk Presensi QR

1. `Siswa` membuka halaman scan QR.
2. `Frontend` meminta kamera untuk memindai QR Code.
3. `Siswa` memindai QR Code.
4. `Frontend` mengirim request `POST /api/presensi` dengan `qr_code`.
5. `PresensiController` menerima request.
6. `PresensiController` memanggil `PresensiService::processScan(qr_code)`.
7. `PresensiService` mencari `Siswa` berdasarkan `qr_code`.
8. Jika siswa tidak ditemukan, kembali ke `PresensiController` dengan error.
9. Jika ditemukan, `PresensiService` memeriksa `Presensi` hari ini.
10. Jika sudah absen, kembalikan pesan bahwa siswa sudah hadir.
11. Jika belum absen, `PresensiService` menyimpan rekaman `Presensi`.
12. Setelah berhasil, `PresensiService` memicu pengiriman email menggunakan `AttendanceNotification`.
13. `PresensiController` mengembalikan response JSON ke `Frontend`.
14. `Frontend` menampilkan hasil ke `Siswa`.
