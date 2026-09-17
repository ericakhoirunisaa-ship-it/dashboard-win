@extends('layouts.app')

@section('title', $indikator->nama_indikator . ' - WIN Wonosobo')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | PERSIAPAN DATA
    |--------------------------------------------------------------------------
    */

    $dataUrut = $data
        ->sortBy(function ($item) {
            $periode = $item->periode;
            return sprintf(
                '%04d-%02d-%06d',
                $periode?->tahun ?? 0,
                $periode?->bulan ?? 0,
                $item->id ?? 0
            );
        })
        ->values();

    $tahunPertama = $dataUrut->first()?->periode?->tahun;
    $tahunTerakhir = $dataUrut->last()?->periode?->tahun;

    $isBulanan = strtolower($dataUrut->first()?->periode?->frekuensi ?? '') === 'bulanan';

    // Pilihan Y to Y / M to M untuk indikator bulanan TPK, RLM, dan Inflasi.
    $isYoyMom = in_array($indikator->slug, [
        'tingkat-penghunian-kamar-tpk-hotel-menurut-bulan-di-kabupaten-wonosobo',
        'rata-rata-lama-menginap-rlm-tamu-hotel-menurut-bulan-di-kabupaten-wonosobo',
        'inflasi',
    ], true);

    $kategoriList = $dataUrut
        ->filter(fn($item) => $item->kategori_indikator_id)
        ->map(fn($item) => [
            'id' => $item->kategori_indikator_id,
            'nama' => optional($item->kategori)->nama_kategori ?? 'Kategori',
        ])
        ->unique('id')
        ->values();

    $hasKategori = $kategoriList->count() > 0;

    /*
    |--------------------------------------------------------------------------
    | KETERANGAN KHUSUS PDRB
    |--------------------------------------------------------------------------
    | PDRB menurut pengeluaran terdiri atas  pengeluaran
    | dan 1 total PDRB. "Produk Domestik Regional Bruto" bukan
    | komponen pengeluaran tersendiri, melainkan nilai total.
    */
    $isPdrb = in_array($indikator->slug ?? '', [
        'pdrb-adhb',
        'pdrb-adhk',
    ], true);

    /*
    |--------------------------------------------------------------------------
    | FORMAT ANGKA
    |--------------------------------------------------------------------------
    | Beberapa indikator bertipe "angka" tetapi tetap membutuhkan
    | dua angka desimal, misalnya indeks kemiskinan (P1).
    | Gunakan satu aturan yang sama untuk ringkasan dan tabel.
    */
    $tipeDataLower = strtolower($indikator->tipe_data ?? '');
    $satuanLower = strtolower(trim($indikator->satuan ?? ''));

    $jumlahDesimal = (
        in_array($tipeDataLower, [
            'persentase',
            'desimal',
            'angka_desimal',
            'decimal'
        ], true)
        || in_array($satuanLower, [
            'indeks',
            'rasio',
            'malam',
            'perjalanan'
        ], true)
    ) ? 2 : 0;

    /*
    | Jika satu periode memiliki beberapa kategori, jangan tampilkan
    | salah satu kategori sebagai "Nilai Terbaru".
    */
    $periodeTerbaru = $dataUrut->last()?->periode;
    $dataTerbaru = $periodeTerbaru
        ? $dataUrut->filter(fn($item) => $item->periode?->id === $periodeTerbaru->id)->values()
        : collect();
    $multiKategoriTerbaru = $dataTerbaru->pluck('kategori_indikator_id')->filter()->unique()->count() > 1;

    $multiKategoriLabel = $isPdrb
        ? ''
        : $dataTerbaru->pluck('kategori_indikator_id')->filter()->unique()->count() . ' kategori';

    $nilaiTerbaru = $multiKategoriTerbaru ? null : $terbaru?->nilai;
    $nilaiPerubahan = $multiKategoriTerbaru ? null : $perubahan;
    $sebelumnyaUntukRingkasan = $multiKategoriTerbaru ? null : $sebelumnya;

    // PDRB: ringkasan menggunakan TOTAL PDRB, sehingga perubahan
    // juga dihitung dari total PDRB tahun/periode sebelumnya.
    if ($isPdrb && $periodeTerbaru) {
        $totalTerbaru = $dataTerbaru->first(function ($item) {
            return strtolower(trim($item->kategori?->nama_kategori ?? '')) ===
                'produk domestik regional bruto';
        });

        $periodeSebelumnya = $dataUrut
            ->filter(function ($item) use ($periodeTerbaru) {
                $p = $item->periode;
                $current = sprintf('%04d-%02d', $periodeTerbaru?->tahun ?? 0, $periodeTerbaru?->bulan ?? 0);
                $key = sprintf('%04d-%02d', $p?->tahun ?? 0, $p?->bulan ?? 0);
                return $key < $current &&
                    strtolower(trim($item->kategori?->nama_kategori ?? '')) ===
                        'produk domestik regional bruto';
            })
            ->sortByDesc(function ($item) {
                $p = $item->periode;
                return sprintf('%04d-%02d', $p?->tahun ?? 0, $p?->bulan ?? 0);
            })
            ->first();

        $nilaiTerbaru = $totalTerbaru?->nilai;
        $sebelumnyaUntukRingkasan = $periodeSebelumnya;
        $nilaiPerubahan = ($totalTerbaru && $periodeSebelumnya)
            ? $totalTerbaru->nilai - $periodeSebelumnya->nilai
            : null;
    }

    $persentasePerubahan = null;
    if ($sebelumnyaUntukRingkasan && $sebelumnyaUntukRingkasan->nilai != 0 && $nilaiPerubahan !== null) {
        $persentasePerubahan = ($nilaiPerubahan / abs($sebelumnyaUntukRingkasan->nilai)) * 100;
    }

    $arahPerubahan = 'same';
    if ($nilaiPerubahan !== null) {
        $arahPerubahan = $nilaiPerubahan > 0 ? 'up' : ($nilaiPerubahan < 0 ? 'down' : 'same');
    }

    $bulanNama = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    $formatPeriode = function ($periode) use ($bulanNama) {
        if (!$periode) return '-';
        if (strtolower($periode->frekuensi ?? '') === 'bulanan' && $periode->bulan) {
            return ($bulanNama[$periode->bulan] ?? '-') . ' ' . $periode->tahun;
        }
        return (string) $periode->tahun;
    };

    /* Data grafik: satu titik per periode untuk indikator biasa,
       beberapa series untuk indikator berkategori. */
    $chartData = $dataUrut
        ->map(function ($item) use ($formatPeriode) {
            return [
                'year' => optional($item->periode)->tahun,
                'month' => optional($item->periode)->bulan,
                'period' => $formatPeriode($item->periode),
                'period_key' => sprintf(
                    '%04d-%02d',
                    optional($item->periode)->tahun ?? 0,
                    optional($item->periode)->bulan ?? 0
                ),
                'category_id' => $item->kategori_indikator_id,
                'category' => optional($item->kategori)->nama_kategori,
                'value' => (float) $item->nilai,
            ];
        })
        ->values()
        ->toJson();

    $tahunList = $dataUrut
        ->map(fn($item) => optional($item->periode)->tahun)
        ->filter()
        ->unique()
        ->sort()
        ->values();

@endphp



<style>

/* =========================================================
   HALAMAN
========================================================= */

.indicator-page {

    color: #1f2937;

}


/* =========================================================
   BREADCRUMB
========================================================= */

.indicator-breadcrumb {

    margin-bottom: 35px;

}


.indicator-breadcrumb small {

    color: #6b7280;

    font-size: 13px;

}


.indicator-breadcrumb a {

    color: #6b7280 !important;

}


.indicator-breadcrumb a:hover {

    color: #2563eb !important;

}


.indicator-breadcrumb strong {

    color: #1f2937;

    font-weight: 700;

}


/* =========================================================
   HEADER INDIKATOR
========================================================= */

.indicator-header {

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 25px;

    margin-bottom: 35px;

}


.indicator-header-content {

    flex: 1;

    min-width: 0;

}


.indicator-badge {

    display: inline-block;

    padding: 6px 11px;

    margin-bottom: 10px;

    border-radius: 20px;

    background: #eff6ff;

    color: #2563eb;

    font-size: 12px;

    font-weight: 700;

}


