@extends('layouts.app')

@section('title', 'Layanan & Kontak - WIN Wonosobo')

@section('content')

<style>
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

    .section-title {
        font-weight: 800;
        color: #1f2937;
    }

    .section-subtitle {
        color: #6b7280;
    }

    /* =========================
       SERVICE CARD
    ========================= */

    .service-card {
        height: 100%;
        border: 0;
        border-radius: 18px;
        background: white;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,.07);
        transition: .25s ease;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,.11);
    }

    .service-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        margin-bottom: 18px;
    }

    .icon-blue {
        background: #dbeafe;
        color: #2563eb;
    }

    .icon-green {
        background: #dcfce7;
        color: #16a34a;
    }

    .icon-orange {
        background: #ffedd5;
        color: #ea580c;
    }

    .icon-purple {
        background: #f3e8ff;
        color: #9333ea;
    }

    .service-title {
        font-size: 18px;
        font-weight: 750;
        color: #1f2937;
        margin-bottom: 9px;
    }

    .service-description {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.65;
        margin-bottom: 0;
    }

    /* =========================
       CONTACT CARD
    ========================= */

    .contact-card {
        border: 0;
        border-radius: 20px;
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,.07);
        padding: 28px;
        height: 100%;
    }

    .contact-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #eef0f3;
    }

    .contact-item:first-child {
        padding-top: 0;
    }

    .contact-item:last-child {
        border-bottom: 0;
    }

    .contact-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 11px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .contact-label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 3px;
    }

    .contact-value {
        font-weight: 650;
        color: #1f2937;
        line-height: 1.5;
    }

    .contact-value a {
        color: #2563eb;
        text-decoration: none;
    }

    .contact-value a:hover {
        text-decoration: underline;
    }

    /* =========================
       MAP
    ========================= */

    .map-card {
        height: 100%;
        min-height: 430px;
        border-radius: 20px;
        overflow: hidden;
        background: #eef4fb;
        position: relative;
        box-shadow: 0 5px 20px rgba(0,0,0,.07);
    }

    .map-card iframe {
        display: block;
        width: 100%;
        height: 100%;
        min-height: 430px;
        border: 0;
    }

    .map-overlay {
        position: absolute;
        left: 20px;
        right: 20px;
        bottom: 20px;

        background: rgba(255,255,255,.96);
        backdrop-filter: blur(8px);

        border-radius: 14px;
        padding: 13px 15px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;

        box-shadow: 0 5px 18px rgba(0,0,0,.12);
    }

    .map-overlay strong {
        display: block;
        color: #1f2937;
        font-size: 14px;
        margin-bottom: 3px;
    }

    .map-overlay span {
        display: block;
        color: #6b7280;
        font-size: 12px;
    }

    /* =========================
       WEBSITE BOX
    ========================= */

    .official-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        margin-top: 20px;
    }

    .official-box a {
        text-decoration: none;
        color: #2563eb;
        font-weight: 650;
    }

    .official-box a:hover {
        text-decoration: underline;
    }

    /* =========================
       INFORMATION BOX
    ========================= */

    .info-box {
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #1e40af;
        border-radius: 16px;
        padding: 20px;
    }

    .info-box i {
        font-size: 22px;
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 768px) {

        .page-hero {
            padding: 30px 24px;
        }

        .map-card {
            min-height: 360px;
        }

        .map-card iframe {
            min-height: 360px;
        }

    }

    @media (max-width: 576px) {

        .map-overlay {
            position: static;
            border-radius: 0;
            flex-direction: column;
            align-items: flex-start;
        }

        .map-card {
            min-height: auto;
        }

        .map-card iframe {
            min-height: 300px;
        }

    }
</style>


