<?php

namespace Tests\Feature;

use Tests\TestCase;

class TCPTest extends TestCase
{
    /**
     * @test
     * Test Case ID: TCP-001 (Manifest and Service Worker Existence)
     */
    public function test_TCP001_pwa_assets_exist(): void
    {
        $this->assertFileExists(public_path('manifest.json'));
        $this->assertFileExists(public_path('sw.js'));
    }

    /**
     * @test
     * Test Case ID: TCP-002 (Offline Page Existence)
     */
    public function test_TCP002_offline_page_is_accessible(): void
    {
        $this->assertFileExists(public_path('offline.html'));
    }
}
