<?php

namespace Tests\Feature\request;

use Tests\TestCase;

class PresensiRequestTest extends TestCase
{
    public function test_api_presensi_request_membutuhkan_qr_code(): void
    {
        $response = $this->postJson('/api/presensi', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['qr_code']);
    }

    public function test_api_presensi_request_membutuhkan_qr_code_string(): void
    {
        $response = $this->postJson('/api/presensi', [
            'qr_code' => null,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['qr_code']);
    }
}
