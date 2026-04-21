<?php

namespace App\Services;

use App\Models\Siswa;

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

}
