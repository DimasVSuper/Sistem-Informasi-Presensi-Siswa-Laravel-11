<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use PHPUnit\Framework\Attributes\Test;

class TCLTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_login_page_bisa_di_akses()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    #[Test]
    public function test_TCL001_user_bisa_login_dengan_credentials_yang_benar()
    {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function test_TCL002_user_tidak_bisa_login_dengan_credentials_yang_salah()
    {
        User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    #[Test]
    public function test_TCL003_user_tidak_bisa_login_dengan_email_tidak_terdaftar()
    {
        $response = $this->post('/login', [
            'email' => 'unknown@test.com',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    #[Test]
    public function test_TCL004_user_bisa_logout()
    {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/scan');
        $this->assertGuest();
    }

    #[Test]
    public function test_TCL005_user_tidak_bisa_akses_dashboard_ketika_belum_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
}