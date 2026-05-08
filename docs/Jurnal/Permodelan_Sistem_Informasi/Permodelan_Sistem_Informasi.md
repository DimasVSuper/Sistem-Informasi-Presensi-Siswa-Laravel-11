# PEMODELAN SISTEM INFORMASI PRESENSI SISWA DIGITAL PresensiGo

## KELOMPOK 4
- Al Faqi Ramdhan — 19241547
- Dimas Bayu Nugroho — 19240384
- Siti Jamilah Safitri — 19241852
- Arvina Nirma Yolin Tiang — 19242302
- Maria Asna Yati Baul — 19242309
- Sahva Susilo Putri — 19240839

**Mata Kuliah**: Permodelan Sistem Informasi

**Dosen**: Bibit Sudarsono, M.Kom

**Fakultas**: Teknik dan Informatika

**Program Studi**: Sistem Informasi

**Universitas**: Bina Sarana Informatika, Jakarta

**Tahun**: 2026

---

# KATA PENGANTAR

Puji syukur kehadirat Tuhan Yang Maha Esa atas berkat dan rahmat-Nya, sehingga penulis dapat menyelesaikan Laporan Akhir Proyek Pemodelan Sistem Informasi yang berjudul “Permodelan Sistem Informasi Presensi Siswa Digital (PWA) – PresensiGo” tepat pada waktunya. Dokumen ini disusun sebagai salah satu tugas akhir Mata Kuliah Permodelan Sistem Informasi.

Penyusunan laporan ini tidak terlepas dari dukungan dan bantuan berbagai pihak. Oleh karena itu, penulis menyampaikan ucapan terima kasih yang sebesar-besarnya, khususnya kepada:

- Rektor Universitas Bina Sarana Informatika
- Dekan Fakultas Teknik dan Informatika Universitas Bina Sarana Informatika
- Kaprodi Sistem Informasi Universitas Bina Sarana Informatika
- Bapak Bibit Sudarsono, selaku Dosen Pengampu Mata Kuliah Permodelan Sistem Informasi, atas bimbingan, arahan, dan saran yang sangat berharga selama proses penyusunan laporan proyek ini.
- Rekan-rekan Kelompok 4, yang telah berjuang dan bekerja sama dengan penuh semangat dalam menyelesaikan proyek ini.
- Teman-teman kelas 19.4C.25, atas dukungan, diskusi, dan saran yang konstruktif selama perkuliahan.
- Seluruh pihak yang tidak dapat disebutkan satu per satu, atas dukungan moral dan materiil yang telah diberikan.

Penulis menyadari bahwa laporan proyek ini masih jauh dari kata sempurna, baik dari segi penulisan, tata bahasa, maupun kedalaman isi. Oleh karena itu, kritik dan saran yang membangun sangat penulis harapkan demi perbaikan di masa mendatang. Akhir kata, penulis berharap semoga laporan proyek ini dapat memberikan manfaat, wawasan, dan kontribusi yang berguna bagi para pembaca serta pihak-pihak yang berkepentingan.

Jakarta, 28 Mei 2026

**Ketua Tim**

AL FAQI RAMDHAN

---

# DAFTAR ISI
1. BAB I PROJECT CHARTER
    - 1.1. Latar Belakang
    - 1.2. Deskripsi Produk/Servis
    - 1.3. Keuntungan Yang Diharapkan
    - 1.4. Perencanaan Aktivitas Secara Global
2. BAB II PROJECT REPORT
    - 2.1. Analisis Sistem Berjalan
    - 2.2. Analisa Kebutuhan Sistem (PSBO)
    - 2.3. Desain Sistem
        * 2.3.1 Desain Basis Data
        * 2.3.2 Desain Antar Muka
        * 2.3.3 Struktur Navigasi
3. BAB III PENUTUP
    - 3.1. Kesimpulan
    - 3.2. Saran

---

# BAB I
## PROJECT CHARTER

### 1.1. Latar Belakang
Dalam era digitalisasi pendidikan, proses administrasi sekolah dituntut untuk lebih efisien, transparan, dan akurat. Salah satu aspek penting yang sering menjadi kendala adalah sistem absensi siswa. Metode konvensional seperti pencatatan manual atau tanda tangan di lembar kehadiran memiliki berbagai kelemahan, antara lain rawan kesalahan input, manipulasi data, serta keterlambatan dalam pelaporan kehadiran.

Untuk menjawab tantangan tersebut, diperlukan sistem informasi yang mampu mengotomatisasi proses absensi dengan teknologi modern. Penggunaan Progressive Web App (PWA) dan QR Code menjadi solusi yang relevan karena memungkinkan proses absensi dilakukan secara cepat, aman, dan dapat diakses dari berbagai perangkat tanpa instalasi aplikasi tambahan.

Sistem ini diharapkan mampu meningkatkan efisiensi operasional sekolah, memperkuat integritas data kehadiran, serta memberikan kemudahan bagi guru, siswa, dan orang tua dalam memantau kehadiran secara real-time. Dengan demikian, pengembangan aplikasi absensi berbasis PWA ini menjadi langkah strategis dalam mendukung transformasi digital di lingkungan pendidikan.

