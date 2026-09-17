<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KelompokIndikator;

class KelompokIndikatorSeeder extends Seeder
{
    public function run(): void
    {
        $kelompok = [
            [
                'nama_kelompok' => 'Kependudukan',
                'slug' => 'kependudukan',
            ],
            [
                'nama_kelompok' => 'Kemiskinan',
                'slug' => 'kemiskinan',
            ],
            [
                'nama_kelompok' => 'Ketenagakerjaan',
                'slug' => 'ketenagakerjaan',
            ],
            [
                'nama_kelompok' => 'Pendidikan',
                'slug' => 'pendidikan',
            ],
            [
                'nama_kelompok' => 'Ekonomi',
                'slug' => 'ekonomi',
            ],
            [
                'nama_kelompok' => 'Pariwisata',
                'slug' => 'pariwisata',
            ],
        ];

        foreach ($kelompok as $item) {
            KelompokIndikator::updateOrCreate(
                ['slug' => $item['slug']],
                ['nama_kelompok' => $item['nama_kelompok']]
            );
        }
    }
}