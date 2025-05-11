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
                'role_kode' => 'A1',
                'role_nama' => 'Anggota 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_kode' => 'A2',
                'role_nama' => 'Anggota 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_kode' => 'A3',
                'role_nama' => 'Anggota 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_kode' => 'A4',
                'role_nama' => 'Anggota 4',
                'created_at' => now(),
                'updated_at' => now(),
            ], 
            [
                'role_kode' => 'A5',
                'role_nama' => 'Anggota 5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_kode' => 'A6',
                'role_nama' => 'Anggota 6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_kode' => 'A7',
                'role_nama' => 'Anggota 7',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_kode' => 'A8',
                'role_nama' => 'Anggota 8',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_kode' => 'A9',
                'role_nama' => 'Anggota 9',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_kode' => 'KJR',
                'role_nama' => 'Kajur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_kode' => 'SPI',
                'role_nama' => 'Satuan Pengawas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_kode' => 'DKT',
                'role_nama' => 'Direktur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
