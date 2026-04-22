<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Presensi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #edf2f7;
            margin: 0;
            padding: 24px 0;
            color: #334155;
        }

        .container {
            max-width: 620px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.16);
        }

        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            padding: 38px 32px;
            text-align: center;
        }

        .header .icon {
            width: 72px;
            height: 72px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.16);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 34px;
            color: #ffffff;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            line-height: 1.1;
        }

        .header p {
            color: rgba(255, 255, 255, 0.88);
            margin: 12px auto 0;
            font-size: 15px;
            max-width: 420px;
            line-height: 1.6;
        }

        .body {
            padding: 32px 32px 40px;
        }

        .greeting {
            margin: 0 0 18px;
            font-size: 16px;
            color: #0f172a;
            line-height: 1.75;
        }

        .intro {
            margin-bottom: 24px;
            font-size: 15px;
            line-height: 1.8;
            color: #475569;
        }

        .card {
            background: #f8fafc;
            border-left: 5px solid #4f46e5;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 26px;
        }

        .card-row {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.18);
            font-size: 14px;
            line-height: 1.7;
        }

        .card-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .label {
            color: #64748b;
            width: 45%;
            font-weight: 600;
        }

        .value {
            color: #0f172a;
            width: 55%;
            text-align: right;
            font-weight: 700;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ecfdf5;
            color: #047857;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .note {
            margin: 0;
            font-size: 14px;
            color: #64748b;
            line-height: 1.8;
        }

        .footer {
            background: #f8fafc;
            padding: 18px 32px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
            border-top: 1px solid rgba(148, 163, 184, 0.18);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">✅</div>
            <h1>Notifikasi Presensi Siswa</h1>
            <p>Informasi kehadiran siswa telah dicatat dan dikirimkan secara otomatis ke orang tua.</p>
        </div>

        <div class="body">
            <p class="greeting">Yth. Bapak/Ibu <strong>{{ $siswa->orangTua->nama }}</strong>,</p>
            <p class="intro">Putra/putri Anda telah melakukan presensi hari ini. Berikut detail kehadirannya:</p>

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

            <p class="note">Terima kasih telah mempercayakan kehadiran siswa Anda pada sistem presensi digital ini. Jika notifikasi ini diterima karena kesalahan, silakan abaikan pesan ini.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Sistem Presensi Digital — dibuat oleh Kelompok 4.
        </div>
    </div>
</body>
</html>