.indicator-title {

    margin: 0 0 10px;

    color: #1f2937;

    font-size: 40px;

    font-weight: 800;

    line-height: 1.2;

}


.indicator-description {

    max-width: 760px;

    margin: 0;

    color: #6b7280;

    font-size: 15px;

    line-height: 1.6;

}


/* =========================================================
   TOMBOL KEMBALI
========================================================= */

.back-button {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    flex-shrink: 0;

    padding: 9px 14px;

    border: 1px solid #e5e7eb;

    border-radius: 9px;

    background: #ffffff;

    color: #2563eb;

    font-size: 12px;

    font-weight: 600;

    text-decoration: none;

    transition: .2s ease;

}


.back-button:hover {

    background: #eff6ff;

    border-color: #93c5fd;

    color: #2563eb;

}


/* =========================================================
   SUMMARY CARDS
========================================================= */

.summary-grid {

    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 20px;

    margin-bottom: 35px;

}


.summary-card {

    min-height: 145px;

    padding: 22px;

    background: #ffffff;

    border: 0;

    border-radius: 18px;

    box-shadow:
        0 5px 20px rgba(0, 0, 0, .07);

    transition: .25s ease;

}


.summary-card:hover {

    box-shadow:
        0 8px 24px rgba(0, 0, 0, .09);

}


.summary-primary {

    background:
        linear-gradient(
            135deg,
            #dbeafe,
            #eff6ff
        );

}


.summary-label {

    display: flex;

    align-items: center;

    gap: 6px;

    margin-bottom: 13px;

    color: #2563eb;

    font-size: 13px;

    font-weight: 700;

}


.summary-value {

    margin-bottom: 9px;

    color: #1f2937;

    font-size: 36px;

    font-weight: 800;

    line-height: 1;

}


.summary-meta {

    color: #6b7280;

    font-size: 12px;

}


.summary-meta-up {

    color: #059669;

    font-weight: 700;

}


.summary-meta-down {

    color: #dc2626;

    font-weight: 700;

}


.change-up {

    color: #009b72;

}


.change-down {

    color: #e34a4a;

}


.change-same {

    color: #64748b;

}


/* =========================================================
   CHART CARD
========================================================= */

.chart-card {

    margin-bottom: 30px;

    padding: 22px;

    background: #ffffff;

    border: 0;

    border-radius: 18px;

    box-shadow:
        0 5px 20px rgba(0, 0, 0, .07);

}


.chart-header {

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 20px;

}


.chart-kicker {

    margin-bottom: 5px;

    color: #2563eb;

    font-size: 13px;

    font-weight: 700;

    letter-spacing: 1px;

}


.chart-title {

    margin: 0 0 6px;

    color: #1f2937;

    font-size: 24px;

    font-weight: 800;

    line-height: 1.2;

}


.chart-subtitle {

    margin: 0;

    color: #6b7280;

    font-size: 13px;

}


/* =========================================================
   TOGGLE GRAFIK
========================================================= */

.chart-actions {

    display: flex;

    align-items: center;

    gap: 10px;

    flex-shrink: 0;

}


.chart-toggle {

    display: inline-flex;

    padding: 4px;

    border-radius: 10px;

    background: #f3f4f6;

}


.chart-toggle button {

    padding: 8px 12px;

    border: 0;

    border-radius: 7px;

    background: transparent;

    color: #6b7280;

    font-size: 11px;

    font-weight: 600;

    cursor: pointer;

    transition: .2s ease;

}


.chart-toggle button:hover {

    color: #2563eb;

}


.chart-toggle button.active {

    background: #ffffff;

    color: #2563eb;

    box-shadow:
        0 1px 4px rgba(0, 0, 0, .08);

}


/* =========================================================
   TOMBOL DOWNLOAD PNG
========================================================= */

.download-chart-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

    height: 40px;

    padding: 0 13px;

    border: 1px solid #2563eb;

    border-radius: 9px;

    background: #2563eb;

    color: #ffffff;

    font-size: 11px;

    font-weight: 600;

    cursor: pointer;

    transition: .2s ease;

}


.download-chart-button:hover {

    background: #1d4ed8;

    border-color: #1d4ed8;

    color: #ffffff;

    transform: translateY(-1px);

    box-shadow:
        0 5px 12px rgba(37, 99, 235, .20);

}


.download-chart-button:active {

    transform: translateY(0);

}


/* =========================================================
   FILTER
========================================================= */

.chart-filter {

    display: flex;

    align-items: flex-end;

    gap: 14px;

    flex-wrap: wrap;

    padding: 15px;

    margin-bottom: 25px;

    border: 1px solid #e5e7eb;

    border-radius: 12px;

    background: #f9fafb;

}


.filter-group {

    display: flex;

    flex-direction: column;

    gap: 5px;

}


.filter-group label {

    color: #6b7280;

    font-size: 10px;

    font-weight: 700;

    text-transform: uppercase;

}


.filter-select {

    min-width: 150px;

    height: 40px;

    padding: 0 12px;

    border: 1px solid #d1d5db;

    border-radius: 8px;

    background: #ffffff;

    color: #374151;

    font-size: 12px;

    outline: none;

}


.filter-select:focus {

    border-color: #93c5fd;

    box-shadow:
        0 0 0 3px rgba(37, 99, 235, .08);

}


.filter-arrow {

    display: flex;

    align-items: center;

    height: 40px;

    color: #9ca3af;

}


.reset-button {

    height: 40px;

    margin-left: auto;

    padding: 0 14px;

    border: 1px solid #d1d5db;

    border-radius: 8px;

    background: #ffffff;

    color: #6b7280;

    font-size: 11px;

    cursor: pointer;

    transition: .2s ease;

}


.reset-button:hover {

    border-color: #93c5fd;

    background: #eff6ff;

    color: #2563eb;

}


/* =========================================================
   AREA CHART
========================================================= */

.chart-wrapper {

    position: relative;

    width: 100%;

    height: 390px;

}


/* =========================================================
   HISTORY CARD
========================================================= */

.history-card {

    margin-bottom: 30px;

    padding: 22px;

    background: #ffffff;

    border: 0;

    border-radius: 18px;

    box-shadow:
        0 5px 20px rgba(0, 0, 0, .07);

}


.history-header {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 18px;

}


.history-kicker {

    margin-bottom: 5px;

    color: #2563eb;

    font-size: 12px;

    font-weight: 700;

    letter-spacing: 1px;

}


.history-title {

    margin: 0;

    color: #1f2937;

    font-size: 24px;

    font-weight: 800;

}


/* =========================================================
   TOMBOL DOWNLOAD DATA
========================================================= */

.download-data-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    flex-shrink: 0;

    padding: 9px 14px;

    border: 1px solid #2563eb;

    border-radius: 9px;

    background: #2563eb;

    color: #ffffff;

    font-size: 12px;

    font-weight: 600;

    text-decoration: none;

    transition: .2s ease;

}


.download-data-button:hover {

    background: #1d4ed8;

    border-color: #1d4ed8;

    color: #ffffff;

    transform: translateY(-1px);

    box-shadow:
        0 5px 12px rgba(37, 99, 235, .20);

}


/* =========================================================
   TABEL
========================================================= */

.history-table {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
}

.history-table thead th {
    padding: 13px 14px;
    color: #64748b;
    font-size: 13px;
    font-weight: 700;
    background: #f8fafc;
    text-align: left;
    white-space: nowrap;
    border-bottom: 1px solid #e5e7eb;
}

.history-table tbody td {
    padding: 13px 14px;
    color: #374151;
    font-size: 13px;
    line-height: 1.5;
    vertical-align: middle;
    border-bottom: 1px solid #eef2f7;
}

.history-table tbody tr:last-child td {
    border-bottom: 0;
}

.history-table .year-cell {
    color: #1f2937;
    font-size: 13px;
    font-weight: 700;
}

.history-table .value-cell {
    color: #1f2937;
    font-size: 13px;
    font-weight: 700;
}

.history-table .unit-cell {
    color: #6b7280;
    font-size: 13px;
}

.table-change {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 8px;
    border-radius: 7px;
    font-size: 11px;
    font-weight: 700;
    line-height: 1.2;
}

.table-up {
    background: #ecfdf5;
    color: #059669;
}

