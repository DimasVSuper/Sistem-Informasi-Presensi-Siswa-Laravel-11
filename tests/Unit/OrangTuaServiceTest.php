<?php

namespace Tests\Unit\backend\service;

use App\Models\OrangTua;
use App\Services\OrangTuaService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

class OrangTuaServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_paginasi_orang_tua(): void
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

        $orangTuaModel = Mockery::mock(OrangTua::class);
        $orangTuaModel->shouldReceive('newQuery')->once()->andReturn($query);
        $query->shouldReceive('latest')->once()->andReturn($query);
        $query->shouldReceive('paginate')->with(10)->once()->andReturn($paginator);

        $service = new OrangTuaService($orangTuaModel);

        $result = $service->getPaginated();

        $this->assertSame(15, $result->total());
        $this->assertSame(10, $result->count());
    }

    public function test_membuat_orang_tua_baru(): void
    {
        $data = [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
        ];

        $orangTua = (object) array_merge(['id' => 1], $data);
        $builder = Mockery::mock();
        $orangTuaModel = Mockery::mock(OrangTua::class);
        $orangTuaModel->shouldReceive('newQuery')->once()->andReturn($builder);
        $builder->shouldReceive('create')->once()->with($data)->andReturn($orangTua);

        $service = new OrangTuaService($orangTuaModel);

        $result = $service->create($data);

        $this->assertSame($orangTua, $result);
        $this->assertSame(1, $result->id);
    }

    public function test_memperbarui_data_orang_tua(): void
    {
        $orangTua = new class extends OrangTua {
            public $nama;
            public $email;

            public function update(array $data = [], array $options = [])
            {
                $this->nama = $data['nama'];
                $this->email = $data['email'];

                return true;
            }
        };

        $orangTua->nama = 'Siti';
        $orangTua->email = 'siti@example.com';

        $service = new OrangTuaService($orangTua);

        $updated = $service->update($orangTua, [
            'nama' => 'Siti Aminah',
            'email' => 'siti.aminah@example.com',
        ]);

        $this->assertSame('Siti Aminah', $updated->nama);
        $this->assertSame('siti.aminah@example.com', $updated->email);
    }

    public function test_menghapus_orang_tua(): void
    {
        $orangTua = new class extends OrangTua {
            public function delete()
            {
                return true;
            }
        };

        $service = new OrangTuaService($orangTua);

        $deleted = $service->delete($orangTua);

        $this->assertTrue($deleted);
    }
}
