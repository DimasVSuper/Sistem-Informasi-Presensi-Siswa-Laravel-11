<?php

namespace Tests\Feature\request;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_request_membutuhkan_nama_nis_dan_orang_tua_id(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('siswa.create'))
            ->post(route('siswa.store'), []);

        $response->assertRedirect(route('siswa.create'));
        $response->assertSessionHasErrors(['nama', 'nis', 'orang_tua_id']);
    }

    public function test_store_request_membutuhkan_id_orang_tua_yang_valid(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('siswa.create'))
            ->post(route('siswa.store'), [
                'nama' => 'Dewi',
                'nis' => '123456',
                'orang_tua_id' => 999,
            ]);

        $response->assertRedirect(route('siswa.create'));
        $response->assertSessionHasErrors(['orang_tua_id']);
    }
}
