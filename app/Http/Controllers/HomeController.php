<?php

namespace App\Http\Controllers;

use App\Models\DataIndikator;
use App\Models\Indikator;
use App\Models\KelompokIndikator;
use App\Models\Periode;

class HomeController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK DASHBOARD
        |--------------------------------------------------------------------------
        */

        $jumlahIndikator = Indikator::count();

        $jumlahKelompok = KelompokIndikator::count();

        $jumlahTahun = Periode::where('frekuensi', 'tahunan')
            ->distinct('tahun')
            ->count('tahun');

        /*
        |--------------------------------------------------------------------------
        | KELOMPOK INDIKATOR
        |--------------------------------------------------------------------------
        */

        $kelompok = KelompokIndikator::withCount('indikator')
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | INDIKATOR UTAMA
        |--------------------------------------------------------------------------
        |
        | Empat indikator yang ditampilkan pada homepage.
        | Data diambil berdasarkan periode terbaru yang tersedia.
        |
        */

        $slugIndikatorUtama = [
            'jumlah-penduduk',
            'indeks-pembangunan-manusia-ipm',
            'pertumbuhan-ekonomi',
            'jumlah-perjalanan-wisatawan-nusantara-tujuan-wonosobo',
        ];

        $indikatorUtama = Indikator::whereIn(
            'slug',
            $slugIndikatorUtama
        )
        ->with([
            'dataIndikator' => function ($query) {
                $query->with('periode');
            }
        ])
        ->get()
        ->sortBy(function ($indikator) use ($slugIndikatorUtama) {
            return array_search(
                $indikator->slug,
                $slugIndikatorUtama
            );
        })
        ->values();

        /*
        |--------------------------------------------------------------------------
        | PROSES DATA INDIKATOR UTAMA
        |--------------------------------------------------------------------------
        */

        $indikatorUtamaData = collect();

        foreach ($indikatorUtama as $indikator) {

            $data = $indikator->dataIndikator
                ->filter(function ($row) {
                    return $row->periode !== null;
                })
                ->sortBy(function ($row) {
                    $periode = $row->periode;

                    return sprintf(
                        '%04d%02d',
                        $periode->tahun,
                        $periode->bulan ?? 0
                    );
                })
                ->values();

            $terbaru = $data->last();

            $sebelumnya = $data->count() >= 2
                ? $data->get($data->count() - 2)
                : null;

            $perubahan = null;

            if ($terbaru && $sebelumnya) {
                $perubahan =
                    (float) $terbaru->nilai -
                    (float) $sebelumnya->nilai;
            }

            $persentasePerubahan = null;

            if (
                $terbaru &&
                $sebelumnya &&
                (float) $sebelumnya->nilai != 0
            ) {
                $persentasePerubahan =
                    (
                        (
                            (float) $terbaru->nilai -
                            (float) $sebelumnya->nilai
                        )
                        /
                        abs((float) $sebelumnya->nilai)
                    ) * 100;
            }

            $style = match ($indikator->slug) {

                'jumlah-penduduk' => [
                    'class' => 'indicator-blue',
                    'icon' => 'bi-people-fill',
                ],

                'indeks-pembangunan-manusia-ipm' => [
                    'class' => 'indicator-green',
                    'icon' => 'bi-person-check-fill',
                ],

                'pertumbuhan-ekonomi' => [
                    'class' => 'indicator-orange',
                    'icon' => 'bi-graph-up-arrow',
                ],

                'jumlah-perjalanan-wisatawan-nusantara-tujuan-wonosobo' => [
                    'class' => 'indicator-purple',
                    'icon' => 'bi-geo-alt-fill',
                ],

                default => [
                    'class' => 'indicator-blue',
                    'icon' => 'bi-bar-chart-fill',
                ],
            };

            $indikatorUtamaData->push([
                'indikator' => $indikator,
                'data' => $data,
                'terbaru' => $terbaru,
                'sebelumnya' => $sebelumnya,
                'perubahan' => $perubahan,
                'persentase_perubahan' => $persentasePerubahan,
                'class' => $style['class'],
                'icon' => $style['icon'],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SEMUA INDIKATOR
        |--------------------------------------------------------------------------
        */

        $semuaIndikator = Indikator::with([
            'dataIndikator' => function ($query) {
                $query
                    ->with(['periode', 'kategori'])
                    ->orderBy('periode_id');
            }
        ])
        ->orderBy('id')
        ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA CHART HOMEPAGE
        |--------------------------------------------------------------------------
        |
        | Grafik mengikuti periode terbaru di database.
        | Data tahunan dan bulanan ditampilkan sesuai struktur periodenya.
        |
        */

        $chartData = [];

        foreach ($semuaIndikator as $indikator) {

            $rows = $indikator->dataIndikator
                ->filter(function ($row) {
                    return $row->periode !== null;
                })
                ->sortBy(function ($row) {
                    $periode = $row->periode;

                    return sprintf(
                        '%04d-%02d',
                        $periode->tahun,
                        $periode->bulan ?? 0
                    );
                })
                ->values();

            $chartData[$indikator->slug] = [
                'nama' => $indikator->nama_indikator,
                'satuan' => $indikator->satuan,
                'tipe' => $indikator->tipe_data,
                'bulanan' => $rows->contains(function ($row) {
                    return optional($row->periode)->frekuensi === 'bulanan';
                }),
                'data' => $rows->map(function ($row) {
                    return [
                        'year' => (int) optional($row->periode)->tahun,
                        'month' => optional($row->periode)->bulan !== null
                            ? (int) $row->periode->bulan
                            : null,
                        'period' => optional($row->periode)->nama_periode
                            ?? (string) optional($row->periode)->tahun,
                        'value' => (float) $row->nilai,
                        'category' => optional($row->kategori)->nama_kategori,
                    ];
                })->values()->toArray(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | KELOMPOK HOMEPAGE
        |--------------------------------------------------------------------------
        */

        $kelompokHome = KelompokIndikator::withCount('indikator')
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA TERBARU
        |--------------------------------------------------------------------------
        */

        $indikatorTerbaru = $semuaIndikator
            ->map(function ($indikator) {

                $data = $indikator->dataIndikator
                    ->filter(function ($row) {
                        return $row->periode !== null;
                    })
                    ->sortBy(function ($row) {

                        $periode = $row->periode;

                        return sprintf(
                            '%04d%02d',
                            $periode->tahun,
                            $periode->bulan ?? 0
                        );
                    })
                    ->last();

                return [
                    'indikator' => $indikator,
                    'data' => $data,
                ];
            })
            ->filter(function ($item) {
                return $item['data'] !== null;
            })
            ->take(5)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | PENDUDUK TERBARU
        |--------------------------------------------------------------------------
        */

        $pendudukTerbaru = DataIndikator::whereHas(
            'indikator',
            function ($query) {
                $query->where(
                    'slug',
                    'jumlah-penduduk'
                );
            }
        )
        ->whereHas(
            'periode',
            function ($query) {
                $query->where(
                    'frekuensi',
                    'tahunan'
                );
            }
        )
        ->with('periode')
        ->orderByDesc('periode_id')
        ->first();

        /*
        |--------------------------------------------------------------------------
        | TAHUN TERBARU
        |--------------------------------------------------------------------------
        */

        $tahunTerbaru = Periode::where(
            'frekuensi',
            'tahunan'
        )->max('tahun');

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'home',
            compact(
                'jumlahIndikator',
                'jumlahKelompok',
                'jumlahTahun',
                'kelompok',
                'indikatorUtamaData',
                'semuaIndikator',
                'chartData',
                'kelompokHome',
                'indikatorTerbaru',
                'pendudukTerbaru',
                'tahunTerbaru'
            )
        );
    }
}
