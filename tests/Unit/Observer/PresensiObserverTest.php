<?php

namespace Tests\Unit\Observer;

use App\Mail\AttendanceNotification;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PresensiObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_mengirim_notifikasi_ke_orang_tua_setelah_presensi_dibuat(): void
    {
        Mail::fake();

        $siswa = Siswa::factory()->create(['qr_code' => 'QR-OBS-TEST']);

        $presensi = Presensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(),
            'waktu' => now()->format('H:i:s'),
            'status' => 'Hadir',
        ]);

        Mail::assertSent(AttendanceNotification::class, function ($mail) use ($siswa, $presensi) {
            return $mail->hasTo($siswa->orangTua->email)
                && $mail->siswa->id === $siswa->id
                && $mail->presensi->id === $presensi->id;
        });
    }
}
