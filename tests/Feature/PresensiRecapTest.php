<?php

namespace Tests\Feature;

use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PresensiRecapTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_monthly_presensi_recap(): void
    {
        $user = User::factory()->create();
        $budi = Siswa::factory()->create([
            'nama' => 'Budi Santoso',
            'nis' => '100001',
        ]);
        $dewi = Siswa::factory()->create([
            'nama' => 'Dewi Lestari',
            'nis' => '100002',
        ]);

        Presensi::create([
            'siswa_id' => $budi->id,
            'tanggal' => '2026-06-03',
            'waktu' => '07:10:00',
            'status' => 'Hadir',
        ]);

        Presensi::create([
            'siswa_id' => $dewi->id,
            'tanggal' => '2026-05-03',
            'waktu' => '07:15:00',
            'status' => 'Hadir',
        ]);

        $response = $this->actingAs($user)->get(route('rekap-presensi.index', [
            'month' => 6,
            'year' => 2026,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Rekap Presensi Bulanan');
        $response->assertSee('Budi Santoso');
        $response->assertSee('100001');
        $response->assertSee('03 June 2026');
        $response->assertSee('07:10:00');
        $response->assertSee('Dewi Lestari');
        $response->assertSee('Belum Ada');
        $response->assertDontSee('07:15:00');
    }

    public function test_guest_is_redirected_from_monthly_presensi_recap(): void
    {
        $response = $this->get(route('rekap-presensi.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_print_recap(): void
    {
        $user = User::factory()->create();
        $budi = Siswa::factory()->create([
            'nama' => 'Budi Santoso',
            'nis' => '100001',
        ]);
        $dewi = Siswa::factory()->create([
            'nama' => 'Dewi Lestari',
            'nis' => '100002',
        ]);

        Presensi::create([
            'siswa_id' => $budi->id,
            'tanggal' => '2026-06-03',
            'waktu' => '07:10:00',
            'status' => 'Hadir',
        ]);

        $response = $this->actingAs($user)->get(route('rekap-presensi.print', [
            'month' => 6,
            'year' => 2026,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Laporan Rekapitulasi Presensi Siswa');
        $response->assertSee('Budi Santoso');
        $response->assertSee('100001');
        $response->assertSee('Dewi Lestari');
        $response->assertSee('100002');
    }

    public function test_guest_is_redirected_from_print_recap(): void
    {
        $response = $this->get(route('rekap-presensi.print'));

        $response->assertRedirect(route('login'));
    }
}
