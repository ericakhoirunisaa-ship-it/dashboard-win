@extends('layouts.app')

@section('title', 'Data Strategis - WIN')

@section('content')

<style>

    /* =====================================================
       PAGE
    ====================================================== */

    .data-page {
        padding-top: 0;
        padding-bottom: 40px;
    }


    /* =====================================================
       BREADCRUMB
    ====================================================== */

    .data-breadcrumb {
        margin-bottom: 28px;
    }

    .data-breadcrumb small {
        font-size: 13px;
        color: #64748b;
    }

    .data-breadcrumb a {
        color: #64748b;
        text-decoration: none;
    }

    .data-breadcrumb a:hover {
        color: #2563eb;
    }


    /* =====================================================
       HERO
    ====================================================== */

    .page-hero {

        background:
            linear-gradient(
                135deg,
                #0d6efd 0%,
                #2563eb 55%,
                #4f46e5 100%
            );

        border-radius: 24px;

        padding: 42px;

        color: white;

        margin-bottom: 36px;

        position: relative;

        overflow: hidden;
    }


    .page-hero::after {

        content: "";

        position: absolute;

        width: 220px;

        height: 220px;

        border-radius: 50%;

        background:
            rgba(255,255,255,.08);

        right: -60px;

        top: -70px;
    }


    .page-hero::before {

        content: "";

        position: absolute;

        width: 180px;

        height: 180px;

        border-radius: 50%;

        background:
            rgba(255,255,255,.045);

        right: 80px;

        bottom: -130px;
    }


    .page-hero-content {

        position: relative;

        z-index: 2;
    }


    .page-hero h1 {

        font-size: 42px;

        font-weight: 800;

        margin-bottom: 10px;

        letter-spacing: -.8px;
    }


    .page-hero p {

        max-width: 720px;

        margin-bottom: 0;

        opacity: .92;

        font-size: 16px;

        line-height: 1.6;
    }


    /* =====================================================
       SEARCH AREA
    ====================================================== */

    .data-search-wrapper {

        position: relative;

        margin-bottom: 42px;
    }


    .data-search-form {

        width: 100%;

        min-height: 64px;

        background: white;

        border:
            1px solid #dbe3ef;

        border-radius: 15px;

        display: flex;

        align-items: center;

        padding: 7px;

        box-shadow:
            0 5px 20px
            rgba(15, 23, 42, .06);

        transition:
            border-color .2s ease,
            box-shadow .2s ease;
    }


    .data-search-form:focus-within {

        border-color: #60a5fa;

        box-shadow:
            0 0 0 4px
            rgba(59,130,246,.08);
    }


    .data-search-icon {

        width: 48px;

        display: flex;

        align-items: center;

        justify-content: center;

        color: #2563eb;

        font-size: 22px;

        flex-shrink: 0;
    }


    .data-search-input {

        flex: 1;

        border: none;

        outline: none;

        background: transparent;

        font-size: 14px;

        color: #334155;

        min-width: 0;

        padding:
            0 10px;
    }


    .data-search-input::placeholder {

        color: #94a3b8;
    }


    .data-search-button {

        height: 50px;

        min-width: 78px;

        border: none;

        border-radius: 11px;

        background: #2563eb;

        color: white;

        font-size: 14px;

        font-weight: 700;

        padding:
            0 18px;

        transition:
            background-color .2s ease,
            transform .2s ease;
    }


    .data-search-button:hover {

        background: #1d4ed8;

        transform:
            translateY(-1px);
    }


    /* =====================================================
       AUTOCOMPLETE
    ====================================================== */

    .data-search-results {

        position: absolute;

        left: 0;

        right: 0;

        top: calc(100% + 8px);

        background: white;

        border:
            1px solid #e2e8f0;

        border-radius: 14px;

        box-shadow:
            0 15px 35px
            rgba(15,23,42,.14);

        overflow: hidden;

        display: none;

        z-index: 1000;
    }


    .data-search-results.show {

        display: block;
    }


    .data-search-item {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

        padding:
            14px 17px;

        text-decoration: none;

        border-bottom:
            1px solid #f1f5f9;

        transition:
            background-color .15s ease;
    }


    .data-search-item:last-child {

        border-bottom: none;
    }


    .data-search-item:hover {

        background: #eff6ff;
    }


    .data-search-item-main {

        min-width: 0;
    }


    .data-search-item-name {

        color: #1e293b;

        font-size: 14px;

        font-weight: 700;

        line-height: 1.4;

        margin-bottom: 4px;
    }


    .data-search-item-meta {

        color: #64748b;

        font-size: 11px;
    }


    .data-search-item-arrow {

        color: #2563eb;

        font-size: 16px;

        flex-shrink: 0;
    }


    .data-search-empty {

        padding:
            18px;

        text-align: center;

        color: #64748b;

        font-size: 13px;
    }


    /* =====================================================
       SECTION
    ====================================================== */

    .section-title {

        font-weight: 800;

        color: #1f2937;

        margin-bottom: 7px;
    }


    .section-subtitle {

        color: #6b7280;

        margin-bottom: 26px;

        font-size: 15px;
    }


    /* =====================================================
       GROUP CARDS
    ====================================================== */

    .group-card {

        position: relative;

        height: 100%;

        min-height: 190px;

        border-radius: 18px;

        padding: 25px;

        text-decoration: none;

        display: flex;

        flex-direction: column;

        justify-content: space-between;

        overflow: hidden;

        border: 1px solid transparent;

        transition:
            transform .2s ease,
            box-shadow .2s ease;
    }


    .group-card:hover {

        transform:
            translateY(-4px);

        box-shadow:
            0 12px 28px
            rgba(15,23,42,.10);
    }


    .group-card::after {

        content: "";

        position: absolute;

        width: 120px;

        height: 120px;

        border-radius: 50%;

        right: -45px;

        bottom: -55px;

        background:
            rgba(255,255,255,.30);
    }


    .group-icon {

        width: 48px;

        height: 48px;

        border-radius: 14px;

        background:
            rgba(255,255,255,.85);

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 21px;

        margin-bottom: 20px;

        position: relative;

        z-index: 2;
    }


    .group-name {

        font-size: 19px;

        font-weight: 800;

        color: #1e293b;

        margin-bottom: 5px;

        position: relative;

        z-index: 2;
    }


    .group-count {

        font-size: 13px;

        color: #475569;

        position: relative;

        z-index: 2;
    }


    .group-arrow {

        position: absolute;

        top: 25px;

        right: 25px;

        width: 38px;

        height: 38px;

        border-radius: 50%;

        background:
            rgba(255,255,255,.85);

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 16px;

        z-index: 3;
    }


    /* =====================================================
       WARNA KELOMPOK
    ====================================================== */

    .group-blue {

        background:
            linear-gradient(
                135deg,
                #dbeafe,
                #bfdbfe
            );

        border-color: #bfdbfe;
    }

    .group-blue .group-icon {
        color: #2563eb;
    }

    .group-blue .group-arrow {
        color: #2563eb;
    }


    .group-red {

        background:
            linear-gradient(
                135deg,
                #fee2e2,
                #fecaca
            );

        border-color: #fecaca;
    }

    .group-red .group-icon {
        color: #dc2626;
    }

    .group-red .group-arrow {
        color: #dc2626;
    }


    .group-orange {

        background:
            linear-gradient(
                135deg,
                #ffedd5,
                #fed7aa
            );

        border-color: #fed7aa;
    }

    .group-orange .group-icon {
        color: #ea580c;
    }

    .group-orange .group-arrow {
        color: #ea580c;
    }


    .group-green {

        background:
            linear-gradient(
                135deg,
                #d1fae5,
                #a7f3d0
            );

        border-color: #a7f3d0;
    }

    .group-green .group-icon {
        color: #059669;
    }

    .group-green .group-arrow {
        color: #059669;
    }


    .group-purple {

        background:
            linear-gradient(
                135deg,
                #ede9fe,
                #ddd6fe
            );

        border-color: #ddd6fe;
    }

    .group-purple .group-icon {
        color: #7c3aed;
    }

    .group-purple .group-arrow {
        color: #7c3aed;
    }


    .group-yellow {

        background:
            linear-gradient(
                135deg,
                #fef3c7,
                #fde68a
            );

        border-color: #fde68a;
    }

    .group-yellow .group-icon {
        color: #d97706;
    }

    .group-yellow .group-arrow {
        color: #d97706;
    }


    .group-cyan {

        background:
            linear-gradient(
                135deg,
                #cffafe,
                #a5f3fc
            );

        border-color: #a5f3fc;
    }

    .group-cyan .group-icon {
        color: #0891b2;
    }

    .group-cyan .group-arrow {
        color: #0891b2;
    }


    /* =====================================================
       SEARCH RESULT SERVER SIDE
    ====================================================== */

    .search-result-section {

        margin-top: 10px;
    }


    .search-result-heading {

        font-weight: 800;

        color: #1f2937;

        margin-bottom: 18px;
    }


    .search-result-card {

        background: white;

        border:
            1px solid #e2e8f0;

        border-radius: 14px;

        padding:
            17px 20px;

        text-decoration: none;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

        margin-bottom: 10px;

        box-shadow:
            0 3px 12px
            rgba(15,23,42,.04);

        transition:
            transform .2s ease,
            border-color .2s ease,
            box-shadow .2s ease;
    }


    .search-result-card:hover {

        transform:
            translateY(-2px);

        border-color: #93c5fd;

        box-shadow:
            0 7px 18px
            rgba(37,99,235,.08);
    }


    .search-result-name {

        color: #1e293b;

        font-size: 15px;

        font-weight: 700;

        margin-bottom: 4px;
    }


    .search-result-meta {

        color: #64748b;

        font-size: 12px;
    }


    .search-result-arrow {

        color: #2563eb;

        font-size: 18px;
    }


    /* =====================================================
       RESPONSIVE
    ====================================================== */

    @media (max-width: 768px) {

        .page-hero {

            padding: 30px;

            border-radius: 20px;
        }


        .page-hero h1 {

            font-size: 32px;
        }


        .page-hero p {

            font-size: 14px;
        }


        .data-search-form {

            min-height: 58px;
        }


        .data-search-button {

            height: 44px;

            min-width: 68px;

            padding:
                0 14px;
        }

    }


    @media (max-width: 576px) {

        .data-breadcrumb {

            margin-bottom: 20px;
        }


        .page-hero {

            padding: 25px;

            margin-bottom: 25px;
        }


        .page-hero h1 {

            font-size: 29px;
        }


        .page-hero p {

            font-size: 13px;
        }


        .data-search-form {

            padding: 6px;
        }


        .data-search-icon {

            width: 38px;

            font-size: 18px;
        }


        .data-search-input {

            font-size: 13px;

            padding:
                0 5px;
        }


        .data-search-button {

            min-width: 62px;

            font-size: 13px;

            padding:
                0 12px;
        }


        .group-card {

            min-height: 170px;
        }


        .section-subtitle {

            font-size: 14px;
        }

    }

