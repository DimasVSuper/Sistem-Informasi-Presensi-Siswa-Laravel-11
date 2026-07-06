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
        // Data orang tua — email testing pakai akun tim
        $orangTua1 = OrangTua::create(['nama' => 'Al Faqi Ramdhan', 'email' => 'presensigo77@gmail.com']);
        $orangTua2 = OrangTua::create(['nama' => 'Dimas Bayu Nugroho', 'email' => 'faqiramdhan@gmail.com']);
        $orangTua3 = OrangTua::create(['nama' => 'Siti Jamilah Safitri', 'email' => 'desainalfaqi@gmail.com']);

        // Data siswa — qr_code unik otomatis menggunakan UUID/random string
        Siswa::create([
            'nama' => 'Arvina Nirma Yolin Tiang',
            'nis' => '2024001',
            'qr_code' => 'QR-'.Str::upper(Str::random(8)),
            'orang_tua_id' => $orangTua1->id,
        ]);

        Siswa::create([
            'nama' => 'Maria Asna Yati Baul',
            'nis' => '2024002',
            'qr_code' => 'QR-'.Str::upper(Str::random(8)),
            'orang_tua_id' => $orangTua2->id,
        ]);

        Siswa::create([
            'nama' => 'Sahva Susilo Putra',
            'nis' => '2024003',
            'qr_code' => 'QR-'.Str::upper(Str::random(8)),
            'orang_tua_id' => $orangTua3->id,
        ]);
    }
}
