<?php

namespace Tests\Unit\Observer;

use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_otomatis_menghasilkan_qr_code_saat_siswa_dibuat_tanpa_qr_code(): void
    {
        $orangTua = OrangTua::factory()->create();

        $siswa = Siswa::create([
            'nama' => 'Andi Wijaya',
            'nis' => '123456',
            'qr_code' => '',
            'orang_tua_id' => $orangTua->id,
        ]);

        $this->assertMatchesRegularExpression('/^QR-[A-Z0-9]{8}$/', $siswa->qr_code);
    }
}
