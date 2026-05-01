<?php

namespace Tests\Feature;

use App\Models\OrangTua;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use PHPUnit\Framework\Attributes\Test;

class TCDTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected OrangTua $orangTua;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $this->orangTua = OrangTua::factory()->create();
    }

    #[Test]
    public function test_TCD001_dashboard_displays_correct_statistics(): void
    {
        Siswa::factory()->count(5)->create();
        OrangTua::factory()->count(2)->create();

        $siswa = Siswa::query()->first();
        Presensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'status' => 'Hadir',
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertSee('5'); // Total Siswa
        $response->assertSee('3'); // Total Orang Tua
        $response->assertSee('1'); // Total Kehadiran Hari Ini
    }

    #[Test]
    public function test_TCD002_authenticated_user_can_create_siswa(): void
    {
        $orangTua = OrangTua::factory()->create();

        $response = $this->actingAs($this->user)->post(route('siswa.store'), [
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

    #[Test]
    public function test_TCD003_authenticated_user_can_update_siswa(): void
    {
        $orangTua = OrangTua::factory()->create();
        $siswa = Siswa::factory()->create([
            'nama' => 'Aldi',
            'nis' => '654321',
            'orang_tua_id' => $orangTua->id,
            'qr_code' => 'QR-TEST-123',
        ]);

        $response = $this->actingAs($this->user)->put(route('siswa.update', $siswa), [
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

    #[Test]
    public function test_TCD004_authenticated_user_can_delete_siswa(): void
    {
        $siswa = Siswa::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('siswa.destroy', $siswa));

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseMissing('siswa', ['id' => $siswa->id]);
    }

    #[Test]
    public function test_TCD005_pengguna_yang_terautentikasi_bisa_membuat_orang_tua(): void
    {
        $response = $this->actingAs($this->user)->post(route('orang-tua.store'), [
            'nama' => 'Rudi Hartono',
            'email' => 'rudi@example.com',
        ]);

        $response->assertRedirect(route('orang-tua.index'));
        $this->assertDatabaseHas('orang_tua', [
            'nama' => 'Rudi Hartono',
            'email' => 'rudi@example.com',
        ]);
    }

    #[Test]
    public function test_TCD006_pengguna_yang_terautentikasi_bisa_menghapus_orang_tua(): void
    {
        $this->orangTua = OrangTua::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('orang-tua.destroy', $this->orangTua));

        $response->assertRedirect(route('orang-tua.index'));
        $this->assertDatabaseMissing('orang_tua', ['id' => $this->orangTua->id]);
    }

    #[Test]
    public function test_TCD007_pengguna_yang_terautentikasi_bisa_mengupdate_orang_tua(): void
    {
        $response = $this->actingAs($this->user)->put(route('orang-tua.update', $this->orangTua), [
            'nama' => 'Lina Ayu',
            'email' => 'lina.ayu@example.com',
        ]);

        $response->assertRedirect(route('orang-tua.index'));
        $this->assertDatabaseHas('orang_tua', [
            'id' => $this->orangTua->id,
            'nama' => 'Lina Ayu',
            'email' => 'lina.ayu@example.com',
        ]);
    }

    #[Test]
    public function test_TCD008_search_siswa_filtering(): void
    {
        Siswa::factory()->create(['nama' => 'Budi Santoso']);
        Siswa::factory()->create(['nama' => 'Dewi Ayu']);

        $response = $this->actingAs($this->user)->get(route('siswa.index', ['search' => 'Budi']));

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertDontSee('Dewi Ayu');
    }
}
