# Test Case: Authentication (Login) - TCL

| Test Case ID | Preconditions | Test Steps | Input Data | Expected Results | Actual Results |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TCL-001 | Berada di halaman login. | 1. Masukkan email & password valid.<br>2. Klik tombol Login. | Email: admin@admin.com<br>Pass: password | Redirect ke dashboard, muncul pesan sukses. | Passed |
| TCL-002 | Berada di halaman login. | 1. Masukkan email valid.<br>2. Masukkan password salah.<br>3. Klik tombol Login. | Email: admin@admin.com<br>Pass: salah123 | Muncul pesan error "Kredensial tidak cocok". | Passed |
| TCL-003 | Berada di halaman login. | 1. Masukkan email tidak terdaftar.<br>2. Klik tombol Login. | Email: unknown@test.com | Muncul pesan error validasi. | Passed |
| TCL-004 | Sudah login ke dashboard. | 1. Klik tombol Logout. | - | Session dihapus, redirect kembali ke halaman login. | Passed |
| TCL-005 | Belum login. | 1. Akses langsung URL `/dashboard`. | - | Redirect ke halaman login. | Passed |
