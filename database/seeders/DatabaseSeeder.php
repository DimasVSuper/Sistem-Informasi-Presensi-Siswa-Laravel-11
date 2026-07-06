<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Al Faqi Ramdhan',
            'email' => 'faqi@admin.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Dimas Bayu Nugroho',
            'email' => 'dimas@admin.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Siti Jamilah Safitri',
            'email' => 'jamilah@admin.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Arvina Nirma Yolin Tiang',
            'email' => 'arvina@admin.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Maria Asna Yati Baul',
            'email' => 'maria@admin.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Sahva Susilo Putra',
            'email' => 'sahva@admin.com',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            SiswaSeeder::class,
        ]);
    }
}