<div class="container py-4">

    {{-- =========================
         BREADCRUMB
    ========================= --}}

    <div class="mb-4">

        <small class="text-muted">

            <a
                href="{{ route('home') }}"
                class="text-decoration-none text-muted"
            >
                Beranda
            </a>

            <span class="mx-2">/</span>

            <strong>
                Layanan & Kontak
            </strong>

        </small>

    </div>


    {{-- =========================
         HERO
    ========================= --}}

    <div class="page-hero">

        <h1>
            Layanan & Kontak
        </h1>

        <p>
            Informasi layanan statistik serta kontak resmi
            Badan Pusat Statistik Kabupaten Wonosobo.
        </p>

    </div>


    {{-- =========================
         LAYANAN STATISTIK
    ========================= --}}

    <div class="mb-5">

        <div class="mb-4">

            <h2 class="section-title">
                Layanan Statistik
            </h2>

            <p class="section-subtitle">
                BPS Kabupaten Wonosobo menyediakan berbagai layanan
                untuk membantu masyarakat memperoleh dan memanfaatkan
                data statistik.
            </p>

        </div>


        <div class="row g-4">

            {{-- KONSULTASI --}}
            <div class="col-md-6 col-lg-3">

                <div class="service-card">

                    <div class="service-icon icon-blue">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>

                    <div class="service-title">
                        Konsultasi Statistik
                    </div>

                    <p class="service-description">
                        Layanan konsultasi terkait data statistik,
                        metodologi, serta pemanfaatan data BPS.
                    </p>

                </div>

            </div>


            {{-- PERPUSTAKAAN --}}
            <div class="col-md-6 col-lg-3">

                <div class="service-card">

                    <div class="service-icon icon-green">
                        <i class="bi bi-book-fill"></i>
                    </div>

                    <div class="service-title">
                        Perpustakaan
                    </div>

                    <p class="service-description">
                        Akses terhadap berbagai publikasi dan
                        informasi statistik yang tersedia di BPS.
                    </p>

                </div>

            </div>


            {{-- REKOMENDASI --}}
            <div class="col-md-6 col-lg-3">

                <div class="service-card">

                    <div class="service-icon icon-orange">
                        <i class="bi bi-file-earmark-check-fill"></i>
                    </div>

                    <div class="service-title">
                        Rekomendasi Kegiatan Statistik
                    </div>

                    <p class="service-description">
                        Informasi dan layanan terkait rekomendasi
                        kegiatan statistik sesuai ketentuan BPS.
                    </p>

                </div>

            </div>


            {{-- AKSES DATA --}}
            <div class="col-md-6 col-lg-3">

                <div class="service-card">

                    <div class="service-icon icon-purple">
                        <i class="bi bi-database-fill"></i>
                    </div>

                    <div class="service-title">
                        Akses Data Statistik
                    </div>

                    <p class="service-description">
                        Akses data statistik melalui website,
                        publikasi, tabel statistik, dan layanan
                        BPS Kabupaten Wonosobo.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
         KONTAK
    ========================= --}}

    <div class="mb-5">

        <div class="mb-4">

            <h2 class="section-title">
                Kontak BPS Kabupaten Wonosobo
            </h2>

            <p class="section-subtitle">
                Hubungi BPS Kabupaten Wonosobo melalui kanal
                layanan resmi berikut.
            </p>

        </div>


        <div class="row g-4">


            {{-- =========================
                 INFORMASI KONTAK
            ========================= --}}

            <div class="col-lg-5">

                <div class="contact-card">


                    {{-- ALAMAT --}}
                    <div class="contact-item">

                        <div class="contact-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>

                        <div>

                            <div class="contact-label">
                                Alamat
                            </div>

                            <div class="contact-value">
                                Jl. Mayjen Bambang Sugeng Km 2,2
                                Wonosobo
                            </div>

                        </div>

                    </div>


                    {{-- TELEPON --}}
                    <div class="contact-item">

                        <div class="contact-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>

                        <div>

                            <div class="contact-label">
                                Telepon
                            </div>

                            <div class="contact-value">

                                <a href="tel:+62286324270">
                                    (0286) 324270
                                </a>

                            </div>

                        </div>

                    </div>


                    {{-- FAX --}}
                    <div class="contact-item">

                        <div class="contact-icon">
                            <i class="bi bi-printer-fill"></i>
                        </div>

                        <div>

                            <div class="contact-label">
                                Faks
                            </div>

                            <div class="contact-value">
                                (0286) 3325380
                            </div>

                        </div>

                    </div>


                    {{-- EMAIL --}}
                    <div class="contact-item">

                        <div class="contact-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>

                        <div>

                            <div class="contact-label">
                                Email
                            </div>

                            <div class="contact-value">

                                <a href="mailto:bps3307@bps.go.id">
                                    bps3307@bps.go.id
                                </a>

                            </div>

                        </div>

                    </div>


                    {{-- JAM LAYANAN --}}
                    <div class="contact-item">

                        <div class="contact-icon">
                            <i class="bi bi-clock-fill"></i>
                        </div>

                        <div>

                            <div class="contact-label">
                                Jam Layanan PST
                            </div>

                            <div class="contact-value">
                                Hari kerja, 07.30–16.00 WIB
                            </div>

                        </div>

                    </div>


                    {{-- WEBSITE --}}
                    <div class="official-box">

                        <div class="contact-label">
                            Website Resmi
                        </div>

                        <a
                            href="https://wonosobokab.bps.go.id/"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            BPS Kabupaten Wonosobo

                            <i class="bi bi-box-arrow-up-right ms-1"></i>

                        </a>

                    </div>


                </div>

            </div>


            {{-- =========================
                 GOOGLE MAPS
            ========================= --}}

            <div class="col-lg-7">

                <div class="map-card">

                    <iframe
                        src="https://www.google.com/maps?q=BPS+Kabupaten+Wonosobo&output=embed"
                        title="Lokasi BPS Kabupaten Wonosobo"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>


                    {{-- MAP OVERLAY --}}
                    <div class="map-overlay">

                        <div>

                            <strong>
                                BPS Kabupaten Wonosobo
                            </strong>

                            <span>
                                Jl. Mayjen Bambang Sugeng Km 2,2 Wonosobo
                            </span>

                        </div>


                        <a
                            href="https://www.google.com/maps/search/?api=1&query=BPS+Kabupaten+Wonosobo"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-primary btn-sm"
                        >

                            <i class="bi bi-map me-1"></i>

                            Buka di Google Maps

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
         INFORMASI LAYANAN
    ========================= --}}

    <div class="info-box">

        <div class="d-flex gap-3">

            <i class="bi bi-info-circle-fill"></i>

            <div>

                <strong>
                    Informasi layanan
                </strong>

                <div class="mt-1">

                    Pelayanan Statistik Terpadu (PST)
                    BPS Kabupaten Wonosobo melayani masyarakat
                    pada hari kerja pukul
                    <strong>07.30–16.00 WIB</strong>.

                </div>

            </div>

        </div>

    </div>


</div>

@endsection