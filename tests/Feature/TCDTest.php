<?php

namespace Tests\Feature;

use App\Models\OrangTua;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TCDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test Case ID: TCD-001 (Dashboard Statistics)
     */
    public function test_TCD001_dashboard_displays_correct_statistics(): void
    {
        $user = User::factory()->create();
        Siswa::factory()->count(5)->create();
        OrangTua::factory()->count(3)->create();
        
        $siswa = Siswa::first();
        Presensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'status' => 'Hadir'
        ]);

        $response = $this->actingAs($user)->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertSee('5'); // Total Siswa
        $response->assertSee('3'); // Total Orang Tua
        $response->assertSee('1'); // Total Kehadiran Hari Ini
    }

    /**
     * @test
     * Test Case ID: TCD-002 (Student Creation)
     */
    public function test_TCD002_authenticated_user_can_create_siswa(): void
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

    /**
     * @test
     * Test Case ID: TCD-002 (Student Update)
     */
    public function test_TCD002_authenticated_user_can_update_siswa(): void
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

    /**
     * @test
     * Test Case ID: TCD-002 (Student Deletion)
     */
    public function test_TCD002_authenticated_user_can_delete_siswa(): void
    {
        $user = User::factory()->create();
        $siswa = Siswa::factory()->create();

        $response = $this->actingAs($user)->delete(route('siswa.destroy', $siswa));

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseMissing('siswa', ['id' => $siswa->id]);
    }

    /**
     * @test
     * Test Case ID: TCD-003 (Parent Creation)
     */
    public function test_TCD003_pengguna_yang_terautentikasi_bisa_membuat_orang_tua(): void
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

    /**
     * @test
     * Test Case ID: TCD-003 (Parent Deletion)
     */
    public function test_TCD003_Deletion_pengguna_yang_terautentikasi_bisa_menghapus_orang_tua(): void
    {
        $user = User::factory()->create();
        $orangTua = OrangTua::factory()->create();

        $response = $this->actingAs($user)->delete(route('orang-tua.destroy', $orangTua));

        $response->assertRedirect(route('orang-tua.index'));
        $this->assertDatabaseMissing('orang_tua', ['id' => $orangTua->id]);
    }

    /**
     * @test
     * Test Case ID: TCD-003 (Parent Update)
     */
    public function test_TCD003_pengguna_yang_terautentikasi_bisa_mengupdate_orang_tua(): void
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

    /**
     * @test
     * Test Case ID: TCD-004 (Search Student)
     */
    public function test_TCD004_search_siswa_filtering(): void
    {
        $user = User::factory()->create();
        Siswa::factory()->create(['nama' => 'Budi Santoso']);
        Siswa::factory()->create(['nama' => 'Dewi Ayu']);

        $response = $this->actingAs($user)->get(route('siswa.index', ['search' => 'Budi']));

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertDontSee('Dewi Ayu');
    }
}
