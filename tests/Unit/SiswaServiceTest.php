<?php

namespace Tests\Unit\backend\service;

use App\Models\Siswa;
use App\Services\SiswaService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

class SiswaServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_paginasi_siswa(): void
    {
        $query = Mockery::mock();
        $paginator = new class {
            public function total(): int
            {
                return 15;
            }

            public function count(): int
            {
                return 10;
            }
        };

        $siswaModel = Mockery::mock(Siswa::class);
        $siswaModel->shouldReceive('newQuery')->once()->andReturn($query);
        $query->shouldReceive('with')->once()->with('orangTua')->andReturn($query);
        $query->shouldReceive('latest')->once()->andReturn($query);
        $query->shouldReceive('paginate')->with(10)->once()->andReturn($paginator);

        $service = new SiswaService($siswaModel);

        $result = $service->getPaginated();

        $this->assertSame(15, $result->total());
        $this->assertSame(10, $result->count());
    }

    public function test_membuat_siswa_baru(): void
    {
        $builder = Mockery::mock();
        $siswaModel = Mockery::mock(Siswa::class);
        $siswaModel->shouldReceive('newQuery')->twice()->andReturn($builder);
        $builder->shouldReceive('where')->once()->with('qr_code', Mockery::type('string'))->andReturn($builder);
        $builder->shouldReceive('exists')->once()->andReturn(false);

        $data = [
            'nama' => 'Andi Wijaya',
            'nis' => '123456',
            'orang_tua_id' => 1,
        ];

        $createdSiswa = (object) array_merge($data, [
            'id' => 1,
            'qr_code' => 'QR-ABCDEFGH',
        ]);

        $builder->shouldReceive('create')->once()->with(Mockery::on(function (array $payload) {
            return isset($payload['qr_code'])
                && str_starts_with($payload['qr_code'], 'QR-')
                && strlen($payload['qr_code']) === 11;
        }))->andReturn($createdSiswa);

        $service = new SiswaService($siswaModel);

        $result = $service->create($data);

        $this->assertSame($createdSiswa, $result);
        $this->assertStringStartsWith('QR-', $result->qr_code);
        $this->assertSame(11, strlen($result->qr_code));
    }

    public function test_memperbarui_data_siswa(): void
    {
        $siswa = new class extends Siswa {
            public $nama;
            public $nis;

            public function update(array $data = [], array $options = [])
            {
                $this->nama = $data['nama'];
                $this->nis = $data['nis'];

                return true;
            }
        };

        $siswa->nama = 'Rina';
        $siswa->nis = '654321';

        $service = new SiswaService($siswa);

        $updated = $service->update($siswa, [
            'nama' => 'Rina Dewi',
            'nis' => '654322',
        ]);

        $this->assertSame('Rina Dewi', $updated->nama);
        $this->assertSame('654322', $updated->nis);
    }

    public function test_menghapus_siswa(): void
    {
        $siswa = new class extends Siswa {
            public function delete()
            {
                return true;
            }
        };

        $service = new SiswaService($siswa);

        $deleted = $service->delete($siswa);

        $this->assertTrue($deleted);
    }
}
