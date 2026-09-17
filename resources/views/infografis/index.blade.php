@extends('layouts.app')

@section('title', 'Infografis - WIN')

@section('content')

<div class="container py-4">

    {{-- =========================================================
         BREADCRUMB
    ========================================================== --}}
    <div class="mb-4">
        <small class="text-muted">
            <a href="{{ route('home') }}"
               class="text-decoration-none text-muted">
                Beranda
            </a>

            <span class="mx-2">/</span>

            <strong>Infografis</strong>
        </small>
    </div>


    {{-- =========================================================
         HERO
    ========================================================== --}}
    <div class="page-hero">
            <h1>Infografis</h1>

            <p>
                Temukan berbagai infografis statistik Kabupaten Wonosobo
                yang disajikan secara ringkas, informatif, dan mudah dipahami.
            </p>
    </div>


    {{-- =========================================================
         JUDUL SECTION
    ========================================================== --}}
    <div class="mb-4">

        <h2 class="section-title mb-2">
            Infografis Terbaru
        </h2>

        <p class="section-subtitle mb-0">
            Informasi statistik terbaru dalam bentuk visual.
        </p>

    </div>


    {{-- =========================================================
         CARD INFOGRAFIS
    ========================================================== --}}
    <div class="row g-4">


        {{-- =====================================================
             INFOGRAFIS 1
        ====================================================== --}}
        <div class="col-md-6 col-lg-4">

            <div class="info-card">

                {{-- GAMBAR --}}
                <div class="info-image">

                    <img
                        src="{{ asset('assets/infografis/pariwisata-juli-2026.png') }}"
                        alt="Perkembangan Pariwisata Kabupaten Wonosobo Juli 2026"
                    >

                </div>


                {{-- CONTENT --}}
                <div class="info-body">

                    <div class="mb-2">

                        <span class="info-badge badge-pariwisata">
                            Pariwisata
                        </span>

                    </div>

                    <h3>
                        Perkembangan Pariwisata
                        Kabupaten Wonosobo
                    </h3>

                    <p>
                        Perkembangan indikator pariwisata Kabupaten Wonosobo
                        berdasarkan Berita Resmi Statistik.
                    </p>

                    <div class="info-meta">

                        <i class="bi bi-calendar3 me-1"></i>
                        Juli 2026

                    </div>


                    {{-- BUTTON --}}
                    <button
                        type="button"
                        class="btn btn-primary w-100 mt-3 btn-view-infografis"

                        data-bs-toggle="modal"
                        data-bs-target="#infografisModal"

                        data-title="Perkembangan Pariwisata Kabupaten Wonosobo"
                        data-category="Pariwisata"
                        data-period="Juli 2026"

                        data-image="{{ asset('assets/infografis/pariwisata-juli-2026.png') }}"
                        data-pdf="{{ asset('assets/infografis/pariwisata-juli-2026.pdf') }}"
                    >

                        <i class="bi bi-eye me-1"></i>
                        Lihat Infografis

                    </button>

                </div>

            </div>

        </div>



        {{-- =====================================================
             INFOGRAFIS 2
        ====================================================== --}}
        <div class="col-md-6 col-lg-4">

            <div class="info-card">

                {{-- GAMBAR --}}
                <div class="info-image">

                    <img
                        src="{{ asset('assets/infografis/transportasi-juli-2026.png') }}"
                        alt="Perkembangan Statistik Transportasi Kabupaten Wonosobo Juli 2026"
                    >

                </div>


                {{-- CONTENT --}}
                <div class="info-body">

                    <div class="mb-2">

                        <span class="info-badge badge-transportasi">
                            Transportasi
                        </span>

                    </div>

                    <h3>
                        Perkembangan Statistik Transportasi
                        Kabupaten Wonosobo
                    </h3>

                    <p>
                        Perkembangan statistik transportasi Kabupaten Wonosobo
                        berdasarkan Berita Resmi Statistik.
                    </p>

                    <div class="info-meta">

                        <i class="bi bi-calendar3 me-1"></i>
                        Juli 2026

                    </div>


                    {{-- BUTTON --}}
                    <button
                        type="button"
                        class="btn btn-primary w-100 mt-3 btn-view-infografis"

                        data-bs-toggle="modal"
                        data-bs-target="#infografisModal"

                        data-title="Perkembangan Statistik Transportasi Kabupaten Wonosobo"
                        data-category="Transportasi"
                        data-period="Juli 2026"

                        data-image="{{ asset('assets/infografis/transportasi-juli-2026.png') }}"
                        data-pdf="{{ asset('assets/infografis/transportasi-juli-2026.pdf') }}"
                    >

                        <i class="bi bi-eye me-1"></i>
                        Lihat Infografis

                    </button>

                </div>

            </div>

        </div>



        {{-- =====================================================
             INFOGRAFIS 3
        ====================================================== --}}
        <div class="col-md-6 col-lg-4">

            <div class="info-card">

                {{-- GAMBAR --}}
                <div class="info-image">

                    <img
                        src="{{ asset('assets/infografis/ihk-agustus-2026.png') }}"
                        alt="Perkembangan Indeks Harga Konsumen Kabupaten Wonosobo Agustus 2026"
                    >

                </div>


                {{-- CONTENT --}}
                <div class="info-body">

                    <div class="mb-2">

                        <span class="info-badge badge-inflasi">
                            Harga dan Inflasi
                        </span>

                    </div>

                    <h3>
                        Perkembangan Indeks Harga Konsumen
                        Kabupaten Wonosobo
                    </h3>

                    <p>
                        Perkembangan Indeks Harga Konsumen dan inflasi
                        Kabupaten Wonosobo.
                    </p>

                    <div class="info-meta">

                        <i class="bi bi-calendar3 me-1"></i>
                        Agustus 2026

                    </div>


                    {{-- BUTTON --}}
                    <button
                        type="button"
                        class="btn btn-primary w-100 mt-3 btn-view-infografis"

                        data-bs-toggle="modal"
                        data-bs-target="#infografisModal"

                        data-title="Perkembangan Indeks Harga Konsumen Kabupaten Wonosobo"
                        data-category="Harga dan Inflasi"
                        data-period="Agustus 2026"

                        data-image="{{ asset('assets/infografis/ihk-agustus-2026.png') }}"
                        data-pdf="{{ asset('assets/infografis/ihk-agustus-2026.pdf') }}"
                    >

                        <i class="bi bi-eye me-1"></i>
                        Lihat Infografis

                    </button>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
         INFO PUBLIKASI BPS
    ========================================================== --}}
    <div class="publication-box mt-5">

        <div class="publication-icon">

            <i class="bi bi-newspaper"></i>

        </div>

        <div class="publication-content">

            <h4>
                Publikasi Statistik BPS Kabupaten Wonosobo
            </h4>

            <p>
                Temukan publikasi, Berita Resmi Statistik, tabel statistik,
                dan berbagai informasi statistik lainnya melalui website
                resmi BPS Kabupaten Wonosobo.
            </p>

            <a
                href="https://wonosobokab.bps.go.id/id/publication"
                target="_blank"
                rel="noopener noreferrer"
                class="publication-link"
            >

                Kunjungi Publikasi BPS
                <i class="bi bi-box-arrow-up-right ms-1"></i>

            </a>

        </div>

    </div>

