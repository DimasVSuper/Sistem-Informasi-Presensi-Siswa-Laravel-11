<?php

namespace App\Services;

use App\Models\Presensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PresensiService
{
    public function __construct(
        protected Siswa $siswa = new Siswa(),
        protected Presensi $presensi = new Presensi()
    ) {
    }

    /**
     * @return array [success: bool, status: int, message: string, data?: array]
     */
    public function processScan(string $qrCode): array
    {
        return DB::transaction(function () use ($qrCode) {
            $siswa = $this->findSiswaByQrCode($qrCode);

            if (! $siswa) {
                return $this->notFoundResponse();
            }

            if ($this->hasAlreadyPresensiToday($siswa)) {
                return $this->alreadyPresensiResponse($siswa);
            }

            $presensi = $this->createPresensiRecord($siswa);

            return $this->successResponse($siswa, $presensi);
        });
    }

    protected function findSiswaByQrCode(string $qrCode): ?Siswa
    {
        return $this->siswa->newQuery()->withQrCode($qrCode)->first();
    }

    protected function hasAlreadyPresensiToday(Siswa $siswa): bool
    {
        return $this->presensi->newQuery()
            ->forSiswaOnDate($siswa, Carbon::today()->toDateString())
            ->exists();
    }

    protected function createPresensiRecord(Siswa $siswa): Presensi
    {
        return $this->presensi->newQuery()->create([
            'siswa_id' => $siswa->id,
            'tanggal' => Carbon::today()->toDateString(),
            'waktu' => Carbon::now()->format('H:i:s'),
            'status' => 'Hadir',
        ]);
    }

    protected function notFoundResponse(): array
    {
        return [
            'success' => false,
            'status' => 404,
            'message' => 'Siswa tidak ditemukan. QR Code tidak valid.',
        ];
    }

    protected function alreadyPresensiResponse(Siswa $siswa): array
    {
        return [
            'success' => false,
            'status' => 409,
            'message' => 'Siswa '.$siswa->nama.' sudah melakukan presensi hari ini.',
            'data' => ['nama' => $siswa->nama, 'nis' => $siswa->nis],
        ];
    }

    protected function successResponse(Siswa $siswa, Presensi $presensi): array
    {
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
