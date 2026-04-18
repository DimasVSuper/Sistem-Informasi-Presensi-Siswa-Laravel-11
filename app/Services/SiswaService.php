<?php

namespace App\Services;

use App\Models\Siswa;
use Illuminate\Support\Str;

class SiswaService
{
    public function __construct(protected Siswa $siswa = new Siswa())
    {
    }

    public function getPaginated(int $perPage = 10)
    {
        return $this->siswa->newQuery()->with('orangTua')->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        $data['qr_code'] = $this->generateUniqueQrCode();

        return $this->siswa->newQuery()->create($data);
    }

    public function update(Siswa $siswa, array $data)
    {
        $siswa->update($data);

        return $siswa;
    }

    public function delete(Siswa $siswa)
    {
        return $siswa->delete();
    }

    private function generateUniqueQrCode(): string
    {
        $qrCode = 'QR-'.Str::upper(Str::random(8));

        while ($this->siswa->newQuery()->where('qr_code', $qrCode)->exists()) {
            $qrCode = 'QR-'.Str::upper(Str::random(8));
        }

        return $qrCode;
    }
}
