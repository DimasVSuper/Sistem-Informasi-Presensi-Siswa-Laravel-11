<?php

namespace Tests\Feature;

use Tests\TestCase;

use PHPUnit\Framework\Attributes\Test;

class TCPTest extends TestCase
{
    #[Test]
    public function test_TCP001_pwa_assets_exist(): void
    {
        $this->assertFileExists(public_path('manifest.json'));
        $this->assertFileExists(public_path('sw.js'));
    }

    #[Test]
    public function test_TCP002_offline_page_is_accessible(): void
    {
        $this->assertFileExists(public_path('offline.html'));
    }
}
