import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
    stages: [
        { duration: '30s', target: 10 },
        { duration: '1m', target: 25 },
        { duration: '1m', target: 50 },
        { duration: '30s', target: 0 },
    ],
    thresholds: {
        http_req_duration: ['p(95)<3000', 'avg<1200'],
        http_req_failed: ['rate<0.01'],
    },
};

const BASE_URL = __ENV.BASE_URL || 'http://localhost:8000';
const QR_CODES = (__ENV.QR_CODES || 'QR-API-TEST').split(',').map((code) => code.trim()).filter(Boolean);

function randomQrCode() {
    return QR_CODES[Math.floor(Math.random() * QR_CODES.length)];
}

export default function () {
    const payload = JSON.stringify({ qr_code: randomQrCode() });
    const params = {
        headers: {
            'Content-Type': 'application/json',
        },
    };

    const response = http.post(`${BASE_URL}/api/presensi`, payload, params);

    check(response, {
        'status is 201, 409, 404 or 422': (r) => [201, 409, 404, 422].includes(r.status),
        'body is valid json': (r) => {
            try {
                return JSON.parse(r.body) !== null;
            } catch (e) {
                return false;
            }
        },
    });

    sleep(1);
}
