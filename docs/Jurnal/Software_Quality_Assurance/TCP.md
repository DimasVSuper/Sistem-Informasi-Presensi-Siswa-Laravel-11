# Test Case: Progressive Web App (PWA) - TCP

Bagian ini menguji fitur Progressive Web App untuk memastikan aplikasi dapat diinstal dan berjalan dengan baik di perangkat mobile.

| Test Case ID | Preconditions | Test Steps | Input Data | Expected Results | Actual Results |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **TCP-001** | Mengakses sistem melalui browser mobile (Chrome/Safari). | 1. Cek ketersediaan file `manifest.json` dan `sw.js`. | - | Status file 200 OK. Browser mengenali aplikasi sebagai PWA. | Passed |
| **TCP-002** | Aplikasi sudah terinstal di home screen atau sedang dibuka. | 1. Matikan koneksi internet (Mode Pesawat).<br>2. Muat ulang halaman. | - | Aplikasi tetap dapat dibuka (Offline Ready) dan menampilkan halaman fallback offline. | Passed |
| **TCP-003** | Membuka aplikasi melalui ikon di home screen. | 1. Klik ikon aplikasi PresensiGo. | - | Aplikasi terbuka dalam mode *standalone* (tanpa address bar browser). | Passed |
| **TCP-004** | Melakukan update pada file Service Worker. | 1. Berikan perubahan kecil pada `sw.js`. | - | Browser mendeteksi versi baru dan melakukan update pada kunjungan berikutnya. | Passed |
