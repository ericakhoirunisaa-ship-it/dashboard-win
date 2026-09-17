<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield(
            'title',
            'WIN - Wonosobo Indicator Navigator'
        )
    </title>

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/logo-win.png') }}"
    >


    {{-- =====================================================
         BOOTSTRAP
    ====================================================== --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- =====================================================
         BOOTSTRAP ICONS
    ====================================================== --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >


    {{-- =====================================================
         CHART.JS
    ====================================================== --}}

    <script
        src="https://cdn.jsdelivr.net/npm/chart.js"
    ></script>


    <style>

        /* =====================================================
           GLOBAL
        ====================================================== */

        html,
        body {
            min-height: 100%;
        }

        body {

            margin: 0;

            font-family:
                "Inter",
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background: #f8fafc;

            color: #1f2937;

            display: flex;

            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .container {
            max-width: 1140px;
        }


        /* =====================================================
           NAVBAR
        ====================================================== */

        .win-navbar {

            min-height: 72px;

            background:
                linear-gradient(
                    90deg,
                    #eff6ff 0%,
                    #dbeafe 50%,
                    #bfdbfe 100%
                );

            border-bottom:
                1px solid #bfdbfe;

            box-shadow:
                0 2px 12px
                rgba(30, 64, 175, .08);

            position: sticky;

            top: 0;

            z-index: 1030;
        }


        /* =====================================================
           BRAND
        ====================================================== */

        .win-brand {

            display: flex;

            align-items: center;

            gap: 11px;

            text-decoration: none;

            color: #1e3a8a;

            flex-shrink: 0;

            min-width: 250px;
        }

        .win-brand:hover {
            color: #1e3a8a;
        }


        /* =====================================================
           LOGO
        ====================================================== */

        .win-logo {

            width: 52px;

            height: 52px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            overflow: hidden;

            background: transparent;
        }

        .win-logo img {

            width: 100%;

            height: 100%;

            object-fit: contain;

            display: block;
        }


        /* =====================================================
           BRAND TEXT
        ====================================================== */

        .win-brand-text {

            display: flex;

            flex-direction: column;

            justify-content: center;

            line-height: 1.1;

            white-space: nowrap;

            margin: 0;
        }


        /* WIN */

        .win-brand-title {

            font-size: 21px;

            font-weight: 800;

            letter-spacing: -.3px;

            color: #1e3a8a;

            margin: 0;
        }


        /* Wonosobo Indicator Navigator */

        .win-brand-subtitle {

            margin-top: 4px;

            margin-bottom: 0;

            font-size: 11px;

            font-weight: 500;

            color: #64748b;

            letter-spacing: .1px;
        }


        /* =====================================================
           NAVIGATION
        ====================================================== */

        .win-nav {

            display: flex;

            align-items: center;

            gap: 4px;
        }


        .win-nav .nav-link {

            min-height: 42px;

            padding:
                0 13px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 10px;

            color: #334155;

            font-size: 14px;

            font-weight: 600;

            text-decoration: none;

            transition:
                background-color .2s ease,
                color .2s ease,
                transform .2s ease;
        }

        /* =====================================================
        WEBSITE BPS - EXTERNAL LINK
        ===================================================== */

        .win-bps-link {

            color: #2563eb !important;

            background: transparent !important;

            border: none !important;

            box-shadow: none !important;

        }


        .win-bps-link:hover {

            color: #1d4ed8 !important;

            background: transparent !important;

            box-shadow: none !important;

            transform: translateY(-1px);

        }


        .win-bps-link i {

            font-size: 11px;

            margin-left: 3px;

            opacity: .9;

        }


        .win-nav .nav-link:hover {

            background:
                rgba(255,255,255,.65);

            color: #1d4ed8;

            transform:
                translateY(-1px);
        }


        .win-nav .nav-link.active {

            background:
                rgba(255,255,255,.90);

            color: #1d4ed8;

            box-shadow:
                0 3px 8px
                rgba(30,64,175,.09);
        }


        /* =====================================================
           SEARCH
        ====================================================== */

        .win-search-wrapper {

            margin-left: auto;

            display: flex;

            align-items: center;
        }


        .win-search {

            width: 235px;

            height: 42px;

            background:
                rgba(255,255,255,.90);

            border:
                1px solid #bfdbfe;

            border-radius: 11px;

            display: flex;

            align-items: center;

            padding:
                0 12px;

            box-shadow:
                0 2px 6px
                rgba(30,64,175,.06);

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background-color .2s ease;
        }


        .win-search:focus-within {

            background: white;

            border-color: #60a5fa;

            box-shadow:
                0 0 0 3px
                rgba(59,130,246,.12);
        }


        .win-search i {

            color: #64748b;

            font-size: 17px;

            flex-shrink: 0;
        }


        .win-search input {

            width: 100%;

            border: none;

            outline: none;

            background: transparent;

            margin-left: 8px;

            font-size: 13px;

            color: #334155;
        }


        .win-search input::placeholder {

            color: #94a3b8;
        }


        /* =====================================================
           NAVBAR TOGGLER
        ====================================================== */

        .win-navbar .navbar-toggler {

            border:
                1px solid #93c5fd;

            border-radius: 9px;

            padding:
                7px 9px;

            background:
                rgba(255,255,255,.65);
        }


        .win-navbar .navbar-toggler:focus {

            box-shadow:
                0 0 0 3px
                rgba(59,130,246,.12);
        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .win-footer {

            margin-top: 60px;

            background: #172554;

            color: #cbd5e1;
        }


        .win-footer-main {

            padding:
                42px 0;
        }


        .win-footer-title {

            color: white;

            font-size: 15px;

            font-weight: 700;

            margin-bottom: 12px;
        }


        .win-footer p {

            margin-bottom: 7px;

            font-size: 13px;

            line-height: 1.6;

            color: #cbd5e1;
        }


        .win-footer i {

            width: 18px;

            color: #93c5fd;
        }


        .win-footer a {

            color: #cbd5e1;

            text-decoration: none;
        }


        .win-footer a:hover {

            color: white;
        }


        .win-footer-bottom {

            border-top:
                1px solid
                rgba(255,255,255,.12);

            padding:
                17px 0;

            font-size: 12px;

            color: #94a3b8;
        }

        /* =====================================================
            SEARCH AUTOCOMPLETE
            ===================================================== */

            .win-search-wrapper {
                position: relative;
            }


            .win-search-results {

                position: absolute;

                top: calc(100% + 8px);

                right: 0;

                width: 320px;

                background: white;

                border:
                    1px solid #e2e8f0;

                border-radius: 13px;

                box-shadow:
                    0 15px 35px
                    rgba(15, 23, 42, .14);

                overflow: hidden;

                display: none;

                z-index: 2000;
            }


            .win-search-results.show {

                display: block;
            }


            .win-search-result {

                display: block;

                padding:
                    11px 14px;

                text-decoration: none;

                border-bottom:
                    1px solid #f1f5f9;

                transition:
                    background-color .15s ease;
            }


            .win-search-result:last-child {

                border-bottom: none;
            }


            .win-search-result:hover {

                background: #eff6ff;
            }


            .win-search-result-name {

                color: #1e293b;

                font-size: 13px;

                font-weight: 700;

                line-height: 1.35;

                margin-bottom: 3px;
            }


            .win-search-result-meta {

                color: #64748b;

                font-size: 10px;

                line-height: 1.4;
            }


            .win-search-result-meta i {

                color: #3b82f6;

                margin-right: 3px;
            }


            .win-search-empty {

                padding:
                    15px;

                text-align: center;

                color: #64748b;

                font-size: 12px;
            }


            .win-search-loading {

                padding:
                    14px;

                text-align: center;

                color: #64748b;

                font-size: 12px;
            }


        /* =====================================================
           RESPONSIVE TABLET
        ====================================================== */

        @media (max-width: 991.98px) {

            .win-navbar {
                min-height: 68px;
            }


            .win-brand {

                min-width: auto;

                margin-right: 10px;
            }


            .win-logo {

                width: 50px;

                height: 50px;
            }


            .win-brand-title {

                font-size: 19px;
            }


            .win-brand-subtitle {

                font-size: 10px;
            }


            .win-nav {

                padding-top: 12px;

                padding-bottom: 8px;

                display: block;
            }


            .win-nav .nav-link {

                width: 100%;

                justify-content: flex-start;

                min-height: 40px;

                padding:
                    0 12px;

                margin-bottom: 3px;
            }


            .win-search-wrapper {

                margin-left: 0;

                padding-top: 5px;

                padding-bottom: 12px;

                width: 100%;
            }


            .win-search {

                width: 100%;
            }

        }


        /* =====================================================
           RESPONSIVE MOBILE
        ====================================================== */

        @media (max-width: 575.98px) {

            .win-navbar {

                min-height: 64px;
            }


            .win-brand {

                gap: 7px;
            }


            .win-logo {

                width: 46px;

                height: 46px;
            }


            .win-brand-title {

                font-size: 16px;
            }


            .win-brand-subtitle {

                font-size: 9px;
            }


            .win-footer {

                margin-top: 40px;
            }


            .win-footer-main {

                padding:
                    35px 0;
            }

        }

    </style>


    @stack('styles')

</head>


<body>


    {{-- =====================================================
         NAVBAR
    ====================================================== --}}

    <nav class="navbar navbar-expand-lg win-navbar">

        <div class="container">


            {{-- =================================================
                 BRAND
            ================================================== --}}

            <a
                href="{{ route('home') }}"
                class="win-brand"
            >


                {{-- LOGO ASLI --}}

                <div class="win-logo">

                    <img
                        src="{{ asset(
                            'images/logo-win.png'
                        ) }}"
                        alt="Logo WIN"
                    >

                </div>


                {{-- TEKS BRAND --}}

                <div class="win-brand-text">


                    <div class="win-brand-title">

                        WIN

                    </div>


                    <div class="win-brand-subtitle">

                        Wonosobo Indicator Navigator

                    </div>


                </div>


            </a>


            {{-- =================================================
                 MOBILE BUTTON
            ================================================== --}}

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#winNavbar"
                aria-controls="winNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >

                <span
                    class="navbar-toggler-icon"
                ></span>

            </button>


            {{-- =================================================
                 MENU + SEARCH
            ================================================== --}}

            <div
                class="collapse navbar-collapse"
                id="winNavbar"
            >


                {{-- MENU --}}

                <div
                    class="win-nav ms-lg-3"
                >


                    {{-- BERANDA --}}

                    <a
                        href="{{ route('home') }}"
                        class="
                            nav-link
                            {{
                                request()->routeIs(
                                    'home'
                                )
                                ? 'active'
                                : ''
                            }}
                        "
                    >

                        Beranda

                    </a>


                    {{-- DATA STRATEGIS --}}

                    <a
                        href="{{ route('kelompok.index') }}"
                        class="nav-link {{
                            request()->routeIs('kelompok.*')
                            || request()->routeIs('indikator.*')
                            || request()->routeIs('perbandingan.index')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Strategis
                    </a>


                    {{-- INFOGRAFIS --}}

                    <a
                        href="{{ route(
                            'infografis.index'
                        ) }}"
                        class="
                            nav-link
                            {{
                                request()->routeIs(
                                    'infografis.*'
                                )
                                ? 'active'
                                : ''
                            }}
                        "
                    >

                        Infografis

                    </a>


                    {{-- LAYANAN --}}

                    <a
                        href="{{ route(
                            'layanan.index'
                        ) }}"
                        class="
                            nav-link
                            {{
                                request()->routeIs(
                                    'layanan.*'
                                )
                                ? 'active'
                                : ''
                            }}
                        "
                    >

                        Layanan

                    </a>
                    
                    {{-- WEBSITE BPS --}}

                    <a
                        href="https://wonosobokab.bps.go.id/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="nav-link win-bps-link"
                    >

                        Website BPS

                        <i
                            class="
                                bi
                                bi-box-arrow-up-right
                                ms-1
                            "
                        ></i>

                    </a> 

                </div>


                {{-- =================================================
                     SEARCH
                ================================================== --}}

                <div class="win-search-wrapper">

                    <form
                        action="{{ route('kelompok.index') }}"
                        method="GET"
                        class="win-search"
                        id="winSearchForm"
                        autocomplete="off"
                    >

                        <i
                            class="
                                bi
                                bi-search
                            "
                        ></i>

                        <input
                            type="text"
                            name="q"
                            id="winSearchInput"
                            value="{{ request('q') }}"
                            placeholder="Cari indikator..."
                            aria-label="Cari indikator"
                        >

                    </form>


                    {{-- HASIL PENCARIAN --}}

                    <div
                        id="winSearchResults"
                        class="win-search-results"
                    ></div>

                </div>


            </div>


        </div>

    </nav>


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <main>

        @yield('content')

    </main>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <footer class="win-footer">


        <div class="container">


            <div class="win-footer-main">


                <div class="row g-4">


                    {{-- =================================================
                         TENTANG WIN
                    ================================================== --}}

                    <div class="col-md-5">


                        <div class="win-footer-title">

                            WIN –
                            Wonosobo Indicator Navigator

                        </div>


                        <p>

                            Dashboard indikator strategis
                            Kabupaten Wonosobo yang menyajikan
                            informasi statistik secara ringkas,
                            terpadu, dan mudah diakses.

                        </p>


                    </div>


                    {{-- =================================================
                         BPS WONOSOBO
                    ================================================== --}}

                    <div class="col-md-4">


                        <div class="win-footer-title">

                            BPS Kabupaten Wonosobo

                        </div>


                        <p>

                            <i
                                class="
                                    bi
                                    bi-geo-alt
                                "
                            ></i>

                            Jl. Mayjen Bambang Sugeng Km 2,2,
                            Wonosobo, Jawa Tengah 56316

                        </p>


                        <p>

                            <i
                                class="
                                    bi
                                    bi-telephone
                                "
                            ></i>

                            (0286) 324270

                        </p>


                        <p>

                            <i
                                class="
                                    bi
                                    bi-printer
                                "
                            ></i>

                            (0286) 3325380

                        </p>


                        <p>

                            <i
                                class="
                                    bi
                                    bi-envelope
                                "
                            ></i>

                            <a
                                href="mailto:bps3307@bps.go.id"
                            >

                                bps3307@bps.go.id

                            </a>

                        </p>


                    </div>


                    {{-- =================================================
                         JAM LAYANAN
                    ================================================== --}}

                    <div class="col-md-3">


                        <div class="win-footer-title">

                            Jam Layanan

                        </div>


                        <p>

                            Senin – Jumat

                        </p>


                        <p>

                            07.30 – 16.00 WIB

                        </p>


                        <p class="mt-3">


                            <a
                                href="https://wonosobokab.bps.go.id/"
                                target="_blank"
                                rel="noopener noreferrer"
                            >

                                <i
                                    class="
                                        bi
                                        bi-globe2
                                    "
                                ></i>

                                Website BPS Wonosobo

                            </a>


                        </p>


                    </div>


                </div>


            </div>


            {{-- =================================================
                 FOOTER BOTTOM
            ================================================== --}}

            <div class="win-footer-bottom">


                <div
                    class="
                        d-flex
                        flex-column
                        flex-md-row
                        justify-content-between
                        gap-2
                    "
                >


                    <div>

                        © {{ date('Y') }}

                        BPS Kabupaten Wonosobo

                    </div>


                    <div>

                        WIN –
                        Wonosobo Indicator Navigator

                    </div>


                </div>


            </div>


        </div>


    </footer>


    {{-- =====================================================
         BOOTSTRAP JS
    ====================================================== --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    @stack('scripts')

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const input =
                    document.getElementById(
                        'winSearchInput'
                    );

                const results =
                    document.getElementById(
                        'winSearchResults'
                    );

                const form =
                    document.getElementById(
                        'winSearchForm'
                    );


                if (
                    !input ||
                    !results
                ) {
                    return;
                }


                let searchTimer = null;


                /* =================================================
                TAMPILKAN HASIL
                ================================================== */

                function showResults(
                    data
                ) {

                    results.innerHTML = '';


                    if (
                        !data ||
                        data.length === 0
                    ) {

                        results.innerHTML = `

                            <div
                                class="win-search-empty"
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
                                'win-search-result';


                            link.innerHTML = `

                                <div
                                    class="
                                        win-search-result-name
                                    "
                                >

                                    ${escapeHtml(
                                        item.nama
                                    )}

                                </div>


                                <div
                                    class="
                                        win-search-result-meta
                                    "
                                >

                                    <i
                                        class="
                                            bi
                                            bi-folder2
                                        "
                                    ></i>

                                    ${escapeHtml(
                                        item.kelompok || '-'
                                    )}

                                    &nbsp; · &nbsp;

                                    ${escapeHtml(
                                        item.satuan || '-'
                                    )}

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
                ESCAPE HTML
                ================================================== */

                function escapeHtml(
                    text
                ) {

                    const div =
                        document.createElement(
                            'div'
                        );

                    div.textContent =
                        text ?? '';

                    return div.innerHTML;

                }


                /* =================================================
                SEARCH
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
                                    win-search-loading
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
                                                        win-search-empty
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
                ENTER
                ================================================== */

                form.addEventListener(
                    'submit',
                    function (event) {

                        const keyword =
                            input.value.trim();


                        if (
                            keyword.length === 0
                        ) {

                            event.preventDefault();

                            return;

                        }

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
                FOCUS KEMBALI
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

</body>

</html>