</div>



{{-- =============================================================
     MODAL / LIGHTBOX INFOGRAFIS
============================================================== --}}
<div
    class="modal fade"
    id="infografisModal"
    tabindex="-1"
    aria-labelledby="infografisModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content infografis-modal">


            {{-- =================================================
                 AREA GAMBAR
            ================================================== --}}
            <div class="infografis-preview">

                {{-- TOMBOL CLOSE --}}
                <button
                    type="button"
                    class="infografis-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >

                    <i class="bi bi-x-lg"></i>

                </button>


                {{-- GAMBAR INFOGRAFIS --}}
                <img
                    id="modalInfografisImage"
                    src=""
                    alt=""
                    class="infografis-preview-image"
                >

            </div>



            {{-- =================================================
                 INFORMASI & ACTION
            ================================================== --}}
            <div class="infografis-modal-info">

                <div class="row align-items-center g-3">

                    {{-- =========================================
                         INFORMASI
                    ========================================== --}}
                    <div class="col-lg-7">

                        <div class="modal-category-wrapper">

                            <span
                                id="modalInfografisCategory"
                                class="modal-category"
                            >
                                Pariwisata
                            </span>

                        </div>


                        <h2
                            id="infografisModalLabel"
                            class="modal-infografis-title"
                        >
                            Perkembangan Pariwisata
                            Kabupaten Wonosobo
                        </h2>


                        <div class="modal-infografis-period">

                            <i class="bi bi-calendar3 me-1"></i>

                            <span id="modalInfografisPeriod">
                                Juli 2026
                            </span>

                        </div>


                        {{-- PAGE INDICATOR --}}
                        <div class="modal-page-indicator">

                            <span id="modalPageNumber">
                                1
                            </span>

                            <span class="mx-1">
                                /
                            </span>

                            <span>
                                1
                            </span>

                        </div>

                    </div>



                    {{-- =========================================
                         BUTTON ACTION
                    ========================================== --}}
                    <div class="col-lg-5">

                        <div class="infografis-modal-actions">


                            {{-- DOWNLOAD GAMBAR --}}
                            <a
                                id="modalDownloadImage"
                                href="#"
                                download
                                class="modal-action-btn"
                            >

                                <i class="bi bi-image me-2"></i>

                                Unduh Gambar

                            </a>



                            {{-- DOWNLOAD PDF --}}
                            <a
                                id="modalDownloadPdf"
                                href="#"
                                download
                                class="modal-action-btn"
                            >

                                <i class="bi bi-file-earmark-pdf me-2"></i>

                                Unduh PDF

                            </a>



                            {{-- SHARE --}}
                            <button
                                type="button"
                                id="modalShareButton"
                                class="modal-action-btn"
                            >

                                <i class="bi bi-share me-2"></i>

                                Bagikan

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- =============================================================
     CSS
