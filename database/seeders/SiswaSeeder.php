<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Data orang tua — gunakan email nyata untuk testing notifikasi
        $orangTua1 = OrangTua::create(['nama' => 'Bapak Ahmad Fauzi', 'email' => 'orangtua1@example.com']);
        $orangTua2 = OrangTua::create(['nama' => 'Ibu Siti Rahayu', 'email' => 'orangtua2@example.com']);
        $orangTua3 = OrangTua::create(['nama' => 'Bapak Dedi Susanto', 'email' => 'orangtua3@example.com']);
        $orangTua4 = OrangTua::create(['nama' => 'Bapak Dimas', 'email' => 'dimasbayunugroho2006@gmail.com']);

        // Data siswa — qr_code unik otomatis menggunakan UUID
        Siswa::create([
            'nama' => 'Budi Santoso',
            'nis' => '2024001',
            'qr_code' => 'QR-'.Str::upper(Str::random(8)),
            'orang_tua_id' => $orangTua1->id,
        ]);

        Siswa::create([
            'nama' => 'Sari Dewi',
            'nis' => '2024002',
            'qr_code' => 'QR-'.Str::upper(Str::random(8)),
            'orang_tua_id' => $orangTua2->id,
        ]);

        Siswa::create([
            'nama' => 'Rian Pratama',
            'nis' => '2024003',
            'qr_code' => 'QR-'.Str::upper(Str::random(8)),
            'orang_tua_id' => $orangTua3->id,
        ]);

        Siswa::create([
            'nama' => 'Dimas Bayu Nugroho',
            'nis' => '2024004',
            'qr_code' => 'QR-'.Str::upper(Str::random(8)),
            'orang_tua_id' => $orangTua4->id,
        ]);
    }
}
