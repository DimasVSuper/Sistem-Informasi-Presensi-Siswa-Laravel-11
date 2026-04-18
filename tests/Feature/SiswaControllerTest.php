<?php

namespace Tests\Feature;

use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_siswa(): void
    {
        $user = User::factory()->create();
        $orangTua = OrangTua::factory()->create();

        $response = $this->actingAs($user)->post(route('siswa.store'), [
            'nama' => 'Dewi',
            'nis' => '123456',
            'orang_tua_id' => $orangTua->id,
        ]);

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseHas('siswa', [
            'nama' => 'Dewi',
            'nis' => '123456',
            'orang_tua_id' => $orangTua->id,
        ]);
    }

    public function test_authenticated_user_can_update_siswa(): void
    {
        $user = User::factory()->create();
        $orangTua = OrangTua::factory()->create();
        $siswa = Siswa::factory()->create([
            'nama' => 'Aldi',
            'nis' => '654321',
            'orang_tua_id' => $orangTua->id,
            'qr_code' => 'QR-TEST-123',
        ]);

        $response = $this->actingAs($user)->put(route('siswa.update', $siswa), [
            'nama' => 'Aldi Pratama',
            'nis' => '654322',
            'orang_tua_id' => $orangTua->id,
        ]);

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseHas('siswa', [
            'id' => $siswa->id,
            'nama' => 'Aldi Pratama',
            'nis' => '654322',
        ]);
    }

    public function test_authenticated_user_can_delete_siswa(): void
    {
        $user = User::factory()->create();
        $siswa = Siswa::factory()->create();

        $response = $this->actingAs($user)->delete(route('siswa.destroy', $siswa));

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseMissing('siswa', ['id' => $siswa->id]);
    }
}
