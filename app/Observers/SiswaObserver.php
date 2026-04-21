<?php

namespace App\Observers;

use App\Models\Siswa;
use Illuminate\Support\Str;

class SiswaObserver
{
    public function creating(Siswa $siswa): void
    {
        if (! $siswa->qr_code) {
            $siswa->qr_code = $this->generateUniqueQrCode();
        }
    }

    protected function generateUniqueQrCode(): string
    {
        $qrCode = 'QR-'.Str::upper(Str::random(8));

        while (Siswa::query()->where('qr_code', $qrCode)->exists()) {
            $qrCode = 'QR-'.Str::upper(Str::random(8));
        }

        return $qrCode;
    }
}
