<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_bisa_melihat_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_bisa_autentikasi_dengan_kredensial_yang_valid(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('secret'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_authentication_harus_gagal_dengan_kredensial_yang_tidak_valid(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('secret'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_pengguna_yang_terautentikasi_bisa_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('scan'));
        $this->assertGuest();
    }
}