============================================================== --}}
<style>


/* =============================================================
   HERO
============================================================= */

.page-hero {
        background: linear-gradient(135deg, #0d6efd 0%, #2563eb 55%, #4f46e5 100%);
        border-radius: 24px;
        padding: 42px;
        color: white;
        margin-bottom: 35px;
        position: relative;
        overflow: hidden;
    }

    .page-hero::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        right: -70px;
        top: -80px;
    }

    .page-hero h1 {
        font-weight: 800;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }

    .page-hero p {
        max-width: 720px;
        margin-bottom: 0;
        opacity: .92;
        position: relative;
        z-index: 1;
    }


.hero-content {

    position: relative;

    z-index: 2;

}


.hero-badge {

    display: inline-flex;

    align-items: center;

    padding: 7px 14px;

    border-radius: 999px;

    background: rgba(255,255,255,.15);

    border: 1px solid rgba(255,255,255,.18);

    font-size: 13px;

    font-weight: 600;

    margin-bottom: 15px;

}


.page-hero h1 {

    font-weight: 800;

    margin-bottom: 10px;

}


.page-hero p {

    max-width: 720px;

    margin-bottom: 0;

    opacity: .92;

    line-height: 1.7;

}



/* =============================================================
   SECTION
============================================================= */

.section-title {

    font-weight: 800;

    color: #1f2937;

}


.section-subtitle {

    color: #6b7280;

}



/* =============================================================
   INFO CARD
============================================================= */

.info-card {

    background: white;

    border-radius: 18px;

    overflow: hidden;

    border: 1px solid #e5e7eb;

    height: 100%;

    display: flex;

    flex-direction: column;

    transition:
        transform .25s ease,
        box-shadow .25s ease;

}


.info-card:hover {

    transform: translateY(-5px);

    box-shadow:
        0 15px 35px rgba(15, 23, 42, .10);

}



/* =============================================================
   IMAGE
============================================================= */

.info-image {

    width: 100%;

    height: 360px;

    background: #f3f4f6;

    overflow: hidden;

    display: flex;

    align-items: center;

    justify-content: center;

}


.info-image img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    object-position: top center;

    transition: transform .35s ease;

}


.info-card:hover .info-image img {

    transform: scale(1.025);

}



/* =============================================================
   INFO BODY
============================================================= */

.info-body {

    padding: 22px;

    display: flex;

    flex-direction: column;

    flex: 1;

}


