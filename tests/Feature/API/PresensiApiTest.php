<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresensiApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_bisa_menginput_presensi_via_api()
    {
        $siswa = Siswa::factory()->create(['qr_code' => 'QR-API-TEST']);

        $response = $this->postJson('/api/presensi', [
            'qr_code' => 'QR-API-TEST'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'nama',
                    'nis',
                    'tanggal',
                    'waktu',
                    'status'
                ]
            ]);
    }

    
    public function test_mengembalikan_error_validasi_untuk_qr_code_yang_harus_diisi()
    {
        $response = $this->postJson('/api/presensi', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['qr_code']);
    }
}