### 1.2. Deskripsi Produk/Servis
Produk yang dikembangkan berupa aplikasi presensi berbasis Progressive Web App (PWA) dengan integrasi pemindaian QR Code dan notifikasi real-time. Sistem ini memungkinkan siswa melakukan presensi dengan cara memindai QR Code yang telah disediakan sekolah. Data kehadiran akan langsung tercatat di basis data dan secara otomatis mengirimkan notifikasi ke orang tua melalui email. Selain itu, aplikasi dilengkapi dengan dashboard admin yang menampilkan laporan kehadiran secara komprehensif sehingga memudahkan pihak sekolah dalam melakukan monitoring dan evaluasi.

| Komponen | Deskripsi | Fungsi Utama |
|---|---|---|
| Data Siswa | Identitas siswa (NIS, nama, kelas, jurusan), QR Code unik, riwayat kehadiran, status kehadiran (hadir, izin, sakit, alfa). | Menjadi basis utama presensi digital dan dokumentasi kehadiran siswa. |
| Data Guru | Identitas guru (NIP, nama, mata pelajaran), hak akses monitoring presensi, riwayat pengawasan kelas. | Memantau kehadiran siswa di kelas masing-masing dan mendukung evaluasi akademik. |
| Data Orang Tua/Wali | Identitas orang tua (nama, email, nomor telepon), notifikasi otomatis ke email, akses terbatas ke riwayat kehadiran anak. | Memberikan transparansi informasi kehadiran siswa kepada orang tua secara real-time. |
| Data Admin Sekolah | Hak akses penuh untuk mengelola data siswa, guru, dan orang tua, serta membuat laporan kehadiran. | Mengontrol sistem secara global, mengatur jadwal presensi, dan menghasilkan laporan resmi. |
| Modul QR Code Generator | Membuat QR Code unik untuk setiap siswa. | Menjadi identitas digital presensi. |
| Modul QR Code Scanner | Pemindaian QR Code menggunakan kamera perangkat mobile. | Memvalidasi kehadiran siswa secara cepat dan akurat. |
| Modul Notifikasi Email | Mengirimkan informasi kehadiran siswa ke orang tua. | Menjamin komunikasi real-time antara sekolah dan wali murid. |
| Dashboard Monitoring | Visualisasi data kehadiran dalam bentuk grafik, tabel, dan laporan. | Memudahkan guru dan admin dalam melakukan evaluasi kehadiran. |
| Database Terpusat (MySQL) | Menyimpan seluruh data presensi, identitas siswa, guru, dan orang tua. | Menjamin keamanan, integritas, dan konsistensi data presensi. |

**Tabel 3.1 Deskripsi Komponen Sistem Presensi**

### 1.3. Keuntungan Yang Diharapkan
Keuntungan yang diharapkan merupakan indikator keberhasilan proyek yang menunjukkan sejauh mana sistem mampu memberikan efisiensi, akurasi, transparansi, dan kemudahan akses dibandingkan metode konvensional. Dengan adanya sistem ini, sekolah dapat meningkatkan kualitas pengelolaan data kehadiran, mempercepat proses administrasi, serta memperkuat kepercayaan antara pihak sekolah dan orang tua.

| No | Keuntungan | Penjelasan |
|---|---|---|
| 1 | Efisiensi waktu dan tenaga | Proses absensi berlangsung otomatis tanpa input manual, menghemat waktu guru dan staf administrasi. |
| 2 | Akurasi dan keandalan data | Sistem berbasis QR Code mengurangi risiko kesalahan pencatatan dan duplikasi data. |
| 3 | Transparansi informasi | Data kehadiran dapat diakses oleh pihak terkait (guru, siswa, orang tua) secara langsung dan real-time. |
| 4 | Kemudahan akses | Aplikasi berbasis PWA dapat digunakan di berbagai perangkat tanpa instalasi tambahan. |
| 5 | Penguatan citra institusi | Implementasi sistem digital menunjukkan komitmen sekolah terhadap inovasi dan efisiensi manajemen pendidikan. |

**Tabel 4.2 Keuntungan Implementasi Sistem Presensi Berbasis QR Code**

### 1.4. Perencanaan Aktivitas Secara Global
Berikut merupakan perencanaan aktivitas secara global dalam pengembangan Aplikasi Presensi Siswa Berbasis PWA (PresensiGo):

- Analisa Desain: menggambarkan dan menganalisa sistem presensi berbasis QR Code sesuai alur bisnis sekolah.
- User Interface: merancang tampilan antarmuka sistem sesuai kebutuhan setiap role pengguna (admin, guru, siswa, orang tua).
- Pembuatan Sistem: mengembangkan desain antarmuka menjadi kode pemrograman berbasis website/PWA yang fungsional.
- Pengujian Sistem: memastikan seluruh fitur absensi, notifikasi, dan dashboard berjalan sesuai dengan yang diharapkan.
- Pengamanan Sistem: menerapkan mekanisme keamanan (validasi QR, OTP/email, enkripsi data) untuk melindungi data dari akses tidak sah.
- Implementasi: penerapan sistem secara langsung kepada pengguna di lingkungan sekolah.
- Pemeliharaan Sistem: memelihara dan memperbarui sistem secara berkala agar tetap berjalan optimal.

