<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_bisa_di_akses()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_tidak_bisa_akses_dashboard_ketika_belum_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

        public function test_user_bisa_akses_dashboard_ketika_sudah_login()
    {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_user_bisa_login_dengan_credentials_yang_benar()
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

    public function test_user_tidak_bisa_login_dengan_credentials_yang_salah()
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

    public function test_user_bisa_logout()
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

    public function test_user_tidak_bisa_akses_dashboard_setelah_logout()
    {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $this->post('/logout');

        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_user_tidak_bisa_akses_login_page_ketika_sudah_login()
    {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $response = $this->get('/login');
        $response->assertRedirect(route('dashboard.index'));
    }

    public function test_user_tidak_bisa_akses_logout_route_ketika_belum_login()
    {
        $response = $this->post('/logout');
        $response->assertRedirect('/login');
    }

    public function test_user_tidak_bisa_akses_master_data_ketika_belum_login()
    {
        $response = $this->get('/orang-tua');
        $response->assertRedirect('/login');

        $response = $this->get('/siswa');
        $response->assertRedirect('/login');
    }

    public function test_user_bisa_akses_master_data_ketika_sudah_login()
    {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $response = $this->get('/orang-tua');
        $response->assertStatus(200);

        $response = $this->get('/siswa');
        $response->assertStatus(200);
    }

}
