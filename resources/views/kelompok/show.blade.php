@extends('layouts.app')

@section('title', $kelompok->nama_kelompok . ' - Data Strategis WIN')

@section('content')

<style>
    /* =========================================================
       MASTER STYLE - DETAIL KELOMPOK
    ========================================================= */

    .group-detail-page {
        padding-top: 0;
    }

    .page-breadcrumb {
        margin-bottom: 28px;
    }

    .page-breadcrumb small {
        font-size: 13px;
    }

    .page-breadcrumb a {
        color: #0d6efd;
        font-weight: 600;
        text-decoration: none;
    }

    .page-breadcrumb a:hover {
        color: #084298;
    }

    .page-breadcrumb .separator {
        color: #9ca3af;
        margin: 0 10px;
    }

    .group-hero {
        background: linear-gradient(135deg, #b9dcff 0%, #9bcaff 100%);
        border: 1px solid #82bcf5;
        border-radius: 24px;
        padding: 42px;
        min-height: 174px;
        margin-bottom: 44px;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .group-hero::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .10);
        right: -70px;
        top: -90px;
    }

    .group-icon {
        width: 78px;
        height: 78px;
        flex-shrink: 0;
        background: rgba(255, 255, 255, .82);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d6efd;
        font-size: 32px;
        margin-right: 22px;
        position: relative;
        z-index: 1;
    }

    .group-hero-content {
        position: relative;
        z-index: 1;
    }

    .group-label {
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #49688e;
        margin-bottom: 6px;
    }

    .group-title {
        font-size: 30px;
        line-height: 1.15;
        font-weight: 800;
        color: #09275c;
        margin: 0 0 7px;
    }

    .group-description {
        font-size: 14px;
        color: #54749c;
        margin: 0;
        max-width: 720px;
    }

    .section-label {
        font-size: 14px;
        color: #183c70;
        font-weight: 500;
        margin-bottom: 4px;
    }

    .section-title {
        font-size: 32px;
        line-height: 1.2;
        font-weight: 700;
        color: #102f61;
        margin-bottom: 8px;
    }

    .section-subtitle {
        font-size: 16px;
        color: #183c70;
        margin-bottom: 22px;
    }

    .indicator-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .indicator-card {
        display: flex;
        align-items: center;
        width: 100%;
        min-height: 102px;
        background: #ffffff;
        border: 1px solid #d6e3f5;
        border-radius: 16px;
        padding: 18px;
        text-decoration: none;
        transition:
            transform .2s ease,
            box-shadow .2s ease,
            border-color .2s ease;
    }

    .indicator-card:hover {
        border-color: #a8c9ef;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(13, 110, 253, .08);
    }

    .indicator-icon {
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        background: #edf5ff;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d6efd;
        font-size: 21px;
        margin-right: 17px;
    }

    .indicator-content {
        flex: 1;
        min-width: 0;
    }

    .indicator-name {
        font-size: 15px;
        line-height: 1.3;
        font-weight: 700;
        color: #102c59;
        margin-bottom: 5px;
    }

    .indicator-description {
        font-size: 11px;
        line-height: 1.4;
        color: #7690b3;
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .indicator-meta {
        font-size: 11px;
        color: #7690b3;
    }

    .indicator-meta .dot {
        margin: 0 7px;
    }

    .indicator-value-area {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-left: 20px;
    }

    .indicator-value {
        min-width: 130px;
        text-align: right;
    }

    .indicator-value-number {
        font-size: 23px;
        line-height: 1;
        font-weight: 800;
        color: #102b59;
        margin-bottom: 5px;
    }

    .indicator-value-unit {
        font-size: 10px;
        color: #8aa0bd;
    }

    .multi-value {
        font-size: 14px;
        line-height: 1.25;
    }

    .change-badge {
        min-width: 104px;
        height: 34px;
        padding: 0 12px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .change-up {
        color: #008c68;
        background: #effaf7;
        border: 1px solid #bcecdf;
    }

    .change-down {
        color: #e34a4a;
        background: #fff2f2;
        border: 1px solid #ffcaca;
    }

    .detail-arrow {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #f1f6fd;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .empty-card {
        background: #ffffff;
        border: 1px solid #d6e3f5;
        border-radius: 16px;
        padding: 35px;
        text-align: center;
        color: #7185a3;
    }

    @media (max-width: 992px) {
        .indicator-value-area {
            gap: 9px;
            margin-left: 12px;
        }

        .indicator-value {
            min-width: 110px;
        }

        .indicator-value-number {
            font-size: 20px;
        }

        .change-badge {
            min-width: 90px;
        }
    }

    @media (max-width: 768px) {
        .group-hero {
            padding: 30px;
            min-height: auto;
        }

        .group-icon {
            width: 64px;
            height: 64px;
            font-size: 26px;
            margin-right: 16px;
        }

        .group-title {
            font-size: 26px;
        }

        .section-title {
            font-size: 28px;
        }

        .indicator-card {
            align-items: flex-start;
        }

        .indicator-value-area {
            flex-direction: column;
            align-items: flex-end;
            gap: 7px;
        }

        .indicator-value {
            min-width: auto;
        }
    }

    @media (max-width: 576px) {
        .group-hero {
            flex-direction: column;
            align-items: flex-start;
            padding: 26px;
        }

        .group-icon {
            margin-right: 0;
            margin-bottom: 16px;
        }

        .group-title {
            font-size: 24px;
        }

        .section-title {
            font-size: 25px;
        }

        .section-subtitle {
            font-size: 14px;
        }

        .indicator-card {
            padding: 14px;
        }

        .indicator-icon {
            width: 44px;
            height: 44px;
            font-size: 18px;
            margin-right: 12px;
        }

        .indicator-name {
            font-size: 13px;
        }

        .indicator-description {
            white-space: normal;
        }

        .indicator-value-area {
            display: none;
        }
    }
</style>

<div class="container py-4 group-detail-page">

    <div class="page-breadcrumb">
        <small>
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">›</span>
            <a href="{{ route('kelompok.index') }}">Data Strategis</a>
            <span class="separator">›</span>
            <span class="text-muted">
                {{ $kelompok->nama_kelompok }}
            </span>
        </small>
    </div>

    <div class="group-hero">
        <div class="group-icon">
            @php
                $groupIcons = [
                    'kependudukan' => 'bi-people-fill',
                    'kemiskinan' => 'bi-graph-down-arrow',
                    'ketenagakerjaan' => 'bi-briefcase-fill',
                    'pendidikan' => 'bi-mortarboard-fill',
                    'ekonomi' => 'bi-graph-up-arrow',
                    'pariwisata' => 'bi-image-fill',
                ];

                $groupIcon = $groupIcons[$kelompok->slug]
                    ?? 'bi-bar-chart-fill';
            @endphp

            <i class="bi {{ $groupIcon }}"></i>
        </div>

        <div class="group-hero-content">
            <div class="group-label">Data Strategis</div>

            <h1 class="group-title">
                {{ $kelompok->nama_kelompok }}
            </h1>

            <p class="group-description">
                Indikator strategis tersedia untuk bidang
                {{ strtolower($kelompok->nama_kelompok) }}.
            </p>
        </div>
    </div>

    <div>
        <div class="section-label">DAFTAR INDIKATOR</div>

        <h2 class="section-title">
            Indikator {{ $kelompok->nama_kelompok }}
        </h2>

        <p class="section-subtitle">
            Pilih indikator untuk melihat nilai, perkembangan, dan data historis.
        </p>

        <div class="indicator-list">

            @forelse ($kelompok->indikator as $indikator)

                @php
                    /*
                    |--------------------------------------------------------------------------
                    | URUTKAN BERDASARKAN PERIODE SEBENARNYA
                    |--------------------------------------------------------------------------
                    | Tahun + bulan agar data bulanan mengambil Juni 2026,
                    | bukan kembali ke Januari 2026.
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

                    /*
                    |--------------------------------------------------------------------------
                    | PERIODE TERBARU
                    |--------------------------------------------------------------------------
                    */
                    $periodeTerbaru = $data->last()?->periode;

                    /*
                    |--------------------------------------------------------------------------
                    | DATA PADA PERIODE TERBARU
                    |--------------------------------------------------------------------------
                    | Untuk indikator berkategori, terdapat beberapa baris
                    | pada periode yang sama. Jangan mengambil salah satunya
                    | secara acak.
                    */
                    $dataPeriodeTerbaru = $data->filter(function ($item) use ($periodeTerbaru) {
                        if (!$periodeTerbaru || !$item->periode) {
                            return false;
                        }

                        return $item->periode->id === $periodeTerbaru->id;
                    })->values();

                    $jumlahKategori = $dataPeriodeTerbaru
                        ->pluck('kategori_indikator_id')
                        ->filter()
                        ->unique()
                        ->count();

                    $multiKategori = $jumlahKategori > 1;

                    $isPdrb = in_array($indikator->slug, [
                        'pdrb-adhb',
                        'pdrb-adhk',
                    ], true);

                    // Untuk kartu ringkasan PDRB, gunakan nilai total
                    // "Produk Domestik Regional Bruto" pada periode terbaru.
                    $nilaiTotalPdrb = null;

                    $perubahanTotalPdrb = null;

                    if ($isPdrb) {
                        $totalPdrb = $dataPeriodeTerbaru->first(function ($item) {
                            return strtolower(trim($item->kategori?->nama_kategori ?? '')) ===
                                'produk domestik regional bruto';
                        });

                        $nilaiTotalPdrb = $totalPdrb?->nilai;

                        $currentKey = sprintf(
                            '%04d-%02d',
                            $periodeTerbaru?->tahun ?? 0,
                            $periodeTerbaru?->bulan ?? 0
                        );

                        $totalPdrbSebelumnya = $data
                            ->filter(function ($item) use ($currentKey) {
                                $p = $item->periode;
                                $key = sprintf(
                                    '%04d-%02d',
                                    $p?->tahun ?? 0,
                                    $p?->bulan ?? 0
                                );

                                return $key < $currentKey
                                    && strtolower(trim($item->kategori?->nama_kategori ?? '')) ===
                                        'produk domestik regional bruto';
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

                        $perubahanTotalPdrb = ($totalPdrb && $totalPdrbSebelumnya)
                            ? $totalPdrb->nilai - $totalPdrbSebelumnya->nilai
                            : null;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | PERUBAHAN
                    |--------------------------------------------------------------------------
                    | Hanya dihitung sebagai perubahan angka apabila indikator
                    | tidak memiliki beberapa kategori pada periode yang sama.
                    */
                    $terbaru = $multiKategori
                        ? null
                        : $dataPeriodeTerbaru->first();

                    $dataSebelumnya = null;

                    if ($terbaru) {
                        $dataSebelumnya = $data
                            ->filter(function ($item) use ($terbaru) {
                                $periode = $item->periode;
                                $periodeTerbaru = $terbaru->periode;

                                if (!$periode || !$periodeTerbaru) {
                                    return false;
                                }

                                return sprintf(
                                    '%04d-%02d',
                                    $periode->tahun ?? 0,
                                    $periode->bulan ?? 0
                                ) <
                                sprintf(
                                    '%04d-%02d',
                                    $periodeTerbaru->tahun ?? 0,
                                    $periodeTerbaru->bulan ?? 0
                                );
                            })
                            ->sortByDesc(function ($item) {
                                $periode = $item->periode;

                                return sprintf(
                                    '%04d-%02d',
                                    $periode?->tahun ?? 0,
                                    $periode?->bulan ?? 0
                                );
                            })
                            ->first();
                    }

                    $perubahan = (
                        $terbaru &&
                        $dataSebelumnya
                    )
                        ? $terbaru->nilai - $dataSebelumnya->nilai
                        : null;

                    /*
                    |--------------------------------------------------------------------------
                    | FORMAT PERIODE
                    |--------------------------------------------------------------------------
                    */
                    $namaPeriode = null;

                    if ($periodeTerbaru) {
                        if (
                            strtolower($periodeTerbaru->frekuensi ?? '')
                            === 'bulanan'
                            && $periodeTerbaru->bulan
                        ) {
                            $bulanNama = [
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

                            $namaPeriode =
                                ($bulanNama[$periodeTerbaru->bulan] ?? '')
                                . ' '
                                . $periodeTerbaru->tahun;
                        } else {
                            $namaPeriode = $periodeTerbaru->tahun;
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | FORMAT ANGKA
                    |--------------------------------------------------------------------------
                    */
                    $tipe = strtolower(trim($indikator->tipe_data ?? ''));
                    $satuan = strtolower(trim($indikator->satuan ?? ''));

                    $desimal = (
                        in_array(
                            $tipe,
                            ['persentase', 'desimal', 'angka_desimal', 'decimal'],
                            true
                        )
                        ||
                        in_array(
                            $satuan,
                            ['indeks', 'rasio', 'malam', 'perjalanan'],
                            true
                        )
                    ) ? 2 : 0;
                @endphp

                <a
                    href="{{ route('indikator.show', $indikator->slug) }}"
                    class="indicator-card"
                >

                    <div class="indicator-icon">
                        <i class="bi bi-bar-chart-fill"></i>
                    </div>

                    <div class="indicator-content">

                        <div class="indicator-name">
                            {{ $indikator->nama_indikator }}
                        </div>

                        <div class="indicator-description">
                            {{
                                $indikator->deskripsi
                                ?? $indikator->nama_indikator
                                . ' Kabupaten Wonosobo.'
                            }}
                        </div>

                        @if ($periodeTerbaru)

                            <div class="indicator-meta">
                                {{ $indikator->satuan }}

                                <span class="dot">•</span>

                                Data {{ $namaPeriode }}

                                @if ($multiKategori && !$isPdrb)
                                    <span class="dot">•</span>
                                    {{ $jumlahKategori }} kategori
                                @endif
                            </div>

                        @endif

                    </div>

                    @if ($periodeTerbaru)

                        <div class="indicator-value-area">

                            <div class="indicator-value">

                                @if ($multiKategori)

                                    @if ($isPdrb && $nilaiTotalPdrb !== null)
                                        <div class="indicator-value-number">
                                            {{ number_format($nilaiTotalPdrb, 2, ',', '.') }}
                                        </div>

                                        <div class="indicator-value-unit">
                                            {{ $indikator->satuan }}
                                        </div>
                                    @else
                                        <div class="indicator-value-number multi-value">
                                            {{ $jumlahKategori }} kategori
                                        </div>

                                        <div class="indicator-value-unit">
                                            Data tersedia
                                        </div>
                                    @endif

                                @else

                                    <div class="indicator-value-number">

                                        @if ($terbaru)

                                            {{ number_format(
                                                $terbaru->nilai,
                                                $desimal,
                                                ',',
                                                '.'
                                            ) }}

                                        @else
                                            —
                                        @endif

                                    </div>

                                    <div class="indicator-value-unit">
                                        {{ $indikator->satuan }}
                                    </div>

                                @endif

                            </div>

                            @php
                                $perubahanTampil = $isPdrb
                                    ? $perubahanTotalPdrb
                                    : $perubahan;

                                $desimalPerubahanTampil = $isPdrb
                                    ? 2
                                    : $desimal;
                            @endphp

                            @if ($perubahanTampil !== null)

                                <div class="change-badge
                                    {{
                                        $perubahanTampil >= 0
                                            ? 'change-up'
                                            : 'change-down'
                                    }}"
                                >

                                    @if ($perubahanTampil >= 0)

                                        ↑ +
                                        {{ number_format(
                                            $perubahanTampil,
                                            $desimalPerubahanTampil,
                                            ',',
                                            '.'
                                        ) }}

                                    @else

                                        ↓
                                        {{ number_format(
                                            $perubahanTampil,
                                            $desimalPerubahanTampil,
                                            ',',
                                            '.'
                                        ) }}

                                    @endif

                                </div>

                            @endif

                            <div class="detail-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>

                        </div>

                    @endif

                </a>

            @empty

                <div class="empty-card">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum tersedia indikator pada kelompok ini.
                </div>

            @endforelse

        </div>
    </div>

</div>

@endsection
