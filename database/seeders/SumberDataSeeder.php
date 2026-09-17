<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SumberDataSeeder extends Seeder
{
    public function run(): void
    {
        $sumber = [
            [
                'nama_sumber' => 'BPS Kabupaten Wonosobo',
                'url' => null,
                'keterangan' => 'Sumber data statistik Kabupaten Wonosobo yang diterbitkan oleh BPS Kabupaten Wonosobo.',
            ],
            [
                'nama_sumber' => 'BPS Provinsi Jawa Tengah',
                'url' => null,
                'keterangan' => 'Sumber data statistik Provinsi Jawa Tengah yang digunakan untuk mendukung data indikator Kabupaten Wonosobo.',
            ],
            [
                'nama_sumber' => 'BPS Republik Indonesia',
                'url' => null,
                'keterangan' => 'Sumber data statistik nasional yang digunakan apabila diperlukan sebagai referensi indikator.',
            ],
        ];

        DB::table('sumber_data')->insert($sumber);
    }
}