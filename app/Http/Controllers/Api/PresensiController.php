<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AttendanceNotification;
use App\Models\Presensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PresensiController extends Controller
{
    /**
     * Proses scan QR Code dan simpan presensi.
     * POST /api/presensi
     */
    public function store(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $qrCode = $request->input('qr_code');

        return DB::transaction(function () use ($qrCode) {
            $siswa = Siswa::with('orangTua')->where('qr_code', $qrCode)->first();

            if (! $siswa) {
                return $this->errorResponse('Siswa tidak ditemukan. QR Code tidak valid.', 404);
            }

            $hasPresensi = Presensi::where('siswa_id', $siswa->id)
                ->where('tanggal', Carbon::today()->toDateString())
                ->exists();

            if ($hasPresensi) {
                return $this->errorResponse(
                    'Siswa '.$siswa->nama.' sudah melakukan presensi hari ini.', 
                    409, 
                    ['nama' => $siswa->nama, 'nis' => $siswa->nis]
                );
            }

            $presensi = Presensi::create([
                'siswa_id' => $siswa->id,
                'tanggal' => Carbon::today()->toDateString(),
                'waktu' => Carbon::now()->format('H:i:s'),
                'status' => 'Hadir',
            ]);

            if ($siswa->orangTua && $siswa->orangTua->email) {
                Mail::to($siswa->orangTua->email)->send(new AttendanceNotification($siswa, $presensi));
            }

            return $this->successResponse('Presensi berhasil dicatat. Notifikasi telah dikirim ke orang tua.', [
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'tanggal' => $presensi->tanggal,
                'waktu' => $presensi->waktu,
                'status' => $presensi->status,
            ], 201);
        });
    }
}