.table-down {
    background: #fef2f2;
    color: #dc2626;
}

.table-same {
    background: #f1f5f9;
    color: #64748b;
}

.first-data {
    color: #9ca3af;
    font-size: 12px;
}


.history-table th {

    padding: 13px 16px;

    background: #f9fafb;

    border-bottom: 1px solid #e5e7eb;

    color: #6b7280;

    font-size: 10px;

    font-weight: 700;

    text-align: left;

    text-transform: uppercase;

}


.history-table td {

    padding: 13px 16px;

    border-bottom: 1px solid #f3f4f6;

    color: #6b7280;

    font-size: 11px;

}


.history-table tbody tr:last-child td {

    border-bottom: 0;

}


.history-table tbody tr:hover td {

    background: #fafafa;

}


.year-cell {

    color: #2563eb !important;

    font-weight: 800;

}


.value-cell {

    color: #1f2937 !important;

    font-size: 12px !important;

    font-weight: 800;

}


/* =========================================================
   PERUBAHAN TABEL
========================================================= */

.table-change {

    display: inline-flex;

    align-items: center;

    gap: 4px;

    padding: 5px 7px;

    border-radius: 7px;

    font-size: 9px;

    font-weight: 700;

}


.table-up {

    background: #ecfdf5;

    color: #059669;

}


.table-down {

    background: #fef2f2;

    color: #dc2626;

}


.table-same {

    background: #f1f5f9;

    color: #64748b;

}


.first-data {

    color: #9ca3af;

}


/* =========================================================
   SUMBER DATA
========================================================= */

.source-card {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 18px 20px;

    margin-bottom: 20px;

    background: #f9fafb;

    border: 1px solid #e5e7eb;

    border-radius: 16px;

}


.source-icon {

    display: flex;

    align-items: center;

    justify-content: center;

    width: 44px;

    height: 44px;

    flex-shrink: 0;

    border-radius: 12px;

    background: #eff6ff;

    color: #2563eb;

}


.source-label {

    color: #6b7280;

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

}


.source-name {

    margin-top: 3px;

    color: #1f2937;

    font-size: 13px;

    font-weight: 700;

}


.source-note {

    display: flex;

    align-items: flex-start;

    gap: 6px;

    margin-top: 6px;

    color: #b45309;

    font-size: 11px;

    line-height: 1.5;

}


/* =========================================================
   TOMBOL BANDINGKAN INDIKATOR
========================================================= */

.compare-indicator-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 20px 22px;
    margin-bottom: 30px;
    background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%);
    border: 1px solid #dbeafe;
    border-radius: 16px;
}

.compare-indicator-content {
    min-width: 0;
}

.compare-indicator-kicker {
    margin-bottom: 5px;
    color: #2563eb;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.compare-indicator-title {
    margin: 0 0 5px;
    color: #1f2937;
    font-size: 18px;
    font-weight: 800;
}

.compare-indicator-text {
    margin: 0;
    color: #6b7280;
    font-size: 13px;
    line-height: 1.5;
}

.compare-indicator-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    flex-shrink: 0;
    padding: 10px 15px;
    border: 1px solid #2563eb;
    border-radius: 10px;
    background: #2563eb;
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    transition: .2s ease;
}

.compare-indicator-button:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 5px 12px rgba(37, 99, 235, .20);
}

@media (max-width: 768px) {
    .compare-indicator-card {
        align-items: stretch;
        flex-direction: column;
    }

    .compare-indicator-button {
        width: 100%;
    }
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .indicator-header {

        align-items: flex-start;

        flex-direction: column;

    }


    .chart-header {

        align-items: flex-start;

        flex-direction: column;

    }


    .chart-actions {

        width: 100%;

        justify-content: space-between;

    }


    .back-button {

        align-self: flex-start;

    }

}


@media (max-width: 768px) {

    .summary-grid {

        grid-template-columns: 1fr;

    }


    .summary-card {

        min-height: 130px;

    }


    .chart-filter {

        align-items: stretch;

        flex-direction: column;

    }


    .filter-select {

        width: 100%;

    }


    .filter-arrow {

        display: none;

    }


    .reset-button {

        width: 100%;

        margin-left: 0;

    }


    .chart-wrapper {

        height: 320px;

    }

}


@media (max-width: 576px) {

    .history-table thead th,
    .history-table tbody td {
        padding: 11px 10px;
        font-size: 12px;
    }

    .history-table .year-cell,
    .history-table .value-cell,
    .history-table .unit-cell {
        font-size: 12px;
    }

    .table-change {
        font-size: 10px;
    }



    .indicator-title {

        font-size: 32px;

    }


    .indicator-description {

        font-size: 13px;

    }


    .summary-value {

        font-size: 32px;

    }


    .chart-card,
    .history-card {

        padding: 18px;

    }


    .chart-title {

        font-size: 19px;

    }


    .chart-actions {

        align-items: stretch;

        flex-direction: column;

    }


    .chart-toggle {

        width: 100%;

    }


    .chart-toggle button {

        flex: 1;

    }


    .download-chart-button {

        width: 100%;

    }


    .source-card {

        align-items: flex-start;

    }


    .chart-wrapper {

        height: 280px;

    }


    .history-header {

        flex-direction: column;

        align-items: stretch;

        gap: 12px;

    }


    .download-data-button {

        width: 100%;

    }

}


<style>
.monthly-excel-table {
    min-width: 760px;
}

.monthly-excel-table .category-name-header,
.monthly-excel-table .category-name-cell {
    min-width: 150px;
    width: 150px;
    text-align: left;
}

.monthly-excel-table .period-column,
.monthly-excel-table .period-value-cell {
    min-width: 120px;
    width: 120px;
    text-align: center;
}

.monthly-excel-table .category-name-cell {
    font-weight: 700;
}

@media (max-width: 768px) {
    .monthly-excel-table {
        min-width: 680px;
    }

    .monthly-excel-table .category-name-header,
    .monthly-excel-table .category-name-cell {
        min-width: 120px;
        width: 120px;
    }

    .monthly-excel-table .period-column,
    .monthly-excel-table .period-value-cell {
        min-width: 100px;
        width: 100px;
    }
}

/* =========================================================
   TOGGLE PERBANDINGAN Y TO Y / M TO M
========================================================= */
.comparison-toggle-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
}

.comparison-label {
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
}

.comparison-toggle {
    display: inline-flex;
    padding: 3px;
    border: 1px solid #dbe3ef;
    border-radius: 10px;
    background: #f8fafc;
}

.comparison-toggle button {
    border: 0;
    border-radius: 7px;
    background: transparent;
    color: #64748b;
    padding: 7px 13px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: .2s ease;
}

.comparison-toggle button.active {
    background: #ffffff;
    color: #2563eb;
    box-shadow: 0 2px 8px rgba(15, 23, 42, .08);
}

@media (max-width: 768px) {
    .comparison-toggle-wrap {
        width: 100%;
        justify-content: space-between;
    }

    .comparison-toggle {
        flex: 1;
    }

    .comparison-toggle button {
        flex: 1;
    }
}

.monthly-comparison-table {
    min-width: 760px;
}

.monthly-comparison-table th,
.monthly-comparison-table td {
    text-align: center;
}

.monthly-comparison-table th:first-child,
.monthly-comparison-table td:first-child {
    text-align: left;
    min-width: 150px;
}

.monthly-comparison-table .comparison-change {
    display: inline-block;
    margin-top: 4px;
    padding: 2px 6px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 700;
}

.monthly-comparison-table .comparison-change.up {
    color: #059669;
    background: #ecfdf5;
}

.monthly-comparison-table .comparison-change.down {
    color: #dc2626;
    background: #fef2f2;
}

.monthly-comparison-table .comparison-change.same {
    color: #64748b;
    background: #f1f5f9;
}
</style>
<style>
/* Perapihan tabel bulanan: judul tahun sejajar dengan nilai di kolomnya */
.monthly-comparison-table thead th:not(:first-child) {
    text-align: center !important;
}

.monthly-comparison-table thead th:first-child {
    text-align: left !important;
}

.monthly-comparison-table tbody td:not(:first-child) {
    text-align: center !important;
}
</style>


</style>



