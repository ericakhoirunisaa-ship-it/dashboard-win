<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periode;

class PeriodeBulananSeeder extends Seeder
{
    public function run(): void
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        for ($tahun = 2019; $tahun <= 2026; $tahun++) {

            for ($bulan = 1; $bulan <= 12; $bulan++) {

                Periode::updateOrCreate(
                    [
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'frekuensi' => 'Bulanan',
                    ],
                    [
                        'nama_periode' =>
                            $namaBulan[$bulan] . ' ' . $tahun,
                    ]
                );
            }
        }

        $this->command->info(
            'Periode bulanan berhasil diproses.'
        );
    }
}