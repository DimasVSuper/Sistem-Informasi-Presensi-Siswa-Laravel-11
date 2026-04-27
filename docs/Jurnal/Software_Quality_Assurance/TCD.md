# Test Case: Dashboard & Management - TCD

Bagian ini menguji fitur manajemen data master (Siswa & Orang Tua) serta tampilan informasi pada Dashboard Admin.

| Test Case ID | Preconditions | Test Steps | Input Data | Expected Results | Actual Results |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **TCD-001** | Sudah login sebagai admin. | 1. Akses halaman `/dashboard`. | - | Menampilkan statistik jumlah siswa, orang tua, dan presensi hari ini secara akurat. | Passed |
| **TCD-002** | Berada di halaman daftar siswa. | 1. Klik "Tambah Siswa".<br>2. Isi nama, NIS, dan pilih orang tua.<br>3. Klik Simpan. | Nama: "Dewi", NIS: "123456" | Data tersimpan di database, muncul di tabel, dan QR Code tergenerasi otomatis. | Passed |
| **TCD-003** | Memiliki data siswa yang sudah ada. | 1. Klik ikon "Edit" pada siswa.<br>2. Ubah nama atau NIS.<br>3. Klik Update. | Nama: "Dewi Pratama" | Data siswa terupdate dengan informasi baru tanpa merubah QR Code asli. | Passed |
| **TCD-004** | Memiliki data siswa yang sudah ada. | 1. Klik ikon "Hapus" pada siswa.<br>2. Konfirmasi penghapusan. | - | Data siswa terhapus dari database dan tabel daftar siswa. | Passed |
| **TCD-005** | Berada di halaman daftar orang tua. | 1. Klik "Tambah Orang Tua".<br>2. Isi nama dan email.<br>3. Klik Simpan. | Nama: "Rudi", Email: "rudi@test.com" | Data orang tua tersimpan dan tersedia untuk dipilih saat input siswa. | Passed |
| **TCD-006** | Memiliki data orang tua. | 1. Klik "Hapus" pada data orang tua yang tidak memiliki siswa aktif. | - | Data orang tua terhapus dengan sukses. | Passed |
| **TCD-007** | Berada di halaman daftar siswa. | 1. Masukkan kata kunci di kolom pencarian. | Input: "Budi" | Tabel hanya menampilkan siswa yang namanya mengandung kata "Budi". | Passed |
