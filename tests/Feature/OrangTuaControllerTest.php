<?php

namespace Tests\Feature;

use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrangTuaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengguna_yang_terautentikasi_bisa_membuat_orang_tua(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('orang-tua.store'), [
            'nama' => 'Rudi Hartono',
            'email' => 'rudi@example.com',
        ]);

        $response->assertRedirect(route('orang-tua.index'));
        $this->assertDatabaseHas('orang_tua', [
            'nama' => 'Rudi Hartono',
            'email' => 'rudi@example.com',
        ]);
    }

    public function test_pengguna_yang_terautentikasi_bisa_mengupdate_orang_tua(): void
    {
        $user = User::factory()->create();
        $orangTua = OrangTua::factory()->create([
            'nama' => 'Lina',
            'email' => 'lina@example.com',
        ]);

        $response = $this->actingAs($user)->put(route('orang-tua.update', $orangTua), [
            'nama' => 'Lina Ayu',
            'email' => 'lina.ayu@example.com',
        ]);

        $response->assertRedirect(route('orang-tua.index'));
        $this->assertDatabaseHas('orang_tua', [
            'id' => $orangTua->id,
            'nama' => 'Lina Ayu',
            'email' => 'lina.ayu@example.com',
        ]);
    }

    public function test_pengguna_yang_terautentikasi_bisa_menghapus_orang_tua(): void
    {
        $user = User::factory()->create();
        $orangTua = OrangTua::factory()->create();

        $response = $this->actingAs($user)->delete(route('orang-tua.destroy', $orangTua));

        $response->assertRedirect(route('orang-tua.index'));
        $this->assertDatabaseMissing('orang_tua', ['id' => $orangTua->id]);
    }
}
