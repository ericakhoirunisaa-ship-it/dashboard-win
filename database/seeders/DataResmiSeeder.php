<?php

namespace Database\Seeders;

use App\Models\DataIndikator;
use App\Models\Indikator;
use App\Models\KategoriIndikator;
use App\Models\Periode;
use App\Models\SumberData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataResmiSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->importCsv();
        });
    }

    private function importCsv(): void
    {
        $path = base_path('data/data_indikator_resmi_v2.csv');

        if (!file_exists($path)) {
            throw new \RuntimeException("File CSV tidak ditemukan: {$path}");
        }

        $handle = fopen($path, 'r');
        if (!$handle) {
            throw new \RuntimeException("CSV tidak dapat dibuka.");
        }

        $header = fgetcsv($handle, 0, ';');
        if (!$header) {
            fclose($handle);
            throw new \RuntimeException("Header CSV kosong.");
        }

        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
        $index = [];
        foreach ($header as $i => $name) {
            $index[strtolower(trim($name))] = $i;
        }

        foreach (['nama_indikator', 'kategori', 'tahun', 'nilai', 'satuan', 'tipe_data'] as $required) {
            if (!array_key_exists($required, $index)) {
                fclose($handle);
                throw new \RuntimeException("Kolom '{$required}' tidak ditemukan di CSV.");
            }
        }

        // Bersihkan data PDRB lama (yang sebelumnya hanya agregat) dan
        // kategori PDRB lama. Setelah ini PDRB akan diisi ulang dengan
        // struktur kategori yang sama seperti APK/APM/HLS.
        $pdrbIndicators = Indikator::whereIn('slug', [
            'pdrb-adhb',
            'pdrb-adhk',
        ])->get();

        foreach ($pdrbIndicators as $pdrbIndicator) {
            DataIndikator::where('indikator_id', $pdrbIndicator->id)->delete();
            KategoriIndikator::where('indikator_id', $pdrbIndicator->id)->delete();
        }

        $processed = 0;
        $failed = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            if (count($row) === 1 && trim((string)$row[0]) === '') {
                continue;
            }

            try {
                $nama = trim((string)$row[$index['nama_indikator']]);
                if ($nama === '') {
                    $skipped++;
                    continue;
                }

                $tahun = (int)($row[$index['tahun']] ?? 0);
                $bulan = isset($index['bulan']) && trim((string)$row[$index['bulan']]) !== ''
                    ? (int)$row[$index['bulan']]
                    : null;

                $nilaiRaw = trim((string)($row[$index['nilai']] ?? ''));
                if ($nilaiRaw === '' || $nilaiRaw === '-') {
                    $skipped++;
                    continue;
                }

                // Handle Indonesian/Excel numeric representations safely.
                $nilaiRaw = str_replace([' ', "\xc2\xa0"], '', $nilaiRaw);
                if (substr_count($nilaiRaw, ',') > 0 && substr_count($nilaiRaw, '.') === 0) {
                    $nilaiRaw = str_replace(',', '.', $nilaiRaw);
                } elseif (substr_count($nilaiRaw, ',') > 0 && substr_count($nilaiRaw, '.') > 0) {
                    $nilaiRaw = str_replace('.', '', $nilaiRaw);
                    $nilaiRaw = str_replace(',', '.', $nilaiRaw);
                }
                if (!is_numeric($nilaiRaw)) {
                    throw new \RuntimeException("Nilai '{$nilaiRaw}' bukan angka.");
                }
                $nilai = (float)$nilaiRaw;

                // Resolve indicator by current DB ID where available;
                // for PDRB use the current indicator slug so stale CSV IDs
                // can never break the import.
                $pdrbSlug = [
                    'PDRB Atas Dasar Harga Berlaku Menurut Pengeluaran' => 'pdrb-adhb',
                    'PDRB Atas Dasar Harga Konstan 2010 Menurut Pengeluaran' => 'pdrb-adhk',
                ];

                // Utamakan pencarian berdasarkan slug nama indikator.
                // ID dari CSV tidak dijadikan acuan utama karena ID master
                // dapat berubah setelah penataan ulang database.
                $indikator = Indikator::where('slug', Str::slug($nama))->first();

                $slugAliases = [
                    'PDRB Atas Dasar Harga Berlaku Menurut Pengeluaran' => 'pdrb-adhb',
                    'PDRB Atas Dasar Harga Konstan 2010 Menurut Pengeluaran' => 'pdrb-adhk',
                    'Angka Partisipasi Sekolah (APS)' => 'angka-partisipasi-sekolah-aps',
                    'Angka Partisipasi Kasar (APK)' => 'angka-partisipasi-kasar-apk',
                    'Angka Partisipasi Murni (APM)' => 'angka-partisipasi-murni-apm',
                ];

                if (!$indikator && isset($slugAliases[$nama])) {
                    $indikator = Indikator::where('slug', $slugAliases[$nama])->first();
                }

                // Fallback terakhir: gunakan ID CSV.
                if (!$indikator && isset($index['indikator_id'])) {
                    $indikatorId = (int)$row[$index['indikator_id']];
                    if ($indikatorId > 0) {
                        $indikator = Indikator::find($indikatorId);
                    }
                }

                if (!$indikator) {
                    throw new \RuntimeException(
                        "Indikator '{$nama}' tidak ditemukan. Slug yang dicoba: '" .
                        Str::slug($nama) . "'."
                    );
                }

                // Period is shared with all indicators.
                $frekuensi = isset($index['frekuensi'])
                    ? trim((string)$row[$index['frekuensi']])
                    : ($bulan ? 'bulanan' : 'tahunan');

                $namaPeriode = isset($index['nama_periode'])
                    ? trim((string)$row[$index['nama_periode']])
                    : ($bulan ? date('F', mktime(0,0,0,$bulan,1)) . ' ' . $tahun : (string)$tahun);

                $periode = Periode::firstOrCreate(
                    [
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'frekuensi' => $frekuensi,
                    ],
                    ['nama_periode' => $namaPeriode]
                );

                // Category lookup is scoped to the current indicator, matching
                // the same pattern used by APK/APM/HLS.
                $kategoriId = null;
                $kategoriNama = isset($index['kategori'])
                    ? trim((string)$row[$index['kategori']])
                    : '';

                if ($kategoriNama !== '') {
                    $kategori = KategoriIndikator::firstOrCreate(
                        [
                            'indikator_id' => $indikator->id,
                            'slug' => Str::slug($kategoriNama),
                        ],
                        [
                            'nama_kategori' => $kategoriNama,
                            'urutan' => $this->kategoriUrutan($kategoriNama),
                        ]
                    );
                    $kategoriId = $kategori->id;
                }

                $sumberNama = isset($index['sumber_data'])
                    ? trim((string)$row[$index['sumber_data']])
                    : 'BPS Kabupaten Wonosobo';

                $sumber = SumberData::firstOrCreate(
                    ['nama_sumber' => $sumberNama],
                    ['url' => null, 'keterangan' => null]
                );

                DataIndikator::updateOrCreate(
                    [
                        'indikator_id' => $indikator->id,
                        'kategori_indikator_id' => $kategoriId,
                        'periode_id' => $periode->id,
                    ],
                    [
                        'sumber_data_id' => $sumber->id,
                        'nilai' => $nilai,
                        'catatan' => null,
                    ]
                );

                $processed++;
            } catch (\Throwable $e) {
                $failed++;
                $this->command?->warn("Baris CSV gagal: " . $e->getMessage());
            }
        }

        fclose($handle);

        $this->command?->info("CSV diproses: {$processed}");
        $this->command?->info("CSV dilewati (kosong/-): {$skipped}");
        $this->command?->info("CSV gagal: {$failed}");

        if ($failed > 0) {
            throw new \RuntimeException(
                "Import CSV memiliki {$failed} baris gagal. Transaksi dibatalkan."
            );
        }
    }
    private function kategoriUrutan(string $nama): int
    {
        $urutan = [
            'Pengeluaran Konsumsi Rumahtangga' => 1,
            'Pengeluaran Konsumsi LNPRT' => 2,
            'Pengeluaran Konsumsi Pemerintah' => 3,
            'Pembentukan Modal Tetap Bruto' => 4,
            'Perubahan Inventori' => 5,
            'Net Ekspor Barang dan Jasa' => 6,
            'Produk Domestik Regional Bruto' => 7,
        ];

        return $urutan[$nama] ?? 99;
    }

}
