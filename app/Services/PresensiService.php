<?php

namespace App\Services;

use App\Mail\AttendanceNotification;
use App\Models\Presensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class PresensiService
{
    /**
     * @return array [success: bool, status: int, message: string, data?: array]
     */
    public function processScan(string $qrCode): array
    {
        $siswa = Siswa::with('orangTua')->where('qr_code', $qrCode)->first();

        if (! $siswa) {
            return [
                'success' => false,
                'status' => 404,
                'message' => 'Siswa tidak ditemukan. QR Code tidak valid.',
            ];
        }

        $today = Carbon::today()->toDateString();

        $sudahPresensi = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $today)
            ->exists();

        if ($sudahPresensi) {
            return [
                'success' => false,
                'status' => 409,
                'message' => 'Siswa '.$siswa->nama.' sudah melakukan presensi hari ini.',
                'data' => ['nama' => $siswa->nama, 'nis' => $siswa->nis],
            ];
        }

        $presensi = Presensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => $today,
            'waktu' => Carbon::now()->format('H:i:s'),
            'status' => 'Hadir',
        ]);

        if ($siswa->orangTua && $siswa->orangTua->email) {
            Mail::to($siswa->orangTua->email)->send(
                new AttendanceNotification($siswa, $presensi)
            );
        }

        return [
            'success' => true,
            'status' => 201,
            'message' => 'Presensi berhasil dicatat. Notifikasi telah dikirim ke orang tua.',
            'data' => [
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'tanggal' => $presensi->tanggal,
                'waktu' => $presensi->waktu,
                'status' => $presensi->status,
            ],
        ];
    }
}