</style>


<div class="container py-4 data-page">


    {{-- =====================================================
         BREADCRUMB
    ====================================================== --}}

    <div class="data-breadcrumb">

        <small class="text-muted">

            <a
                href="{{ route('home') }}"
                class="text-decoration-none text-muted"
            >

                Beranda

            </a>

            <span class="mx-2">/</span>

            <strong>Data Strategis</strong>

        </small>

    </div>


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div class="page-hero">

        <div class="page-hero-content">

            <h1>

                Data Strategis

            </h1>

            <p>

                Jelajahi indikator strategis Kabupaten
                Wonosobo berdasarkan bidang pembangunan.

            </p>

        </div>

    </div>


    {{-- =====================================================
         SEARCH
         TIDAK ADA LAGI JUDUL YANG MENGULANG HERO
    ====================================================== --}}

    <div class="data-search-wrapper">


        <form
            action="{{ route('kelompok.index') }}"
            method="GET"
            class="data-search-form"
            id="dataSearchForm"
            autocomplete="off"
        >


            <div class="data-search-icon">

                <i class="bi bi-search"></i>

            </div>


            <input
                type="text"
                name="q"
                id="dataSearchInput"
                class="data-search-input"
                value="{{ $query ?? request('q') }}"
                placeholder="Cari indikator strategis..."
                aria-label="Cari indikator strategis"
            >


            <button
                type="submit"
                class="data-search-button"
            >

                Cari

            </button>


        </form>


        {{-- AUTOCOMPLETE --}}

        <div
            id="dataSearchResults"
            class="data-search-results"
        ></div>


    </div>


    {{-- =====================================================
         HASIL PENCARIAN SERVER
    ====================================================== --}}

    @if(!empty($query))

        @php

            $hasilPencarian = collect();

            foreach ($kelompok as $group) {

                foreach ($group->indikator as $item) {

                    $hasilPencarian->push([
                        'indikator' => $item,
                        'kelompok' => $group
                    ]);

                }

            }

        @endphp


        <div class="search-result-section mb-5">


            <h3 class="search-result-heading">

                Hasil Pencarian
                <span
                    class="text-primary"
                >
                    "{{ $query }}"
                </span>

            </h3>


            @if($hasilPencarian->count() > 0)


                @foreach($hasilPencarian as $hasil)

                    @php

                        $indikator =
                            $hasil['indikator'];

                        $group =
                            $hasil['kelompok'];

                    @endphp


                    <a
                        href="{{ route(
                            'indikator.show',
                            $indikator->slug
                        ) }}"
                        class="search-result-card"
                    >


                        <div>


                            <div
                                class="
                                    search-result-name
                                "
                            >

                                {{ $indikator->nama_indikator }}

                            </div>


                            <div
                                class="
                                    search-result-meta
                                "
                            >

                                {{ $group->nama_kelompok }}

                                &nbsp; · &nbsp;

                                {{ $indikator->satuan }}

                            </div>


                        </div>


                        <div
                            class="
                                search-result-arrow
                            "
                        >

                            <i
                                class="
                                    bi
                                    bi-arrow-right
                                "
                            ></i>

                        </div>


                    </a>


                @endforeach


            @else


                <div
                    class="
                        alert
                        alert-light
                        border
                        rounded-4
                    "
                >

                    <i
                        class="
                            bi
                            bi-search
                            me-2
                        "
                    ></i>

                    Indikator dengan kata
                    <strong>
                        "{{ $query }}"
                    </strong>
                    tidak ditemukan.

                </div>


            @endif


        </div>


    @else


        {{-- =================================================
             KELOMPOK INDIKATOR
        ================================================== --}}

        <div class="mb-4">


            <h2 class="section-title">

                Berbagai Kelompok Indikator

            </h2>


            <p class="section-subtitle">

                Pilih kelompok untuk melihat indikator
                strategis yang tersedia.

            </p>


        </div>


        <div class="row g-4">


            @php

                $groupStyles = [

                    'kependudukan' => [
                        'class' => 'group-blue',
                        'icon' => 'bi-people'
                    ],

                    'kemiskinan' => [
                        'class' => 'group-red',
                        'icon' => 'bi-graph-down-arrow'
                    ],

                    'ketenagakerjaan' => [
                        'class' => 'group-orange',
                        'icon' => 'bi-briefcase'
                    ],

                    'pembangunan-manusia' => [
                        'class' => 'group-green',
                        'icon' => 'bi-person-badge'
                    ],

                    'ekonomi' => [
                        'class' => 'group-purple',
                        'icon' => 'bi-bar-chart-line'
                    ],

                    'pariwisata' => [
                        'class' => 'group-yellow',
                        'icon' => 'bi-building'
                    ],

                    'pendidikan' => [
                        'class' => 'group-cyan',
                        'icon' => 'bi-mortarboard'
                    ],

                ];

            @endphp


            @foreach($kelompok as $group)

                @php

                    $style =
                        $groupStyles[
                            $group->slug
                        ]
                        ??
                        [
                            'class' => 'group-blue',
                            'icon' => 'bi-bar-chart'
                        ];

                @endphp


                <div class="col-md-6 col-lg-4">


                    <a
                        href="{{ route(
                            'kelompok.show',
                            $group->slug
                        ) }}"
                        class="
                            group-card
                            {{ $style['class'] }}
                        "
                    >


                        <div>


                            <div
                                class="group-icon"
                            >

                                <i
                                    class="
                                        bi
                                        {{ $style['icon'] }}
                                    "
                                ></i>

                            </div>


                            <div class="group-name">

                                {{ $group->nama_kelompok }}

                            </div>


                            <div class="group-count">

                                {{ $group->indikator_count }}
                                indikator strategis

                            </div>


                        </div>


                        <div class="group-arrow">

                            <i
                                class="
                                    bi
                                    bi-arrow-up-right
                                "
                            ></i>

                        </div>


                    </a>


                </div>


            @endforeach


        </div>


    @endif


