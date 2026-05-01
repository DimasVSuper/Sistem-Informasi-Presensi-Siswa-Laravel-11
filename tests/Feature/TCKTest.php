<?php

namespace Tests\Feature;

use App\Mail\AttendanceNotification;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

use PHPUnit\Framework\Attributes\Test;

class TCKTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_TCK001_api_presensi_multiple_scans_can_be_processed(): void
    {
        Mail::fake();

        $orangTua = OrangTua::factory()->create(['email' => 'ortu@example.com']);

        $students = Siswa::factory()->count(5)->create([
            'orang_tua_id' => $orangTua->id,
        ]);

        foreach ($students as $student) {
            $response = $this->postJson('/api/presensi', [
                'qr_code' => $student->qr_code,
            ]);

            $response->assertCreated()
                ->assertJsonPath('success', true)
                ->assertJsonPath('data.nis', $student->nis);
        }

        Mail::assertQueued(AttendanceNotification::class, 5);
    }

    #[Test]
    public function test_TCK002_login_password_is_hashed_in_database(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertNotEquals('password', $user->password);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    #[Test]
    public function test_TCK003_guest_access_dashboard_redirects_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }
}