| No | Keterangan | Jumlah Hari | Biaya (Rp) |
|---|---|---|---|
| 1 | Analisa Desain | 30 hari | 12.000.000 |
| 2 | User Interface | 25 hari | 12.000.000 |
| 3 | Pembuatan Sistem | 60 hari | 45.000.000 |
| 4 | Pengujian Sistem | 14 hari | 8.000.000 |
| 5 | Pengamanan Sistem | 14 hari | 6.000.000 |
| 6 | Implementasi | 7 hari | 10.000.000 |
| 7 | Pemeliharaan Sistem | 30 hari | 12.000.000 |
| 8 | Biaya Tak Terduga | - | 5.000.000 |
|   | **Total** | 180 hari | **Rp 110.000.000** |

**Tabel 3.3 Rencana Anggaran Biaya (RAB)**

---

# BAB II
## PROJECT REPORT

### 2.1. Analisis Sistem Berjalan

#### A. Sejarah Perusahaan
Sekolah IT Indra Bangsa merupakan lembaga pendidikan vokasi yang berfokus pada pengembangan kompetensi di bidang teknologi informasi dan bisnis digital. Berdiri dengan visi mencetak generasi muda yang unggul dalam literasi digital dan siap bersaing di dunia industri, sekolah ini terus berinovasi dalam penerapan sistem pembelajaran berbasis teknologi.

Dalam upaya mendukung transformasi digital di lingkungan pendidikan, Sekolah IT Indra Bangsa mengembangkan berbagai aplikasi internal, salah satunya PresensiGo, yaitu sistem absensi berbasis Progressive Web App (PWA) dengan integrasi QR Code dan notifikasi real-time kepada orang tua. Pengembangan sistem ini berawal dari kebutuhan sekolah akan solusi absensi yang efisien, transparan, dan terintegrasi dengan sistem akademik.

Dengan adanya sistem seperti PresensiGo, Sekolah IT Indra Bangsa diharapkan mampu meningkatkan akurasi data kehadiran siswa, memperkuat komunikasi antara sekolah dan orang tua, serta menjadi contoh penerapan teknologi informasi dalam manajemen pendidikan modern.

#### B. Struktur Organisasi
Berikut merupakan struktur organisasi proyek pengembangan sistem di Sekolah IT Indra Bangsa, yang terdiri dari beberapa peran utama dengan tanggung jawab masing-masing:

| Nama Anggota | Jabatan | Tanggung Jawab Utama |
|---|---|---|
| Al Faqi Ramadhan | Project Manager | Mengatur jalannya proyek, melakukan koordinasi antar anggota tim, menyusun timeline dan rencana kerja, serta memastikan seluruh tahapan proyek berjalan sesuai target dan standar kualitas. |
| Arvina Nirma Yolin Tiang | System Analyst | Menganalisis kebutuhan sistem, menyusun spesifikasi fungsional dan non-fungsional, serta membuat diagram pemodelan proses bisnis presensi siswa. |
| Maria Asna Yati Baul | UI/UX Designer | Mendesain tampilan antarmuka dan pengalaman pengguna agar sistem mudah digunakan, menarik, dan sesuai dengan prinsip desain modern. |
| Dimas Bayu Nugroho | Frontend & Backend Developer | Mengembangkan tampilan antarmuka (frontend) dan logika sistem (backend), mengelola database, serta memastikan integrasi antara komponen sistem berjalan dengan baik. |
| Sahva Susilo Putra | Tester / Quality Assurance | Melakukan pengujian sistem secara fungsional dan non-fungsional, mendeteksi bug/error, serta memastikan sistem berjalan sesuai spesifikasi dan standar kualitas. |
| Siti Jamilah Safitri | Documentation / Technical Writer | Menyusun dokumentasi teknis, laporan proyek, serta panduan penggunaan sistem agar mudah dipahami oleh pengguna dan pihak sekolah. |

**Tabel 3.4 Struktur Tim dan Pembagian Tugas Proyek**

#### C. Proses Bisnis
Berikut merupakan proses bisnis yang terdapat pada sistem PresensiGo di Sekolah IT Indra Bangsa, yang menggambarkan alur penggunaan sistem oleh pengguna. Proses ini mencakup pencatatan kehadiran, pengelolaan data absensi, notifikasi orang tua, monitoring laporan, serta sinkronisasi data antar perangkat.

| No | Deskripsi Tugas | Biaya (Rp) |
|---|---|---|
| 1 | Analisa Desain | 12.000.000 |
| 2 | User Interface | 12.000.000 |
| 3 | Pembuatan Sistem | 45.000.000 |
| 4 | Pengujian Sistem | 8.000.000 |
| 5 | Pengamanan Sistem | 6.000.000 |
| 6 | Implementasi | 10.000.000 |
| 7 | Pemeliharaan Sistem | 12.000.000 |
| 8 | Biaya Tak Terduga | 5.000.000 |
|   | **Total** | **Rp 110.000.000** |

