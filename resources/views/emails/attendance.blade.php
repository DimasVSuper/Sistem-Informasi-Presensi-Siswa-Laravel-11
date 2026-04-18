<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Presensi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .header p {
            color: rgba(255,255,255,0.85);
            margin: 8px 0 0;
            font-size: 14px;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 12px;
        }
        .body {
            padding: 32px 30px;
        }
        .greeting {
            font-size: 16px;
            color: #374151;
            margin-bottom: 20px;
        }
        .card {
            background: #f8fafc;
            border-left: 4px solid #667eea;
            border-radius: 8px;
            padding: 20px 24px;
            margin: 20px 0;
        }
        .card-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        .card-row:last-child {
            border-bottom: none;
        }
        .card-row .label {
            color: #6b7280;
            font-weight: 500;
        }
        .card-row .value {
            color: #111827;
            font-weight: 600;
        }
        .status-badge {
            display: inline-block;
            background: #d1fae5;
            color: #065f46;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }
        .note {
            font-size: 13px;
            color: #6b7280;
            margin-top: 24px;
            line-height: 1.6;
        }
        .footer {
            background: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">✅</div>
            <h1>Notifikasi Presensi Siswa</h1>
            <p>Sistem Presensi Digital Sekolah</p>
        </div>
        <div class="body">
            <p class="greeting">Yth. Bapak/Ibu <strong>{{ $siswa->orangTua->nama }}</strong>,</p>
            <p style="color:#374151; font-size:15px;">
                Berikut adalah informasi presensi putra/putri Anda hari ini:
            </p>

            <div class="card">
                <div class="card-row">
                    <span class="label">Nama Siswa</span>
                    <span class="value">{{ $siswa->nama }}</span>
                </div>
                <div class="card-row">
                    <span class="label">NIS</span>
                    <span class="value">{{ $siswa->nis }}</span>
                </div>
                <div class="card-row">
                    <span class="label">Tanggal</span>
                    <span class="value">{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="card-row">
                    <span class="label">Waktu Hadir</span>
                    <span class="value">{{ $presensi->waktu }}</span>
                </div>
                <div class="card-row">
                    <span class="label">Status</span>
                    <span class="value"><span class="status-badge">{{ $presensi->status }}</span></span>
                </div>
            </div>

            <p class="note">
                Email ini dikirim secara otomatis oleh sistem presensi sekolah.
                Jika Anda merasa mendapatkan email ini karena kesalahan, silakan abaikan pesan ini.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Sistem Presensi Digital &mdash; Dibuat oleh Kelompok 4
        </div>
    </div>
</body>
</html>
