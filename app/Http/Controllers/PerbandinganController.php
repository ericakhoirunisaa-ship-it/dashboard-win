<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Periode;
use Illuminate\Http\Request;

class PerbandinganController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Daftar seluruh indikator
        |--------------------------------------------------------------------------
        */

        $indikator = Indikator::with('kelompok')
            ->orderBy('kelompok_indikator_id')
            ->orderBy('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Indikator yang dipilih
        |--------------------------------------------------------------------------
        */

        $selected = $request->input('indikator', []);

        // Pastikan selalu berupa array
        if (!is_array($selected)) {
            $selected = [$selected];
        }

        // Batasi maksimal 5 indikator
        $selected = array_slice($selected, 0, 5);


        /*
        |--------------------------------------------------------------------------
        | Tahun
        |--------------------------------------------------------------------------
        */

        $tahunMulai = $request->input('tahun_mulai', 2021);
        $tahunAkhir = $request->input('tahun_akhir', 2025);


        /*
        |--------------------------------------------------------------------------
        | Ambil data indikator
        |--------------------------------------------------------------------------
        */

        $dataPerbandingan = collect();

        if (count($selected) > 0) {

            $indikatorTerpilih = Indikator::whereIn(
                'slug',
                $selected
            )
            ->with([
                'kelompok',
                'dataIndikator' => function ($query) use (
                    $tahunMulai,
                    $tahunAkhir
                ) {
                    $query->with('periode')
                        ->whereHas('periode', function ($q) use (
                            $tahunMulai,
                            $tahunAkhir
                        ) {
                            $q->whereBetween(
                                'tahun',
                                [
                                    $tahunMulai,
                                    $tahunAkhir
                                ]
                            );
                        });
                }
            ])
            ->get();


            /*
            |--------------------------------------------------------------------------
            | Susun data untuk grafik
            |--------------------------------------------------------------------------
            */

            foreach ($indikatorTerpilih as $item) {

                $nilai = [];

                foreach ($item->dataIndikator as $data) {

                    if (!$data->periode) {
                        continue;
                    }

                    $nilai[$data->periode->tahun] =
                        (float) $data->nilai;
                }

                $dataPerbandingan->push([
                    'slug' => $item->slug,
                    'nama' => $item->nama_indikator,
                    'satuan' => $item->satuan,
                    'kelompok' => optional(
                        $item->kelompok
                    )->nama_kelompok,
                    'nilai' => $nilai,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Daftar tahun
        |--------------------------------------------------------------------------
        */

        $tahun = Periode::whereBetween(
            'tahun',
            [
                $tahunMulai,
                $tahunAkhir
            ]
        )
        ->orderBy('tahun')
        ->pluck('tahun')
        ->unique()
        ->values();


        /*
        |--------------------------------------------------------------------------
        | Kirim ke View
        |--------------------------------------------------------------------------
        */

        return view(
            'perbandingan.index',
            compact(
                'indikator',
                'selected',
                'tahunMulai',
                'tahunAkhir',
                'tahun',
                'dataPerbandingan'
            )
        );
    }
}