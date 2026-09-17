<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Indikator;
use App\Models\KategoriIndikator;
use Illuminate\Support\Str;

class KategoriIndikatorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // HLS
            [
                'indikator' => 'harapan-lama-sekolah-hls',
                'kategori' => [
                    'Laki-laki',
                    'Perempuan',
                ],
            ],

            // APS
            [
                'indikator' => 'angka-partisipasi-sekolah-aps',
                'kategori' => [
                    '7–12',
                    '13–15',
                    '16–18',
                    '19–23',
                ],
            ],

            // APK
            [
                'indikator' => 'angka-partisipasi-kasar-apk',
                'kategori' => [
                    'SD',
                    'SMP',
                    'SMA',
                    'PT',
                ],
            ],

            // APM
            [
                'indikator' => 'angka-partisipasi-murni-apm',
                'kategori' => [
                    'SD',
                    'SMP',
                    'SMA',
                    'PT',
                ],
            ],

            // Status pekerjaan utama
            [
                'indikator' => 'persentase-penduduk-bekerja-menurut-status-pekerjaan-utama',
                'kategori' => [
                    'Berusaha sendiri',
                    'Berusaha dibantu buruh tidak tetap/buruh tidak dibayar',
                    'Berusaha dibantu buruh tetap atau buruh dibayar',
                    'Buruh karyawan pegawai',
                    'Pekerja bebas',
                    'Pekerja keluarga/tidak dibayar',
                ],
            ],

            // TPK
            [
                'indikator' => 'tingkat-penghunian-kamar-tpk-hotel-menurut-bulan-di-kabupaten-wonosobo',
                'kategori' => [
                    'Bintang dan Non-Bintang',
                ],
            ],

            // RLM
            [
                'indikator' => 'rata-rata-lama-menginap-rlm-tamu-hotel-menurut-bulan-di-kabupaten-wonosobo',
                'kategori' => [
                    'Bintang dan Non-Bintang',
                ],
            ],
        ];

        foreach ($data as $item) {

            $indikator = Indikator::where(
                'slug',
                $item['indikator']
            )->first();

            if (!$indikator) {
                $this->command->error(
                    "Indikator tidak ditemukan: {$item['indikator']}"
                );
                continue;
            }

            foreach ($item['kategori'] as $urutan => $namaKategori) {

                KategoriIndikator::updateOrCreate(
                    [
                        'indikator_id' => $indikator->id,
                        'slug' => Str::slug($namaKategori),
                    ],
                    [
                        'nama_kategori' => $namaKategori,
                        'urutan' => $urutan + 1,
                    ]
                );
            }
        }
    }
}