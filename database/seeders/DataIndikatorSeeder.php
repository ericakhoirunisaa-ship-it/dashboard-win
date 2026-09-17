<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataIndikatorSeeder extends Seeder
{
    public function run(): void
    {
        $indikator = DB::table('indikator')
            ->pluck('id', 'slug');

        $periode = DB::table('periode')
            ->where('frekuensi', 'Tahunan')
            ->pluck('id', 'tahun');

        $sumber = DB::table('sumber_data')
            ->where('nama_sumber', 'BPS Kabupaten Wonosobo')
            ->value('id');

        /*
        |--------------------------------------------------------------------------
        | DATA DUMMY / SIMULASI
        |--------------------------------------------------------------------------
        | Data ini hanya digunakan untuk pengembangan dan pengujian Dashboard WIN.
        | Nilai wajib diganti dengan data resmi sebelum dashboard digunakan
        | sebagai publikasi statistik.
        */

        $data = [

            // =====================================================
            // KEPENDUDUKAN
            // =====================================================

            'jumlah-penduduk' => [
                2021 => 886420,
                2022 => 893127,
                2023 => 899873,
                2024 => 906241,
                2025 => 912580,
            ],

            'laju-pertumbuhan-penduduk' => [
                2021 => 0.72,
                2022 => 0.76,
                2023 => 0.75,
                2024 => 0.71,
                2025 => 0.70,
            ],

            'kepadatan-penduduk' => [
                2021 => 690,
                2022 => 695,
                2023 => 700,
                2024 => 705,
                2025 => 710,
            ],

            'rasio-jenis-kelamin' => [
                2021 => 98.4,
                2022 => 98.5,
                2023 => 98.6,
                2024 => 98.7,
                2025 => 98.8,
            ],


            // =====================================================
            // KEMISKINAN
            // =====================================================

            'persentase-penduduk-miskin' => [
                2021 => 17.23,
                2022 => 16.91,
                2023 => 16.52,
                2024 => 15.84,
                2025 => 15.21,
            ],

            'jumlah-penduduk-miskin' => [
                2021 => 150200,
                2022 => 148500,
                2023 => 146300,
                2024 => 143800,
                2025 => 140900,
            ],

            'garis-kemiskinan' => [
                2021 => 365420,
                2022 => 382150,
                2023 => 401230,
                2024 => 423750,
                2025 => 448200,
            ],

            'indeks-kedalaman-kemiskinan-p1' => [
                2021 => 2.84,
                2022 => 2.63,
                2023 => 2.51,
                2024 => 2.32,
                2025 => 2.18,
            ],


            // =====================================================
            // KETENAGAKERJAAN
            // =====================================================

            'tingkat-pengangguran-terbuka' => [
                2021 => 4.12,
                2022 => 3.85,
                2023 => 3.62,
                2024 => 3.48,
                2025 => 3.31,
            ],

            'jumlah-angkatan-kerja' => [
                2021 => 470250,
                2022 => 475800,
                2023 => 481200,
                2024 => 486750,
                2025 => 492300,
            ],

            'persentase-bekerja-lapangan-usaha' => [
                2021 => 42.10,
                2022 => 41.85,
                2023 => 41.42,
                2024 => 40.96,
                2025 => 40.55,
            ],


            // =====================================================
            // PEMBANGUNAN MANUSIA
            // =====================================================

            'ipm' => [
                2021 => 68.25,
                2022 => 68.91,
                2023 => 69.45,
                2024 => 69.78,
                2025 => 70.31,
            ],

            'harapan-lama-sekolah' => [
                2021 => 12.84,
                2022 => 12.91,
                2023 => 13.02,
                2024 => 13.14,
                2025 => 13.25,
            ],


            // =====================================================
            // EKONOMI
            // =====================================================

            'pertumbuhan-ekonomi' => [
                2021 => 3.21,
                2022 => 5.04,
                2023 => 5.18,
                2024 => 5.23,
                2025 => 5.41,
            ],

            'pdrb-adhb' => [
                2021 => 28500000,
                2022 => 30500000,
                2023 => 32600000,
                2024 => 34800000,
                2025 => 37100000,
            ],

            'pdrb-adhk' => [
                2021 => 18900000,
                2022 => 19850000,
                2023 => 20880000,
                2024 => 21970000,
                2025 => 23100000,
            ],

            'pdrb-menurut-pengeluaran' => [
                2021 => 28500000,
                2022 => 30500000,
                2023 => 32600000,
                2024 => 34800000,
                2025 => 37100000,
            ],

            'inflasi' => [
                2021 => 2.14,
                2022 => 5.32,
                2023 => 2.61,
                2024 => 2.48,
                2025 => 2.35,
            ],


            // =====================================================
            // PARIWISATA
            // =====================================================

            'jumlah-wisatawan' => [
                2021 => 875400,
                2022 => 1125300,
                2023 => 1387200,
                2024 => 1712400,
                2025 => 1856300,
            ],

            'tingkat-penghunian-kamar' => [
                2021 => 36.20,
                2022 => 41.50,
                2023 => 45.80,
                2024 => 49.30,
                2025 => 51.20,
            ],

            'rata-rata-lama-menginap' => [
                2021 => 1.42,
                2022 => 1.51,
                2023 => 1.58,
                2024 => 1.64,
                2025 => 1.70,
            ],

            'jumlah-akomodasi-hotel' => [
                2021 => 128,
                2022 => 134,
                2023 => 141,
                2024 => 149,
                2025 => 156,
            ],


            // =====================================================
            // PENDIDIKAN
            // =====================================================

            'angka-partisipasi-sekolah' => [
                2021 => 96.21,
                2022 => 96.48,
                2023 => 96.72,
                2024 => 96.95,
                2025 => 97.18,
            ],

            'angka-partisipasi-kasar' => [
                2021 => 87.42,
                2022 => 88.15,
                2023 => 88.74,
                2024 => 89.31,
                2025 => 89.85,
            ],

            'angka-partisipasi-murni' => [
                2021 => 79.42,
                2022 => 80.16,
                2023 => 80.83,
                2024 => 81.42,
                2025 => 82.01,
            ],
        ];


        $records = [];

        foreach ($data as $slug => $values) {

            if (!isset($indikator[$slug])) {
                continue;
            }

            foreach ($values as $tahun => $nilai) {

                if (!isset($periode[$tahun])) {
                    continue;
                }

                $records[] = [
                    'indikator_id' => $indikator[$slug],
                    'periode_id' => $periode[$tahun],
                    'sumber_data_id' => $sumber,
                    'nilai' => $nilai,
                    'catatan' => 'DATA SIMULASI / DUMMY - BUKAN DATA PUBLIKASI',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }


        DB::table('data_indikator')->insert($records);
    }
}