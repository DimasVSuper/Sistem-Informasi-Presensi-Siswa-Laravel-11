<?php

namespace App\Services;

use App\Models\OrangTua;

class OrangTuaService
{
    public function getPaginated(int $perPage = 10)
    {
        return OrangTua::latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return OrangTua::create($data);
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