**Tabel 3.5 Rincian Biaya Pengembangan Sistem Presensi**

**Estimasi Sumber Daya Yang Diperlukan**

| No | Kategori | Rincian |
|---|---|---|
| 1 | Sumber Daya Manusia | 6 orang anggota tim proyek:<br>- Project Manager<br>- System Analyst<br>- Programmer<br>- Quality Assurance<br>- Technical Writer |
| 2 | Materi / Alat | Laptop / komputer<br>Software development (Laravel 11, Laragon, VS Code)<br>Koneksi internet |
| 3 | Infrastruktur | Server lokal (localhost)<br>Database MySQL |
| 4 | Perangkat Pendukung | Browser (Google Chrome) |

**Tabel 3.6 Kebutuhan Sumber Daya Sistem Presensi**

**Jadwal**

| Tahapan | Deskripsi Aktivitas | Durasi |
|---|---|---|
| Analisis Kebutuhan Sistem | Mengidentifikasi kebutuhan fungsional dan non-fungsional, melakukan wawancara dengan pengguna (guru, siswa, admin), serta menyusun dokumen spesifikasi sistem. | Minggu 1–2 |
| Desain Sistem (ERD, UML, UI/UX) | Membuat model data (ERD), diagram UML (Use Case, Activity, Sequence, Class, Package), dan rancangan antarmuka pengguna (UI/UX). | Minggu 3–4 |
| Implementasi Kode Program | Pengembangan aplikasi berbasis Laravel dan PWA, integrasi database MySQL, serta penerapan modul QR Code dan notifikasi email. | Minggu 5–7 |
| Pengujian Sistem | Melakukan uji fungsional dan non-fungsional, validasi presensi QR Code, pengujian notifikasi, serta perbaikan bug. | Minggu 8 |
| Implementasi dan Pelatihan Pengguna | Penerapan sistem di lingkungan sekolah, pelatihan admin dan guru, serta sosialisasi kepada siswa dan orang tua. | Minggu 9 |
| Evaluasi dan Pemeliharaan Sistem | Monitoring performa sistem, perbaikan bug lanjutan, dan pengembangan fitur tambahan (dashboard laporan, grafik kehadiran). | Minggu 10–12 |

**Tabel 3.7 Tahapan Pengembangan Sistem Presensi Berbasis QR Code**

**Teknologi Yang Digunakan**

| Komponen | Nama Teknologi | Fungsi |
|---|---|---|
| Komputer Server | Server Sekolah (Windows Server) | Menjalankan aplikasi presensi, menyimpan database, dan melayani permintaan dari client. |
| Komputer Client | PC/Laptop/Smartphone | Digunakan oleh siswa, guru, dan orang tua untuk mengakses aplikasi melalui browser/PWA. |
| Sistem Operasi Server | Windows Server | Menjadi platform utama untuk deployment aplikasi di lingkungan produksi. |
| Sistem Operasi Client | Windows, Android, iOS, macOS | Menyediakan akses aplikasi bagi pengguna melalui browser modern. |
| Framework (Backend & API) | Laravel 11 | Mengelola logika bisnis, routing, autentikasi, dan RESTful API. |
| Frontend | Blade Engine, Tailwind CSS, Vite | Menyusun tampilan antarmuka pengguna yang dinamis, responsif, dan cepat. |
| Database | MySQL | Menyimpan data presensi, akun pengguna, dan log aktivitas sistem. |
| Environment (Local) | Laragon | Lingkungan pengembangan lokal untuk testing dan debugging. |
| Environment (Deployment) | Windows Server | Platform produksi untuk menjalankan aplikasi secara stabil dan aman. |

**Tabel 3.8 Spesifikasi Teknologi Sistem Presensi Berbasis QR Code**

### 2.2. Analisa Kebutuhan Sistem (PSBO)
Analisa kebutuhan sistem dilakukan untuk menentukan fungsi dan karakteristik yang harus dimiliki oleh aplikasi PresensiGo agar dapat memenuhi kebutuhan pengguna di lingkungan Sekolah IT Indra Bangsa. Proses ini mencakup identifikasi kebutuhan fungsional dan non-fungsional berdasarkan hasil observasi, wawancara, serta studi literatur terkait sistem informasi absensi digital.

Menurut Sommerville (2016), analisis kebutuhan merupakan tahap penting dalam rekayasa perangkat lunak yang bertujuan untuk memahami apa yang diinginkan pengguna dan bagaimana sistem dapat memenuhi kebutuhan tersebut. Dalam konteks pendidikan, sistem absensi digital berperan penting dalam meningkatkan efisiensi pencatatan kehadiran serta transparansi informasi antara sekolah dan orang tua.

