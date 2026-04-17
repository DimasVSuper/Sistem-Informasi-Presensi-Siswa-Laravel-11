<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar QR Code Siswa</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- QRCode.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 40px 20px;
            color: #1f2937;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 32px;
            font-weight: 800;
            color: #111827;
            margin: 0;
        }
        .header p {
            color: #6b7280;
            margin-top: 8px;
        }
        
        /* Grid Layout */
        .qr-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }
        
        /* Card Style */
        .qr-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.2s;
        }
        .qr-card:hover {
            transform: translateY(-5px);
        }
        
        .qr-container {
            background: #f9fafb;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
        }
        
        .student-name {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
            text-align: center;
        }
        .student-nis {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 16px;
        }
        
        .qr-code-text {
            font-family: monospace;
            background: #f3f4f6;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            color: #374151;
        }

        /* Print Button */
        .no-print {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .btn-print {
            background: #667eea;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(102, 126, 234, 0.39);
        }

        /* Print Media Query */
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .qr-grid { gap: 10px; }
            .qr-card { box-shadow: none; border: 1px solid #eee; break-inside: avoid; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>ID Card Digital Siswa</h1>
        <p>Tampilkan halaman ini di Laptop/Tablet untuk di-scan oleh HP petugas</p>
    </div>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
    </div>

    <div class="qr-grid">
        @foreach($siswa as $s)
        <div class="qr-card">
            <div class="qr-container" id="qrcode-{{ $s->id }}"></div>
            <div class="student-name">{{ $s->nama }}</div>
            <div class="student-nis">NIS: {{ $s->nis }}</div>
            <div class="qr-code-text">{{ $s->qr_code }}</div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($siswa as $s)
            new QRCode(document.getElementById("qrcode-{{ $s->id }}"), {
                text: "{{ $s->qr_code }}",
                width: 180,
                height: 180,
                colorDark : "#111827",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        @endforeach
    });
</script>

</body>
</html>
