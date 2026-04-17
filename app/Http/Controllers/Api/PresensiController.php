<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AttendanceNotification;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Proses scan QR Code dan simpan presensi.
     * POST /api/presensi
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        // 2. Cari siswa berdasarkan QR code
        $siswa = Siswa::with('orangTua')->where('qr_code', $request->qr_code)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan. QR Code tidak valid.',
            ], 404);
        }

        // 3. Cek apakah siswa sudah presensi hari ini
        $today = Carbon::today()->toDateString();

        $sudahPresensi = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $today)
            ->exists();

        if ($sudahPresensi) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa ' . $siswa->nama . ' sudah melakukan presensi hari ini.',
                'data' => [
                    'nama' => $siswa->nama,
                    'nis'  => $siswa->nis,
                ]
            ], 409);
        }

        // 4. Simpan presensi
        $presensi = Presensi::create([
            'siswa_id' => $siswa->id,
            'tanggal'  => $today,
            'waktu'    => Carbon::now()->format('H:i:s'),
            'status'   => 'Hadir',
        ]);

        // 5. Kirim notifikasi email ke orang tua
        if ($siswa->orangTua && $siswa->orangTua->email) {
            Mail::to($siswa->orangTua->email)->send(
                new AttendanceNotification($siswa, $presensi)
            );
        }

        // 6. Response sukses
        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil dicatat. Notifikasi telah dikirim ke orang tua.',
            'data' => [
                'nama'    => $siswa->nama,
                'nis'     => $siswa->nis,
                'tanggal' => $presensi->tanggal,
                'waktu'   => $presensi->waktu,
                'status'  => $presensi->status,
            ],
        ], 201);
    }
}