| No | Kode | Kebutuhan Fungsional | Deskripsi |
|---|---|---|---|
| 1 | F-01 | Login User | Sistem memungkinkan pengguna login dengan username dan password. |
| 2 | F-02 | Presensi QR Code | Siswa melakukan presensi dengan memindai QR Code unik. |
| 3 | F-03 | Validasi Identitas | Sistem memverifikasi identitas siswa sebelum data presensi dikirim. |
| 4 | F-04 | Pengiriman Data | Data presensi dikirim ke server secara otomatis setelah scan QR. |
| 5 | F-05 | Penyimpanan Data | Server menyimpan data ke database MySQL dengan integritas terjaga. |
| 6 | F-06 | Notifikasi Orang Tua | Sistem mengirim notifikasi ke perangkat orang tua secara real-time. |
| 7 | F-07 | Laporan Kehadiran | Sistem menghasilkan laporan rekap kehadiran siswa untuk pihak sekolah. |

**Tabel 3.9 Kebutuhan Fungsional Sistem Presensi Berbasis QR Code**

| No | Kode | Kategori | Deskripsi |
|---|---|---|---|
| 1 | NF-01 | Performance | Sistem harus merespon pemindaian QR dalam waktu kurang dari 3 detik. |
| 2 | NF-02 | Security | Password login harus dienkripsi, data presensi dikirim melalui protokol aman (HTTPS). |
| 3 | NF-03 | Usability | Antarmuka aplikasi harus intuitif, mudah dipahami, dan ramah pengguna bagi siswa serta orang tua. |
| 4 | NF-04 | Reliability | Sistem tetap stabil dan konsisten dalam mengirim notifikasi meskipun digunakan oleh banyak siswa secara bersamaan. |
| 5 | NF-05 | Compatibility | Aplikasi PWA dapat berjalan di berbagai perangkat (Android, iOS) dan browser utama (Chrome, Edge, Safari). |
| 6 | NF-06 | Maintainability | Sistem harus mudah diperbarui, diperbaiki, dan dikembangkan tanpa mengganggu layanan utama. |
| 7 | NF-07 | Scalability | Sistem mampu menangani peningkatan jumlah pengguna dan data tanpa penurunan performa. |

**Tabel 3.10 Kebutuhan Non-Fungsional Sistem Presensi Berbasis QR Code**

| Pengguna | Kebutuhan Utama |
|---|---|
| Admin Sekolah | Mengelola data master (siswa, kelas, guru), mengatur jadwal presensi, melihat semua laporan kehadiran, melakukan backup database. |
| Guru / Wali Kelas | Mencatat presensi di kelas masing-masing, melihat rekap mingguan/bulanan, mengoreksi presensi jika ada kesalahan, mencetak laporan kehadiran siswa. |
| Siswa | Melihat riwayat presensi pribadi, melihat persentase kehadiran, melakukan presensi dengan QR Code atau login akun. |
| Orang Tua / Wali | Menerima notifikasi kehadiran anak secara real-time (email/WhatsApp), melihat riwayat presensi anak, mendapat transparansi status kehadiran (hadir, izin, sakit, alfa). |

**Tabel 3.11 Kebutuhan Pengguna Sistem Presensi Berbasis QR Code**

### 2.3. Desain Sistem

#### 2.3.1 Desain Basis Data
LRS (Logical Record Structure) merupakan rancangan awal yang menggambarkan hubungan antar entitas data dalam sistem sebelum diimplementasikan ke dalam basis data fisik. LRS digunakan untuk menunjukkan bagaimana data disimpan, dihubungkan, dan diakses oleh setiap modul sistem. Dalam proyek ini, LRS dirancang untuk mendukung proses presensi berbasis QR Code, sehingga setiap entitas seperti Siswa, Orang Tua, Guru, dan Admin memiliki keterkaitan logis melalui tabel-tabel utama seperti users, presensis, dan kelas. Struktur ini memastikan bahwa setiap data presensi dapat ditelusuri berdasarkan identitas siswa dan waktu kehadiran, serta dapat diakses oleh orang tua dan admin melalui dashboard sistem.

##### Entity Relationship Diagram
ERD digunakan untuk memodelkan struktur basis data dan hubungan antar entitas dalam sistem. Diagram ini membantu menggambarkan keterkaitan data seperti relasi antara User, Siswa, OrangTua, dan Presensi agar desain database terstruktur dan konsisten.

- Entitas Orang Tua ke Siswa (One-to-Many)
- Entitas Siswa ke Presensi (One-to-Many)
- Atribut QR Code pada Siswa
- Integrasi dengan Tabel Users

##### Use Case
Use Case Diagram menjelaskan interaksi antara aktor dan sistem. Diagram ini menunjukkan fungsi‑fungsi utama yang dapat dilakukan oleh pengguna seperti Admin, Siswa, dan Orang Tua, misalnya login, mengelola data, melakukan presensi, dan menerima notifikasi.

Pada sistem PresensiGo terdapat tiga aktor utama, yaitu Siswa, Orang Tua, dan Admin.

- Siswa melakukan presensi dengan cara memindai QR Code melalui aplikasi. Sistem memvalidasi QR Code, mencegah presensi ganda, mencatat waktu kehadiran, lalu mengirimkan notifikasi ke orang tua.
- Orang Tua menerima notifikasi otomatis melalui email berisi status kehadiran anak, sehingga dapat memantau kehadiran secara real-time.
- Admin mengelola data siswa dan orang tua melalui dashboard, menautkan relasi data, serta melihat riwayat presensi dalam bentuk tabel maupun grafik.

