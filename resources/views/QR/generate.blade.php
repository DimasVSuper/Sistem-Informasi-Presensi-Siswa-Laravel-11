@extends('app')

@section('title', 'Daftar QR Code Siswa')

@push('styles')
<style>
    /* Grid Layout */
    .qr-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 24px;
    }
    
    /* Card Style */
    .qr-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #f3f4f6;
    }
    .qr-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .qr-container {
        background: #f9fafb;
        padding: 16px;
        border-radius: 16px;
        margin-bottom: 20px;
        border: 1px solid #e5e7eb;
    }
    
    /* Print Media Query */
    @media print {
        @page { margin: 1cm; }
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
        body { background: white; padding: 0; }
        .qr-grid { gap: 15px; grid-template-columns: repeat(3, 1fr); }
        .qr-card { box-shadow: none; border: 1px solid #000; break-inside: avoid; }
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endpush

@section('content')
<div class="print-area">
    <div class="text-center mb-8 no-print">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Katalog QR Siswa</h1>
        <p class="text-gray-500 mt-2">Daftar kartu digital untuk scan presensi</p>
    </div>

    <div class="flex justify-center mb-10 no-print">
        <button onclick="window.print()" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-md hover:bg-indigo-700 hover:shadow-lg transition flex items-center">
            <i data-feather="printer" class="w-5 h-5 mr-2"></i> Cetak Dokumen PDF
        </button>
    </div>

    <div class="qr-grid">
        @foreach($siswa as $s)
        <div class="qr-card">
            <div class="qr-container" id="qrcode-{{ $s->id }}"></div>
            <div class="text-lg font-bold text-gray-900 mb-1 text-center">{{ $s->nama }}</div>
            <div class="text-sm text-gray-500 font-medium mb-4">NIS: {{ $s->nis }}</div>
            <div class="font-mono bg-gray-100 px-3 py-1 rounded text-xs text-gray-600 font-semibold border border-gray-200">
                {{ $s->qr_code }}
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($siswa as $s)
            new QRCode(document.getElementById("qrcode-{{ $s->id }}"), {
                text: "{{ $s->qr_code }}",
                width: 160,
                height: 160,
                colorDark : "#1f2937",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        @endforeach
    });
</script>
@endpush
