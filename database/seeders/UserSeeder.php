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
                'nama_user' => 'Muhammad Rosyid',
                'username' => 'rosyid',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 2,
                'nama_user' => 'Gunawan',
                'username' => 'gunawan',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 3,
                'nama_user' => 'Muhammad Arif',
                'username' => 'arif',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 4,
                'nama_user' => 'Dewi Sulistyowati',
                'username' => 'dewi',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 5,
                'nama_user' => 'Belqis Ivana',
                'username' => 'belqis',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 6,
                'nama_user' => 'Leo Rumici',
                'username' => 'leo',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 7,
                'nama_user' => 'Jons Alfred',
                'username' => 'jons',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 8,
                'nama_user' => 'Aliyah Braven',
                'username' => 'aliyah',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 9,
                'nama_user' => 'Isyana Sarasvati',
                'username' => 'isyana',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 10,
                'nama_user' => 'Ketua Jurusan',
                'username' => 'kajur',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 11,
                'nama_user' => 'Pengawas',
                'username' => 'spi',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 12,
                'nama_user' => 'Direktur',
                'username' => 'direktur',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
