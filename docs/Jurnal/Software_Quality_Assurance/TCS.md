# Test Case: Presence Scan (API & QR) - TCS

| Test Case ID | Preconditions | Test Steps | Input Data | Expected Results | Actual Results |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TCS-001 | Siswa terdaftar, belum absen hari ini. | 1. Kirim POST request ke `/api/presensi`.<br>2. Sertakan `qr_code` valid. | qr_code: "QR-12345" | Status 200, data tersimpan, email terkirim. | Passed |
| TCS-002 | Siswa sudah absen hari ini. | 1. Kirim POST request ke `/api/presensi`. | qr_code: "QR-12345" | Status 422, pesan "Sudah absen hari ini". | Passed |
| TCS-003 | QR Code tidak ada di database. | 1. Kirim POST request ke `/api/presensi`. | qr_code: "INVALID" | Status 404, pesan "QR Code tidak valid". | Passed |
| TCS-004 | Mengirim request tanpa parameter. | 1. Kirim POST request ke `/api/presensi` tanpa body. | - | Status 422, pesan error validasi `qr_code`. | Passed |
| TCS-005 | Email orang tua tidak valid/kosong. | 1. Scan QR siswa yang orang tuanya tidak punya email. | qr_code: "QR-NO-MAIL" | Data presensi tetap tersimpan, log error pengiriman. | Passed |
