<?php

namespace Tests\Feature;

use App\Mail\AttendanceNotification;
use App\Models\OrangTua;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TCSTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test Case ID: TCS-001 (Success Presence Scan)
     */
    public function test_TCS001_success_presence_scan(): void
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

    /**
     * @test
     * Test Case ID: TCS-002 (Duplicate Scan)
     */
    public function test_TCS002_duplicate_scan_same_day(): void
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

        Mail::assertNothingSent();
    }

    /**
     * @test
     * Test Case ID: TCS-003 (Invalid QR Code)
     */
    public function test_TCS003_invalid_qr_code(): void
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

    /**
     * @test
     * Test Case ID: TCS-004 (Missing QR Parameter)
     */
    public function test_TCS004_missing_qr_parameter(): void
    {
        $response = $this->postJson('/api/presensi', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['qr_code']);
    }

    /**
     * @test
     * Test Case ID: TCS-005 (Empty Parent Email)
     */
    public function test_TCS005_presence_with_empty_parent_email(): void
    {
        Mail::fake();

        $orangTua = OrangTua::factory()->create(['email' => null]);
        $siswa = Siswa::factory()->create([
            'qr_code' => 'QR-NO-MAIL',
            'orang_tua_id' => $orangTua->id
        ]);

        $response = $this->postJson('/api/presensi', [
            'qr_code' => 'QR-NO-MAIL',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('presensi', ['siswa_id' => $siswa->id]);
        
        // Notification should not be sent or should fail gracefully (handled in logic usually)
        Mail::assertNothingSent();
    }



}