###### Skenario 1 – Absensi Siswa (Scanning)

| Keterangan | Deskripsi |
|---|---|
| Use Case Name | Absensi Siswa (Scanning) |
| Requirements | Sistem harus mampu memvalidasi QR Code, mencatat waktu kehadiran, dan mengirim notifikasi ke email orang tua secara otomatis. |
| Goal | Mencatat kehadiran siswa secara digital dan mengirimkan bukti kehadiran ke orang tua. |
| Pre-conditions | Siswa berada di halaman /scan dan memiliki QR Code valid yang terdaftar di sistem. |
| Post-conditions | Data kehadiran tersimpan di database dan notifikasi terkirim ke email orang tua. |
| Failed end condition | QR Code tidak valid, koneksi internet terputus, atau siswa sudah melakukan presensi sebelumnya. |
| Primary Actors | Siswa |
| Main Flow / Basic Path | 1. Siswa membuka halaman scan.<br>2. Siswa melakukan pemindaian QR Code.<br>3. Sistem memvalidasi QR Code.<br>4. Sistem memeriksa presensi harian untuk mencegah duplikasi.<br>5. Sistem mencatat waktu kehadiran.<br>6. Sistem mengirim email notifikasi ke orang tua.<br>7. Siswa menerima pesan “Presensi Berhasil”. |

###### Skenario 2 – Manajemen Data Master

| Keterangan | Deskripsi |
|---|---|
| Use Case Name | Manajemen Data Master |
| Requirements | Sistem harus menyediakan fitur input data orang tua dan siswa, serta menghasilkan QR Code unik untuk setiap siswa. |
| Goal | Mengelola data induk siswa dan orang tua sebagai dasar sistem presensi. |
| Pre-conditions | Admin telah login ke dashboard sistem. |
| Post-conditions | Data orang tua dan siswa tersimpan di database, serta QR Code unik berhasil dihasilkan. |
| Failed end condition | Data tidak tersimpan karena kesalahan input atau koneksi database gagal. |
| Primary Actors | Admin |
| Main Flow / Basic Path | 1. Admin login ke dashboard.<br>2. Admin menginput data orang tua (termasuk email).<br>3. Admin menginput data siswa dan menautkannya ke orang tua.<br>4. Sistem menghasilkan QR Code unik untuk siswa tersebut.<br>5. Data tersimpan dan siap digunakan untuk proses absensi. |

###### Skenario 3 – Monitoring Notifikasi

| Keterangan | Deskripsi |
|---|---|
| Use Case Name | Monitoring Notifikasi |
| Requirements | Sistem harus mampu mendeteksi setiap data presensi baru dan mengirimkan notifikasi ke email orang tua secara otomatis. |
| Goal | Menjamin setiap presensi siswa diikuti dengan pengiriman bukti kehadiran ke orang tua tanpa intervensi manual. |
| Pre-conditions | Data presensi siswa telah tercatat di database. |
| Post-conditions | Email notifikasi terkirim ke orang tua dan log pengiriman tercatat di sistem. |
| Failed end condition | Email gagal terkirim karena kesalahan server atau alamat email tidak valid. |
| Primary Actors | Sistem (Automation) |
| Main Flow / Basic Path | 1. Sistem mendeteksi entri presensi baru.<br>2. Sistem mengambil data siswa dan email orang tua.<br>3. Sistem mengirimkan notifikasi kehadiran melalui email.<br>4. Sistem mencatat aktivitas pengiriman ke log.<br>5. Orang tua menerima bukti kehadiran anak secara otomatis. |

##### Activity Diagram
Activity Diagram menggambarkan alur aktivitas atau proses kerja sistem dari awal hingga akhir. Diagram ini memperlihatkan urutan langkah‑langkah dan keputusan dalam proses presensi, sehingga memudahkan analisis logika sistem.

Activity Diagram pada sistem PresensiGo menunjukkan bahwa proses presensi dimulai ketika siswa membuka aplikasi berbasis PWA dan melakukan pemindaian QR Code. Sistem kemudian melakukan validasi terhadap data siswa dan mencegah terjadinya presensi ganda. Jika validasi berhasil, data kehadiran dicatat ke dalam database dan notifikasi otomatis dikirimkan kepada orang tua melalui email. Pada tahap akhir, siswa menerima umpan balik berupa pesan “Presensi Berhasil” sebagai tanda bahwa presensi telah tercatat dengan sukses. Dengan alur ini, sistem mampu menjamin keakuratan data kehadiran sekaligus meningkatkan transparansi komunikasi antara sekolah dan orang tua.

##### Class Diagram
Class Diagram digunakan untuk memodelkan struktur kelas dalam sistem berbasis objek. Diagram ini menampilkan atribut, metode, dan hubungan antar kelas seperti User, Siswa, OrangTua, dan Presensi, yang menjadi dasar implementasi kode program.

