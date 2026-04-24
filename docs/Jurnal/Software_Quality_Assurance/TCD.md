# Test Case: Dashboard & Management - TCD

| Test Case ID | Preconditions | Test Steps | Input Data | Expected Results | Actual Results |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TCD-001 | Sudah login sebagai admin. | 1. Akses halaman `/dashboard`. | - | Menampilkan statistik jumlah siswa, orang tua, dan presensi hari ini. | Passed |
| TCD-002 | Berada di menu Data Siswa. | 1. Tambah Siswa.<br>2. Isi form valid.<br>3. Simpan. | Nama: Budi, NIS: 001 | Data muncul di tabel, QR Code tergenerasi otomatis. | Passed |
| TCD-003 | Berada di menu Data Orang Tua. | 1. Klik Hapus pada salah satu data. | - | Data terhapus, muncul notifikasi konfirmasi. | Passed |
| TCD-004 | Mencari data siswa. | 1. Masukkan nama/NIS di kolom pencarian. | Input: "Budi" | Tabel memfilter data yang hanya mengandung kata "Budi". | Passed |
