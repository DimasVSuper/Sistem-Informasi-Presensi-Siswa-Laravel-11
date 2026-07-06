<?php

namespace Tests\Feature;

use App\Mail\AttendanceNotification;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PresensiKeluarTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_checkout_fails_if_student_not_found(): void
    {
        $response = $this->postJson('/api/presensi', [
            'qr_code' => 'QR-NOTFOUND-pulang',
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Siswa tidak ditemukan. QR Code tidak valid.',
            ]);
    }

    #[Test]
    public function test_checkout_fails_if_not_checked_in_yet(): void
    {
        $siswa = Siswa::factory()->create(['qr_code' => 'QR-TEST']);

        $response = $this->postJson('/api/presensi', [
            'qr_code' => 'QR-TEST-pulang',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Siswa '.$siswa->nama.' belum melakukan presensi masuk hari ini.',
            ]);
    }

    #[Test]
    public function test_checkout_success_after_checkin(): void
    {
        Mail::fake();

        $siswa = Siswa::factory()->create(['qr_code' => 'QR-TEST']);

        // 1. Check-in first
        $checkinResponse = $this->postJson('/api/presensi', [
            'qr_code' => 'QR-TEST',
        ]);
        $checkinResponse->assertCreated();

        // 2. Perform check-out
        $checkoutResponse = $this->postJson('/api/presensi', [
            'qr_code' => 'QR-TEST-pulang',
        ]);

        $checkoutResponse->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'Pulang')
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['nama', 'nis', 'tanggal', 'waktu', 'status'],
            ]);

        $this->assertDatabaseHas('presensi', [
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(),
        ]);

        $presensi = Presensi::where('siswa_id', $siswa->id)->first();
        $this->assertNotNull($presensi->waktu_keluar);

        // Verify checkout notification was sent
        Mail::assertQueued(AttendanceNotification::class, function ($mail) {
            return $mail->type === 'pulang';
        });
    }

    #[Test]
    public function test_checkout_fails_if_already_checked_out(): void
    {
        Mail::fake();

        $siswa = Siswa::factory()->create(['qr_code' => 'QR-TEST']);

        // 1. Check-in
        $this->postJson('/api/presensi', [
            'qr_code' => 'QR-TEST',
        ])->assertCreated();

        // 2. First Check-out
        $this->postJson('/api/presensi', [
            'qr_code' => 'QR-TEST-pulang',
        ])->assertOk();

        // 3. Second Check-out
        $response = $this->postJson('/api/presensi', [
            'qr_code' => 'QR-TEST-pulang',
        ]);

        $response->assertStatus(409)
            ->assertJson([
                'success' => false,
                'message' => 'Siswa '.$siswa->nama.' sudah melakukan presensi pulang hari ini.',
            ]);
    }
}
