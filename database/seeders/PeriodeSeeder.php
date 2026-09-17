<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periode;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        // Periode tahunan 2021–2025
        for ($tahun = 2021; $tahun <= 2025; $tahun++) {
            Periode::updateOrCreate(
                [
                    'tahun' => $tahun,
                    'bulan' => null,
                    'frekuensi' => 'tahunan',
                ],
                [
                    'nama_periode' => (string) $tahun,
                ]
            );
        }

        // Periode bulanan 2019–2026
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
                        'frekuensi' => 'bulanan',
                    ],
                    [
                        'nama_periode' => $namaBulan[$bulan] . ' ' . $tahun,
                    ]
                );
            }
        }
    }
}