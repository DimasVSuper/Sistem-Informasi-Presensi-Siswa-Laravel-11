<?php

namespace Tests\Feature\request;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrangTuaRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_request_membutuhkan_nama_dan_email(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('orang-tua.create'))
            ->post(route('orang-tua.store'), []);

        $response->assertRedirect(route('orang-tua.create'));
        $response->assertSessionHasErrors(['nama', 'email']);
    }

    public function test_store_request_membutuhkan_email_yang_valid(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('orang-tua.create'))
            ->post(route('orang-tua.store'), [
                'nama' => 'Budi',
                'email' => 'invalid-email',
            ]);

        $response->assertRedirect(route('orang-tua.create'));
        $response->assertSessionHasErrors(['email']);
    }
}
