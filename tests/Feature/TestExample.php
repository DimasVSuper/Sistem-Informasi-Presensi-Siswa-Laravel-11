<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_aplikasi_mengalihkan_ke_halaman_scan(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('scan'));
    }
}