.info-body h3 {

    font-size: 18px;

    line-height: 1.4;

    font-weight: 750;

    color: #1f2937;

    margin-bottom: 10px;

}


.info-body p {

    color: #6b7280;

    font-size: 14px;

    line-height: 1.6;

    margin-bottom: 10px;

}


.info-meta {

    font-size: 13px;

    color: #6b7280;

}



/* =============================================================
   BADGE
============================================================= */

.info-badge {

    display: inline-flex;

    align-items: center;

    padding: 6px 11px;

    border-radius: 999px;

    font-size: 12px;

    font-weight: 700;

}


.badge-pariwisata {

    background: #fff7ed;

    color: #ea580c;

}


.badge-transportasi {

    background: #eff6ff;

    color: #2563eb;

}


.badge-inflasi {

    background: #fef2f2;

    color: #dc2626;

}



/* =============================================================
   VIEW BUTTON
============================================================= */

.btn-view-infografis {

    border-radius: 10px;

    padding: 10px 14px;

    font-weight: 600;

    border: none;

    transition:
        transform .2s ease,
        box-shadow .2s ease;

}


.btn-view-infografis:hover {

    transform: translateY(-1px);

    box-shadow:
        0 6px 15px rgba(13, 110, 253, .22);

}



/* =============================================================
   PUBLICATION BOX
============================================================= */

.publication-box {

    display: flex;

    align-items: center;

    gap: 20px;

    background: #f8fafc;

    border: 1px solid #e5e7eb;

    border-radius: 18px;

    padding: 25px;

}


.publication-icon {

    width: 55px;

    height: 55px;

    min-width: 55px;

    border-radius: 14px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #e8f1ff;

    color: #0d6efd;

    font-size: 24px;

}


.publication-content h4 {

    font-size: 18px;

    font-weight: 750;

    color: #1f2937;

    margin-bottom: 7px;

}


.publication-content p {

    color: #6b7280;

    margin-bottom: 10px;

    line-height: 1.6;

}


.publication-link {

    text-decoration: none;

    font-weight: 600;

    color: #0d6efd;

}


.publication-link:hover {

    text-decoration: underline;

}



/* =============================================================
   MODAL
============================================================= */

#infografisModal {

    padding: 0 !important;

}


#infografisModal .modal-dialog {

    max-width: 1180px;

    margin: 20px auto;

}


.infografis-modal {

    border: none;

    border-radius: 18px;

    overflow: hidden;

    background: #111827;

    box-shadow:
        0 30px 80px rgba(0,0,0,.45);

}



/* =============================================================
   IMAGE PREVIEW
============================================================= */

.infografis-preview {

    position: relative;

    background:
        #111827;

    min-height: 68vh;

    max-height: 75vh;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 30px;

    overflow: auto;

}


.infografis-preview-image {

    display: block;

    max-width: 100%;

    max-height: 68vh;

    width: auto;

    height: auto;

    object-fit: contain;

    border-radius: 4px;

    box-shadow:
        0 12px 35px rgba(0,0,0,.35);

}



/* =============================================================
   CLOSE BUTTON
============================================================= */

.infografis-close {

    position: absolute;

    top: 18px;

    right: 18px;

    width: 42px;

    height: 42px;

    border-radius: 50%;

    border: 1px solid rgba(255,255,255,.18);

    background: rgba(0,0,0,.55);

    color: white;

    display: flex;

    align-items: center;

    justify-content: center;

    cursor: pointer;

    z-index: 20;

    transition:
        background .2s ease,
        transform .2s ease;

}


.infografis-close:hover {

    background: rgba(0,0,0,.8);

    transform: scale(1.05);

}



/* =============================================================
   MODAL INFO
============================================================= */

.infografis-modal-info {

    background: white;

    padding: 25px 30px;

}


.modal-category-wrapper {

    margin-bottom: 7px;

}


.modal-category {

    display: inline-flex;

    align-items: center;

    padding: 6px 12px;

    border-radius: 999px;

    background: #eff6ff;

    color: #2563eb;

    font-size: 12px;

    font-weight: 700;

}


.modal-infografis-title {

    color: #111827;

    font-size: 21px;

    font-weight: 800;

    line-height: 1.4;

    margin-bottom: 7px;

}