- Class Admin: atribut `id`, `username`, `password`; metode autentikasi pengguna.
- Class Siswa: atribut `id_siswa`, `nama`, `nis`, `kelas`; metode untuk proses presensi dan tampilan riwayat kehadiran.
- Class OrangTua: atribut `id_orangtua`, `nama`, `kontak`; metode untuk menerima notifikasi kehadiran siswa.
- Class Presensi: atribut `id_presensi`, `tanggal`, `status`, `qr_code`; metode untuk mencatat dan memvalidasi kehadiran siswa.

##### Sequence Diagram
Sequence Diagram menunjukkan urutan interaksi antar objek atau komponen sistem secara kronologis. Diagram ini menggambarkan bagaimana pesan dikirim dan diterima antara Frontend, Controller, Database, dan Mail Server selama proses presensi berlangsung.

**Pengelolaan Data (Admin)**

Admin memasukkan informasi dasar mengenai siswa dan orang tua ke dalam sistem. Data tersebut kemudian disimpan ke dalam tabel siswa dan orang_tua. Setelah proses penyimpanan berhasil, sistem secara otomatis menghasilkan QR Code unik untuk setiap siswa berdasarkan atribut NIS. QR Code ini berfungsi sebagai identitas digital yang akan digunakan dalam proses presensi.

**Proses Scan (Siswa)**

Siswa melakukan pemindaian QR Code melalui perangkat atau aplikasi yang telah disediakan. Proses scan ini diteruskan ke Controller, yang bertugas melakukan validasi terhadap database. Validasi mencakup pengecekan apakah siswa tersebut terdaftar dalam sistem serta memastikan bahwa siswa belum melakukan presensi pada hari yang sama. Hal ini sesuai dengan Unique Constraint pada tabel presensi, yang membatasi satu siswa hanya dapat melakukan presensi sekali per hari.

**Pencatatan Presensi**

Apabila validasi berhasil, sistem akan mencatat kehadiran dengan menambahkan record baru ke tabel presensi. Data yang dicatat meliputi identitas siswa, tanggal, waktu, serta status kehadiran. Proses ini memastikan bahwa setiap aktivitas presensi terdokumentasi secara sistematis dan dapat ditelusuri kembali melalui riwayat presensi.

**Notifikasi Real-time (Orang Tua)**

Setelah data presensi berhasil dicatat, sistem melakukan pencarian terhadap relasi `orang_tua_id` dari siswa yang bersangkutan. Berdasarkan relasi tersebut, sistem memanggil layanan notifikasi, baik berupa email maupun integrasi dengan API pihak ketiga. Notifikasi dikirimkan secara real-time kepada orang tua, berisi informasi bahwa anaknya telah melakukan presensi atau tiba di sekolah. Tahap ini memberikan transparansi dan meningkatkan keterlibatan orang tua dalam memantau kehadiran anak.

##### Package Diagram
Package Diagram memberikan visualisasi layer arsitektur sistem (Form, Controller, Model, Notification).

Sistem ini dibagi menjadi empat bagian utama yang bekerja secara terintegrasi:

- **Form**: Tempat siswa melakukan scan QR. Terhubung ke Controller dengan label <<access>> karena hanya menyediakan akses API untuk mengirimkan data.
- **Controller**: Mengatur semua logika. Controller mengimpor Model untuk mengenali data siswa dan aturan absensi.
- **Model (Database)**: Gudang penyimpanan data (Siswa, Orang Tua, dan Riwayat Absen). Menyediakan struktur data yang dibutuhkan oleh sistem.
- **Notification**: Layanan pengiriman notifikasi email ke orang tua. Controller menggunakan layanan ini setelah absen berhasil dicatat.

##### Spec File

| Nama File | Lokasi (Folder) | Deskripsi |
|---|---|---|
| Siswa.php | app/Models/ | Definisi entitas Siswa dan relasinya ke Orang Tua & Presensi. |
| OrangTua.php | app/Models/ | Definisi entitas Orang Tua (kontak untuk notifikasi). |
| Presensi.php | app/Models/ | Mencatat data kehadiran (siswa_id, waktu, status). |
| PresensiController.php | app/Http/Controllers/ | Logika utama: Validasi QR Code, Simpan Absen, & Trigger Notifikasi. |
| DashboardController.php | app/Http/Controllers/ | Mengelola CRUD data Siswa, Orang Tua, dan User. |
| AttendanceNotification.php | app/Http/Mail/ | Menangani pengiriman notifikasi Email. |
| api.php / web.php | routes/ | Definisi URL/Endpoint untuk akses aplikasi dan API Scan. |
| .env | root/ | Konfigurasi database, API Key Gateway, dan App Key. |

##### Struktur Kode
Sistem PresensiGo menggunakan arsitektur MVC (Model-View-Controller) pada framework Laravel untuk menjaga modularitas dan keteraturan kode.

