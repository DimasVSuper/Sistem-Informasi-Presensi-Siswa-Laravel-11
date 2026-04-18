<?php

namespace Tests\Feature\request;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_membutuhkan_password_dan_email(): void
    {
        $response = $this->from('/login')->post('/login', []);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_login_membutuhkan_email_yang_valid(): void
    {
        User::factory()->create();

        $response = $this->from('/login')->post('/login', [
            'email' => 'not-valid',
            'password' => 'secret',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email']);
    }
}
