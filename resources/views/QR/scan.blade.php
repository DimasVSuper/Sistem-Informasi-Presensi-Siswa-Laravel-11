@extends('app')

@section('title', 'Presensi Siswa - Scan QR')

@push('styles')
<style>
    /* Card */
    .card {
        background: rgba(255,255,255,1);
        border-radius: 24px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 10px 40px rgba(79, 70, 229, 0.15);
        overflow: hidden;
        margin: 0 auto;
        border: 1px solid #f3f4f6;
    }

    /* Scanner area */
    .scanner-section { padding: 24px 24px 0; }
    .scanner-label {
        font-size: 13px;
        font-weight: 700;
        color: #4f46e5;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }
    #qr-reader {
        width: 100%;
        border-radius: 16px;
        overflow: hidden;
        background: #0f0f0f;
        min-height: 250px;
        box-shadow: inset 0 2px 10px rgba(0,0,0,0.5);
    }
    /* Override html5-qrcode default styles */
    #qr-reader video { border-radius: 12px; }
    #qr-reader__scan_region { border-radius: 12px; overflow: hidden; }
    #qr-reader__dashboard { display: none !important; }

    /* Status section */
    .status-section { padding: 20px 24px 24px; }

    /* Status card */
    .status-card {
        border-radius: 16px;
        padding: 16px 18px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }
    .status-card.idle { background: #f8fafc; border: 1.5px dashed #cbd5e1; }
    .status-card.loading { background: #eef2ff; border: 1.5px solid #c7d2fe; }
    .status-card.success { background: #f0fdf4; border: 1.5px solid #bbf7d0; animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .status-card.error { background: #fef2f2; border: 1.5px solid #fecaca; animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .status-card.warning { background: #fffbeb; border: 1.5px solid #fde68a; animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }

    @keyframes pop {
        0% { transform: scale(0.95); opacity: 0.5; }
        100% { transform: scale(1); opacity: 1; }
    }

    .status-icon { font-size: 28px; flex-shrink: 0; margin-top: 2px; }
    .status-title { font-size: 15px; font-weight: 700; color: #1e293b; }
    .status-message { font-size: 13px; color: #64748b; margin-top: 3px; line-height: 1.5; }

    /* Student info */
    .student-info {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-radius: 16px;
        padding: 20px;
        color: white;
        margin-bottom: 16px;
        display: none;
        box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
    }
    .student-info.visible { display: block; animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .student-info .info-label { font-size: 11px; font-weight: 600; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.8px; }
    .student-info .info-value { font-size: 16px; font-weight: 700; margin-top: 2px; }
    .student-info .info-row { margin-bottom: 12px; }
    .student-info .info-row:last-child { margin-bottom: 0; }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 12px; background: rgba(0,0,0,0.15); padding: 12px; border-radius: 12px; }
    .badge-hadir {
        display: inline-flex;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 999px;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
    }

    /* Button */
    .btn-scan {
        width: 100%;
        padding: 16px;
        border-radius: 14px;
        border: none;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-scan.start {
        background: border-box linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }
    .btn-scan.start:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(79, 70, 229, 0.4); }
    .btn-scan.start:active { transform: translateY(0); }
    .btn-scan.stop {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .btn-scan.stop:hover { background: #e2e8f0; color: #1e293b; }

    /* Spinner */
    .spinner {
        width: 18px;
        height: 18px;
        border: 2.5px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        display: inline-block;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Scanning indicator */
    .scan-indicator {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        font-weight: 600;
        color: #047857;
    }
    .dot-pulse {
        width: 10px; height: 10px;
        background: #10b981;
        border-radius: 50%;
        animation: pulse 1.2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        flex-shrink: 0;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
@endpush

@section('content')
<div id="app" class="pb-10 pt-4">
    <!-- Header Text -->
    <div class="text-center mb-8 px-4">
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Portal Presensi</h2>
        <p class="text-gray-500 mt-1 text-sm bg-indigo-50 inline-block px-3 py-1 rounded-full border border-indigo-100">Arahkan QR Code ke kamera</p>
    </div>

    <div class="card">
        <!-- Scanner -->
        <div class="scanner-section">
            <div class="scanner-label">
                <i data-feather="camera" class="w-4 h-4 mr-2"></i> Area Scan QR
            </div>
            <div id="qr-reader"></div>
        </div>

        <!-- Status & Controls -->
        <div class="status-section">

            <!-- Scanning indicator -->
            <div class="scan-indicator" v-if="isScanning">
                <span class="dot-pulse"></span>
                Scanner aktif — arahkan layar ke QR Code
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
                        <div class="info-label text-indigo-200">Identitas Siswa</div>
                        <div class="info-value">@{{ result.nama }}</div>
                    </div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label text-indigo-300">NIS</div>
                            <div class="info-value">@{{ result.nis }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label text-indigo-300">Waktu Scan</div>
                            <div class="info-value">@{{ result.waktu }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label text-indigo-300">Tanggal</div>
                            <div class="info-value text-sm mt-0.5">@{{ result.tanggal }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label text-indigo-300">Status</div>
                            <div class="mt-1"><span class="badge-hadir">@{{ result.status }}</span></div>
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
                <span v-if="isLoading" class="flex items-center"><span class="spinner"></span> Sinkronisasi Server...</span>
                <span v-else-if="isScanning" class="flex items-center"><i data-feather="square" class="w-4 h-4 mr-2"></i> Hentikan Scanner</span>
                <span v-else class="flex items-center"><i data-feather="play" class="w-4 h-4 mr-2"></i> Mulai Scan Kamera</span>
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const { createApp, ref, reactive, onMounted } = Vue;

createApp({
    setup() {
        const isScanning = ref(false);
        const isLoading = ref(false);
        const result = ref(null);
        const status = reactive({
            type: 'idle',
            icon: '📱',
            title: 'Siap Digunakan',
            message: 'Tekan tombol di bawah untuk menyalakan kamera device.',
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

            setStatus('loading', '⌛', 'Verifikasi...', 'Mengenkripsi dan mengirim data ke server pusat.');

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
                    setStatus('success', '🎉', 'Berhasil Hadir!', data.message);
                } else if (response.status === 409) {
                    setStatus('warning', '⚠️', 'Info Ganda', data.message);
                } else if (response.status === 404) {
                    setStatus('error', '⛔', 'QR Code Ilegal', data.message);
                } else {
                    setStatus('error', '❌', 'Sistem Error', data.message || 'Terjadi kesalahan tidak terduga pada server.');
                }
            } catch (err) {
                setStatus('error', '🔌', 'Offline', 'Gagal tersambung ke jaringan server.');
            } finally {
                isLoading.value = false;
                // Allow next scan after 3 seconds
                setTimeout(() => { isScanHandled = false; }, 3000);
            }
        };

        const startScanner = () => {
            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode('qr-reader');
            }
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
                setStatus('idle', '📷', 'Kamera Aktif', 'Fokuskan QR Code ke dalam kotak scanner.');
            }).catch((err) => {
                setStatus('error', '🚫', 'Akses Diblokir', 'Pastikan izin kamera browser sudah diberikan.');
                isScanning.value = false;
            });
        };

        const stopScanner = () => {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                    html5QrCode = null;
                    isScanning.value = false;
                    setStatus('idle', '💤', 'Scanner Dimatikan', 'Sistem scanner offline untuk menghemat daya.');
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

        onMounted(() => {
            // Re-render feather icons if inside Vue template just in case
            setTimeout(() => feather.replace(), 100);
        });

        return { isScanning, isLoading, result, status, toggleScan };
    }
}).mount('#app');
</script>
@endpush