.modal-infografis-period {

    color: #6b7280;

    font-size: 14px;

}


.modal-page-indicator {

    display: inline-flex;

    align-items: center;

    margin-top: 12px;

    padding: 5px 11px;

    border-radius: 999px;

    background: #f3f4f6;

    color: #374151;

    font-size: 12px;

    font-weight: 700;

}



/* =============================================================
   MODAL ACTIONS
============================================================= */

.infografis-modal-actions {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 9px;

    flex-wrap: wrap;

}


.modal-action-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 42px;

    padding: 10px 15px;

    border: none;

    border-radius: 999px;

    background: #111827;

    color: white;

    text-decoration: none;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    transition:
        background .2s ease,
        transform .2s ease;

}


.modal-action-btn:hover {

    background: #1f2937;

    color: white;

    transform: translateY(-1px);

}


.modal-action-btn:focus {

    color: white;

    outline: none;

    box-shadow:
        0 0 0 3px rgba(13,110,253,.2);

}



/* =============================================================
   MOBILE
============================================================= */

@media (max-width: 767.98px) {


    .page-hero {

        padding: 28px 24px;

        border-radius: 20px;

    }


    .page-hero h1 {

        font-size: 28px;

    }


    .info-image {

        height: 320px;

    }


    .publication-box {

        align-items: flex-start;

    }


    .infografis-preview {

        min-height: 60vh;

        max-height: 68vh;

        padding: 18px;

    }


    .infografis-preview-image {

        max-height: 60vh;

    }


    .infografis-modal-info {

        padding: 22px;

    }


    .modal-infografis-title {

        font-size: 18px;

    }


    .infografis-modal-actions {

        justify-content: flex-start;

        margin-top: 5px;

    }


    .modal-action-btn {

        flex: 1 1 auto;

    }


    #infografisModal .modal-dialog {

        margin: 8px;

    }


    .infografis-modal {

        border-radius: 14px;

    }

}



/* =============================================================
   VERY SMALL MOBILE
============================================================= */

@media (max-width: 480px) {


    .info-image {

        height: 280px;

    }


    .publication-box {

        flex-direction: column;

    }


    .publication-icon {

        width: 48px;

        height: 48px;

        min-width: 48px;

    }


    .infografis-preview {

        min-height: 55vh;

        max-height: 62vh;

    }


    .modal-action-btn {

        width: 100%;

        flex: 1 1 100%;

    }

}

</style>