</div>


{{-- =========================================================
     JAVASCRIPT SEARCH
========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const input =
            document.getElementById(
                'dataSearchInput'
            );


        const results =
            document.getElementById(
                'dataSearchResults'
            );


        const form =
            document.getElementById(
                'dataSearchForm'
            );


        if (
            !input ||
            !results
        ) {

            return;

        }


        let searchTimer = null;


        /* =================================================
           ESCAPE HTML
        ================================================== */

        function escapeHtml(text) {

            const div =
                document.createElement(
                    'div'
                );

            div.textContent =
                text ?? '';

            return div.innerHTML;

        }


        /* =================================================
           TAMPILKAN HASIL
        ================================================== */

        function showResults(data) {


            results.innerHTML = '';


            if (
                !data ||
                data.length === 0
            ) {


                results.innerHTML = `

                    <div
                        class="data-search-empty"
                    >

                        <i
                            class="
                                bi
                                bi-search
                                me-1
                            "
                        ></i>

                        Indikator tidak ditemukan.

                    </div>

                `;


                results.classList.add(
                    'show'
                );


                return;

            }


            data.forEach(
                function (item) {


                    const link =
                        document.createElement(
                            'a'
                        );


                    link.href =
                        item.url;


                    link.className =
                        'data-search-item';


                    link.innerHTML = `

                        <div
                            class="
                                data-search-item-main
                            "
                        >

                            <div
                                class="
                                    data-search-item-name
                                "
                            >

                                ${escapeHtml(
                                    item.nama
                                )}

                            </div>


                            <div
                                class="
                                    data-search-item-meta
                                "
                            >

                                ${escapeHtml(
                                    item.kelompok || '-'
                                )}

                                &nbsp; · &nbsp;

                                ${escapeHtml(
                                    item.satuan || '-'
                                )}

                            </div>

                        </div>


                        <div
                            class="
                                data-search-item-arrow
                            "
                        >

                            <i
                                class="
                                    bi
                                    bi-arrow-right
                                "
                            ></i>

                        </div>

                    `;


                    results.appendChild(
                        link
                    );

                }
            );


            results.classList.add(
                'show'
            );

        }


        /* =================================================
           KETIKA MENGETIK
        ================================================== */

        input.addEventListener(
            'input',
            function () {


                const keyword =
                    this.value.trim();


                clearTimeout(
                    searchTimer
                );


                if (
                    keyword.length < 2
                ) {


                    results.innerHTML = '';

                    results.classList.remove(
                        'show'
                    );


                    return;

                }


                results.innerHTML = `

                    <div
                        class="
                            data-search-empty
                        "
                    >

                        <span
                            class="
                                spinner-border
                                spinner-border-sm
                                me-1
                            "
                        ></span>

                        Mencari indikator...

                    </div>

                `;


                results.classList.add(
                    'show'
                );


                searchTimer =
                    setTimeout(
                        function () {


                            fetch(
                                `{{ route(
                                    'indikator.search'
                                ) }}?q=${encodeURIComponent(
                                    keyword
                                )}`
                            )


                            .then(
                                response => {

                                    if (
                                        !response.ok
                                    ) {

                                        throw new Error(
                                            'Search error'
                                        );

                                    }

                                    return response.json();

                                }
                            )


                            .then(
                                data => {

                                    showResults(
                                        data
                                    );

                                }
                            )


                            .catch(
                                error => {

                                    console.error(
                                        error
                                    );


                                    results.innerHTML = `

                                        <div
                                            class="
                                                data-search-empty
                                            "
                                        >

                                            Terjadi kesalahan
                                            saat mencari data.

                                        </div>

                                    `;

                                }
                            );


                        },
                        250
                    );

            }
        );


        /* =================================================
           SUBMIT
        ================================================== */

        form.addEventListener(
            'submit',
            function () {

                results.classList.remove(
                    'show'
                );

            }
        );


        /* =================================================
           KLIK DI LUAR SEARCH
        ================================================== */

        document.addEventListener(
            'click',
            function (event) {


                if (
                    !input.contains(
                        event.target
                    ) &&
                    !results.contains(
                        event.target
                    )
                ) {


                    results.classList.remove(
                        'show'
                    );

                }

            }
        );


        /* =================================================
           FOCUS
        ================================================== */

        input.addEventListener(
            'focus',
            function () {


                if (
                    this.value.trim().length >= 2 &&
                    results.innerHTML.trim() !== ''
                ) {


                    results.classList.add(
                        'show'
                    );

                }

            }
        );


    }
);

</script>

@endsection