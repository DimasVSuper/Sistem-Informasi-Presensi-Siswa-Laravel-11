<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#667eea">
    <meta name="description" content="Sistem Presensi Siswa berbasis QR Code">
    <title>Presensi Siswa - Scan QR</title>

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icon-192x192.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- html5-qrcode CDN -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <!-- Vue 3 CDN -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>

    <!-- CSRF Token for API calls -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 16px;
        }

        /* Header */
        .header {
            text-align: center;
            color: white;
            margin-bottom: 24px;
            width: 100%;
            max-width: 440px;
        }
        .header .logo { font-size: 40px; margin-bottom: 8px; }
        .header h1 { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; }
        .header p { font-size: 13px; opacity: 0.85; margin-top: 4px; }

        /* Card */
        .card {
            background: rgba(255,255,255,0.97);
            border-radius: 24px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            overflow: hidden;
        }

        /* Scanner area */
        .scanner-section { padding: 24px 24px 0; }
        .scanner-label {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 12px;
        }
        #qr-reader {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            background: #0f0f0f;
            min-height: 250px;
        }
        /* Override html5-qrcode default styles */
        #qr-reader video { border-radius: 12px; }
        #qr-reader__scan_region { border-radius: 12px; overflow: hidden; }
        #qr-reader__dashboard { display: none !important; }

        /* Status section */
        .status-section { padding: 20px 24px 24px; }

        /* Status card */
        .status-card {
            border-radius: 14px;
            padding: 16px 18px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }
        .status-card.idle { background: #f8fafc; border: 1.5px dashed #e2e8f0; }
        .status-card.loading { background: #eff6ff; border: 1.5px solid #bfdbfe; }
        .status-card.success { background: #f0fdf4; border: 1.5px solid #bbf7d0; animation: pop 0.3s ease; }
        .status-card.error { background: #fef2f2; border: 1.5px solid #fecaca; animation: pop 0.3s ease; }
        .status-card.warning { background: #fffbeb; border: 1.5px solid #fde68a; animation: pop 0.3s ease; }

        @keyframes pop {
            0% { transform: scale(0.97); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }

        .status-icon { font-size: 28px; flex-shrink: 0; margin-top: 2px; }
        .status-title { font-size: 14px; font-weight: 700; color: #111827; }
        .status-message { font-size: 13px; color: #4b5563; margin-top: 3px; line-height: 1.5; }

        /* Student info */
        .student-info {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 14px;
            padding: 16px 18px;
            color: white;
            margin-bottom: 16px;
            display: none;
        }
        .student-info.visible { display: block; animation: slideUp 0.3s ease; }
        @keyframes slideUp {
            from { transform: translateY(10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .student-info .info-label { font-size: 11px; font-weight: 600; opacity: 0.75; text-transform: uppercase; letter-spacing: 0.6px; }
        .student-info .info-value { font-size: 15px; font-weight: 700; margin-top: 1px; }
        .student-info .info-row { margin-bottom: 10px; }
        .student-info .info-row:last-child { margin-bottom: 0; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px; }
        .badge-hadir {
            display: inline-block;
            background: rgba(255,255,255,0.25);
            border: 1px solid rgba(255,255,255,0.4);
            border-radius: 999px;
            padding: 3px 10px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Button */
        .btn-scan {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: none;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            letter-spacing: 0.3px;
        }
        .btn-scan.start {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102,126,234,0.4);
        }
        .btn-scan.start:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(102,126,234,0.5); }
        .btn-scan.start:active { transform: translateY(0); }
        .btn-scan.stop {
            background: #f1f5f9;
            color: #475569;
        }
        .btn-scan.stop:hover { background: #e2e8f0; }

        /* Spinner */
        .spinner {
            width: 18px;
            height: 18px;
            border: 2.5px solid rgba(59,130,246,0.25);
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Footer */
        .footer { margin-top: 20px; text-align: center; color: rgba(255,255,255,0.6); font-size: 12px; }

        /* Scanning indicator */
        .scan-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.3);
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 12px;
            font-weight: 600;
            color: #15803d;
        }
        .dot-pulse {
            width: 8px; height: 8px;
            background: #22c55e;
            border-radius: 50%;
            animation: pulse 1.2s ease-in-out infinite;
            flex-shrink: 0;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }
    </style>
</head>
<body>
<div id="app">
    <div class="header">
        <div class="logo">📱</div>
        <h1>Presensi Siswa</h1>
        <p>Scan QR Code untuk mencatat kehadiran</p>
    </div>

    <div class="card">
        <!-- Scanner -->
        <div class="scanner-section">
            <p class="scanner-label">📷 Kamera QR Scanner</p>
            <div id="qr-reader"></div>
        </div>

        <!-- Status & Controls -->
        <div class="status-section">

            <!-- Scanning indicator -->
            <div class="scan-indicator" v-if="isScanning">
                <span class="dot-pulse"></span>
                Scanner aktif — arahkan kamera ke QR Code siswa
            </div>

            <!-- Status card -->
            <div class="status-card" :class="status.type">
                <div class="status-icon">@{{ status.icon }}</div>
                <div>
                    <div class="status-title">@{{ status.title }}</div>
                    <div class="status-message">@{{ status.message }}</div>
                </div>
            </div>

            <!-- Student result card -->
            <div class="student-info" :class="{ visible: result !== null }">
                <div v-if="result">
                    <div class="info-row">
                        <div class="info-label">Nama Siswa</div>
                        <div class="info-value">@{{ result.nama }}</div>
                    </div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">NIS</div>
                            <div class="info-value">@{{ result.nis }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Waktu</div>
                            <div class="info-value">@{{ result.waktu }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Tanggal</div>
                            <div class="info-value">@{{ result.tanggal }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Status</div>
                            <div class="info-value"><span class="badge-hadir">@{{ result.status }}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Control button -->
            <button
                id="btn-toggle-scan"
                class="btn-scan"
                :class="isScanning ? 'stop' : 'start'"
                @click="toggleScan"
                :disabled="isLoading"
            >
                <span v-if="isLoading"><span class="spinner"></span>Memproses...</span>
                <span v-else-if="isScanning">⏹ Hentikan Scanner</span>
                <span v-else>▶ Mulai Scan QR Code</span>
            </button>
        </div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Presensi Siswa Digital &middot; PWA
    </div>
</div>

<script>
const { createApp, ref, reactive } = Vue;

createApp({
    setup() {
        const isScanning = ref(false);
        const isLoading = ref(false);
        const result = ref(null);
        const status = reactive({
            type: 'idle',
            icon: '📋',
            title: 'Siap Scan',
            message: 'Tekan tombol di bawah untuk memulai scanner QR Code.',
        });

        let html5QrCode = null;
        let isScanHandled = false;

        const setStatus = (type, icon, title, message) => {
            status.type = type;
            status.icon = icon;
            status.title = title;
            status.message = message;
        };

        const sendPresensi = async (qrCode) => {
            isLoading.value = true;
            isScanHandled = true;
            result.value = null;

            setStatus('loading', '⏳', 'Memproses...', 'Mengirim data presensi ke server...');

            try {
                const response = await fetch('/api/presensi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ qr_code: qrCode }),
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    result.value = data.data;
                    setStatus('success', '✅', 'Presensi Berhasil!', data.message);
                } else if (response.status === 409) {
                    setStatus('warning', '⚠️', 'Sudah Presensi', data.message);
                } else if (response.status === 404) {
                    setStatus('error', '❌', 'QR Tidak Valid', data.message);
                } else {
                    setStatus('error', '❌', 'Gagal', data.message || 'Terjadi kesalahan server.');
                }
            } catch (err) {
                setStatus('error', '❌', 'Error Koneksi', 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.');
            } finally {
                isLoading.value = false;
                // Allow next scan after 3 seconds
                setTimeout(() => { isScanHandled = false; }, 3000);
            }
        };

        const startScanner = () => {
            html5QrCode = new Html5Qrcode('qr-reader');
            const config = { fps: 10, qrbox: { width: 230, height: 230 } };

            html5QrCode.start(
                { facingMode: 'environment' },
                config,
                (decodedText) => {
                    if (!isScanHandled && !isLoading.value) {
                        sendPresensi(decodedText);
                    }
                },
                () => { /* ignore scan errors */ }
            ).then(() => {
                isScanning.value = true;
                setStatus('idle', '📷', 'Scanner Aktif', 'Arahkan kamera ke QR Code siswa.');
            }).catch((err) => {
                setStatus('error', '❌', 'Kamera Tidak Dapat Diakses', 'Pastikan izin kamera sudah diberikan dan coba lagi.');
                isScanning.value = false;
            });
        };

        const stopScanner = () => {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                    html5QrCode = null;
                    isScanning.value = false;
                    setStatus('idle', '📋', 'Scanner Dihentikan', 'Tekan tombol untuk memulai kembali.');
                });
            }
        };

        const toggleScan = () => {
            if (isScanning.value) {
                stopScanner();
            } else {
                result.value = null;
                startScanner();
            }
        };

        return { isScanning, isLoading, result, status, toggleScan };
    }
}).mount('#app');

// Register service worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').then((reg) => {
            console.log('Service Worker registered:', reg.scope);
        }).catch((err) => {
            console.log('Service Worker failed:', err);
        });
    });
}
</script>
</body>
</html>
