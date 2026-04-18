<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        $totalSiswa = Siswa::count();
        $totalHadir = Presensi::where('tanggal', $today)->count();
        $belumHadir = $totalSiswa - $totalHadir;

        $recentPresensi = Presensi::with('siswa')
            ->where('tanggal', $today)
            ->latest('waktu')
            ->get();

        return view('dashboard.index', compact('totalSiswa', 'totalHadir', 'belumHadir', 'recentPresensi', 'today'));
    }
}
