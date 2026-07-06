<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PresensiRecapController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'month' => ['nullable', 'integer', 'between:1,12'],
            'year' => ['nullable', 'integer', 'between:2000,2100'],
        ]);

        $selectedMonth = (int) ($validated['month'] ?? now()->month);
        $selectedYear = (int) ($validated['year'] ?? now()->year);
        $selectedDate = Carbon::create($selectedYear, $selectedMonth, 1);
        $startOfMonth = $selectedDate->copy()->startOfMonth()->toDateString();
        $endOfMonth = $selectedDate->copy()->endOfMonth()->toDateString();

        $totalSiswa = Siswa::count();
        $totalPresensi = Presensi::whereBetween('tanggal', [$startOfMonth, $endOfMonth])->count();
        $totalSiswaHadir = Presensi::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->distinct('siswa_id')
            ->count('siswa_id');
        $totalBelumPernahHadir = max($totalSiswa - $totalSiswaHadir, 0);

        $rekapSiswa = Siswa::with('orangTua')
            ->withCount([
                'presensi as total_hadir' => fn ($query) => $query->whereBetween('tanggal', [$startOfMonth, $endOfMonth]),
            ])
            ->orderBy('nama')
            ->get();

        $riwayatPresensi = Presensi::with(['siswa.orangTua'])
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->latest('tanggal')
            ->latest('waktu')
            ->paginate(15)
            ->withQueryString();

        $years = range((int) now()->year + 1, 2024);

        return view('dashboard.rekap-presensi.index', compact(
            'selectedMonth',
            'selectedYear',
            'selectedDate',
            'totalSiswa',
            'totalPresensi',
            'totalSiswaHadir',
            'totalBelumPernahHadir',
            'rekapSiswa',
            'riwayatPresensi',
            'years'
        ));
    }

    public function print(Request $request): View
    {
        $validated = $request->validate([
            'month' => ['nullable', 'integer', 'between:1,12'],
            'year' => ['nullable', 'integer', 'between:2000,2100'],
        ]);

        $selectedMonth = (int) ($validated['month'] ?? now()->month);
        $selectedYear = (int) ($validated['year'] ?? now()->year);
        $selectedDate = Carbon::create($selectedYear, $selectedMonth, 1);
        $startOfMonth = $selectedDate->copy()->startOfMonth()->toDateString();
        $endOfMonth = $selectedDate->copy()->endOfMonth()->toDateString();

        $totalSiswa = Siswa::count();

        $rekapSiswa = Siswa::with('orangTua')
            ->withCount([
                'presensi as total_hadir' => fn ($query) => $query->whereBetween('tanggal', [$startOfMonth, $endOfMonth]),
            ])
            ->orderBy('nama')
            ->get();

        // Calculate dynamic active school days in this period (days where at least one attendance occurred)
        $activeDays = Presensi::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->distinct('tanggal')
            ->count('tanggal');

        if ($activeDays === 0) {
            // Default/fallback to 20 days if no attendance is logged yet
            $activeDays = 20;
        }

        return view('dashboard.rekap-presensi.print', compact(
            'selectedMonth',
            'selectedYear',
            'selectedDate',
            'totalSiswa',
            'rekapSiswa',
            'activeDays'
        ));
    }
}