{{-- =============================================================
     JAVASCRIPT
============================================================== --}}
<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | MODAL ELEMENTS
    |--------------------------------------------------------------------------
    */

    const modal = document.getElementById('infografisModal');

    const modalImage =
        document.getElementById('modalInfografisImage');

    const modalTitle =
        document.getElementById('infografisModalLabel');

    const modalCategory =
        document.getElementById('modalInfografisCategory');

    const modalPeriod =
        document.getElementById('modalInfografisPeriod');

    const downloadImage =
        document.getElementById('modalDownloadImage');

    const downloadPdf =
        document.getElementById('modalDownloadPdf');

    const shareButton =
        document.getElementById('modalShareButton');



    /*
    |--------------------------------------------------------------------------
    | KETIKA MODAL AKAN DIBUKA
    |--------------------------------------------------------------------------
    */

    if (modal) {

        modal.addEventListener(
            'show.bs.modal',
            function (event) {

                /*
                | Tombol yang diklik
                */

                const button =
                    event.relatedTarget;


                if (!button) {
                    return;
                }


                /*
                | Ambil data dari tombol
                */

                const title =
                    button.getAttribute('data-title');

                const category =
                    button.getAttribute('data-category');

                const period =
                    button.getAttribute('data-period');

                const image =
                    button.getAttribute('data-image');

                const pdf =
                    button.getAttribute('data-pdf');



                /*
                | Masukkan data ke modal
                */

                modalTitle.textContent =
                    title || '';

                modalCategory.textContent =
                    category || '';

                modalPeriod.textContent =
                    period || '';


                /*
                | Gambar
                */

                modalImage.src =
                    image || '';

                modalImage.alt =
                    title || 'Infografis';



                /*
                | Link download gambar
                */

                downloadImage.href =
                    image || '#';



                /*
                | Link download PDF
                */

                downloadPdf.href =
                    pdf || '#';



                /*
                | Simpan URL gambar untuk tombol share
                */

                shareButton.dataset.image =
                    image || '';

                shareButton.dataset.title =
                    title || '';

                shareButton.dataset.period =
                    period || '';

            });

    }



    /*
    |--------------------------------------------------------------------------
    | TOMBOL BAGIKAN
    |--------------------------------------------------------------------------
    */

    if (shareButton) {

        shareButton.addEventListener(
            'click',
            async function () {

                const title =
                    this.dataset.title || 'Infografis WIN';

                const image =
                    this.dataset.image || '';

                const period =
                    this.dataset.period || '';



                /*
                | Coba menggunakan Web Share API
                */

                if (navigator.share) {

                    try {

                        await navigator.share({

                            title:
                                title,

                            text:
                                title +
                                (period
                                    ? ' - ' + period
                                    : '') +
                                ' | WIN - Wonosobo Indicator Navigator',

                            url:
                                window.location.href

                        });

                    }

                    catch (error) {

                        /*
                        | User membatalkan share.
                        | Tidak perlu menampilkan error.
                        */

                        console.log(
                            'Share dibatalkan.'
                        );

                    }

                    return;

                }



                /*
                | Jika Web Share API tidak tersedia,
                | gunakan Clipboard.
                */

                const shareText =
                    title +
                    (period
                        ? ' - ' + period
                        : '') +
                    '\n' +
                    window.location.href;



                if (
                    navigator.clipboard &&
                    window.isSecureContext
                ) {

                    try {

                        await navigator.clipboard.writeText(
                            shareText
                        );

                        showShareNotification(
                            'Tautan berhasil disalin.'
                        );

                    }

                    catch (error) {

                        fallbackCopyText(
                            shareText
                        );

                    }

                }

                else {

                    fallbackCopyText(
                        shareText
                    );

                }

            });

    }



    /*
    |--------------------------------------------------------------------------
    | RESET MODAL KETIKA DITUTUP
    |--------------------------------------------------------------------------
    */

    if (modal) {

        modal.addEventListener(
            'hidden.bs.modal',
            function () {

                modalImage.src = '';

                modalImage.alt = '';

                modalTitle.textContent = '';

                modalCategory.textContent = '';

                modalPeriod.textContent = '';

                downloadImage.href = '#';

                downloadPdf.href = '#';

            });

    }



    /*
    |--------------------------------------------------------------------------
    | FALLBACK COPY
    |--------------------------------------------------------------------------
    */

    function fallbackCopyText(text) {

        const textarea =
            document.createElement('textarea');

        textarea.value = text;

        textarea.style.position = 'fixed';

        textarea.style.left = '-999999px';

        document.body.appendChild(
            textarea
        );

        textarea.focus();

        textarea.select();


        try {

            document.execCommand('copy');

            showShareNotification(
                'Tautan berhasil disalin.'
            );

        }

        catch (error) {

            alert(
                'Silakan salin alamat halaman ini secara manual.'
            );

        }


        document.body.removeChild(
            textarea
        );

    }



    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI SHARE
    |--------------------------------------------------------------------------
    */

    function showShareNotification(message) {

        const notification =
            document.createElement('div');


        notification.textContent =
            message;


        notification.style.position =
            'fixed';

        notification.style.bottom =
            '25px';

        notification.style.left =
            '50%';

        notification.style.transform =
            'translateX(-50%)';

        notification.style.background =
            '#111827';

        notification.style.color =
            '#ffffff';

        notification.style.padding =
            '11px 18px';

        notification.style.borderRadius =
            '999px';

        notification.style.fontSize =
            '13px';

        notification.style.fontWeight =
            '600';

        notification.style.zIndex =
            '99999';

        notification.style.boxShadow =
            '0 8px 25px rgba(0,0,0,.25)';


        document.body.appendChild(
            notification
        );


        setTimeout(function () {

            notification.style.opacity =
                '0';

            notification.style.transition =
                'opacity .25s ease';


            setTimeout(function () {

                notification.remove();

            }, 250);

        }, 1800);

    }

});

</script>

@endsection