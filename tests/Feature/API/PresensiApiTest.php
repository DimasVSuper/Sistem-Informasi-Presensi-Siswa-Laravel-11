<?php

namespace Tests\Feature;

use App\Mail\AttendanceNotification;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PresensiApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_bisa_menginput_presensi_via_api(): void
    {
        Mail::fake();

        $siswa = Siswa::factory()->create(['qr_code' => 'QR-API-TEST']);

        $response = $this->postJson('/api/presensi', [
            'qr_code' => 'QR-API-TEST',
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.nama', $siswa->nama)
            ->assertJsonPath('data.nis', $siswa->nis)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['nama', 'nis', 'tanggal', 'waktu', 'status'],
            ]);

        Mail::assertSent(AttendanceNotification::class);
    }

    public function test_mengembalikan_error_validasi_untuk_qr_code_yang_harus_diisi(): void
    {
        $response = $this->postJson('/api/presensi', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['qr_code']);
    }

    public function test_mengembalikan_error_jika_siswa_tidak_ditemukan(): void
    {
        $response = $this->postJson('/api/presensi', [
            'qr_code' => 'QR-UNKNOWN',
        ]);

        $response->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => 'Siswa tidak ditemukan. QR Code tidak valid.',
            ]);
    }

    public function test_mengembalikan_error_jika_siswa_sudah_melakukan_presensi_hari_ini(): void
    {
        Mail::fake();

        $siswa = Siswa::factory()->create(['qr_code' => 'QR-API-DUP']);

        Presensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(),
            'waktu' => now()->format('H:i:s'),
            'status' => 'Hadir',
        ]);

        $response = $this->postJson('/api/presensi', [
            'qr_code' => 'QR-API-DUP',
        ]);

        $response->assertStatus(409)
            ->assertJson([
                'success' => false,
                'message' => 'Siswa '.$siswa->nama.' sudah melakukan presensi hari ini.',
            ]);

        Mail::assertSent(AttendanceNotification::class, 1);
    }
}
