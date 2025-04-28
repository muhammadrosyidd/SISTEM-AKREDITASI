<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'id_role' => 1, // pastikan id_role 1 ini memang ada di tabel role
                'nama' => 'Muhammad Rosyid',
                'username' => 'rosyid',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 2,
                'nama' => 'Gunawan',
                'username' => 'gunawan',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 3,
                'nama' => 'Muhammad Arif',
                'username' => 'arif',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 4,
                'nama' => 'Dewi Sulistyowati',
                'username' => 'dewi',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 5,
                'nama' => 'Belqis Ivana',
                'username' => 'belqis',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 6,
                'nama' => 'Leo Rumici',
                'username' => 'leo',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 7,
                'nama' => 'Jons Alfred',
                'username' => 'jons',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 8,
                'nama' => 'Aliyah Braven',
                'username' => 'aliyah',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 9,
                'nama' => 'Isyana Sarasvati',
                'username' => 'isyana',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 10,
                'nama' => 'Ketua Jurusan',
                'username' => 'kajur',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 11,
                'nama' => 'Pengawas',
                'username' => 'spi',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 12,
                'nama' => 'Direktur',
                'username' => 'direktur',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
