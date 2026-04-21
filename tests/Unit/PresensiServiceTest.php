<?php

namespace Tests\Unit;

use App\Models\Presensi;
use App\Models\Siswa;
use App\Services\PresensiService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

class PresensiServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_gagal_bila_siswa_tidak_ditemukan(): void
    {
        DB::shouldReceive('transaction')->once()->andReturnUsing(fn ($closure) => $closure());

        $siswaBuilder = Mockery::mock();
        $siswaModel = Mockery::mock(Siswa::class);
        $siswaModel->shouldReceive('newQuery')->once()->andReturn($siswaBuilder);
        $siswaBuilder->shouldReceive('withQrCode')->once()->with('QR-NOT-EXISTS')->andReturn($siswaBuilder);
        $siswaBuilder->shouldReceive('first')->once()->andReturnNull();

        $presensiModel = Mockery::mock(Presensi::class);
        $service = new PresensiService($siswaModel, $presensiModel);

        $result = $service->processScan('QR-NOT-EXISTS');

        $this->assertFalse($result['success']);
        $this->assertSame(404, $result['status']);
        $this->assertSame('Siswa tidak ditemukan. QR Code tidak valid.', $result['message']);
    }

    public function test_berhasil_menginput_presensi(): void
    {
        DB::shouldReceive('transaction')->once()->andReturnUsing(fn ($closure) => $closure());

        $siswaBuilder = Mockery::mock();
        $siswa = new class extends Siswa {
            public $id;
            public $nama;
            public $nis;
            public $orangTua;
        };

        $siswa->id = 1;
        $siswa->nama = 'Anton';
        $siswa->nis = '12345';
        $siswa->orangTua = (object) ['email' => 'ortu@example.com'];

        $siswaModel = Mockery::mock(Siswa::class);
        $siswaModel->shouldReceive('newQuery')->once()->andReturn($siswaBuilder);
        $siswaBuilder->shouldReceive('withQrCode')->once()->with('QR-VALID-123')->andReturn($siswaBuilder);
        $siswaBuilder->shouldReceive('first')->once()->andReturn($siswa);

        $presensiBuilder = Mockery::mock();
        $presensiModel = Mockery::mock(Presensi::class);
        $presensiModel->shouldReceive('newQuery')->twice()->andReturn($presensiBuilder);
        $presensiBuilder->shouldReceive('forSiswaOnDate')->once()->with($siswa, Carbon::today()->toDateString())->andReturn($presensiBuilder);
        $presensiBuilder->shouldReceive('exists')->once()->andReturn(false);

        $createdPresensi = new class extends Presensi {
            public $tanggal;
            public $waktu;
            public $status;
        };

        $createdPresensi->tanggal = Carbon::today()->toDateString();
        $createdPresensi->waktu = '08:00:00';
        $createdPresensi->status = 'Hadir';

        $presensiBuilder->shouldReceive('create')->once()->with(Mockery::on(function (array $payload) {
            return $payload['siswa_id'] === 1
                && $payload['status'] === 'Hadir'
                && $payload['tanggal'] === Carbon::today()->toDateString();
        }))->andReturn($createdPresensi);

        $service = new PresensiService($siswaModel, $presensiModel);

        $result = $service->processScan('QR-VALID-123');

        $this->assertTrue($result['success']);
        $this->assertSame(201, $result['status']);
        $this->assertSame('Presensi berhasil dicatat. Notifikasi telah dikirim ke orang tua.', $result['message']);
        $this->assertSame('Anton', $result['data']['nama']);
        $this->assertSame('12345', $result['data']['nis']);
        $this->assertSame(Carbon::today()->toDateString(), $result['data']['tanggal']);
    }

    public function test_gagal_bila_siswa_sudah_melakukan_presensi_hari_ini(): void
    {
        DB::shouldReceive('transaction')->once()->andReturnUsing(fn ($closure) => $closure());

        $siswaBuilder = Mockery::mock();
        $siswa = new class extends Siswa {
            public $id;
            public $nama;
            public $nis;
            public $orangTua;
        };

        $siswa->id = 2;
        $siswa->nama = 'Budi';
        $siswa->nis = '98765';
        $siswa->orangTua = (object) ['email' => 'ortu@example.com'];

        $siswaModel = Mockery::mock(Siswa::class);
        $siswaModel->shouldReceive('newQuery')->once()->andReturn($siswaBuilder);
        $siswaBuilder->shouldReceive('withQrCode')->once()->with('QR-DOUBLE-SCAN')->andReturn($siswaBuilder);
        $siswaBuilder->shouldReceive('first')->once()->andReturn($siswa);

        $presensiBuilder = Mockery::mock();
        $presensiModel = Mockery::mock(Presensi::class);
        $presensiModel->shouldReceive('newQuery')->once()->andReturn($presensiBuilder);
        $presensiBuilder->shouldReceive('forSiswaOnDate')->once()->with($siswa, Carbon::today()->toDateString())->andReturn($presensiBuilder);
        $presensiBuilder->shouldReceive('exists')->once()->andReturn(true);

        $service = new PresensiService($siswaModel, $presensiModel);

        $result = $service->processScan('QR-DOUBLE-SCAN');

        $this->assertFalse($result['success']);
        $this->assertSame(409, $result['status']);
        $this->assertStringContainsString('sudah melakukan presensi hari ini', $result['message']);
    }
}
