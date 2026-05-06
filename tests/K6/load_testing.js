// Import modul http dari k6 untuk melakukan request HTTP
import http from 'k6/http';
// Import fungsi check dan sleep dari k6
import { check, sleep } from 'k6';

// Konfigurasi skenario load testing
export const options = {
    stages: [
        // Naik ke 10 user virtual dalam 30 detik
        { duration: '30s', target: 10 },
        // Naik ke 25 user virtual dalam 1 menit
        { duration: '1m', target: 25 },
        // Naik ke 50 user virtual dalam 1 menit
        { duration: '1m', target: 50 },
        // Turun ke 0 user virtual dalam 30 detik
        { duration: '30s', target: 0 },
    ],
    thresholds: {
        // Durasi request HTTP: 95% < 3000ms, rata-rata < 1200ms
        http_req_duration: ['p(95)<3000', 'avg<1200'],
        // Error rate request HTTP harus < 1%
        http_req_failed: ['rate<0.01'],
    },
};

// Base URL API, bisa diatur lewat environment variable BASE_URL
const BASE_URL = __ENV.BASE_URL || 'http://localhost:8000';
// Daftar QR code, bisa diatur lewat environment variable QR_CODES (dipisah koma)
const QR_CODES = (__ENV.QR_CODES || 'QR-API-TEST').split(',').map((code) => code.trim()).filter(Boolean);

// Fungsi untuk mengambil QR code secara acak dari daftar
function randomQrCode() {
    return QR_CODES[Math.floor(Math.random() * QR_CODES.length)];
}

// Fungsi utama yang dijalankan setiap virtual user
export default function () {
    // Payload JSON dengan qr_code acak
    const payload = JSON.stringify({ qr_code: randomQrCode() });
    // Header request
    const params = {
        headers: {
            'Content-Type': 'application/json',
        },
    };

    // Kirim POST request ke endpoint /api/presensi
    const response = http.post(`${BASE_URL}/api/presensi`, payload, params);

    // Validasi response
    check(response, {
        // Status harus 201, 409, 404, atau 422
        'status is 201, 409, 404 or 422': (r) => [201, 409, 404, 422].includes(r.status),
        // Body harus berupa JSON yang valid
        'body is valid json': (r) => {
            try {
                return JSON.parse(r.body) !== null;
            } catch (e) {
                return false;
            }
        },
    });

    // Tunggu 1 detik sebelum iterasi berikutnya
    sleep(1);
}
