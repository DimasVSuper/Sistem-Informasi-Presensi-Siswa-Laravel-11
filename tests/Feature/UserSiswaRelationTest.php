<?php

namespace Tests\Feature;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserSiswaRelationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_siswa_can_be_created_with_user_id(): void
    {
        $user = User::factory()->create();
        $siswa = Siswa::factory()->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('siswa', [
            'id' => $siswa->id,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function test_siswa_can_be_created_without_user_id(): void
    {
        $siswa = Siswa::factory()->create();

        $this->assertDatabaseHas('siswa', [
            'id' => $siswa->id,
            'user_id' => null,
        ]);
    }

    #[Test]
    public function test_siswa_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $siswa = Siswa::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $siswa->user);
        $this->assertEquals($user->id, $siswa->user->id);
    }

    #[Test]
    public function test_user_has_one_siswa(): void
    {
        $user = User::factory()->create();
        $siswa = Siswa::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Siswa::class, $user->siswa);
        $this->assertEquals($siswa->id, $user->siswa->id);
    }

    #[Test]
    public function test_user_id_becomes_null_when_user_is_deleted(): void
    {
        $user = User::factory()->create();
        $siswa = Siswa::factory()->create(['user_id' => $user->id]);

        $user->delete();

        $siswa->refresh();
        $this->assertNull($siswa->user_id);
        $this->assertDatabaseHas('siswa', ['id' => $siswa->id]);
    }
}
