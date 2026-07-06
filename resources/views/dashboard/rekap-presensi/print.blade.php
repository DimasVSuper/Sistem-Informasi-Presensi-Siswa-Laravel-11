<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekap Presensi - {{ $selectedDate->translatedFormat('F Y') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Kop Surat Double Line */
        .kop-line {
            border: 0;
            border-top: 4px double #000000; /* Black for formal printing */
            height: 0;
            margin-top: 8px;
            margin-bottom: 20px;
        }

        /* Print Settings */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff;
                color: #000000;
                padding: 0;
                margin: 0;
            }
            .print-container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            /* Prevent page break inside table rows and signature block */
            tr {
                page-break-inside: avoid;
            }
            .signature-section {
                page-break-inside: avoid;
            }
        }

        @page {
            size: A4 portrait;
            margin: 1.5cm 1.5cm 1.5cm 1.5cm;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-8 text-gray-800">

    <!-- Floating Action Bar for Web View -->
    <div class="max-w-4xl mx-auto mb-6 px-4 no-print flex items-center justify-between">
        <a href="{{ route('rekap-presensi.index', ['month' => $selectedMonth, 'year' => $selectedYear]) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-indigo-600 font-medium transition-colors">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Rekap
        </a>
        <div class="flex space-x-3">
            <button onclick="window.close()" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                <i data-feather="x" class="w-4 h-4 mr-2"></i> Tutup
            </button>
            <button onclick="window.print()" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-all flex items-center">
                <i data-feather="printer" class="w-4 h-4 mr-2"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Paper Container -->
    <div class="print-container max-w-4xl mx-auto bg-white border border-gray-200 shadow-sm rounded-2xl p-10 print:border-none print:shadow-none print:p-0">
        
        <!-- KOP SURAT (School Letterhead) -->
        <div class="flex items-center justify-between pb-4 mb-1">
            <!-- Placeholder Logo (Formal design element) -->
            <div class="w-16 h-16 border-2 border-black rounded-lg flex items-center justify-center text-black mr-4 shadow-sm">
                <i data-feather="book-open" class="w-8 h-8"></i>
            </div>
            
            <div class="flex-1 text-center pr-8">
                <h1 class="text-xl font-bold tracking-wider text-black uppercase leading-none">Yayasan Pendidikan IT Indra Bangsa</h1>
                <h2 class="text-2xl font-extrabold tracking-tight text-black uppercase mt-1">Sekolah IT Indra Bangsa</h2>
                <p class="text-xs text-gray-600 mt-1 font-medium">Terakreditasi A • SK Pendirian No. 120/SK/2020</p>
                <p class="text-xs text-gray-500 mt-0.5">Jl. Teknologi Informasi No. 42, Kota Digital • Telp: (021) 123-4567 • Email: info@itindrabangsa.sch.id</p>
            </div>
        </div>
        <hr class="kop-line">

        <!-- REPORT TITLE -->
        <div class="text-center mb-8">
            <h3 class="text-lg font-bold uppercase tracking-wider text-black">Laporan Rekapitulasi Presensi Siswa</h3>
            <p class="text-sm font-semibold text-gray-800 mt-1">Periode Kehadiran: <span class="text-black">{{ $selectedDate->translatedFormat('F Y') }}</span></p>
        </div>

        <!-- REPORT INFO / METADATA -->
        <div class="grid grid-cols-2 gap-4 mb-6 text-xs text-gray-700 bg-gray-50 p-4 rounded-xl print:bg-transparent print:border print:border-gray-200 print:p-3">
            <div>
                <table class="w-full">
                    <tr>
                        <td class="font-semibold py-1 w-32">Nama Dokumen</td>
                        <td class="py-1">: Laporan Presensi Bulanan</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1">Periode Bulan</td>
                        <td class="py-1">: {{ $selectedDate->translatedFormat('F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1">Hari Belajar Efektif</td>
                        <td class="py-1">: {{ $activeDays }} Hari</td>
                    </tr>
                </table>
            </div>
            <div>
                <table class="w-full">
                    <tr>
                        <td class="font-semibold py-1 w-32">Total Siswa Terdaftar</td>
                        <td class="py-1">: {{ $totalSiswa }} Siswa</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1">Tanggal Cetak</td>
                        <td class="py-1">: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1">Dicetak Oleh</td>
                        <td class="py-1">: {{ Auth::user()->name ?? 'Administrator' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- MAIN ATTENDANCE TABLE -->
        <div class="overflow-x-auto mb-8">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-black uppercase font-bold border border-gray-300">
                        <th class="px-3 py-3 text-center border border-gray-300 w-10">No</th>
                        <th class="px-4 py-3 border border-gray-300 w-24">NIS</th>
                        <th class="px-4 py-3 border border-gray-300">Nama Siswa</th>
                        <th class="px-3 py-3 text-center border border-gray-300 w-24">Hari Efektif</th>
                        <th class="px-3 py-3 text-center border border-gray-300 w-24">Total Hadir</th>
                        <th class="px-3 py-3 text-center border border-gray-300 w-24">Absen / Alpa</th>
                        <th class="px-3 py-3 text-center border border-gray-300 w-20">Persentase</th>
                        <th class="px-4 py-3 text-center border border-gray-300 w-28">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapSiswa as $index => $siswa)
                        @php
                            $absenCount = max(0, $activeDays - $siswa->total_hadir);
                            $percentage = $activeDays > 0 ? round(($siswa->total_hadir / $activeDays) * 100) : 0;
                            
                            // Determine status/keterangan based on attendance percentage
                            if ($percentage >= 90) {
                                $keterangan = 'Sangat Baik';
                            } elseif ($percentage >= 75) {
                                $keterangan = 'Baik';
                            } else {
                                $keterangan = 'Perlu Perhatian';
                            }
                            
                            $rowBg = 'even:bg-gray-50/50 even:print:bg-gray-50/20';
                        @endphp
                        <tr class="{{ $rowBg }} border border-gray-200 hover:bg-gray-50/80 transition-colors">
                            <td class="px-3 py-2.5 text-center border border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-4 py-2.5 border border-gray-200 font-mono">{{ $siswa->nis }}</td>
                            <td class="px-4 py-2.5 border border-gray-200 font-bold text-gray-900">{{ $siswa->nama }}</td>
                            <td class="px-3 py-2.5 text-center border border-gray-200 text-gray-700">{{ $activeDays }} H</td>
                            <td class="px-3 py-2.5 text-center border border-gray-200 font-bold text-gray-900">{{ $siswa->total_hadir }} H</td>
                            <td class="px-3 py-2.5 text-center border border-gray-200 font-bold text-gray-900">
                                {{ $absenCount }} H
                            </td>
                            <td class="px-3 py-2.5 text-center border border-gray-200 font-bold text-gray-900">{{ $percentage }}%</td>
                            <td class="px-4 py-2.5 text-center border border-gray-200 text-gray-800 font-medium">
                                {{ $keterangan }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500 border border-gray-200">Tidak ada data rekap presensi siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- SIGNATURE AREA -->
        <div class="signature-section grid grid-cols-2 gap-8 mt-12 text-xs">
            <div class="text-center">
                <p class="text-gray-600 mb-1">Mengetahui,</p>
                <p class="font-bold text-gray-800 mb-16">Kepala Sekolah IT Indra Bangsa</p>
                
                <p class="font-bold text-gray-900 underline">Dr. H. Ahmad Fauzi, M.Pd.</p>
                <p class="text-gray-500 mt-0.5">NIP. 19750812 200212 1 003</p>
            </div>
            
            <div class="text-center">
                <p class="text-gray-600 mb-1">Kota Digital, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold text-gray-800 mb-16">Wali Kelas / Staf Kesiswaan</p>
                
                <p class="font-bold text-gray-900 underline">{{ Auth::user()->name ?? 'Administrator' }}</p>
                <p class="text-gray-500 mt-0.5">NIP. ..................................</p>
            </div>
        </div>

        <!-- FOOTER FOR PRINTED PAGE -->
        <div class="hidden print:block border-t border-gray-200 mt-16 pt-3 text-center text-[10px] text-gray-400">
            Laporan ini dibuat otomatis melalui Sistem Informasi Presensi Siswa Sekolah IT Indra Bangsa pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}.
        </div>

    </div>

    <!-- Script to auto trigger print -->
    <script>
        feather.replace();
        
        // Auto trigger print when page is loaded
        window.addEventListener('DOMContentLoaded', () => {
            // Give icons a moment to render
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
