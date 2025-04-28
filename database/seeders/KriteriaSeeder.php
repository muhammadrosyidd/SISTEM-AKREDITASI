<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriteria')->insert([
            [
                'nama' => 'VMTS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Tata Kelola, Tata Pamong , dan Kerjasama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'SDM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Keuangan, Sarana, dan Prasarana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Penelitian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Pengabdian Kepada Masyarakat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Luaran dan Capaian TRIDARMA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
