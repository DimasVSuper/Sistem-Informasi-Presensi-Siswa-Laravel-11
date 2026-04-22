# Dokumentasi Frontend (UI, UX & PWA)

PresensiGo mengombinasikan kekuatan **Blade (SSR)**, **Tailwind CSS**, dan **Vue.js** untuk menciptakan interface yang cepat dan interaktif.

## 1. Design System
- **Tailwind CSS (via CDN)**: Digunakan untuk mempercepat proses styling langsung di file Blade. Memungkinkan iterasi desain yang sangat cepat tanpa proses kompilasi CSS yang lama.
- **Glassmorphism & Modern UI**: Menggunakan bayangan lembut (*soft shadows*), *rounded corners* yang besar, dan palet warna Indigo/Purple yang premium.
- **Feather Icons**: Library ikon vektor ringan yang dirender di sisi klien menggunakan script `feather.replace()`.

## 2. Reactivity Engine (Vue.js 3 CDN)
Kami memilih **Vue.js via CDN** untuk halaman Scanner karena:
- **Zero Build Time for JS**: Memudahkan integrasi langsung di dalam file Blade tanpa perlu setup Vue-Loader yang kompleks.
- **State Management**: Digunakan untuk mengelola status scanner (Loading, Success, Error) secara reaktif tanpa me-refresh halaman.

## 3. QR Engine
- **HTML5-QRCode**: Digunakan sebagai mesin pembaca kamera. Sangat handal dalam mengenali kode QR bahkan dalam kondisi cahaya minim.
- **QRCode.js**: Digunakan untuk merender kode QR siswa ke dalam format canvas/image yang tajam dan siap cetak.

## 4. Progressive Web App (PWA)
Aplikasi ini memiliki kapabilitas PWA dengan dua file kunci:
- **`manifest.json`**: Memungkinkan aplikasi muncul sebagai aplikasi native di homescreen smartphone.
- **`sw.js` (Service Worker)**: Cache manager yang memastikan script scanner tetap tersedia meski jaringan terputus tiba-tiba di lapangan.

---
[Kembali ke Dokumentasi Utama](../README.md)
