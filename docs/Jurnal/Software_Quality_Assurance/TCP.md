# Test Case: Progressive Web App (PWA) - TCP

Bagian ini menguji fitur Progressive Web App untuk memastikan aplikasi dapat diinstal dan berjalan dengan baik di perangkat mobile.

| Test Case ID | Preconditions | Test Steps | Input Data | Expected Results | Actual Results |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **TCP-001** | Browser mendukung PWA. | 1. Akses aplikasi via Chrome mobile. | - | Muncul prompt "Add to Home Screen". | |
| **TCP-002** | Aplikasi sudah terinstal. | 1. Matikan internet (Offline).<br>2. Buka aplikasi. | - | Aplikasi tetap terbuka, aset statis (CSS/JS) termuat. | |
| **TCP-003** | Service Worker terdaftar. | 1. Cek tab Application di DevTools. | - | `sw.js` status: "Activated and Running". | |
