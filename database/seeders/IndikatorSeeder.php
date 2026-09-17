<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Indikator;
use App\Models\KelompokIndikator;
use Illuminate\Support\Str;

class IndikatorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // KEPENDUDUKAN
            [
                'kelompok' => 'kependudukan',
                'nama' => 'Jumlah Penduduk',
                'satuan' => 'Jiwa',
                'tipe_data' => 'angka',
            ],
            [
                'kelompok' => 'kependudukan',
                'nama' => 'Laju Pertumbuhan Penduduk',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],
            [
                'kelompok' => 'kependudukan',
                'nama' => 'Kepadatan Penduduk',
                'satuan' => 'Jiwa/km²',
                'tipe_data' => 'angka',
            ],
            [
                'kelompok' => 'kependudukan',
                'nama' => 'Rasio Jenis Kelamin',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],

            // KEMISKINAN
            [
                'kelompok' => 'kemiskinan',
                'nama' => 'Persentase Penduduk Miskin',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],
            [
                'kelompok' => 'kemiskinan',
                'nama' => 'Jumlah Penduduk Miskin',
                'satuan' => 'Jiwa',
                'tipe_data' => 'angka',
            ],
            [
                'kelompok' => 'kemiskinan',
                'nama' => 'Garis Kemiskinan',
                'satuan' => 'Rupiah/Kapita/Bulan',
                'tipe_data' => 'angka',
            ],
            [
                'kelompok' => 'kemiskinan',
                'nama' => 'Indeks Kedalaman Kemiskinan (P1)',
                'satuan' => 'Indeks',
                'tipe_data' => 'angka',
            ],

            // KETENAGAKERJAAN
            [
                'kelompok' => 'ketenagakerjaan',
                'nama' => 'Tingkat Pengangguran Terbuka (TPT)',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],
            [
                'kelompok' => 'ketenagakerjaan',
                'nama' => 'Jumlah Angkatan Kerja',
                'satuan' => 'Jiwa',
                'tipe_data' => 'angka',
            ],
            [
                'kelompok' => 'ketenagakerjaan',
                'nama' => 'Persentase Penduduk Bekerja Menurut Status Pekerjaan Utama',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],

            // PENDIDIKAN
            [
                'kelompok' => 'pendidikan',
                'nama' => 'Indeks Pembangunan Manusia (IPM)',
                'satuan' => 'Indeks',
                'tipe_data' => 'angka',
            ],
            [
                'kelompok' => 'pendidikan',
                'nama' => 'Harapan Lama Sekolah (HLS)',
                'satuan' => 'Tahun',
                'tipe_data' => 'angka',
            ],
            [
                'kelompok' => 'pendidikan',
                'nama' => 'Pertumbuhan Ekonomi',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],

            // EKONOMI
            [
                'kelompok' => 'ekonomi',
                'nama' => 'PDRB Atas Dasar Harga Berlaku Menurut Pengeluaran',
                'satuan' => 'Miliar Rupiah',
                'tipe_data' => 'angka',
                'slug' => 'pdrb-adhb',
            ],
            [
                'kelompok' => 'ekonomi',
                'nama' => 'PDRB Atas Dasar Harga Konstan 2010 Menurut Pengeluaran',
                'satuan' => 'Miliar Rupiah',
                'tipe_data' => 'angka',
                'slug' => 'pdrb-adhk',
            ],
            [
                'kelompok' => 'ekonomi',
                'nama' => 'Inflasi',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],

            // PARIWISATA
            [
                'kelompok' => 'pariwisata',
                'nama' => 'Jumlah Perjalanan Wisatawan Nusantara Tujuan Wonosobo',
                'satuan' => 'Perjalanan',
                'tipe_data' => 'angka',
            ],
            [
                'kelompok' => 'pariwisata',
                'nama' => 'Tingkat Penghunian Kamar (TPK) Hotel Menurut Bulan di Kabupaten Wonosobo',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],
            [
                'kelompok' => 'pariwisata',
                'nama' => 'Rata-rata Lama Menginap (RLM) Tamu Hotel Menurut Bulan di Kabupaten Wonosobo',
                'satuan' => 'Malam',
                'tipe_data' => 'angka',
            ],
        ];

        // Tambahan indikator pendidikan
        $pendidikanTambahan = [
            [
                'nama' => 'Angka Partisipasi Sekolah (APS)',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],
            [
                'nama' => 'Angka Partisipasi Kasar (APK)',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],
            [
                'nama' => 'Angka Partisipasi Murni (APM)',
                'satuan' => 'Persen',
                'tipe_data' => 'persentase',
            ],
        ];

        foreach ($pendidikanTambahan as $item) {
            $data[] = [
                'kelompok' => 'pendidikan',
                'nama' => $item['nama'],
                'satuan' => $item['satuan'],
                'tipe_data' => $item['tipe_data'],
            ];
        }

        foreach ($data as $item) {
            $kelompok = KelompokIndikator::where(
                'slug',
                $item['kelompok']
            )->first();

            if (!$kelompok) {
                $this->command->error(
                    "Kelompok tidak ditemukan: {$item['kelompok']}"
                );
                continue;
            }

            $slug = $item['slug'] ?? Str::slug($item['nama']);

            Indikator::updateOrCreate(
                ['slug' => $slug],
                [
                    'kelompok_indikator_id' => $kelompok->id,
                    'nama_indikator' => $item['nama'],
                    'satuan' => $item['satuan'],
                    'tipe_data' => $item['tipe_data'],
                ]
            );
        }
    }
}