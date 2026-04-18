<?php

namespace Database\Factories;

use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nis' => $this->faker->unique()->numerify('######'),
            'qr_code' => 'QR-' . Str::upper(Str::random(8)),
            'orang_tua_id' => OrangTua::factory(),
        ];
    }
}