- **Controllers** (`app/Http/Controllers/`): Mengatur alur bisnis sistem, termasuk `DashboardController.php` untuk CRUD data master dan `PresensiController.php` untuk proses presensi berbasis QR Code.
- **Models** (`app/Models/`): Merepresentasikan tabel database melalui objek ORM seperti `Siswa.php`, `OrangTua.php`, dan `Presensi.php` yang mengatur relasi antar-entitas.
- **Services** (`app/Http/Mail/`): Menangani integrasi eksternal melalui `AttendanceNotification.php` sebagai proses pengiriman notifikasi Email.
- **Views & Assets** (`resources/views/`, `public/`): Mengelola tampilan berbasis Blade sesuai hak akses pengguna dan menyimpan aset statis seperti CSS, JS, serta QR Code.
- **Routes & Database** (`routes/`, `database/migrations/`): Mendefinisikan endpoint sistem dengan middleware keamanan dan dokumentasi skema database untuk menjaga konsistensi antar lingkungan pengembangan.

#### 2.3.2 Desain Antar Muka
Tampilan absensi untuk melakukan scan QR.

Tampilan untuk admin login.

Dashboard admin berisi informasi siswa dan absensi.

Dashboard admin Data Siswa berisi untuk mengelola data siswa.

Dashboard admin Data Siswa berisi untuk menambahkan data siswa baru.

Dashboard admin Data Siswa berisi untuk menampilkan QR kode siswa.

Dashboard admin Data Orang Tua untuk mengelola data orang tua.

#### 2.3.3 Struktur Navigasi

**Struktur Navigasi Admin**

Struktur navigasi sistem PresensiGo dirancang untuk mendukung alur kerja admin dalam mengelola data presensi berbasis QR Code. Navigasi dimulai dari halaman Login, yang berfungsi sebagai gerbang autentikasi pengguna sebelum masuk ke sistem. Setelah berhasil login, admin diarahkan ke Admin Panel sebagai pusat kendali utama. Dari Admin Panel, terdapat beberapa cabang navigasi:

- **Data Siswa** → menyediakan fitur pengelolaan identitas siswa, termasuk opsi Tambah Baru untuk menambahkan data siswa, serta fungsi Cetak QR yang menghasilkan kode unik sebagai identitas presensi. QR Code dapat dicetak dalam bentuk PDF untuk distribusi ke siswa.
- **Data Orang Tua** → memungkinkan admin mengelola informasi orang tua, dengan fitur Tambah Baru yang dilengkapi opsi Simpan Data atau Batal untuk menjaga konsistensi input.
- **Dashboard** → menampilkan ringkasan informasi sistem, status presensi, dan akses cepat ke menu lain.

### 2.4. Pembuatan Kode Program

- **AuthController**: Controller pertama yang bertanggung jawab terhadap proses autentikasi pengguna. Di dalamnya terdapat fungsi untuk login, logout, dan registrasi.
- **SiswaController**: Mengelola data siswa dan aktivitas presensi. Controller ini menangani proses scan QR Code, penyimpanan data kehadiran, serta penampilan riwayat presensi.
- **OrangTuaController**: Menampilkan riwayat presensi anak dan mengirimkan notifikasi kepada orang tua. Melalui controller ini, sistem dapat memberikan informasi kehadiran siswa secara real-time, sehingga orang tua dapat memantau aktivitas anaknya tanpa harus datang ke sekolah.
- **DashboardController**: Menampilkan statistik dan ringkasan data presensi.

---

# BAB III
## PENUTUP

### 3.1. Kesimpulan
Dokumen ini memperlihatkan bahwa sistem PresensiGo dapat direpresentasikan secara lengkap melalui pemodelan sistem informasi. Struktur data, alur proses, serta arsitektur aplikasi dijelaskan untuk memastikan implementasi kode sesuai dengan kebutuhan bisnis.

### 3.2. Saran
Sistem selanjutnya dapat ditingkatkan dengan fitur notifikasi multi-kanal (WhatsApp, SMS), manajemen jadwal presensi kelas, dan dashboard analitik yang lebih lengkap untuk admin dan orang tua.

---

# DAFTAR GAMBAR

1. Gambar 2.1 Entity Relationship Diagram (ERD) Sistem Presensi .............. xx
2. Gambar 2.2 Use Case Diagram Sistem Presensi ..................................... xx
3. Gambar 2.3 Activity Diagram Sistem Presensi ...................................... xx
4. Gambar 2.4 Class Diagram Sistem Presensi ......................................... xx
5. Gambar 2.5 Sequence Diagram Sistem Presensi .................................... xx
6. Gambar 2.6 Package Diagram Sistem Presensi ..................................... xx
7. Gambar 2.7 Tampilan Scan QR Code (Siswa) ....................................... xx
8. Gambar 2.8 Tampilan Login Admin ..................................................... xx
9. Gambar 2.9 Dashboard Admin .......................................................... xx
10. Gambar 2.10 Halaman Data Siswa ..................................................... xx
11. Gambar 2.11 Form Tambah Data Siswa ............................................. xx
12. Gambar 2.12 Tampilan QR Code Siswa ............................................. xx
13. Gambar 2.13 Halaman Data Orang Tua .............................................. xx

# DAFTAR TABLE

# DAFTAR LAMPIRAN
