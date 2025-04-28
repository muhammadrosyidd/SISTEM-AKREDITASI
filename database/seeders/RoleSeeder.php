<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role')->insert([
            [
                'kode' => 'A1',
                'nama' => 'Anggota 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'A2',
                'nama' => 'Anggota 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'A3',
                'nama' => 'Anggota 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'A4',
                'nama' => 'Anggota 4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'A5',
                'nama' => 'Anggota 5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'A6',
                'nama' => 'Anggota 6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'A7',
                'nama' => 'Anggota 7',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'A8',
                'nama' => 'Anggota 8',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'A9',
                'nama' => 'Anggota 9',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'KJR',
                'nama' => 'Kajur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SPI',
                'nama' => 'SPI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'DKT',
                'nama' => 'Direktur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
