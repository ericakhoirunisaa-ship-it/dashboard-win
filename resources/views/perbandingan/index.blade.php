@extends('layouts.app')

@section('content')

<style>

    /*
    |--------------------------------------------------------------------------
    | PAGE
    |--------------------------------------------------------------------------
    */

    .comparison-page {
        min-height: calc(100vh - 120px);
    }


    /*
    |--------------------------------------------------------------------------
    | HERO
    |--------------------------------------------------------------------------
    */

    .page-hero {
        background: linear-gradient(
            135deg,
            #0d6efd 0%,
            #2563eb 55%,
            #4f46e5 100%
        );

        border-radius: 24px;

        padding: 42px;

        color: white;

        margin-bottom: 30px;

        position: relative;

        overflow: hidden;
    }


    .page-hero::after {
        content: "";

        position: absolute;

        width: 220px;
        height: 220px;

        border-radius: 50%;

        background: rgba(255,255,255,.08);

        right: -60px;
        top: -70px;
    }


    .page-hero h1 {
        font-weight: 800;

        margin-bottom: 10px;

        position: relative;

        z-index: 2;
    }


    .page-hero p {
        max-width: 760px;

        margin-bottom: 0;

        opacity: .92;

        position: relative;

        z-index: 2;
    }


    /*
    |--------------------------------------------------------------------------
    | CARD
    |--------------------------------------------------------------------------
    */

    .compare-card {
        border: 0;

        border-radius: 20px;

        box-shadow:
            0 8px 30px rgba(15, 23, 42, .07);
    }


    .compare-title {
        font-weight: 800;

        color: #1f2937;
    }


    .compare-subtitle {
        color: #6b7280;
    }


    /*
    |--------------------------------------------------------------------------
    | FORM
    |--------------------------------------------------------------------------
    */

    .indicator-select {
        border-radius: 12px;

        min-height: 48px;
    }


    .btn-compare {
        border-radius: 12px;

        font-weight: 700;

        padding: 11px 22px;
    }


    /*
    |--------------------------------------------------------------------------
    | INDICATOR PICKER
    |--------------------------------------------------------------------------
    */

    .indicator-picker {
        border: 1px solid #dee2e6;

        border-radius: 14px;

        background: #ffffff;

        padding: 10px;

        max-height: 430px;

        overflow-y: auto;

        /*
        | Tidak menggunakan smooth scroll.
        | Tidak ada JavaScript scroll.
        */

        scroll-behavior: auto;
    }


    .indicator-group {
        margin-bottom: 12px;
    }


    .indicator-group:last-child {
        margin-bottom: 0;
    }


    .indicator-group-title {
        font-size: .78rem;

        font-weight: 800;

        text-transform: uppercase;

        letter-spacing: .03em;

        color: #64748b;

        padding: 8px 10px 6px;
    }


    /*
    |--------------------------------------------------------------------------
    | INDICATOR OPTION
    |--------------------------------------------------------------------------
    */

    .indicator-option {
        display: flex;

        align-items: center;

        gap: 10px;

        padding: 10px;

        border-radius: 10px;

        cursor: pointer;

        transition:
            background .15s ease;

        margin-bottom: 3px;
    }


    .indicator-option:hover {
        background: #f1f5f9;
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOM CHECKBOX
    |--------------------------------------------------------------------------
    */

    .indicator-option input {
        appearance: none;

        -webkit-appearance: none;

        width: 20px;

        height: 20px;

        min-width: 20px;

        margin: 0;

        padding: 0;

        border: 2px solid #cbd5e1;

        border-radius: 6px;

        background: #ffffff;

        cursor: pointer;

        position: relative;

        transition:
            background .15s ease,
            border-color .15s ease,
            opacity .15s ease;
    }


    .indicator-option input:hover {
        border-color: #2563eb;
    }


    .indicator-option input:checked {
        background: #2563eb;

        border-color: #2563eb;
    }


    .indicator-option input:checked::after {
        content: "";

        position: absolute;

        left: 5px;

        top: 1px;

        width: 6px;

        height: 11px;

        border: solid #ffffff;

        border-width: 0 2px 2px 0;

        transform: rotate(45deg);
    }


    .indicator-option input:disabled {
        opacity: .45;

        cursor: not-allowed;
    }


    .indicator-label {
        display: flex;

        flex-direction: column;

        line-height: 1.25;
    }


    .indicator-label strong {
        font-size: .92rem;

        color: #1f2937;
    }


    .indicator-label small {
        color: #64748b;

        margin-top: 2px;
    }


    /*
    |--------------------------------------------------------------------------
    | SELECTED INDICATOR
    |--------------------------------------------------------------------------
    */

    .selected-indicator {
        border-radius: 12px;

        border: 1px solid #e5e7eb;

        background: #f8fafc;

        padding: 12px 15px;

        margin-bottom: 8px;
    }


    .selected-indicator strong {
        color: #1f2937;
    }


    .badge-group {
        font-size: .75rem;

        background: #e0e7ff;

        color: #3730a3;

        border-radius: 20px;

        padding: 4px 9px;
    }


    /*
    |--------------------------------------------------------------------------
    | CHART
    |--------------------------------------------------------------------------
    */

    .chart-card {
        border: 0;

        border-radius: 20px;

        box-shadow:
            0 8px 30px rgba(15, 23, 42, .07);
    }


    .chart-wrapper {
        position: relative;

        height: 440px;
    }


    .chart-tools .btn {
        border-radius: 10px;

        font-weight: 600;
    }


    /*
    |--------------------------------------------------------------------------
    | EMPTY STATE
    |--------------------------------------------------------------------------
    */

    .empty-state {
        border: 2px dashed #dbe3ef;

        border-radius: 18px;

        padding: 55px 25px;

        text-align: center;

        color: #6b7280;

        background: #f8fafc;
    }


    .empty-state i {
        font-size: 42px;

        color: #94a3b8;

        margin-bottom: 12px;
    }


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    .comparison-table {
        border-radius: 15px;

        overflow: hidden;
    }


    .comparison-table th {
        background: #f8fafc;

        font-weight: 700;

        white-space: nowrap;
    }


    .comparison-table td,
    .comparison-table th {
        padding: 12px 14px;

        vertical-align: middle;
    }


    /*
    |--------------------------------------------------------------------------
    | MODE DESCRIPTION
    |--------------------------------------------------------------------------
    */

    .mode-description {
        background: #eff6ff;

        border-radius: 12px;

        padding: 12px 15px;

        color: #1e40af;

        font-size: .9rem;
    }


    /*
    |--------------------------------------------------------------------------
    | WIN WARNING MODAL
    |--------------------------------------------------------------------------
    */

    .win-modal-overlay {
        position: fixed;

        inset: 0;

        background:
            rgba(15, 23, 42, .55);

        backdrop-filter:
            blur(4px);

        -webkit-backdrop-filter:
            blur(4px);

        display: flex;

        align-items: center;

        justify-content: center;

        padding: 20px;

        z-index: 9999;

        opacity: 0;

        visibility: hidden;

        transition:
            opacity .2s ease,
            visibility .2s ease;
    }


    .win-modal-overlay.show {
        opacity: 1;

        visibility: visible;
    }


    .win-warning-modal {
        width: 100%;

        max-width: 430px;

        background: #ffffff;

        border-radius: 22px;

        padding: 28px;

        box-shadow:
            0 25px 70px
            rgba(15, 23, 42, .25);

        text-align: center;

        transform:
            translateY(15px)
            scale(.97);

        transition:
            transform .2s ease;
    }


    .win-modal-overlay.show
    .win-warning-modal {

        transform:
            translateY(0)
            scale(1);

    }


    /*
    |--------------------------------------------------------------------------
    | WARNING ICON
    |--------------------------------------------------------------------------
    */

    .win-warning-icon {
        width: 58px;

        height: 58px;

        margin: 0 auto 18px;

        border-radius: 50%;

        display: flex;

        align-items: center;

        justify-content: center;

        background: #fff7ed;

        color: #f97316;

        font-size: 27px;
    }


    /*
    |--------------------------------------------------------------------------
    | WARNING CONTENT
    |--------------------------------------------------------------------------
    */

    .win-warning-content h5 {

        margin-bottom: 8px;

        color: #1f2937;

        font-size: 1.15rem;

        font-weight: 800;
    }


    .win-warning-content p {

        margin-bottom: 22px;

        color: #64748b;

        line-height: 1.6;

        font-size: .94rem;
    }


    /*
    |--------------------------------------------------------------------------
    | WARNING BUTTON
    |--------------------------------------------------------------------------
    */

    .win-warning-button {

        width: 100%;

        border: 0;

        border-radius: 12px;

        padding: 11px 18px;

        background:
            linear-gradient(
                135deg,
                #0d6efd,
                #2563eb
            );

        color: #ffffff;

        font-weight: 700;

        cursor: pointer;

        transition:
            transform .15s ease,
            box-shadow .15s ease;
    }


    .win-warning-button:hover {

        transform:
            translateY(-1px);

        box-shadow:
            0 7px 18px
            rgba(37, 99, 235, .25);
    }


    .win-warning-button:active {

        transform:
            translateY(0);
    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 768px) {

        .page-hero {
            padding: 30px 25px;
        }


        .chart-wrapper {
            height: 350px;
        }


        .chart-tools {
            width: 100%;
        }


        .chart-tools .btn {
            margin-bottom: 5px;
        }

    }


    @media (max-width: 576px) {

        .win-warning-modal {

            padding: 24px 20px;

            border-radius: 18px;
        }

    }

</style>


<div class="comparison-page">

    <div class="container py-4">


        {{-- ========================================================= --}}
        {{-- BREADCRUMB --}}
        {{-- ========================================================= --}}

        <div class="mb-4">

            <small class="text-muted">

                <a
                    href="{{ route('home') }}"
                    class="text-decoration-none text-muted"
                >

                    Beranda

                </a>


                <span class="mx-2">
                    /
                </span>


                <a
                    href="{{ route('kelompok.index') }}"
                    class="text-decoration-none text-muted"
                >

                    Data Strategis

                </a>


                <span class="mx-2">
                    /
                </span>


                <strong>
                    Bandingkan Indikator
                </strong>

            </small>

        </div>


        {{-- ========================================================= --}}
        {{-- HERO --}}
        {{-- ========================================================= --}}

        <div class="page-hero">

            <h1>
                Bandingkan Indikator
            </h1>


            <p>

                Bandingkan perkembangan beberapa indikator strategis
                Kabupaten Wonosobo dalam satu tampilan grafik.

            </p>

        </div>


        {{-- ========================================================= --}}
        {{-- FORM PEMILIHAN --}}
        {{-- ========================================================= --}}

        <div class="card compare-card mb-4">

            <div class="card-body p-4">


                <div
                    class="d-flex
                           justify-content-between
                           align-items-center
                           flex-wrap
                           gap-2
                           mb-3"
                >

                    <div>

                        <h4 class="compare-title mb-1">

                            Pilih Indikator

                        </h4>


                        <div class="compare-subtitle">

                            Pilih 2 sampai 5 indikator untuk dibandingkan.

                        </div>

                    </div>

                </div>


                <form
                    method="GET"
                    action="{{ route('perbandingan.index') }}"
                    id="comparisonForm"
                >

                    <div class="row g-3">


                        {{-- ================================================= --}}
                        {{-- DAFTAR INDIKATOR --}}
                        {{-- ================================================= --}}

                        <div class="col-lg-7">

                            <label class="form-label fw-semibold">

                                Indikator

                            </label>


                            <div class="indicator-picker">

                                @foreach (
                                    $indikator->groupBy(function ($item) {

                                        return optional(
                                            $item->kelompok
                                        )->nama_kelompok;

                                    })
                                    as $namaKelompok => $daftarIndikator
                                )


                                    <div class="indicator-group">


                                        <div class="indicator-group-title">

                                            {{ $namaKelompok }}

                                        </div>


                                        @foreach (
                                            $daftarIndikator
                                            as $item
                                        )


                                            <label
                                                class="indicator-option"
                                            >


                                                <input
                                                    type="checkbox"
                                                    name="indikator[]"
                                                    value="{{ $item->slug }}"
                                                    class="indicator-checkbox"

                                                    @checked(
                                                        in_array(
                                                            $item->slug,
                                                            $selected
                                                        )
                                                    )
                                                >


                                                <span
                                                    class="indicator-checkmark"
                                                ></span>


                                                <span
                                                    class="indicator-label"
                                                >

                                                    <strong>

                                                        {{ $item->nama_indikator }}

                                                    </strong>


                                                    <small>

                                                        {{ $item->satuan }}

                                                    </small>

                                                </span>


                                            </label>


                                        @endforeach

                                    </div>


                                @endforeach

                            </div>


                            {{-- Counter --}}
                            <div
                                class="d-flex
                                       justify-content-between
                                       align-items-center
                                       mt-2"
                            >

                                <small class="text-muted">

                                    Pilih minimal 2 dan maksimal 5 indikator.

                                </small>


                                <small
                                    class="fw-semibold text-primary"
                                    id="selectedCount"
                                >

                                    0 indikator dipilih

                                </small>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- TAHUN --}}
                        {{-- ================================================= --}}

                        <div class="col-lg-5">


                            <div class="row g-3">


                                {{-- Tahun Mulai --}}
                                <div class="col-md-6">

                                    <label
                                        class="form-label fw-semibold"
                                    >

                                        Tahun Mulai

                                    </label>


                                    <select
                                        name="tahun_mulai"
                                        id="tahunMulai"
                                        class="form-select indicator-select"
                                    >

                                        @for (
                                            $year = 2021;
                                            $year <= 2025;
                                            $year++
                                        )

                                            <option
                                                value="{{ $year }}"

                                                @selected(
                                                    $tahunMulai == $year
                                                )
                                            >

                                                {{ $year }}

                                            </option>

                                        @endfor

                                    </select>

                                </div>


                                {{-- Tahun Akhir --}}
                                <div class="col-md-6">

                                    <label
                                        class="form-label fw-semibold"
                                    >

                                        Tahun Akhir

                                    </label>


                                    <select
                                        name="tahun_akhir"
                                        id="tahunAkhir"
                                        class="form-select indicator-select"
                                    >

                                        @for (
                                            $year = 2021;
                                            $year <= 2025;
                                            $year++
                                        )

                                            <option
                                                value="{{ $year }}"

                                                @selected(
                                                    $tahunAkhir == $year
                                                )
                                            >

                                                {{ $year }}

                                            </option>

                                        @endfor

                                    </select>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- BUTTON --}}
                            {{-- ================================================= --}}

                            <div
                                class="mt-3
                                       d-flex
                                       gap-2"
                            >


                                {{-- RESET --}}
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-compare"
                                    id="resetComparison"
                                >

                                    <i
                                        class="bi bi-arrow-counterclockwise me-2"
                                    ></i>

                                    Reset

                                </button>


                                {{-- SUBMIT --}}
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-compare flex-grow-1"
                                >

                                    <i
                                        class="bi bi-bar-chart-line me-2"
                                    ></i>

                                    Tampilkan Perbandingan

                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- HASIL PERBANDINGAN --}}
        {{-- ========================================================= --}}

        @if ($dataPerbandingan->count() > 0)


            {{-- ===================================================== --}}
            {{-- INDIKATOR YANG DIBANDINGKAN --}}
            {{-- ===================================================== --}}

            <div class="card compare-card mb-4">

                <div class="card-body p-4">


                    <h5 class="compare-title mb-3">

                        Indikator yang Dibandingkan

                    </h5>


                    <div class="row g-2">


                        @foreach (
                            $dataPerbandingan
                            as $item
                        )


                            <div class="col-md-6 col-lg-4">

                                <div class="selected-indicator">


                                    <strong>

                                        {{ $item['nama'] }}

                                    </strong>


                                    <div class="mt-1">


                                        <span class="badge-group">

                                            {{ $item['kelompok'] }}

                                        </span>


                                        <small
                                            class="text-muted ms-1"
                                        >

                                            {{ $item['satuan'] }}

                                        </small>


                                    </div>


                                </div>

                            </div>


                        @endforeach

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- GRAFIK --}}
            {{-- ===================================================== --}}

            <div class="card chart-card mb-4">

                <div class="card-body p-4">


                    <div
                        class="d-flex
                               justify-content-between
                               align-items-center
                               flex-wrap
                               gap-3
                               mb-3"
                    >


                        <div>

                            <h4 class="compare-title mb-1">

                                Grafik Perbandingan

                            </h4>


                            <div class="compare-subtitle">

                                Periode

                                {{ $tahunMulai }}

                                –

                                {{ $tahunAkhir }}

                            </div>

                        </div>


                        {{-- CHART TOOLS --}}
                        <div class="chart-tools">


                            {{-- GARIS --}}
                            <button
                                type="button"
                                class="btn btn-outline-primary me-1"
                                id="lineMode"
                            >

                                <i
                                    class="bi bi-graph-up me-1"
                                ></i>

                                Garis

                            </button>


                            {{-- BATANG --}}
                            <button
                                type="button"
                                class="btn btn-outline-primary me-1"
                                id="barMode"
                            >

                                <i
                                    class="bi bi-bar-chart me-1"
                                ></i>

                                Batang

                            </button>


                            {{-- INDEKS --}}
                            <button
                                type="button"
                                class="btn btn-outline-dark"
                                id="indexMode"
                            >

                                <i
                                    class="bi bi-100 me-1"
                                ></i>

                                Indeks

                            </button>


                            {{-- PNG --}}
                            <button
                                type="button"
                                class="btn btn-outline-success ms-1"
                                id="downloadComparison"
                            >

                                <i
                                    class="bi bi-filetype-png me-1"
                                ></i>

                                PNG

                            </button>

                        </div>

                    </div>


                    {{-- MODE DESCRIPTION --}}
                    <div
                        class="mode-description mb-3"
                        id="modeDescription"
                    >

                        <strong>
                            Mode nilai asli:
                        </strong>

                        grafik menampilkan nilai indikator
                        sesuai satuan aslinya.

                    </div>


                    {{-- CANVAS --}}
                    <div class="chart-wrapper">

                        <canvas
                            id="comparisonChart"
                        ></canvas>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- TABEL --}}
            {{-- ===================================================== --}}

            <div class="card compare-card">

                <div class="card-body p-4">


                    <div class="mb-3">


                        <h4 class="compare-title mb-1">

                            Tabel Perbandingan

                        </h4>


                        <div class="compare-subtitle">

                            Nilai indikator berdasarkan tahun.

                        </div>


                    </div>


                    <div class="table-responsive">


                        <table
                            class="table table-hover comparison-table mb-0"
                        >


                            <thead>

                                <tr>


                                    <th>

                                        Tahun

                                    </th>


                                    @foreach (
                                        $dataPerbandingan
                                        as $item
                                    )


                                        <th>

                                            {{ $item['nama'] }}


                                            <div
                                                class="small
                                                       fw-normal
                                                       text-muted"
                                            >

                                                {{ $item['satuan'] }}

                                            </div>


                                        </th>


                                    @endforeach


                                </tr>

                            </thead>


                            <tbody>


                                @foreach (
                                    $tahun
                                    as $year
                                )


                                    <tr>


                                        <td>

                                            <strong>

                                                {{ $year }}

                                            </strong>

                                        </td>


                                        @foreach (
                                            $dataPerbandingan
                                            as $item
                                        )


                                            <td>


                                                @if (
                                                    isset(
                                                        $item['nilai'][$year]
                                                    )
                                                )


                                                    {{ number_format(
                                                        $item['nilai'][$year],
                                                        2,
                                                        ',',
                                                        '.'
                                                    ) }}


                                                @else


                                                    <span
                                                        class="text-muted"
                                                    >

                                                        –

                                                    </span>


                                                @endif


                                            </td>


                                        @endforeach


                                    </tr>


                                @endforeach


                            </tbody>


                        </table>


                    </div>

                </div>

            </div>


        @else


            {{-- ===================================================== --}}
            {{-- EMPTY STATE --}}
            {{-- ===================================================== --}}

            <div class="empty-state">


                <i class="bi bi-bar-chart-line"></i>


                <h5 class="fw-bold">

                    Belum ada indikator yang dibandingkan

                </h5>


                <p class="mb-0">

                    Pilih minimal dua indikator pada bagian
                    <strong>Pilih Indikator</strong>,
                    kemudian klik
                    <strong>Tampilkan Perbandingan</strong>.

                </p>


            </div>


        @endif

    </div>

