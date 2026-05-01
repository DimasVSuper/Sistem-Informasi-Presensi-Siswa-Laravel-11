# Test Case: Dashboard & Management - TCD

Bagian ini menguji fitur manajemen data master (Siswa & Orang Tua) serta tampilan informasi pada Dashboard Admin.

| Test Case ID | Preconditions | Test Steps | Input Data | Expected Results | Actual Results |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **TCD-001** | Sudah login sebagai admin. | 1. Akses halaman `/dashboard`. | - | Menampilkan statistik jumlah siswa, orang tua, dan presensi hari ini. | |
| **TCD-002** | Berada di menu Data Siswa. | 1. Tambah Siswa.<br>2. Isi form valid.<br>3. Simpan. | Nama: Budi, NIS: 001 | Data muncul di tabel, QR Code tergenerasi otomatis. | |
| **TCD-003** | Ada data siswa yang dapat diubah. | 1. Buka form edit siswa.<br>2. Ubah data nama/NIS.<br>3. Simpan. | Nama: Budi Santoso, NIS: 002 | Data siswa terupdate di tabel. | |
| **TCD-004** | Ada data siswa yang dapat dihapus. | 1. Klik tombol hapus pada siswa.<br>2. Konfirmasi penghapusan. | - | Data siswa terhapus dari tabel. | |
| **TCD-005** | Berada di menu Data Orang Tua. | 1. Tambah orang tua baru.<br>2. Isi nama dan email.<br>3. Simpan. | Nama: Rudi, Email: rudi@test.com | Data orang tua tersimpan dan tersedia untuk dipilih. | |
| **TCD-006** | Ada data orang tua tanpa siswa aktif. | 1. Klik hapus pada orang tua.<br>2. Konfirmasi penghapusan. | - | Data orang tua terhapus dari daftar. | |
| **TCD-007** | Ada data orang tua yang dapat diubah. | 1. Buka form edit orang tua.<br>2. Ubah nama/email.<br>3. Simpan. | Nama: Lina Ayu, Email: lina.ayu@test.com | Data orang tua terupdate di daftar. | |
| **TCD-008** | Berada di menu Data Siswa. | 1. Masukkan kata kunci pencarian. | Input: "Budi" | Tabel hanya menampilkan siswa yang cocok dengan nama pencarian. | |
