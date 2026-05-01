# Test Case: Performance & Security - TCK

Bagian ini menguji aspek performa dan keamanan aplikasi.

| Test Case ID | Preconditions | Test Steps | Input Data | Expected Results | Actual Results |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **TCK-001** | Server aktif, aplikasi berjalan | 1. Lakukan scan QR beberapa kali.<br>2. Pastikan semua respons sukses. | `qr_code` valid | Sistem memproses banyak presensi tanpa error. | |
| **TCK-002** | Data login tersimpan di DB | 1. Buat user baru.<br>2. Cek field password di database. | - | Password tersimpan dalam bentuk hash (bcrypt). | |
| **TCK-003** | Belum login | 1. Akses `/dashboard` tanpa autentikasi. | - | Redirect ke halaman login. | |