</div>


{{-- ================================================================= --}}
{{-- POPUP PERINGATAN --}}
{{-- ================================================================= --}}

<div
    class="win-modal-overlay"
    id="winWarningModal"
    aria-hidden="true"
>


    <div
        class="win-warning-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="winWarningTitle"
    >


        {{-- ICON --}}
        <div class="win-warning-icon">

            <i class="bi bi-exclamation-lg"></i>

        </div>


        {{-- CONTENT --}}
        <div class="win-warning-content">


            <h5 id="winWarningTitle">

                Pilih Indikator

            </h5>


            <p id="winWarningMessage">

                Silakan pilih minimal 2 indikator
                untuk dibandingkan.

            </p>


        </div>


        {{-- BUTTON --}}
        <button
            type="button"
            class="win-warning-button"
            id="winWarningClose"
        >

            <i class="bi bi-check2 me-1"></i>

            Mengerti

        </button>


    </div>

</div>


{{-- ================================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ================================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | CHECKBOX INDIKATOR
        |--------------------------------------------------------------------------
        */

        const indicatorCheckboxes =
            document.querySelectorAll(
                '.indicator-checkbox'
            );


        const selectedCount =
            document.getElementById(
                'selectedCount'
            );


        /*
        |--------------------------------------------------------------------------
        | UPDATE COUNTER
        |--------------------------------------------------------------------------
        */

        function updateSelectedCount() {


            const jumlah =
                document.querySelectorAll(
                    '.indicator-checkbox:checked'
                ).length;


            if (selectedCount) {


                selectedCount.textContent =
                    jumlah +
                    ' indikator dipilih';


            }


            /*
            |--------------------------------------------------------------------------
            | Maksimal 5 indikator
            |--------------------------------------------------------------------------
            */

            indicatorCheckboxes.forEach(
                function (checkbox) {


                    if (
                        jumlah >= 5 &&
                        !checkbox.checked
                    ) {


                        checkbox.disabled =
                            true;


                    } else {


                        checkbox.disabled =
                            false;


                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | EVENT CHECKBOX
        |--------------------------------------------------------------------------
        |
        | Tidak ada:
        | - window.scrollTo()
        | - scrollIntoView()
        | - focus()
        |
        | Jadi memilih checkbox tidak akan
        | menggeser halaman.
        |
        */

        indicatorCheckboxes.forEach(
            function (checkbox) {


                checkbox.addEventListener(
                    'change',
                    function () {


                        updateSelectedCount();


                    }
                );


            }
        );


        updateSelectedCount();


        /*
        |--------------------------------------------------------------------------
        | WIN WARNING MODAL
        |--------------------------------------------------------------------------
        */

        const warningModal =
            document.getElementById(
                'winWarningModal'
            );


        const warningTitle =
            document.getElementById(
                'winWarningTitle'
            );


        const warningMessage =
            document.getElementById(
                'winWarningMessage'
            );


        const warningClose =
            document.getElementById(
                'winWarningClose'
            );


        /*
        |--------------------------------------------------------------------------
        | SHOW WARNING
        |--------------------------------------------------------------------------
        */

        function showWarning(
            title,
            message
        ) {


            if (!warningModal) {

                return;

            }


            if (warningTitle) {

                warningTitle.textContent =
                    title;

            }


            if (warningMessage) {

                warningMessage.textContent =
                    message;

            }


            warningModal.classList.add(
                'show'
            );


            warningModal.setAttribute(
                'aria-hidden',
                'false'
            );


        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE WARNING
        |--------------------------------------------------------------------------
        */

        function closeWarning() {


            if (!warningModal) {

                return;

            }


            warningModal.classList.remove(
                'show'
            );


            warningModal.setAttribute(
                'aria-hidden',
                'true'
            );


        }


        /*
        |--------------------------------------------------------------------------
        | BUTTON MENGERTI
        |--------------------------------------------------------------------------
        */

        if (warningClose) {


            warningClose.addEventListener(
                'click',
                function () {

                    closeWarning();

                }
            );


        }


        /*
        |--------------------------------------------------------------------------
        | KLIK AREA LUAR POPUP
        |--------------------------------------------------------------------------
        */

        if (warningModal) {


            warningModal.addEventListener(
                'click',
                function (event) {


                    if (
                        event.target ===
                        warningModal
                    ) {


                        closeWarning();


                    }

                }
            );


        }


        /*
        |--------------------------------------------------------------------------
        | TOMBOL ESC
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            function (event) {


                if (
                    event.key === 'Escape' &&
                    warningModal &&
                    warningModal.classList.contains(
                        'show'
                    )
                ) {


                    closeWarning();


                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        |
        | Reset langsung kembali ke URL dasar:
        |
        | /perbandingan
        |
        | Tanpa parameter indikator.
        |
        | Karena itu hasil lama otomatis hilang.
        |
        */

        const resetButton =
            document.getElementById(
                'resetComparison'
            );


        if (resetButton) {


            resetButton.addEventListener(
                'click',
                function () {


                    window.location.href =
                        "{{ route('perbandingan.index') }}";


                }
            );


        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI FORM
        |--------------------------------------------------------------------------
        */

        const comparisonForm =
            document.getElementById(
                'comparisonForm'
            );


        if (comparisonForm) {


            comparisonForm.addEventListener(
                'submit',
                function (event) {


                    /*
                    |--------------------------------------------------------------------------
                    | Hitung indikator
                    |--------------------------------------------------------------------------
                    */

                    const jumlah =
                        document.querySelectorAll(
                            '.indicator-checkbox:checked'
                        ).length;


                    /*
                    |--------------------------------------------------------------------------
                    | Minimal 2 indikator
                    |--------------------------------------------------------------------------
                    */

                    if (
                        jumlah < 2
                    ) {


                        event.preventDefault();


                        showWarning(

                            'Pilih Indikator',

                            'Silakan pilih minimal 2 indikator untuk dibandingkan.'

                        );


                        return;


                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Tahun
                    |--------------------------------------------------------------------------
                    */

                    const tahunMulaiElement =
                        document.getElementById(
                            'tahunMulai'
                        );


                    const tahunAkhirElement =
                        document.getElementById(
                            'tahunAkhir'
                        );


                    const tahunMulai =
                        parseInt(
                            tahunMulaiElement.value
                        );


                    const tahunAkhir =
                        parseInt(
                            tahunAkhirElement.value
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Tahun mulai > tahun akhir
                    |--------------------------------------------------------------------------
                    */

                    if (
                        tahunMulai >
                        tahunAkhir
                    ) {


                        event.preventDefault();


                        showWarning(

                            'Periksa Periode',

                            'Tahun mulai tidak boleh lebih besar dari tahun akhir.'

                        );


                        return;


                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | GRAFIK
        |--------------------------------------------------------------------------
        */

        const comparisonCanvas =
            document.getElementById(
                'comparisonChart'
            );


        /*
        |--------------------------------------------------------------------------
        | Jika belum ada hasil,
        | jangan menjalankan Chart.js
        |--------------------------------------------------------------------------
        */

        if (!comparisonCanvas) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | DATA LARAVEL
        |--------------------------------------------------------------------------
        */

        const dataPerbandingan =
            @json($dataPerbandingan);


        const tahun =
            @json($tahun);


        /*
        |--------------------------------------------------------------------------
        | WARNA GRAFIK
        |--------------------------------------------------------------------------
        */

        const warna = [

            '#2563eb',

            '#dc2626',

            '#16a34a',

            '#9333ea',

            '#ea580c'

        ];


        /*
        |--------------------------------------------------------------------------
        | MODE
        |--------------------------------------------------------------------------
        */

        let tipeGrafik =
            'line';


        let modeIndeks =
            false;


        let comparisonChart =
            null;


        /*
        |--------------------------------------------------------------------------
        | LOAD CHART.JS
        |--------------------------------------------------------------------------
        */

        const chartScript =
            document.createElement(
                'script'
            );


        chartScript.src =
            'https://cdn.jsdelivr.net/npm/chart.js';


        chartScript.onload =
            function () {


                buatGrafik();


            };


        document.head.appendChild(
            chartScript
        );


        /*
        |--------------------------------------------------------------------------
        | BUAT DATASET
        |--------------------------------------------------------------------------
        */

        function buatDataset() {


            return dataPerbandingan.map(
                function (
                    item,
                    index
                ) {


                    const values =
                        tahun.map(
                            function (year) {


                                const value =
                                    item.nilai[year] ??
                                    null;


                                /*
                                |--------------------------------------------------------------------------
                                | MODE INDEKS
                                |--------------------------------------------------------------------------
                                */

                                if (
                                    modeIndeks &&
                                    value !== null
                                ) {


                                    const nilaiAwal =
                                        item.nilai[
                                            tahun[0]
                                        ];


                                    if (
                                        nilaiAwal !== undefined &&
                                        nilaiAwal !== 0
                                    ) {


                                        return (
                                            value /
                                            nilaiAwal
                                        ) * 100;


                                    }

                                }


                                return value;


                            }
                        );


                    return {


                        label:
                            item.nama,


                        data:
                            values,


                        borderColor:
                            warna[index],


                        backgroundColor:
                            warna[index],


                        borderWidth:
                            3,


                        tension:
                            .35,


                        pointRadius:
                            4,


                        pointHoverRadius:
                            6,


                        fill:
                            false,


                        ...(tipeGrafik === 'bar'
                            ? {

                                borderWidth:
                                    1,

                                borderRadius:
                                    6

                            }
                            : {}
                        )


                    };


                }
            );


        }


        /*
        |--------------------------------------------------------------------------
        | BUAT GRAFIK
        |--------------------------------------------------------------------------
        */

        function buatGrafik() {


            comparisonChart =
                new Chart(
                    comparisonCanvas,
                    {


                        type:
                            tipeGrafik,


                        data: {


                            labels:
                                tahun,


                            datasets:
                                buatDataset()


                        },


                        options: {


                            responsive:
                                true,


                            maintainAspectRatio:
                                false,


                            interaction: {


                                mode:
                                    'index',


                                intersect:
                                    false


                            },


                            plugins: {


                                legend: {


                                    position:
                                        'bottom'


                                },


                                tooltip: {


                                    callbacks: {


                                        label:
                                            function (
                                                context
                                            ) {


                                                const label =
                                                    context
                                                        .dataset
                                                        .label ||
                                                    '';


                                                const value =
                                                    context
                                                        .parsed
                                                        .y;


                                                /*
                                                |--------------------------------------------------------------------------
                                                | MODE INDEKS
                                                |--------------------------------------------------------------------------
                                                */

                                                if (
                                                    modeIndeks
                                                ) {


                                                    return (

                                                        label +

                                                        ': ' +

                                                        Number(
                                                            value
                                                        ).toLocaleString(
                                                            'id-ID',
                                                            {
                                                                maximumFractionDigits:
                                                                    2
                                                            }
                                                        ) +

                                                        ' indeks'

                                                    );


                                                }


                                                /*
                                                |--------------------------------------------------------------------------
                                                | NILAI ASLI
                                                |--------------------------------------------------------------------------
                                                */

                                                const item =
                                                    dataPerbandingan[
                                                        context
                                                            .datasetIndex
                                                    ];


                                                return (

                                                    label +

                                                    ': ' +

                                                    Number(
                                                        value
                                                    ).toLocaleString(
                                                        'id-ID',
                                                        {
                                                            maximumFractionDigits:
                                                                2
                                                        }
                                                    ) +

                                                    ' ' +

                                                    item.satuan

                                                );


                                            }

                                    }

                                }

                            },


                            scales: {


                                y: {


                                    beginAtZero:
                                        false,


                                    title: {


                                        display:
                                            true,


                                        text:

                                            modeIndeks

                                                ? 'Indeks (tahun awal = 100)'

                                                : 'Nilai'


                                    }

                                },


                                x: {


                                    title: {


                                        display:
                                            true,


                                        text:
                                            'Tahun'


                                    }

                                }

                            }

                        }

                    }
                );


        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE GRAFIK
        |--------------------------------------------------------------------------
        */

        function updateChart() {


            if (comparisonChart) {


                comparisonChart.destroy();


            }


            buatGrafik();


            /*
            |--------------------------------------------------------------------------
            | Update keterangan
            |--------------------------------------------------------------------------
            */

            const modeDescription =
                document.getElementById(
                    'modeDescription'
                );


            if (modeDescription) {


                if (modeIndeks) {


                    modeDescription.innerHTML = `

                        <strong>
                            Mode indeks:
                        </strong>

                        setiap indikator dinormalisasi
                        dengan nilai tahun awal sebagai 100
                        sehingga pola perubahan antarindikator
                        lebih mudah dibandingkan meskipun
                        satuannya berbeda.

                    `;


                } else {


                    modeDescription.innerHTML = `

                        <strong>
                            Mode nilai asli:
                        </strong>

                        grafik menampilkan nilai indikator
                        sesuai satuan aslinya.

                    `;


                }

            }

        }


        /*
        |--------------------------------------------------------------------------
        | MODE GARIS
        |--------------------------------------------------------------------------
        */

        const lineMode =
            document.getElementById(
                'lineMode'
            );


        if (lineMode) {


            lineMode.addEventListener(
                'click',
                function () {


                    tipeGrafik =
                        'line';


                    updateChart();


                }
            );


        }


        /*
        |--------------------------------------------------------------------------
        | MODE BATANG
        |--------------------------------------------------------------------------
        */

        const barMode =
            document.getElementById(
                'barMode'
            );


        if (barMode) {


            barMode.addEventListener(
                'click',
                function () {


                    tipeGrafik =
                        'bar';


                    updateChart();


                }
            );


        }


        /*
        |--------------------------------------------------------------------------
        | MODE INDEKS
        |--------------------------------------------------------------------------
        */

        const indexMode =
            document.getElementById(
                'indexMode'
            );


        if (indexMode) {


            indexMode.addEventListener(
                'click',
                function () {


                    modeIndeks =
                        !modeIndeks;


                    updateChart();


                }
            );


        }


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD PNG
        |--------------------------------------------------------------------------
        */

        const downloadButton =
            document.getElementById(
                'downloadComparison'
            );


        if (downloadButton) {


            downloadButton.addEventListener(
                'click',
                function () {


                    if (!comparisonChart) {

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Canvas export
                    |--------------------------------------------------------------------------
                    */

                    const exportCanvas =
                        document.createElement(
                            'canvas'
                        );


                    exportCanvas.width =
                        1600;


                    exportCanvas.height =
                        1000;


                    const exportCtx =
                        exportCanvas.getContext(
                            '2d'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Background
                    |--------------------------------------------------------------------------
                    */

                    exportCtx.fillStyle =
                        '#ffffff';


                    exportCtx.fillRect(
                        0,
                        0,
                        exportCanvas.width,
                        exportCanvas.height
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Judul
                    |--------------------------------------------------------------------------
                    */

                    exportCtx.fillStyle =
                        '#111827';


                    exportCtx.font =
                        'bold 34px Arial';


                    exportCtx.fillText(
                        'Perbandingan Indikator Strategis',
                        80,
                        70
                    );


                    exportCtx.font =
                        '22px Arial';


                    exportCtx.fillText(
                        'Kabupaten Wonosobo',
                        80,
                        110
                    );


                    exportCtx.font =
                        '20px Arial';


                    exportCtx.fillText(

                        'Periode: ' +

                        tahun[0] +

                        '–' +

                        tahun[
                            tahun.length - 1
                        ],

                        80,
                        145

                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Grafik
                    |--------------------------------------------------------------------------
                    */

                    const chartImage =
                        comparisonChart
                            .toBase64Image();


                    const image =
                        new Image();


                    image.onload =
                        function () {


                            exportCtx.drawImage(

                                image,

                                80,

                                180,

                                1440,

                                650

                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Footer PNG
                            |--------------------------------------------------------------------------
                            */

                            exportCtx.font =
                                '18px Arial';


                            exportCtx.fillStyle =
                                '#6b7280';


                            exportCtx.fillText(

                                modeIndeks

                                    ? 'Mode indeks — tahun awal = 100'

                                    : 'Mode nilai asli',

                                80,

                                885

                            );


                            exportCtx.fillText(

                                'WIN – Wonosobo Indicator Navigator',

                                80,

                                920

                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Download
                            |--------------------------------------------------------------------------
                            */

                            const link =
                                document.createElement(
                                    'a'
                                );


                            link.download =

                                'perbandingan-indikator-' +

                                tahun[0] +

                                '-' +

                                tahun[
                                    tahun.length - 1
                                ] +

                                '.png';


                            link.href =
                                exportCanvas.toDataURL(
                                    'image/png'
                                );


                            link.click();


                        };


                    image.src =
                        chartImage;


                }
            );

        }

    }
);

</script>

@endsection