<div class="container py-4 indicator-page">


    {{-- =====================================================
         BREADCRUMB
    ====================================================== --}}

    <div class="indicator-breadcrumb">

        <small class="text-muted">

            <a
                href="{{ route('home') }}"
                class="text-decoration-none text-muted"
            >
                Beranda
            </a>

            <span class="mx-2">/</span>

            <a
                href="{{ route('kelompok.index') }}"
                class="text-decoration-none text-muted"
            >
                Data Strategis
            </a>

            <span class="mx-2">/</span>

            <a
                href="{{ route(
                    'kelompok.show',
                    $indikator->kelompok->slug
                ) }}"
                class="text-decoration-none text-muted"
            >
                {{ $indikator->kelompok->nama_kelompok }}
            </a>

            <span class="mx-2">/</span>

            <strong>
                {{ $indikator->nama_indikator }}
            </strong>

        </small>

    </div>



    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="indicator-header">

        <div class="indicator-header-content">

            <span class="indicator-badge">

                {{ $indikator->kelompok->nama_kelompok }}

            </span>


            <h1 class="indicator-title">

                {{ $indikator->nama_indikator }}

            </h1>


            <p class="indicator-description">

                {{
                    $indikator->deskripsi
                    ??
                    $indikator->nama_indikator .
                    ' Kabupaten Wonosobo.'
                }}

            </p>

        </div>


        <a
            href="{{ route(
                'kelompok.show',
                $indikator->kelompok->slug
            ) }}"
            class="back-button"
        >

            <i class="bi bi-arrow-left"></i>

            Kembali ke Kelompok

        </a>

    </div>



    {{-- =====================================================
         SUMMARY
    ====================================================== --}}

    <div class="summary-grid">


        {{-- NILAI TERBARU --}}

        <div class="summary-card summary-primary">

            <div class="summary-label">

                <i class="bi bi-bar-chart-line-fill"></i>

                Nilai Terbaru

            </div>


            <div class="summary-value">

                @if ($nilaiTerbaru !== null)

                    {{ number_format($nilaiTerbaru, $jumlahDesimal, ',', '.') }}

                @else

                    —

                @endif

            </div>


            <div class="summary-meta">

                {{ $indikator->satuan }}

                <span class="mx-1">•</span>

                {{ $formatPeriode($periodeTerbaru) }}

            </div>

        </div>



        {{-- PERUBAHAN --}}

        <div class="summary-card">

            <div class="summary-label">

                <i class="bi bi-graph-up-arrow"></i>

                Perubahan

            </div>


            <div class="
                summary-value
                change-{{ $arahPerubahan }}
            ">

                @if ($nilaiPerubahan !== null)

                @elseif ($multiKategoriTerbaru)

                    —

                    {{ $nilaiPerubahan > 0 ? '+' : '' }}{{ number_format($nilaiPerubahan, $jumlahDesimal, ',', '.') }}

                @else

                    —

                @endif

            </div>


            <div class="summary-meta">

                @if ($multiKategoriTerbaru && !$isPdrb)

                    {{ $multiKategoriLabel }} pada {{ $formatPeriode($periodeTerbaru) }}

                @elseif ($arahPerubahan === 'up')

                    <span class="summary-meta-up">

                        ↑ Meningkat

                    </span>

                @elseif ($arahPerubahan === 'down')

                    <span class="summary-meta-down">

                        ↓ Menurun

                    </span>

                @else

                    Tidak berubah

                @endif


                @if ($persentasePerubahan !== null)

                    <span class="mx-1">•</span>

                    {{
                        $persentasePerubahan > 0
                            ? '+'
                            : ''
                    }}

                    {{
                        number_format(
                            $persentasePerubahan,
                            2,
                            ',',
                            '.'
                        )
                    }}%

                @endif

            </div>

        </div>



        {{-- RENTANG DATA --}}

        <div class="summary-card">

            <div class="summary-label">

                <i class="bi bi-calendar3"></i>

                Rentang Data

            </div>


            <div class="summary-value">

                {{ $formatPeriode($dataUrut->first()?->periode) }}

                <span class="mx-1">—</span>

                {{ $formatPeriode($dataUrut->last()?->periode) }}

            </div>


            <div class="summary-meta">

                {{ $dataUrut->count() }}

                periode tersedia

            </div>

        </div>

    </div>



    {{-- =====================================================
         GRAFIK
    ====================================================== --}}

    <div class="chart-card">

        <div class="chart-header">

            <div>

                <div class="chart-kicker">

                    PERKEMBANGAN DATA

                </div>


                <h2 class="chart-title">

                    Perkembangan
                    {{ $indikator->nama_indikator }}

                </h2>


                <p class="chart-subtitle">

                    Gunakan filter untuk melihat perkembangan
                    indikator pada periode tertentu.

                </p>

            </div>


            {{-- =================================================
                 ACTION GRAFIK
            ================================================== --}}

            <div class="chart-actions">

                @if ($isYoyMom)
                    <div class="comparison-toggle-wrap">
                        <span class="comparison-label">Perbandingan</span>

                        <div class="comparison-toggle">
                            <button
                                type="button"
                                id="yoyChartBtn"
                                class="active"
                            >
                                Y to Y
                            </button>

                            <button
                                type="button"
                                id="momChartBtn"
                            >
                                M to M
                            </button>
                        </div>
                    </div>
                @endif


                {{-- TOGGLE GRAFIK --}}

                <div class="chart-toggle">

                    <button
                        type="button"
                        id="lineChartBtn"
                    >

                        <i class="bi bi-graph-up"></i>

                        Garis

                    </button>


                    <button
                        type="button"
                        id="barChartBtn"
                        class="active"
                    >

                        <i class="bi bi-bar-chart-fill"></i>

                        Batang

                    </button>

                </div>


                {{-- DOWNLOAD PNG --}}

                <button
                    type="button"
                    id="downloadChartPng"
                    class="download-chart-button"
                >

                    <i class="bi bi-filetype-png"></i>

                    PNG

                </button>

            </div>

        </div>



        {{-- =================================================
             FILTER TAHUN
        ================================================== --}}

        @if ($dataUrut->count() > 0)

            <div class="chart-filter">


                <div class="filter-group">

                    <label for="fromYear">

                        Dari Tahun

                    </label>


                    <select
                        id="fromYear"
                        class="filter-select"
                    >

                        @foreach ($tahunList as $tahun)

                            <option
                                value="{{ $tahun }}"
                                {{ $loop->first
                                    ? 'selected'
                                    : ''
                                }}
                            >

                                {{ $tahun }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="filter-arrow">

                    <i class="bi bi-arrow-right"></i>

                </div>


                <div class="filter-group">

                    <label for="toYear">

                        Sampai Tahun

                    </label>


                    <select
                        id="toYear"
                        class="filter-select"
                    >

                        @foreach ($tahunList as $tahun)

                            <option
                                value="{{ $tahun }}"
                                {{ $loop->last
                                    ? 'selected'
                                    : ''
                                }}
                            >

                                {{ $tahun }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <button
                    type="button"
                    id="resetFilter"
                    class="reset-button"
                >

                    <i class="bi bi-arrow-counterclockwise"></i>

                    Reset

                </button>

            </div>

        @endif



        {{-- =================================================
             CANVAS
        ================================================== --}}

        @if ($dataUrut->count() > 0)

            <div class="chart-wrapper">

                <canvas id="indicatorChart"></canvas>

            </div>

        @else

            <div class="text-center py-5 text-muted">

                <i class="bi bi-bar-chart fs-2"></i>

                <div class="mt-2">

                    Belum tersedia data
                    untuk ditampilkan.

                </div>

            </div>

        @endif

    </div>



    {{-- =====================================================
         TABEL HISTORIS
    ====================================================== --}}

    @if ($dataUrut->count() > 0)

        <div class="history-card">

            <div class="history-header">
                <div>
                    <div class="history-kicker">DATA HISTORIS</div>
                    <h2 class="history-title">
                        Tabel Data{{ $hasKategori ? ' (' . $indikator->satuan . ')' : '' }}
                    </h2>
                </div>

                <a
                    href="{{ route('indikator.download', $indikator->slug) }}"
                    class="download-data-button"
                >
                    <i class="bi bi-download"></i>
                    Unduh Data
                </a>
            </div>

            <div class="table-responsive">

                @if ($hasKategori)
                    @if ($isBulanan)
                        {{-- TABEL BULANAN:
                             baris = bulan, kolom = tahun --}}
                        @php
                            $tahunGroups = $dataUrut
                                ->groupBy(function ($item) {
                                    return $item->periode?->tahun ?? 0;
                                })
                                ->sortKeys();

                            $bulanList = collect(range(1, 12));

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
                        @endphp

                        <table class="history-table category-history-table excel-history-table monthly-excel-table">
                            <thead>
                                <tr>
                                    <th class="category-name-header">Bulan</th>

                                    @foreach ($tahunGroups as $tahun => $tahunRows)
                                        <th class="period-column" data-year="{{ $tahun }}">
                                            {{ $tahun }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody id="historyTableBody">
                                @foreach ($bulanList as $nomorBulan)
                                    <tr>
                                        <td class="category-name-cell">
                                            {{ $namaBulan[$nomorBulan] }}
                                        </td>

                                        @foreach ($tahunGroups as $tahun => $tahunRows)
                                            @php
                                                $row = $tahunRows->first(function ($item) use ($nomorBulan) {
                                                    return (int) ($item->periode?->bulan ?? 0) === $nomorBulan;
                                                });

                                                $change = null;

                                                if ($row) {
                                                    $currentKey = sprintf(
                                                        '%04d-%02d',
                                                        $row->periode?->tahun ?? 0,
                                                        $row->periode?->bulan ?? 0
                                                    );

                                                    $previousRow = $dataUrut
                                                        ->filter(function ($item) use ($row, $currentKey) {
                                                            $p = $item->periode;
                                                            $key = sprintf(
                                                                '%04d-%02d',
                                                                $p?->tahun ?? 0,
                                                                $p?->bulan ?? 0
                                                            );

                                                            return $key < $currentKey
                                                                && $item->kategori_indikator_id == $row->kategori_indikator_id;
                                                        })
                                                        ->sortByDesc(function ($item) {
                                                            $p = $item->periode;

                                                            return sprintf(
                                                                '%04d-%02d',
                                                                $p?->tahun ?? 0,
                                                                $p?->bulan ?? 0
                                                            );
                                                        })
                                                        ->first();

                                                    $change = $previousRow
                                                        ? $row->nilai - $previousRow->nilai
                                                        : null;
                                                }
                                            @endphp

                                            <td
                                                class="category-value-cell period-value-cell"
                                                data-year="{{ $tahun }}"
                                            >
                                                @if ($row)
                                                    <div class="table-main-value">
                                                        {{ number_format($row->nilai, $jumlahDesimal, ',', '.') }}
                                                    </div>

                                                    @if ($change !== null)
                                                        <span class="table-change table-change-inline {{
                                                            $change > 0
                                                                ? 'table-up'
                                                                : ($change < 0 ? 'table-down' : 'table-same')
                                                        }}">
                                                            @if ($change > 0)
                                                                <i class="bi bi-arrow-up"></i>
                                                            @elseif ($change < 0)
                                                                <i class="bi bi-arrow-down"></i>
                                                            @else
                                                                <i class="bi bi-dash"></i>
                                                            @endif

                                                            {{ $change > 0 ? '+' : '' }}{{ number_format($change, $jumlahDesimal, ',', '.') }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="first-data">—</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @else
                        {{-- TABEL TAHUNAN BERKATEGORI:
                             baris = kategori, kolom = tahun --}}
                        @php
                            $periodGroups = $dataUrut
                                ->groupBy(function ($item) {
                                    $p = $item->periode;
                                    return sprintf('%04d-%02d', $p?->tahun ?? 0, $p?->bulan ?? 0);
                                })
                                ->sortKeys();

                            $periodList = $periodGroups->map(function ($rows) {
                                return $rows->first()?->periode;
                            })->values();
                        @endphp

                        <table class="history-table category-history-table excel-history-table">
                            <thead>
                                <tr>
                                    <th class="category-name-header">
                                        @if ($isPdrb)
                                            Komponen / Tahun
                                        @else
                                            Kategori / Tahun
                                        @endif
                                    </th>

                                    @foreach ($periodList as $period)
                                        <th class="period-column" data-year="{{ $period?->tahun }}">
                                            {{ $period?->tahun ?? '-' }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody id="historyTableBody">
                                @foreach ($kategoriList as $kategori)
                                    <tr>
                                        <td class="category-name-cell">{{ $kategori['nama'] }}</td>

                                        @foreach ($periodGroups as $periodKey => $periodRows)
                                            @php
                                                $row = $periodRows->firstWhere(
                                                    'kategori_indikator_id',
                                                    $kategori['id']
                                                );

                                                $previousRow = $dataUrut
                                                    ->filter(function ($item) use ($kategori, $periodKey) {
                                                        $p = $item->periode;
                                                        $key = sprintf('%04d-%02d', $p?->tahun ?? 0, $p?->bulan ?? 0);

                                                        return $item->kategori_indikator_id == $kategori['id']
                                                            && $key < $periodKey;
                                                    })
                                                    ->sortByDesc(function ($item) {
                                                        $p = $item->periode;

                                                        return sprintf('%04d-%02d', $p?->tahun ?? 0, $p?->bulan ?? 0);
                                                    })
                                                    ->first();

                                                $change = $row && $previousRow
                                                    ? $row->nilai - $previousRow->nilai
                                                    : null;
                                            @endphp

                                            <td
                                                class="category-value-cell period-value-cell"
                                                data-year="{{ $period?->tahun ?? $periodRows->first()?->periode?->tahun }}"
                                            >
                                                @if ($row)
                                                    <div class="table-main-value">
                                                        {{ number_format($row->nilai, $jumlahDesimal, ',', '.') }}
                                                    </div>

                                                    @if ($change !== null)
                                                        <span class="table-change table-change-inline {{
                                                            $change > 0
                                                                ? 'table-up'
                                                                : ($change < 0 ? 'table-down' : 'table-same')
                                                        }}">
                                                            @if ($change > 0)
                                                                <i class="bi bi-arrow-up"></i>
                                                            @elseif ($change < 0)
                                                                <i class="bi bi-arrow-down"></i>
                                                            @else
                                                                <i class="bi bi-dash"></i>
                                                            @endif

                                                            {{ $change > 0 ? '+' : '' }}{{ number_format($change, $jumlahDesimal, ',', '.') }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="first-data">—</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                @else
                    @if ($isBulanan)
                        @php
                            $tahunGroups = $dataUrut
                                ->groupBy(fn($item) => $item->periode?->tahun ?? 0)
                                ->sortKeys();

                            $bulanList = collect(range(1, 12));

                            $namaBulan = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                                4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                                10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                            ];
                        @endphp

                        <table class="history-table category-history-table excel-history-table monthly-excel-table">
                            <thead>
                                <tr>
                                    <th class="category-name-header">Bulan</th>
                                    @foreach ($tahunGroups as $tahun => $tahunRows)
                                        <th class="period-column" data-year="{{ $tahun }}">
                                            {{ $tahun }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody id="historyTableBody">
                                @foreach ($bulanList as $nomorBulan)
                                    <tr>
                                        <td class="category-name-cell">
                                            {{ $namaBulan[$nomorBulan] }}
                                        </td>

                                        @foreach ($tahunGroups as $tahun => $tahunRows)
                                            @php
                                                $row = $tahunRows->first(function ($item) use ($nomorBulan) {
                                                    return (int) ($item->periode?->bulan ?? 0) === $nomorBulan;
                                                });

                                                $change = null;

                                                if ($row) {
                                                    $currentKey = sprintf(
                                                        '%04d-%02d',
                                                        $row->periode?->tahun ?? 0,
                                                        $row->periode?->bulan ?? 0
                                                    );

                                                    $previousRow = $dataUrut
                                                        ->filter(function ($item) use ($currentKey) {
                                                            $p = $item->periode;
                                                            $key = sprintf(
                                                                '%04d-%02d',
                                                                $p?->tahun ?? 0,
                                                                $p?->bulan ?? 0
                                                            );

                                                            return $key < $currentKey;
                                                        })
                                                        ->sortByDesc(function ($item) {
                                                            $p = $item->periode;

                                                            return sprintf(
                                                                '%04d-%02d',
                                                                $p?->tahun ?? 0,
                                                                $p?->bulan ?? 0
                                                            );
                                                        })
                                                        ->first();

                                                    $change = $previousRow
                                                        ? $row->nilai - $previousRow->nilai
                                                        : null;
                                                }
                                            @endphp

                                            <td class="category-value-cell period-value-cell" data-year="{{ $tahun }}">
                                                @if ($row)
                                                    <div class="table-main-value">
                                                        {{ number_format($row->nilai, $jumlahDesimal, ',', '.') }}
                                                    </div>

                                                    @if ($change !== null)
                                                        <span class="table-change table-change-inline {{
                                                            $change > 0
                                                                ? 'table-up'
                                                                : ($change < 0 ? 'table-down' : 'table-same')
                                                        }}">
                                                            @if ($change > 0)
                                                                <i class="bi bi-arrow-up"></i>
                                                            @elseif ($change < 0)
                                                                <i class="bi bi-arrow-down"></i>
                                                            @else
                                                                <i class="bi bi-dash"></i>
                                                            @endif
                                                            {{ $change > 0 ? '+' : '' }}{{ number_format($change, $jumlahDesimal, ',', '.') }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="first-data">—</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @else
                        {{-- TABEL INDIKATOR TANPA KATEGORI TAHUNAN --}}
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Nilai</th>
                                    <th>Perubahan</th>
                                    <th>Satuan</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody">
                                @foreach ($dataUrut as $index => $point)
                                    @php
                                        $periodePoint = $point->periode;
                                        $pointKey = sprintf('%04d-%02d', $periodePoint?->tahun ?? 0, $periodePoint?->bulan ?? 0);
                                        $previousPoint = $dataUrut
                                            ->filter(function ($item) use ($pointKey) {
                                                $p = $item->periode;
                                                $key = sprintf('%04d-%02d', $p?->tahun ?? 0, $p?->bulan ?? 0);
                                                return $key < $pointKey;
                                            })
                                            ->sortByDesc(function ($item) {
                                                $p = $item->periode;
                                                return sprintf('%04d-%02d', $p?->tahun ?? 0, $p?->bulan ?? 0);
                                            })->first();
                                        $perubahanTahun = $previousPoint ? $point->nilai - $previousPoint->nilai : null;
                                    @endphp
                                    <tr data-year="{{ $periodePoint?->tahun }}">
                                        <td class="year-cell">{{ $periodePoint?->tahun ?? '-' }}</td>
                                        <td class="value-cell">{{ number_format($point->nilai, $jumlahDesimal, ',', '.') }}</td>
                                        <td>
                                            @if ($perubahanTahun !== null)
                                                <span class="table-change {{ $perubahanTahun > 0 ? 'table-up' : ($perubahanTahun < 0 ? 'table-down' : 'table-same') }}">
                                                    @if ($perubahanTahun > 0)<i class="bi bi-arrow-up"></i>@elseif ($perubahanTahun < 0)<i class="bi bi-arrow-down"></i>@else<i class="bi bi-dash"></i>@endif
                                                    {{ $perubahanTahun > 0 ? '+' : '' }}{{ number_format($perubahanTahun, $jumlahDesimal, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="first-data">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $indikator->satuan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                @endif

            </div>
            @if ($hasKategori || $isBulanan)
                <div class="table-note">
                    <i class="bi bi-info-circle"></i>
                    <span>
                        @if ($isBulanan)
                            Setiap baris menunjukkan bulan, sedangkan setiap kolom menunjukkan tahun. Tanda di bawah nilai menunjukkan perubahan sesuai metode perbandingan yang dipilih.
                        @elseif ($isPdrb)
                            Tabel menampilkan komponen PDRB. Setiap kolom menunjukkan tahun, sedangkan tanda di bawah nilai menunjukkan perubahan dibanding periode sebelumnya pada komponen yang sama.
                        @else
                            Setiap baris menunjukkan kategori, sedangkan setiap kolom menunjukkan tahun. Tanda di bawah nilai menunjukkan perubahan dibanding periode sebelumnya pada kategori yang sama.
                        @endif
                    </span>
                </div>
            @endif

        </div>

    @endif


    {{-- =====================================================
         SUMBER DATA
    ====================================================== --}}

    <div class="source-card">

        <div class="source-icon">

            <i class="bi bi-database-fill"></i>

        </div>


        <div>

            <div class="source-label">

                Sumber Data

            </div>


            <div class="source-name">

                {{
                    $terbaru?->sumberData?->nama_sumber
                    ??
                    'BPS Kabupaten Wonosobo'
                }}

            </div>


            @if ($terbaru?->catatan)

                <div class="source-note">

                    <i class="bi bi-info-circle"></i>

                    <span>

                        {{ $terbaru->catatan }}

                    </span>

                </div>

            @endif

        </div>

    </div>


    {{-- =====================================================
         BANDINGKAN DENGAN INDIKATOR LAIN
    ====================================================== --}}

    <div class="compare-indicator-card">

        <div class="compare-indicator-content">

            <div class="compare-indicator-kicker">
                PERBANDINGAN INDIKATOR
            </div>

            <h3 class="compare-indicator-title">
                Ingin membandingkan dengan indikator lain?
            </h3>

            <p class="compare-indicator-text">
                Bandingkan indikator ini dengan indikator strategis
                Kabupaten Wonosobo lainnya dalam satu tampilan grafik.
            </p>

        </div>


        <a
            href="{{ route(
                'perbandingan.index',
                ['indikator[]' => $indikator->slug]
            ) }}"
            class="compare-indicator-button"
        >

            <i class="bi bi-bar-chart-line me-1"></i>

            Bandingkan dengan Indikator Lain

            <i class="bi bi-arrow-right"></i>

        </a>

    </div>


</div>



<style>
.category-history-table th,
.category-history-table td {
    min-width: 130px;
}

.category-history-table th:first-child,
.category-history-table td:first-child {
    min-width: 110px;
    width: 110px;
}

.category-column {
    text-align: center !important;
    white-space: nowrap;
}

.category-value-cell {
    text-align: center !important;
    vertical-align: middle !important;
}

.table-main-value {
    font-weight: 700;
    color: #111827;
    margin-bottom: 6px;
}

.table-change-inline {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    font-size: 10px !important;
    padding: 3px 7px !important;
}

.table-note {
    display: flex;
    gap: 8px;
    align-items: flex-start;
    margin-top: 14px;
    padding: 10px 12px;
    border-radius: 8px;
    background: #f8fafc;
    color: #64748b;
    font-size: 12px;
    line-height: 1.5;
}

.table-note i {
    color: #2563eb;
    margin-top: 2px;
}

@media (max-width: 768px) {
    .category-history-table th,
    .category-history-table td {
        min-width: 105px;
    }
}
</style>



<style>
.excel-history-table { min-width: 760px; }
.excel-history-table th, .excel-history-table td { white-space: nowrap; }
.excel-history-table .category-name-header, .excel-history-table .category-name-cell { min-width: 285px; width: 285px; text-align: left; white-space: normal; }
.excel-history-table .period-column, .excel-history-table .period-value-cell { min-width: 105px; width: 105px; text-align: center; }
.excel-history-table .category-name-cell { color: #1f2937; font-size: 13px; font-weight: 700; vertical-align: middle; }
.excel-history-table .category-value-cell { text-align: center !important; vertical-align: middle !important; }
.excel-history-table .table-main-value { display: inline-block; color: #1f2937; font-size: 13px; font-weight: 700; }
.excel-history-table .table-change-inline { display: flex; width: fit-content; margin: 4px auto 0; }
.excel-history-table tbody tr:hover td { background: #f8fafc; }
@media (max-width: 768px) {
    .excel-history-table { min-width: 700px; }
    .excel-history-table .category-name-header, .excel-history-table .category-name-cell { min-width: 240px; width: 240px; }
    .excel-history-table .period-column, .excel-history-table .period-value-cell { min-width: 95px; width: 95px; }
}
</style>

{{-- =========================================================
     JAVASCRIPT CHART
========================================================= --}}

@if ($dataUrut->count() > 0)

<script>
document.addEventListener('DOMContentLoaded', function () {

    const indicatorData = {!! $chartData !!};
    const indicatorName = @json($indikator->nama_indikator);
    const indicatorUnit = @json($indikator->satuan);
    const indicatorType = @json($indikator->tipe_data);
    const isMonthly = @json($isBulanan);
    const isYoyMom = @json($isYoyMom);

    const canvas = document.getElementById('indicatorChart');
    const fromYear = document.getElementById('fromYear');
    const toYear = document.getElementById('toYear');
    const resetButton = document.getElementById('resetFilter');
    const lineButton = document.getElementById('lineChartBtn');
    const barButton = document.getElementById('barChartBtn');
    const downloadPngButton = document.getElementById('downloadChartPng');
    let tableBody = document.getElementById('historyTableBody');
    const historyTable = tableBody ? tableBody.closest('table') : null;

    const yoyButton = document.getElementById('yoyChartBtn');
    const momButton = document.getElementById('momChartBtn');

    let chart = null;
    let chartType = 'bar';
    let comparisonMode = 'yoy';

    function formatNumber(value) {
        const tipe = String(indicatorType || '').toLowerCase();
        const satuan = String(indicatorUnit || '').trim().toLowerCase();

        const gunakanDesimal =
            [
                'persentase',
                'desimal',
                'angka_desimal',
                'decimal'
            ].includes(tipe)
            || ['indeks', 'rasio', 'malam', 'perjalanan'].includes(satuan);

        return new Intl.NumberFormat(
            'id-ID',
            gunakanDesimal
                ? {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
                : {
                    maximumFractionDigits: 0
                }
        ).format(value);
    }

    function getFilteredData() {
        const start = parseInt(fromYear.value);
        const end = parseInt(toYear.value);

        return indicatorData.filter(function (item) {
            return item.year >= start && item.year <= end;
        });
    }

    function getYearList(data) {
        return [...new Set(
            data
                .map(item => Number(item.year))
                .filter(year => Number.isFinite(year))
        )].sort((a, b) => a - b);
    }

    const monthNames = [
        'Januari', 'Februari', 'Maret', 'April',
        'Mei', 'Juni', 'Juli', 'Agustus',
        'September', 'Oktober', 'November', 'Desember'
    ];

    const yoyColors = [
        '#2563eb', '#16a34a', '#f59e0b',
        '#9333ea', '#dc2626', '#0891b2',
        '#ea580c', '#4f46e5'
    ];

    function getYoyDatasets(filtered) {
        const years = getYearList(filtered);

        return years.map(function (year, yearIndex) {
            const values = monthNames.map(function (_, monthIndex) {
                const row = filtered.find(function (item) {
                    return Number(item.year) === year
                        && Number(item.month) === monthIndex + 1;
                });

                return row ? Number(row.value) : null;
            });

            const color = yoyColors[
                yearIndex % yoyColors.length
            ];

            return {
                label: String(year),
                data: values,
                backgroundColor: color,
                borderColor: color,
                borderWidth: 2,
                borderRadius: chartType === 'bar' ? 4 : 0,
                tension: .3,
                fill: false,
                pointRadius: chartType === 'line' ? 3 : 0,
                pointHoverRadius: chartType === 'line' ? 6 : 0
            };
        });
    }

    function getMomData(filtered) {
        return [...filtered].sort(function (a, b) {
            return String(a.period_key).localeCompare(String(b.period_key));
        });
    }

    function getMomDataset(filtered) {
        const rows = getMomData(filtered);

        return {
            labels: rows.map(item => item.period),
            rows: rows,
            dataset: {
                label: indicatorName,
                data: rows.map(item => Number(item.value)),
                borderWidth: 3,
                borderRadius: chartType === 'bar' ? 5 : 0,
                tension: .3,
                fill: chartType === 'line',
                pointRadius: chartType === 'line' ? 3 : 0,
                pointHoverRadius: chartType === 'line' ? 6 : 0
            }
        };
    }

    function getCategoryNames(data) {
        return [...new Set(
            data
                .map(item => item.category)
                .filter(function (category) {
                    return category !== null
                        && category !== undefined
                        && String(category).trim() !== '';
                })
        )];
    }

    const categoryColors = [
        '#2563eb',
        '#16a34a',
        '#f59e0b',
        '#9333ea',
        '#dc2626',
        '#0891b2',
        '#ea580c',
        '#4f46e5'
    ];

    function getCategoryDatasets(data) {
        const categories = getCategoryNames(data);
        const years = getYearList(data);

        return categories.map(function (category, index) {
            const color = categoryColors[
                index % categoryColors.length
            ];

            return {
                label: category,
                data: years.map(function (year) {
                    const row = data.find(function (item) {
                        return Number(item.year) === Number(year)
                            && item.category === category;
                    });

                    return row ? Number(row.value) : null;
                }),
                backgroundColor: color,
                borderColor: color,
                borderWidth: 2,
                borderRadius: chartType === 'bar' ? 5 : 0,
                tension: 0.3,
                fill: false,
                pointRadius: chartType === 'line' ? 3 : 0,
                pointHoverRadius: chartType === 'line' ? 6 : 0
            };
        });
    }

    function getChartPayload(filtered) {

        const categories = getCategoryNames(filtered);

        /*
         * TPK / RLM / Inflasi:
         * Y to Y = bulan pada sumbu X, tahun sebagai dataset.
         */
        if (isYoyMom && comparisonMode === 'yoy') {
            return {
                labels: monthNames,
                datasets: getYoyDatasets(filtered)
            };
        }

        /*
         * TPK / RLM / Inflasi:
         * M to M = seluruh periode bulanan berurutan.
         */
        if (isYoyMom && comparisonMode === 'mom') {
            const result = getMomDataset(filtered);

            return {
                labels: result.labels,
                datasets: [result.dataset]
            };
        }

        /*
         * INDIKATOR BERKATEGORI TAHUNAN:
         * APS, APK, APM, HLS, PDRB ADHB, PDRB ADHK, dll.
         *
         * Setiap kategori menjadi dataset tersendiri.
         * Karena Chart.js menerima satu dataset untuk satu kategori,
         * batang akan otomatis tampil berdampingan (grouped bar)
         * untuk setiap tahun.
         */
        if (categories.length > 0) {

            const years = getYearList(filtered);

            return {
                labels: years,
                datasets: getCategoryDatasets(filtered)
            };
        }

        /*
         * INDIKATOR BIASA TANPA KATEGORI:
         * Satu seri mengikuti periode yang tersedia.
         */
        return {
            labels: filtered.map(item => item.period),
            datasets: [{
                label: indicatorName,
                data: filtered.map(item => Number(item.value)),
                borderWidth: 3,
                borderRadius: chartType === 'bar' ? 5 : 0,
                tension: 0.3,
                fill: chartType === 'line',
                pointRadius: chartType === 'line' ? 4 : 0,
                pointHoverRadius: chartType === 'line' ? 6 : 0
            }]
        };
    }


    function renderChart() {
        const filtered = getFilteredData();
        const payload = getChartPayload(filtered);

        if (chart) {
            chart.destroy();
        }

        chart = new Chart(canvas, {
            type: chartType,
            data: {
                labels: payload.labels,
                datasets: payload.datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                interaction: {
                    intersect: chartType === 'bar',
                    mode: chartType === 'bar' ? 'nearest' : 'index'
                },
                plugins: {
                    legend: {
                        display: (
                            payload.datasets.length > 1
                            || (isYoyMom && comparisonMode === 'yoy')
                        ),
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 18
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return ' ' + formatNumber(context.parsed.y)
                                    + ' ' + indicatorUnit;
                            },
                            afterLabel: function (context) {
                                if (isYoyMom && comparisonMode === 'yoy') {
                                    return 'Tahun: ' + context.dataset.label;
                                }

                                if (getCategoryNames(indicatorData).length > 0) {
                                    return 'Kategori: ' + context.dataset.label;
                                }

                                return '';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#6b7280',
                            font: { size: 11 },
                            maxRotation: isYoyMom && comparisonMode === 'mom' ? 45 : 0,
                            minRotation: isYoyMom && comparisonMode === 'mom' ? 45 : 0,
                            autoSkip: true,
                            maxTicksLimit:
                                isYoyMom && comparisonMode === 'yoy'
                                    ? 12
                                    : 24
                        }
                    },
                    y: {
                        beginAtZero: false,
                        grid: { color: 'rgba(0,0,0,.06)' },
                        ticks: {
                            color: '#6b7280',
                            font: { size: 11 },
                            callback: function (value) {
                                return formatNumber(value);
                            }
                        }
                    }
                }
            }
        });

        updateTable();
    }

    function changeBadge(change) {
        if (change === null || change === undefined || Number.isNaN(change)) {
            return '';
        }

        let cls = 'same';
        let icon = '→';

        if (change > 0) {
            cls = 'up';
            icon = '↑';
        } else if (change < 0) {
            cls = 'down';
            icon = '↓';
        }

        const sign = change > 0 ? '+' : '';

        return `
            <span class="comparison-change ${cls}">
                ${icon} ${sign}${formatNumber(change)}
            </span>
        `;
    }

    function getPreviousYearValue(data, year, month) {
        const row = data.find(function (item) {
            return Number(item.year) === Number(year) - 1
                && Number(item.month) === Number(month);
        });

        return row ? Number(row.value) : null;
    }

    function getPreviousMonthValue(data, row) {
        const currentKey = String(row.period_key);

        const previous = data
            .filter(function (item) {
                return String(item.period_key) < currentKey;
            })
            .sort(function (a, b) {
                return String(b.period_key).localeCompare(String(a.period_key));
            })[0];

        return previous ? Number(previous.value) : null;
    }

    function buildYoyTable(data) {
        if (!historyTable) return;

        const years = getYearList(data);

        historyTable.classList.add('monthly-comparison-table');

        let html = `
            <thead>
                <tr>
                    <th>Bulan</th>
                    ${years.map(year => `<th>${year}</th>`).join('')}
                </tr>
            </thead>
            <tbody id="historyTableBody">
        `;

        monthNames.forEach(function (monthName, monthIndex) {
            html += `<tr>
                <td class="category-name-cell">${monthName}</td>`;

            years.forEach(function (year) {
                const row = data.find(function (item) {
                    return Number(item.year) === year
                        && Number(item.month) === monthIndex + 1;
                });

                if (!row) {
                    html += `<td>—</td>`;
                    return;
                }

                const value = Number(row.value);
                const previousYear = getPreviousYearValue(
                    indicatorData,
                    year,
                    monthIndex + 1
                );

                const change = previousYear !== null
                    ? value - previousYear
                    : null;

                html += `
                    <td>
                        <div class="table-main-value">
                            ${formatNumber(value)}
                        </div>
                        ${changeBadge(change)}
                    </td>
                `;
            });

            html += `</tr>`;
        });

        html += `</tbody>`;
        historyTable.innerHTML = html;

        tableBody = historyTable.querySelector('#historyTableBody');
    }

    function buildMomTable(data) {
        if (!historyTable) return;

        // Format tabel M to M dibuat sama dengan Y to Y:
        // baris = bulan, kolom = tahun.
        // Yang berubah hanya nilai perubahan: dihitung terhadap bulan sebelumnya.
        const years = getYearList(data);

        historyTable.classList.add('monthly-comparison-table');

        let html = `
            <thead>
                <tr>
                    <th>Bulan</th>
                    ${years.map(year => `<th>${year}</th>`).join('')}
                </tr>
            </thead>
            <tbody id="historyTableBody">
        `;

        monthNames.forEach(function (monthName, monthIndex) {
            html += `<tr>
                <td class="category-name-cell">${monthName}</td>`;

            years.forEach(function (year) {
                const row = data.find(function (item) {
                    return Number(item.year) === year
                        && Number(item.month) === monthIndex + 1;
                });

                if (!row) {
                    html += `<td>—</td>`;
                    return;
                }

                const value = Number(row.value);

                // M to M: bandingkan dengan bulan sebelumnya.
                // Gunakan seluruh indicatorData agar Januari pada filter
                // tahun tertentu tetap dapat dibandingkan dengan Desember
                // tahun sebelumnya.
                const previous = getPreviousMonthValue(indicatorData, row);

                const change = previous !== null
                    ? value - previous
                    : null;

                html += `
                    <td>
                        <div class="table-main-value">
                            ${formatNumber(value)}
                        </div>
                        ${changeBadge(change)}
                    </td>
                `;
            });

            html += `</tr>`;
        });

        html += `</tbody>`;
        historyTable.innerHTML = html;

        tableBody = historyTable.querySelector('#historyTableBody');
    }

    function updateTable() {
        if (isYoyMom) {
            const filtered = getFilteredData();

            if (comparisonMode === 'yoy') {
                buildYoyTable(filtered);
            } else {
                buildMomTable(filtered);
            }

            return;
        }

        if (!tableBody) return;

        const start = parseInt(fromYear.value);
        const end = parseInt(toYear.value);
        const table = tableBody.closest('table');

        if (table && table.classList.contains('excel-history-table')) {
            table.querySelectorAll('[data-year]').forEach(function (cell) {
                const year = parseInt(cell.dataset.year);
                cell.style.display =
                    (year >= start && year <= end) ? '' : 'none';
            });

            return;
        }

        tableBody.querySelectorAll('tr').forEach(function (row) {
            const year = parseInt(row.dataset.year);
            row.style.display =
                (year >= start && year <= end) ? '' : 'none';
        });
    }

    function validateFilter() {
        const start = parseInt(fromYear.value);
        const end = parseInt(toYear.value);

        if (start > end) {
            toYear.value = fromYear.value;
        }
    }

    fromYear.addEventListener('change', function () {
        validateFilter();
        renderChart();
    });

    toYear.addEventListener('change', function () {
        validateFilter();
        renderChart();
    });

    resetButton.addEventListener('click', function () {
        fromYear.selectedIndex = 0;
        toYear.selectedIndex = toYear.options.length - 1;
        renderChart();
    });

    lineButton.addEventListener('click', function () {
        chartType = 'line';
        lineButton.classList.add('active');
        barButton.classList.remove('active');
        renderChart();
    });

    barButton.addEventListener('click', function () {
        chartType = 'bar';
        barButton.classList.add('active');
        lineButton.classList.remove('active');
        renderChart();
    });

    if (isYoyMom && yoyButton && momButton) {
        yoyButton.addEventListener('click', function () {
            comparisonMode = 'yoy';

            yoyButton.classList.add('active');
            momButton.classList.remove('active');

            renderChart();
        });

        momButton.addEventListener('click', function () {
            comparisonMode = 'mom';

            momButton.classList.add('active');
            yoyButton.classList.remove('active');

            renderChart();
        });
    }

    downloadPngButton.addEventListener('click', function () {
        if (!chart) return;

        const filtered = getFilteredData();

        if (filtered.length === 0) return;

        const chartImage = new Image();

        chartImage.onload = function () {
            const exportCanvas = document.createElement('canvas');
            const ctx = exportCanvas.getContext('2d');

            exportCanvas.width = 1600;
            exportCanvas.height = 900;

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, exportCanvas.width, exportCanvas.height);

            ctx.fillStyle = '#173a6b';
            ctx.font = 'bold 32px Arial';
            ctx.fillText(indicatorName, 70, 75);

            ctx.fillStyle = '#64748b';
            ctx.font = '18px Arial';

            const comparisonLabel =
                isYoyMom
                    ? (comparisonMode === 'yoy' ? 'Y to Y' : 'M to M')
                    : '';

            ctx.fillText(
                indicatorUnit
                    + (comparisonLabel ? ' · ' + comparisonLabel : ''),
                70,
                108
            );

            ctx.fillStyle = '#94a3b8';
            ctx.font = '16px Arial';
            ctx.fillText(
                indicatorSource,
                70,
                138
            );

            ctx.drawImage(
                chartImage,
                70,
                175,
                1460,
                620
            );

            ctx.fillStyle = '#64748b';
            ctx.font = '14px Arial';
            ctx.fillText(
                'WIN – Wonosobo Indicator Navigator',
                70,
                845
            );

            const link = document.createElement('a');
            link.download =
                indicatorName
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    + '-'
                    + (comparisonLabel || 'grafik')
                    + '.png';

            link.href = exportCanvas.toDataURL('image/png');
            link.click();
        };

        chartImage.src = chart.toBase64Image();
    });

    renderChart();
});
</script>

@endif

@endsection
