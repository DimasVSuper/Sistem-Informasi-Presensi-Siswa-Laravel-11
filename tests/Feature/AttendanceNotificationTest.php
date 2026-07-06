<?php

namespace Tests\Feature;

use App\Mail\AttendanceNotification;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AttendanceNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_attendance_notification_for_checkin(): void
    {
        // Set locale for translatedFormat
        Carbon::setLocale('id');

        $siswa = Siswa::factory()->create();
        $presensi = Presensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => '2026-07-06',
            'waktu' => '07:15:00',
            'status' => 'Hadir',
        ]);

        $mailable = new AttendanceNotification($siswa, $presensi, 'masuk');

        // Assert subject
        $mailable->assertHasSubject('Notifikasi Presensi - '.$siswa->nama);

        // Assert content contains student and parent details
        $mailable->assertSeeInHtml($siswa->nama);
        $mailable->assertSeeInHtml($siswa->nis);
        $mailable->assertSeeInHtml($siswa->orangTua->nama);
        $mailable->assertSeeInHtml('masuk');
        $mailable->assertSeeInHtml('07:15:00');
        $mailable->assertSeeInHtml('Hadir');

        // Check formatted date "Senin, 06 Juli 2026"
        $formattedDate = Carbon::parse($presensi->tanggal)->translatedFormat('l, d F Y');
        $mailable->assertSeeInHtml($formattedDate);
    }

    public function test_attendance_notification_for_checkout(): void
    {
        // Set locale for translatedFormat
        Carbon::setLocale('id');

        $siswa = Siswa::factory()->create();
        $presensi = Presensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => '2026-07-06',
            'waktu' => '07:15:00',
            'waktu_keluar' => '15:30:00',
            'status' => 'Hadir',
        ]);

        $mailable = new AttendanceNotification($siswa, $presensi, 'pulang');

        // Assert subject
        $mailable->assertHasSubject('Notifikasi Presensi Pulang - '.$siswa->nama);

        // Assert content contains student and parent details
        $mailable->assertSeeInHtml($siswa->nama);
        $mailable->assertSeeInHtml($siswa->nis);
        $mailable->assertSeeInHtml($siswa->orangTua->nama);
        $mailable->assertSeeInHtml('pulang');
        $mailable->assertSeeInHtml('15:30:00');
        $mailable->assertSeeInHtml('Pulang');

        // Check formatted date "Senin, 06 Juli 2026"
        $formattedDate = Carbon::parse($presensi->tanggal)->translatedFormat('l, d F Y');
        $mailable->assertSeeInHtml($formattedDate);
    }
}
