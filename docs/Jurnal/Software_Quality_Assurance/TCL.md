# Test Case: Authentication (Login) - TCL

Bagian ini menguji sistem keamanan akses admin untuk memastikan hanya pengguna yang sah yang dapat masuk ke Dashboard.

| Test Case ID | Preconditions | Test Steps | Input Data | Expected Results | Actual Results |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **TCL-001** | Pengguna berada di halaman login. | 1. Masukkan email & password yang terdaftar.<br>2. Klik tombol Login. | Email: `admin@test.com`<br>Pass: `password123` | Redirect ke halaman Dashboard dengan pesan sukses. | Passed |
| **TCL-002** | Pengguna berada di halaman login. | 1. Masukkan email valid.<br>2. Masukkan password yang salah.<br>3. Klik tombol Login. | Email: `admin@test.com`<br>Pass: `wrongpass` | Muncul pesan error "The provided credentials do not match". | Passed |
| **TCL-003** | Pengguna berada di halaman login. | 1. Masukkan email yang tidak terdaftar.<br>2. Klik tombol Login. | Email: `random@test.com` | Muncul pesan error validasi pada field email. | Passed |
| **TCL-004** | Pengguna sudah dalam keadaan login (Authenticated). | 1. Klik tombol "Log Out" pada sidebar. | - | Sesi dihapus, pengguna diarahkan kembali ke halaman login/scan. | Passed |
| **TCL-005** | Pengguna belum login (Guest). | 1. Mencoba akses langsung ke URL `/dashboard`. | - | Sistem menolak akses dan melakukan redirect otomatis ke `/login`. | Passed |
