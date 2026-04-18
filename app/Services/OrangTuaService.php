<?php

namespace App\Services;

use App\Models\OrangTua;

class OrangTuaService
{
    public function __construct(protected OrangTua $orangTua = new OrangTua())
    {
    }

    public function getPaginated(int $perPage = 10)
    {
        return $this->orangTua->newQuery()->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->orangTua->newQuery()->create($data);
    }

    public function update(OrangTua $orangTua, array $data)
    {
        $orangTua->update($data);

        return $orangTua;
    }

    public function delete(OrangTua $orangTua)
    {
        return $orangTua->delete();
    }
}
