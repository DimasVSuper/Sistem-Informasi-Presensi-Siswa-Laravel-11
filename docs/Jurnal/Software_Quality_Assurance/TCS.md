# Test Case: Presence Scan (API & QR) - TCS

Bagian ini menguji integrasi antara sistem presensi berbasis QR Code dan API backend untuk memastikan proses pemindaian dan notifikasi berjalan dengan benar.

| Test Case ID | Preconditions | Test Steps | Input Data | Expected Results | Actual Results |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **TCS-001** | Siswa terdaftar di database dan belum melakukan absensi pada hari ini. | 1. Kirim POST request ke `/api/presensi`.<br>2. Sertakan parameter `qr_code` yang valid. | `qr_code`: "QR-ABC12345" | **Status 201 Created**. Data tersimpan di tabel presensi dan email notifikasi terkirim. | Passed |
| **TCS-002** | Siswa sudah melakukan absensi sebelumnya pada hari yang sama. | 1. Kirim POST request ke `/api/presensi`.<br>2. Gunakan `qr_code` yang sama. | `qr_code`: "QR-ABC12345" | **Status 409 Conflict**. Pesan error: "Siswa sudah melakukan presensi hari ini." | Passed |
| **TCS-003** | Mencoba memindai QR Code yang tidak terdaftar dalam sistem. | 1. Kirim POST request ke `/api/presensi` dengan kode acak. | `qr_code`: "QR-ILLEGAL" | **Status 404 Not Found**. Pesan error: "Siswa tidak ditemukan. QR Code tidak valid." | Passed |
| **TCS-004** | Mengirimkan permintaan presensi tanpa menyertakan data. | 1. Kirim POST request ke `/api/presensi` tanpa body data. | - | **Status 422 Unprocessable Entity**. Menampilkan error validasi field `qr_code`. | Passed |
| **TCS-005** | Siswa melakukan absensi namun data orang tua tidak memiliki email. | 1. Scan QR siswa yang email orang tuanya kosong. | `qr_code`: "QR-NO-EMAIL" | **Status 201 Created**. Presensi berhasil dicatat, namun sistem melewati proses kirim email. | Passed |
