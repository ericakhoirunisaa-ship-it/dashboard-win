<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\KelompokIndikator;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN DATA STRATEGIS
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = trim($request->q ?? '');

        $kelompok = KelompokIndikator::with([
            'indikator' => function ($q) use ($query) {
                if ($query !== '') {
                    $q->where(
                        'nama_indikator',
                        'like',
                        '%' . $query . '%'
                    );
                }

                $q->orderBy('id');
            }
        ])
        ->withCount('indikator')
        ->orderBy('id')
        ->get();

        return view('kelompok.index', compact(
            'kelompok',
            'query'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN KELOMPOK INDIKATOR
    |--------------------------------------------------------------------------
    */
    public function group($slug)
    {
        $kelompok = KelompokIndikator::where('slug', $slug)
            ->with([
                'indikator' => function ($query) {
                    $query->with([
                        'dataIndikator' => function ($q) {
                            $q->with([
                                'periode',
                                'sumberData'
                            ])
                            ->orderBy('periode_id');
                        },
                        'kategori'
                    ])
                    ->orderBy('id');
                }
            ])
            ->firstOrFail();

        return view(
            'kelompok.show',
            compact('kelompok')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH INDICATOR
    |--------------------------------------------------------------------------
    */
    public function search(Request $request)
    {
        $query = trim($request->q ?? '');

        if ($query === '') {
            return response()->json([]);
        }

        $indikator = Indikator::with('kelompok')
            ->where(
                'nama_indikator',
                'like',
                '%' . $query . '%'
            )
            ->orderBy('nama_indikator')
            ->limit(8)
            ->get([
                'id',
                'kelompok_indikator_id',
                'nama_indikator',
                'slug',
                'satuan',
            ]);

        return response()->json(
            $indikator->map(function ($item) {
                return [
                    'nama' => $item->nama_indikator,
                    'slug' => $item->slug,
                    'satuan' => $item->satuan,
                    'kelompok' => optional(
                        $item->kelompok
                    )->nama_kelompok,
                    'url' => route(
                        'indikator.show',
                        $item->slug
                    ),
                ];
            })
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL INDIKATOR
    |--------------------------------------------------------------------------
    */
    public function show($slug)
    {
        $indikator = Indikator::where('slug', $slug)
            ->with([
                'kelompok',
                'kategori',
                'dataIndikator' => function ($query) {
                    $query->with([
                        'periode',
                        'sumberData',
                        'kategori'
                    ])
                    ->orderBy('periode_id');
                }
            ])
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | URUTKAN DATA BERDASARKAN TANGGAL PERIODE
        |--------------------------------------------------------------------------
        | Tahun + bulan dipakai agar data bulanan (TPK/RLM/wisatawan)
        | tidak kembali salah urutan hanya karena tahunnya sama.
        */
        $data = $indikator->dataIndikator
            ->sortBy(function ($item) {
                $periode = $item->periode;

                return sprintf(
                    '%04d-%02d',
                    $periode?->tahun ?? 0,
                    $periode?->bulan ?? 0
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
                $terbaru->nilai -
                $sebelumnya->nilai;
        }

        return view(
            'indikator.show',
            compact(
                'indikator',
                'data',
                'terbaru',
                'sebelumnya',
                'perubahan'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD DATA INDIKATOR
    |--------------------------------------------------------------------------
    */
    public function download($slug)
    {
        $indikator = Indikator::where('slug', $slug)
            ->with([
                'kelompok',
                'dataIndikator' => function ($query) {
                    $query->with([
                        'periode',
                        'sumberData',
                        'kategori'
                    ])
                    ->orderBy('periode_id');
                }
            ])
            ->firstOrFail();

        $data = $indikator->dataIndikator
            ->sortBy(function ($item) {
                $periode = $item->periode;

                return sprintf(
                    '%04d-%02d',
                    $periode?->tahun ?? 0,
                    $periode?->bulan ?? 0
                );
            })
            ->values();

        $filename =
            'data-' .
            $indikator->slug .
            '.csv';

        return response()->streamDownload(
            function () use ($indikator, $data) {

                $handle = fopen(
                    'php://output',
                    'w'
                );

                fwrite(
                    $handle,
                    "\xEF\xBB\xBF"
                );

                fputcsv(
                    $handle,
                    [
                        'Kelompok Indikator',
                        $indikator->kelompok->nama_kelompok
                    ],
                    ';'
                );

                fputcsv(
                    $handle,
                    [
                        'Indikator',
                        $indikator->nama_indikator
                    ],
                    ';'
                );

                fputcsv(
                    $handle,
                    [
                        'Satuan',
                        $indikator->satuan
                    ],
                    ';'
                );

                fputcsv(
                    $handle,
                    [
                        'Tipe Data',
                        $indikator->tipe_data
                    ],
                    ';'
                );

                if ($indikator->deskripsi) {
                    fputcsv(
                        $handle,
                        [
                            'Deskripsi',
                            $indikator->deskripsi
                        ],
                        ';'
                    );
                }

                fputcsv($handle, []);

                fputcsv(
                    $handle,
                    [
                        'Tahun',
                        'Bulan',
                        'Periode',
                        'Kategori',
                        'Nilai',
                        'Satuan',
                        'Sumber Data'
                    ],
                    ';'
                );

                foreach ($data as $item) {
                    fputcsv(
                        $handle,
                        [
                            optional($item->periode)->tahun,
                            optional($item->periode)->bulan,
                            optional($item->periode)->nama_periode,
                            optional($item->kategori)->nama_kategori,
                            $item->nilai,
                            $indikator->satuan,
                            optional($item->sumberData)->nama_sumber
                                ?? 'BPS Kabupaten Wonosobo'
                        ],
                        ';'
                    );
                }

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="' .
                    $filename .
                    '"',
            ]
        );
    }
}
