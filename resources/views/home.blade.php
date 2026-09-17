@extends('layouts.app')

@section('title', 'WIN - Wonosobo Indicator Navigator')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | STYLE KELOMPOK
    |--------------------------------------------------------------------------
    |
    | Data indikator dan statistik homepage sekarang diproses
    | oleh HomeController. Blade hanya menampilkan hasilnya.
    |
    */

    $groupStyles = [

        'kependudukan' => [
            'class' => 'home-group-blue',
            'icon' => 'bi-people-fill',
        ],

        'kemiskinan' => [
            'class' => 'home-group-red',
            'icon' => 'bi-graph-down-arrow',
        ],

        'ketenagakerjaan' => [
            'class' => 'home-group-orange',
            'icon' => 'bi-briefcase-fill',
        ],

        'pembangunan-manusia' => [
            'class' => 'home-group-green',
            'icon' => 'bi-person-hearts',
        ],

        'ekonomi' => [
            'class' => 'home-group-indigo',
            'icon' => 'bi-graph-up-arrow',
        ],

        'pariwisata' => [
            'class' => 'home-group-purple',
            'icon' => 'bi-image-fill',
        ],

        'pendidikan' => [
            'class' => 'home-group-cyan',
            'icon' => 'bi-mortarboard-fill',
        ],

    ];
@endphp

<style>

/* =========================================================
   HOME PAGE
========================================================= */

.home-page {
    padding-bottom: 70px;
}


/* =========================================================
   ANIMATIONS
========================================================= */

@keyframes homeFadeUp {

    from {
        opacity: 0;
        transform: translateY(18px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}


@keyframes homeFadeRight {

    from {
        opacity: 0;
        transform: translateX(18px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }

}


@keyframes homeFloat {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-8px);
    }

}


@keyframes homeFloatReverse {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(7px);
    }

}


@keyframes homePulse {

    0%,
    100% {
        opacity: .35;
        transform: scale(1);
    }

    50% {
        opacity: .55;
        transform: scale(1.05);
    }

}


@keyframes homeBars {

    0%,
    100% {
        transform: scaleY(.9);
    }

    50% {
        transform: scaleY(1.08);
    }

}


.home-animate {
    animation:
        homeFadeUp
        .7s
        ease
        both;
}


.home-delay-1 {
    animation-delay: .1s;
}


.home-delay-2 {
    animation-delay: .2s;
}


.home-delay-3 {
    animation-delay: .3s;
}


.home-delay-4 {
    animation-delay: .4s;
}


/* =========================================================
   HERO
========================================================= */

.home-hero {

    position: relative;

    overflow: hidden;

    min-height: 410px;

    border-radius: 24px;

    padding: 45px;

    margin-bottom: 48px;

    color: white;

    background:
        linear-gradient(
            135deg,
            #0d6efd 0%,
            #2563eb 55%,
            #4f46e5 100%
        );
}


.home-hero::before {

    content: "";

    position: absolute;

    width: 350px;
    height: 350px;

    border-radius: 50%;

    background:
        rgba(255,255,255,.08);

    right: -100px;

    top: -160px;

    animation:
        homePulse
        9s
        ease-in-out
        infinite;
}


.home-hero::after {

    content: "";

    position: absolute;

    width: 220px;
    height: 220px;

    border-radius: 50%;

    background:
        rgba(255,255,255,.05);

    right: 220px;

    bottom: -150px;

    animation:
        homePulse
        11s
        ease-in-out
        infinite
        reverse;
}


/* =========================================================
   HERO CONTENT
========================================================= */

.home-hero-content {

    position: relative;

    z-index: 5;

    max-width: 720px;
}


.home-badge {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    background:
        rgba(255,255,255,.15);

    border:
        1px solid
        rgba(255,255,255,.22);

    padding:
        7px 13px;

    border-radius: 30px;

    font-size: 12px;

    font-weight: 700;

    margin-bottom: 16px;
}


.home-hero h1 {

    font-size: 44px;

    line-height: 1.08;

    font-weight: 800;

    letter-spacing: -1px;

    margin-bottom: 14px;
}


.home-hero h1 span {

    display: block;
}


.home-hero-description {

    max-width: 640px;

    font-size: 15px;

    line-height: 1.7;

    color:
        rgba(255,255,255,.92);

    margin-bottom: 22px;
}


/* =========================================================
   BUTTONS
========================================================= */

.home-actions {

    display: flex;

    flex-wrap: wrap;

    gap: 10px;
}


.home-btn-primary,
.home-btn-secondary {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    text-decoration: none;

    border-radius: 10px;

    padding:
        11px 18px;

    font-size: 14px;

    font-weight: 700;

    transition:
        transform .2s ease,
        background-color .2s ease,
        box-shadow .2s ease;
}


.home-btn-primary {

    background: white;

    color: #2563eb;

    border:
        1px solid white;
}


.home-btn-primary:hover {

    background: #f8fafc;

    color: #1d4ed8;

    transform:
        translateY(-3px);

    box-shadow:
        0 8px 18px
        rgba(15,23,42,.15);
}


.home-btn-secondary {

    background:
        rgba(255,255,255,.10);

    color: white;

    border:
        1px solid
        rgba(255,255,255,.35);
}


.home-btn-secondary:hover {

    background:
        rgba(255,255,255,.20);

    color: white;

    transform:
        translateY(-3px);
}


/* =========================================================
   HERO SUMMARY
========================================================= */

.hero-summary {

    position: relative;

    z-index: 6;

    display: grid;

    grid-template-columns:
        repeat(2, 150px);

    gap: 10px;

    width: fit-content;

    margin-top: 22px;
}


.hero-summary-card {

    min-height: 62px;

    background:
        rgba(255,255,255,.12);

    border:
        1px solid
        rgba(255,255,255,.20);

    border-radius: 13px;

    padding:
        11px 13px;

    backdrop-filter:
        blur(7px);

    transition:
        background .2s ease,
        transform .2s ease;
}


.hero-summary-card:hover {

    background:
        rgba(255,255,255,.17);

    transform:
        translateY(-2px);
}


.hero-summary-value {

    font-size: 20px;

    font-weight: 800;

    line-height: 1.2;

    margin-bottom: 3px;
}


.hero-summary-label {

    font-size: 9px;

    color:
        rgba(255,255,255,.78);

    font-weight: 600;
}


/* =========================================================
   HERO VISUAL
========================================================= */

.hero-visual {

    position: absolute;

    z-index: 4;

    right: 38px;

    top: 55px;

    width: 330px;

    height: 290px;
}


.hero-orbit {

    position: absolute;

    width: 265px;

    height: 150px;

    border:
        1px solid
        rgba(255,255,255,.16);

    border-radius: 50%;

    left: 35px;

    top: 60px;

    transform:
        rotate(-12deg);

    animation:
        homePulse
        7s
        ease-in-out
        infinite;
}


/* =========================================================
   DASHBOARD VISUAL
========================================================= */

.hero-dashboard-card {

    position: absolute;

    left: 65px;

    top: 63px;

    width: 205px;

    min-height: 145px;

    background:
        rgba(255,255,255,.96);

    border-radius: 18px;

    padding: 17px;

    color: #172554;

    box-shadow:
        0 18px 45px
        rgba(15,23,42,.18);

    animation:
        homeFloat
        5s
        ease-in-out
        infinite;
}


.hero-dashboard-top {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 14px;
}


.hero-dashboard-label {

    font-size: 10px;

    font-weight: 800;

    color: #64748b;

    letter-spacing: .6px;

    text-transform: uppercase;
}


.hero-dashboard-icon {

    width: 30px;

    height: 30px;

    border-radius: 9px;

    background: #eff6ff;

    color: #2563eb;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 13px;
}


.hero-dashboard-value {

    font-size: 27px;

    font-weight: 800;

    line-height: 1;

    margin-bottom: 4px;

    color: #172554;
}


.hero-dashboard-unit {

    font-size: 10px;

    color: #64748b;

    margin-bottom: 14px;
}


.hero-dashboard-bars {

    display: flex;

    align-items: end;

    gap: 6px;

    height: 35px;
}


.hero-dashboard-bars span {

    display: block;

    width: 13px;

    border-radius:
        4px 4px 2px 2px;

    background:
        linear-gradient(
            180deg,
            #60a5fa,
            #2563eb
        );

    animation:
        homeBars
        2.4s
        ease-in-out
        infinite;
}


.hero-dashboard-bars span:nth-child(1) {

    height: 15px;

    animation-delay: .1s;
}


.hero-dashboard-bars span:nth-child(2) {

    height: 22px;

    animation-delay: .3s;
}


.hero-dashboard-bars span:nth-child(3) {

    height: 18px;

    animation-delay: .5s;
}


.hero-dashboard-bars span:nth-child(4) {

    height: 29px;

    animation-delay: .7s;
}


.hero-dashboard-bars span:nth-child(5) {

    height: 35px;

    animation-delay: .9s;
}


/* =========================================================
   FLOATING CARDS
========================================================= */

.hero-floating-card {

    position: absolute;

    display: flex;

    align-items: center;

    gap: 8px;

    background: white;

    color: #172554;

    border-radius: 12px;

    padding:
        9px 11px;

    font-size: 10px;

    font-weight: 700;

    box-shadow:
        0 10px 25px
        rgba(15,23,42,.14);
}


.hero-floating-card i {

    width: 25px;

    height: 25px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 7px;

    background: #eff6ff;

    color: #2563eb;
}


.hero-floating-one {

    left: 4px;

    top: 42px;

    animation:
        homeFloatReverse
        4.5s
        ease-in-out
        infinite;
}


.hero-floating-two {

    right: 0;

    top: 24px;

    animation:
        homeFloat
        5.2s
        ease-in-out
        infinite;
}


.hero-floating-three {

    right: 13px;

    bottom: 30px;

    animation:
        homeFloatReverse
        4.8s
        ease-in-out
        infinite;
}


/* =========================================================
   SECTION
========================================================= */

.home-section {

    margin-bottom: 52px;
}


.home-section-label {

    color: #2563eb;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: 1.5px;

    text-transform: uppercase;

    margin-bottom: 7px;
}


.home-section-title {

    color: #172554;

    font-size: 28px;

    line-height: 1.2;

    font-weight: 800;

    letter-spacing: -.4px;

    margin-bottom: 7px;
}


.home-section-description {

    color: #64748b;

    font-size: 14px;

    line-height: 1.6;

    margin-bottom: 21px;
}


/* =========================================================
   INDIKATOR UTAMA
========================================================= */

.main-indicator-card {

    height: 190px;

    border-radius: 18px;

    padding: 19px;

    color: white;

    position: relative;

    overflow: hidden;

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}


.main-indicator-card:hover {

    transform:
        translateY(-6px)
        scale(1.01);

    box-shadow:
        0 15px 30px
        rgba(15,23,42,.15);
}


.main-indicator-card::after {

    content: "";

    position: absolute;

    width: 120px;

    height: 120px;

    border-radius: 50%;

    background:
        rgba(255,255,255,.09);

    right: -35px;

    bottom: -50px;

    transition:
        transform .35s ease;
}


.main-indicator-card:hover::after {

    transform:
        scale(1.15);
}


.indicator-blue {

    background:
        linear-gradient(
            135deg,
            #0d6efd,
            #2780f5
        );
}


.indicator-green {

    background:
        linear-gradient(
            135deg,
            #10b981,
            #16a34a
        );
}


.indicator-orange {

    background:
        linear-gradient(
            135deg,
            #f59e0b,
            #ea580c
        );
}


.indicator-purple {

    background:
        linear-gradient(
            135deg,
            #8b5cf6,
            #7c3aed
        );
}


.indicator-top {

    position: relative;

    z-index: 2;

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    gap: 8px;
}


.indicator-name {

    font-size: 13px;

    font-weight: 700;

    line-height: 1.4;

    min-height: 37px;

    max-width: 80%;
}


.indicator-icon {

    width: 35px;

    height: 35px;

    border-radius: 10px;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        rgba(255,255,255,.16);

    font-size: 15px;

    flex-shrink: 0;

    transition:
        transform .25s ease;
}


.main-indicator-card:hover
.indicator-icon {

    transform:
        rotate(-5deg)
        scale(1.08);
}


.indicator-value {

    position: relative;

    z-index: 2;

    font-size: 28px;

    line-height: 1.15;

    font-weight: 800;

    letter-spacing: -.5px;

    margin-top: 4px;
}


.indicator-unit {

    position: relative;

    z-index: 2;

    font-size: 11px;

    opacity: .82;

    margin-top: 2px;
}


.indicator-change {

    position: relative;

    z-index: 2;

    margin-top: 8px;

    font-size: 10px;

    font-weight: 700;
}


.change-pill {

    display: inline-flex;

    align-items: center;

    gap: 4px;

    background:
        rgba(255,255,255,.16);

    border-radius: 7px;

    padding:
        4px 7px;
}


/* =========================================================
   TREND
========================================================= */

.trend-card {

    background: white;

    border-radius: 20px;

    border:
        1px solid #e5e7eb;

    box-shadow:
        0 5px 20px
        rgba(0,0,0,.06);

    overflow: hidden;
}


.trend-card-header {

    padding:
        21px 23px 13px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    border-bottom:
        1px solid #f1f5f9;
}


.trend-card-title {

    font-size: 16px;

    font-weight: 800;

    color: #172554;

    margin-bottom: 3px;
}


.trend-card-subtitle {

    color: #64748b;

    font-size: 12px;
}


.trend-select {

    width: 240px;

    border-radius: 9px;

    border:
        1px solid #dbe3ef;

    padding:
        8px 12px;

    font-size: 12px;

    color: #334155;

    background: #f8fafc;

    outline: none;
}


.trend-select:focus {

    border-color: #60a5fa;

    box-shadow:
        0 0 0 3px
        rgba(59,130,246,.10);
}


.trend-chart-wrapper {

    height: 320px;

    padding:
        18px 23px 23px;
}


/* =========================================================
   BIDANG STRATEGIS
========================================================= */

.home-group-card {

    height: 175px;

    border-radius: 18px;

    padding: 21px;

    position: relative;

    overflow: hidden;

    text-decoration: none;

    display: flex;

    flex-direction: column;

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}


.home-group-card:hover {

    transform:
        translateY(-5px);

    box-shadow:
        0 12px 28px
        rgba(15,23,42,.10);
}


.home-group-icon {

    width: 44px;

    height: 44px;

    border-radius: 12px;

    background:
        rgba(255,255,255,.75);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 19px;

    margin-bottom: 14px;

    transition:
        transform .25s ease;
}


.home-group-card:hover
.home-group-icon {

    transform:
        rotate(-5deg)
        scale(1.08);
}


.home-group-name {

    color: #102a56;

    font-size: 16px;

    font-weight: 800;

    margin-bottom: 5px;
}


.home-group-count {

    color: #527095;

    font-size: 12px;

    font-weight: 600;
}


.home-group-arrow {

    position: absolute;

    top: 20px;

    right: 20px;

    width: 31px;

    height: 31px;

    border-radius: 50%;

    background:
        rgba(255,255,255,.75);

    display: flex;

    align-items: center;

    justify-content: center;

    color: #315f9e;

    font-size: 13px;

    transition:
        transform .25s ease;
}


.home-group-card:hover
.home-group-arrow {

    transform:
        translate(
            2px,
            -2px
        );
}


.home-group-blue {

    background:
        linear-gradient(
            135deg,
            #b7dbff,
            #9dcbf5
        );
}


.home-group-red {

    background:
        linear-gradient(
            135deg,
            #ffd0d2,
            #ffc3c6
        );
}


.home-group-orange {

    background:
        linear-gradient(
            135deg,
            #ffdda5,
            #ffd092
        );
}


.home-group-green {

    background:
        linear-gradient(
            135deg,
            #b8efd6,
            #a1e2c3
        );
}


.home-group-indigo {

    background:
        linear-gradient(
            135deg,
            #d1d7ff,
            #c1c9f8
        );
}


.home-group-purple {

    background:
        linear-gradient(
            135deg,
            #d5b8f7,
            #c5a4ee
        );
}


.home-group-cyan {

    background:
        linear-gradient(
            135deg,
            #c0e9eb,
            #afe0e2
        );
}


/* =========================================================
   DATA TERBARU
========================================================= */

.latest-card {

    background: white;

    border-radius: 18px;

    border:
        1px solid #e5e7eb;

    box-shadow:
        0 5px 20px
        rgba(0,0,0,.06);

    overflow: hidden;
}


.latest-header {

    padding:
        20px 22px;

    border-bottom:
        1px solid #eef2f7;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;
}


.latest-title {

    color: #172554;

    font-size: 16px;

    font-weight: 800;
}


.latest-link {

    color: #2563eb;

    font-size: 12px;

    font-weight: 700;

    text-decoration: none;
}


.latest-link:hover {

    color: #1d4ed8;
}


.latest-table {

    width: 100%;

    margin: 0;
}


.latest-table th {

    background: #f8fafc;

    color: #64748b;

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .5px;

    padding:
        11px 20px;

    border-bottom:
        1px solid #e5e7eb;
}


.latest-table td {

    color: #334155;

    font-size: 13px;

    padding:
        13px 20px;

    border-bottom:
        1px solid #f1f5f9;

    vertical-align: middle;
}


.latest-table tr:last-child td {

    border-bottom: none;
}


.latest-indicator-name {

    font-weight: 700;

    color: #1e293b;
}


.latest-value {

    font-weight: 800;

    color: #172554;

    white-space: nowrap;
}


.latest-year {

    color: #64748b;

    white-space: nowrap;
}


.latest-unit {

    color: #94a3b8;

    font-size: 11px;

    white-space: nowrap;
}


/* =========================================================
   SIMULATION NOTE
========================================================= */

.simulation-note {

    margin-top: 12px;

    padding:
        10px 13px;

    background: #fff7ed;

    border:
        1px solid #fed7aa;

    border-radius: 9px;

    color: #9a3412;

    font-size: 11px;

    line-height: 1.5;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .hero-visual {

        opacity: .55;

        right: 0;
    }

    .home-hero {

        min-height: auto;

        padding-bottom: 35px;
    }

}


@media (max-width: 768px) {

    .home-hero {

        padding:
            35px 27px;

        border-radius: 20px;
    }


    .home-hero h1 {

        font-size: 35px;
    }


    .home-hero-description {

        font-size: 14px;
    }


    .hero-visual {

        display: none;
    }


    .hero-summary {

        grid-template-columns:
            repeat(2, 150px);

        width: fit-content;

        max-width: 100%;
    }


    .home-section-title {

        font-size: 26px;
    }


    .trend-card-header {

        align-items:
            flex-start;

        flex-direction:
            column;
    }


    .trend-select {

        width: 100%;
    }


    .trend-chart-wrapper {

        height: 280px;
    }

}


@media (max-width: 576px) {

    .home-hero {

        padding:
            30px 22px;
    }


    .home-hero h1 {

        font-size: 31px;
    }


    .home-actions {

        width: 100%;

        flex-direction: column;
    }


    .home-btn-primary,
    .home-btn-secondary {

        width: 100%;
    }


    .hero-summary {

        grid-template-columns:
            1fr 1fr;

        width: 100%;

        max-width: 320px;
    }


    .hero-summary-card {

        min-height: 62px;
    }


    .main-indicator-card {

        height: 180px;
    }


    .latest-header {

        align-items:
            flex-start;

        flex-direction:
            column;
    }


    .latest-table th,
    .latest-table td {

        padding-left: 13px;

        padding-right: 13px;
    }


    .latest-table th:nth-child(3),
    .latest-table td:nth-child(3) {

        display: none;
    }


    .trend-chart-wrapper {

        height: 240px;

        padding:
            12px 12px 18px;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    *,
    *::before,
    *::after {

        animation-duration:
            .01ms !important;

        animation-iteration-count:
            1 !important;

        transition-duration:
            .01ms !important;
    }

}

/* =========================================================
   SEE ALL LINK
========================================================= */

.home-see-all {

    display: inline-flex;

    align-items: center;

    white-space: nowrap;

    color: #2563eb;

    font-size: 13px;

    font-weight: 700;

    text-decoration: none;

    margin-bottom: 5px;

    transition:
        color .2s ease,
        transform .2s ease;
}


.home-see-all:hover {

    color: #1d4ed8;

    transform:
        translateX(3px);
}


.home-see-all i {

    font-size: 12px;

}

@media (max-width: 576px) {

    .home-see-all {

        font-size: 12px;

    }

}

</style>


<div class="container home-page py-4">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="home-hero">


        <div
            class="
                home-hero-content
                home-animate
            "
        >


            {{-- BADGE --}}

            <div class="home-badge">

                <i class="bi bi-bar-chart-fill"></i>

                BPS Kabupaten Wonosobo

            </div>


            {{-- TITLE --}}

            <h1>

                Wonosobo Indicator

                <span>
                    Navigator
                </span>

            </h1>


            {{-- DESCRIPTION --}}

            <p class="home-hero-description">

                Dashboard indikator strategis Kabupaten
                Wonosobo yang menyajikan data statistik
                secara terpadu, informatif, dan mudah
                diakses.

            </p>


            {{-- BUTTONS --}}

            <div class="home-actions">


                <a
                    href="{{ route(
                        'kelompok.index'
                    ) }}"
                    class="home-btn-primary"
                >

                    <i
                        class="
                            bi
                            bi-grid-3x3-gap-fill
                            me-1
                        "
                    ></i>

                    Jelajahi Data

                </a>


                <a
                    href="{{ route(
                        'infografis.index'
                    ) }}"
                    class="home-btn-secondary"
                >

                    <i
                        class="
                            bi
                            bi-bar-chart-line
                            me-1
                        "
                    ></i>

                    Lihat Infografis

                </a>


            </div>


            {{-- =================================================
                 SUMMARY
            ================================================== --}}

            <div
                class="
                    hero-summary
                    home-animate
                    home-delay-2
                "
            >


                <div class="hero-summary-card">


                    <div class="hero-summary-value">

                        {{ $jumlahIndikator }}

                    </div>


                    <div class="hero-summary-label">

                        Indikator Strategis

                    </div>


                </div>


                <div class="hero-summary-card">


                    <div class="hero-summary-value">

                        {{ $jumlahKelompok }}

                    </div>


                    <div class="hero-summary-label">

                        Bidang Strategis

                    </div>


                </div>


            </div>


        </div>


        {{-- =====================================================
             HERO VISUAL
        ====================================================== --}}

        <div class="hero-visual">


            <div class="hero-orbit"></div>


            {{-- DATA --}}

            <div
                class="
                    hero-floating-card
                    hero-floating-one
                "
            >

                <i
                    class="
                        bi
                        bi-database-fill
                    "
                ></i>

                Data

            </div>


            {{-- STATISTIK --}}

            <div
                class="
                    hero-floating-card
                    hero-floating-two
                "
            >

                <i
                    class="
                        bi
                        bi-graph-up
                    "
                ></i>

                Statistik

            </div>


            {{-- ANALISIS --}}

            <div
                class="
                    hero-floating-card
                    hero-floating-three
                "
            >

                <i
                    class="
                        bi
                        bi-bar-chart-fill
                    "
                ></i>

                Analisis

            </div>


            {{-- DASHBOARD CARD --}}

            <div class="hero-dashboard-card">


                <div class="hero-dashboard-top">


                    <div class="hero-dashboard-label">

                        WIN Dashboard

                    </div>


                    <div class="hero-dashboard-icon">

                        <i
                            class="
                                bi
                                bi-activity
                            "
                        ></i>

                    </div>


                </div>


                <div class="hero-dashboard-value">

                    {{ $jumlahIndikator }}

                </div>


                <div class="hero-dashboard-unit">

                    Indikator Strategis

                </div>


                <div class="hero-dashboard-bars">

                    <span></span>

                    <span></span>

                    <span></span>

                    <span></span>

                    <span></span>

                </div>


            </div>


        </div>


    </section>


    {{-- =====================================================
         INDIKATOR UTAMA
    ====================================================== --}}

    <section class="home-section">


        <div class="d-flex justify-content-between align-items-end gap-3">

            <div>

                <div class="home-section-label">

                    Ringkasan Data

                </div>

                <h2 class="home-section-title mb-0">

                    Indikator Utama

                </h2>

            </div>


            <a
                href="{{ route('kelompok.index') }}"
                class="home-see-all"
            >

                Lihat Semua

                <i
                    class="
                        bi
                        bi-arrow-right
                        ms-1
                    "
                ></i>

            </a>

        </div>


        <p class="home-section-description">

            Gambaran singkat beberapa indikator strategis
            Kabupaten Wonosobo berdasarkan data terbaru.

        </p>


        <div class="row g-3">


            @foreach(
                $indikatorUtamaData
                as $index => $item
            )


                @php

                    $indikator =
                        $item['indikator'];

                    $terbaru =
                        $item['terbaru'];

                    $perubahan =
                        $item['perubahan'];

                @endphp


                <div
                    class="
                        col-md-6
                        col-lg-3
                        home-animate
                        home-delay-{{ $index + 1 }}
                    "
                >


                    <a
                        href="{{ route(
                            'indikator.show',
                            $indikator->slug
                        ) }}"
                        class="text-decoration-none"
                    >


                        <div
                            class="
                                main-indicator-card
                                {{ $item['class'] }}
                            "
                        >


                            <div
                                class="indicator-top"
                            >


                                <div
                                    class="indicator-name"
                                >

                                    {{ $indikator->nama_indikator }}

                                </div>


                                <div
                                    class="indicator-icon"
                                >

                                    <i
                                        class="
                                            bi
                                            {{ $item['icon'] }}
                                        "
                                    ></i>

                                </div>


                            </div>


                            <div
                                class="indicator-value"
                                data-count-value="{{ $terbaru->nilai }}"
                                data-count-type="{{ in_array($indikator->slug, [
                                    'indeks-pembangunan-manusia-ipm',
                                    'jumlah-perjalanan-wisatawan-nusantara-tujuan-wonosobo'
                                ], true) ? 'desimal' : $indikator->tipe_data }}"
                            >

                                @php
                                    $tipe = strtolower(trim($indikator->tipe_data ?? ''));
                                    $satuan = strtolower(trim($indikator->satuan ?? ''));

                                    $desimalTampil = (
                                        in_array($tipe, [
                                            'persentase',
                                            'desimal',
                                            'angka_desimal',
                                            'decimal'
                                        ], true)
                                        ||
                                        in_array($satuan, [
                                            'indeks',
                                            'rasio',
                                            'malam',
                                            'perjalanan'
                                        ], true)
                                    ) ? 2 : 0;
                                @endphp

                                {{ number_format(
                                    $terbaru->nilai,
                                    $desimalTampil,
                                    ',',
                                    '.'
                                ) }}

                            </div>


                            <div
                                class="indicator-unit"
                            >

                                {{ $indikator->satuan }}

                                ·

                                @if (optional($terbaru->periode)->frekuensi === 'bulanan')
                                    {{ optional($terbaru->periode)->nama_periode }}
                                @else
                                    {{ optional($terbaru->periode)->tahun }}
                                @endif

                            </div>


                            @if(
                                $perubahan !== null
                            )


                                <div
                                    class="
                                        indicator-change
                                    "
                                >

                                    <span
                                        class="
                                            change-pill
                                        "
                                    >


                                        @if(
                                            $perubahan > 0
                                        )

                                            <i
                                                class="
                                                    bi
                                                    bi-arrow-up
                                                "
                                            ></i>

                                            +{{ number_format(
                                                $perubahan,
                                                2,
                                                ',',
                                                '.'
                                            ) }}


                                        @elseif(
                                            $perubahan < 0
                                        )

                                            <i
                                                class="
                                                    bi
                                                    bi-arrow-down
                                                "
                                            ></i>

                                            {{ number_format(
                                                $perubahan,
                                                2,
                                                ',',
                                                '.'
                                            ) }}


                                        @else

                                            <i
                                                class="
                                                    bi
                                                    bi-dash
                                                "
                                            ></i>

                                            Tidak berubah

                                        @endif


                                    </span>

                                </div>


                            @endif


                        </div>


                    </a>


                </div>


            @endforeach


        </div>


    </section>


    {{-- =====================================================
         TREND INDIKATOR
    ====================================================== --}}

    <section class="home-section">


        <div class="home-section-label">

            Analisis Data

        </div>


        <h2 class="home-section-title">

            Tren Indikator Strategis

        </h2>


        <p class="home-section-description">

            Lihat perkembangan indikator strategis
            Kabupaten Wonosobo dari tahun ke tahun.

        </p>


        <div class="trend-card">


            <div class="trend-card-header">


                <div>


                    <div class="trend-card-title">

                        Perkembangan Indikator

                    </div>


                    <div
                        class="trend-card-subtitle"
                        id="chartSubtitle"
                    >

                        Pilih indikator untuk melihat tren data.

                    </div>


                </div>


                <select
                    id="indicatorSelect"
                    class="trend-select"
                    aria-label="Pilih indikator"
                >


                    @foreach(
                        $semuaIndikator
                        as $index => $indikator
                    )


                        <option
                            value="{{ $indikator->slug }}"
                            @selected(
                                $index === 0
                            )
                        >

                            {{ $indikator->nama_indikator }}

                        </option>


                    @endforeach


                </select>


            </div>


            <div
                class="trend-chart-wrapper"
            >

                <canvas
                    id="indicatorTrendChart"
                ></canvas>

            </div>


        </div>


    </section>


    {{-- =====================================================
         BIDANG STRATEGIS
    ====================================================== --}}

    <section class="home-section">


        <div class="home-section-label">

            Eksplorasi Data

        </div>


        <h2 class="home-section-title">

            Bidang Strategis

        </h2>


        <p class="home-section-description">

            Jelajahi indikator berdasarkan bidang
            pembangunan Kabupaten Wonosobo.

        </p>


        <div class="row g-3">


            @foreach(
                $kelompokHome
                as $index => $group
            )


                @php

                    $style =
                        $groupStyles[
                            $group->slug
                        ]
                        ??
                        [
                            'class' =>
                                'home-group-blue',

                            'icon' =>
                                'bi-grid-fill'
                        ];

                @endphp


                <div
                    class="
                        col-md-6
                        col-lg-3
                        home-animate
                    "
                    style="
                        animation-delay:
                        {{ 0.08 * $index }}s;
                    "
                >


                    <a
                        href="{{ route(
                            'kelompok.show',
                            $group->slug
                        ) }}"
                        class="
                            home-group-card
                            {{ $style['class'] }}
                        "
                    >


                        <div
                            class="home-group-icon"
                        >

                            <i
                                class="
                                    bi
                                    {{ $style['icon'] }}
                                "
                            ></i>

                        </div>


                        <div
                            class="home-group-name"
                        >

                            {{ $group->nama_kelompok }}

                        </div>


                        <div
                            class="home-group-count"
                        >

                            {{ $group->indikator_count }}

                            indikator

                        </div>


                        <div
                            class="home-group-arrow"
                        >

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


    </section>


    {{-- =====================================================
         DATA TERBARU
    ====================================================== --}}

    <section class="home-section">


        <div class="home-section-label">

            Informasi Terkini

        </div>


        <h2 class="home-section-title">

            Data Terbaru

        </h2>


        <p class="home-section-description">

            Beberapa nilai indikator berdasarkan
            periode data terbaru yang tersedia.

        </p>


        <div class="latest-card">


            <div class="latest-header">


                <div class="latest-title">

                    Indikator Terbaru

                </div>


                <a
                    href="{{ route(
                        'kelompok.index'
                    ) }}"
                    class="latest-link"
                >

                    Lihat seluruh data

                    <i
                        class="
                            bi
                            bi-arrow-right
                            ms-1
                        "
                    ></i>

                </a>


            </div>


            <div class="table-responsive">


                <table class="latest-table">


                    <thead>

                        <tr>

                            <th>
                                Indikator
                            </th>

                            <th>
                                Nilai
                            </th>

                            <th>
                                Satuan
                            </th>

                            <th>
                                Tahun
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach(
                            $indikatorTerbaru
                            as $item
                        )


                            @php

                                $indikator =
                                    $item[
                                        'indikator'
                                    ];

                                $data =
                                    $item[
                                        'data'
                                    ];

                            @endphp


                            <tr>


                                <td>

                                    <div
                                        class="
                                            latest-indicator-name
                                        "
                                    >

                                        {{ $indikator->nama_indikator }}

                                    </div>

                                </td>


                                <td>

                                    <span
                                        class="
                                            latest-value
                                        "
                                    >

                                        @if(
                                            $indikator->tipe_data
                                            === 'angka'
                                        )

                                            {{ number_format(
                                                $data->nilai,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        @else

                                            {{ number_format(
                                                $data->nilai,
                                                2,
                                                ',',
                                                '.'
                                            ) }}

                                        @endif

                                    </span>

                                </td>


                                <td>

                                    <span
                                        class="
                                            latest-unit
                                        "
                                    >

                                        {{ $indikator->satuan }}

                                    </span>

                                </td>


                                <td>

                                    <span
                                        class="
                                            latest-year
                                        "
                                    >

                                        @if(
                                            optional($data->periode)->frekuensi === 'bulanan'
                                        )
                                            {{ optional($data->periode)->nama_periode }}
                                        @else
                                            {{ optional($data->periode)->tahun }}
                                        @endif

                                    </span>

                                </td>


                            </tr>


                        @endforeach


                    </tbody>


                </table>


            </div>


        </div>


        {{-- CATATAN --}}

        <div class="simulation-note">


            <i
                class="
                    bi
                    bi-info-circle-fill
                    me-1
                "
            ></i>


            <strong>
                Catatan pengembangan:
            </strong>


            data yang ditampilkan pada Dashboard WIN
            bersumber dari basis data indikator yang
            telah diintegrasikan ke dalam sistem.
            Periode data mengikuti ketersediaan data
            pada basis data WIN.


        </div>


    </section>


</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /* =====================================================
           CHART — SINKRON DENGAN DATA DETAIL INDIKATOR
        ====================================================== */

        const chartData = @json($chartData);

        const select =
            document.getElementById('indicatorSelect');

        const canvas =
            document.getElementById('indicatorTrendChart');

        const subtitle =
            document.getElementById('chartSubtitle');

        let trendChart = null;

        if (select && canvas) {

            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April',
                'Mei', 'Juni', 'Juli', 'Agustus',
                'September', 'Oktober', 'November', 'Desember'
            ];

            function formatNumber(value, data) {
                const tipe = String(data?.tipe || '').toLowerCase();
                const satuan = String(data?.satuan || '').trim().toLowerCase();

                const decimals =
                    ['persentase', 'desimal', 'angka_desimal', 'decimal'].includes(tipe)
                    || ['indeks', 'rasio', 'malam', 'perjalanan'].includes(satuan)
                        ? 2
                        : 0;

                return new Intl.NumberFormat(
                    'id-ID',
                    {
                        minimumFractionDigits: decimals,
                        maximumFractionDigits: decimals
                    }
                ).format(value);
            }

            function isMonthly(data) {
                return Boolean(data?.bulanan);
            }

            function sortedRows(data) {
                return [...(data?.data || [])].sort(function (a, b) {
                    const ak = `${a.year}-${String(a.month ?? 0).padStart(2, '0')}`;
                    const bk = `${b.year}-${String(b.month ?? 0).padStart(2, '0')}`;

                    return ak.localeCompare(bk);
                });
            }

            function hasCategories(rows) {
                return rows.some(function (row) {
                    return row.category !== null
                        && row.category !== undefined
                        && String(row.category).trim() !== '';
                });
            }

            function buildPayload(data) {

                const rows = sortedRows(data);
                const bulanan = isMonthly(data);
                const berkategori = hasCategories(rows);

                if (berkategori) {

                    const categories = [
                        ...new Set(
                            rows
                                .map(row => row.category)
                                .filter(Boolean)
                        )
                    ];

                    if (bulanan) {
                        const periods = [
                            ...new Set(
                                rows.map(row => row.period)
                            )
                        ];

                        return {
                            labels: periods,
                            datasets: categories.map(function (category) {
                                return {
                                    label: category,
                                    data: periods.map(function (period) {
                                        const row = rows.find(function (item) {
                                            return item.period === period
                                                && item.category === category;
                                        });

                                        return row ? row.value : null;
                                    }),
                                    borderWidth: 3,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    tension: 0.35,
                                    fill: false
                                };
                            })
                        };
                    }

                    const years = [
                        ...new Set(rows.map(row => row.year))
                    ].sort((a, b) => a - b);

                    return {
                        labels: years,
                        datasets: categories.map(function (category) {
                            return {
                                label: category,
                                data: years.map(function (year) {
                                    const row = rows.find(function (item) {
                                        return item.year === year
                                            && item.category === category;
                                    });

                                    return row ? row.value : null;
                                }),
                                borderWidth: 1,
                                borderRadius: 4
                            };
                        })
                    };
                }

                if (bulanan) {
                    return {
                        labels: rows.map(function (row) {
                            return row.period;
                        }),
                        datasets: [{
                            label: data.nama,
                            data: rows.map(row => row.value),
                            borderWidth: 3,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.35,
                            fill: false
                        }]
                    };
                }

                return {
                    labels: rows.map(row => row.year),
                    datasets: [{
                        label: data.nama,
                        data: rows.map(row => row.value),
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                };
            }

            function updateChart(slug) {

                const data = chartData[slug];

                if (!data) {
                    return;
                }

                subtitle.textContent =
                    data.nama + ' · ' + data.satuan;

                if (trendChart) {
                    trendChart.destroy();
                }

                // Untuk indikator bulanan, default grafik hanya menampilkan
                // bulan-bulan pada tahun terakhir yang tersedia.
                // Indikator tahunan tetap menampilkan seluruh riwayat tahun.
                let displayData = data;

                if (isMonthly(data) && data.data && data.data.length) {
                    const latestYear = Math.max(
                        ...data.data.map(row => Number(row.year))
                    );

                    displayData = {
                        ...data,
                        data: data.data.filter(function (row) {
                            return Number(row.year) === latestYear;
                        })
                    };
                }

                const payload = buildPayload(displayData);
                const berkategori = payload.datasets.length > 1;
                const bulanan = isMonthly(displayData);

                trendChart = new Chart(
                    canvas,
                    {
                        type: 'line',

                        data: {
                            labels: payload.labels,
                            datasets: payload.datasets
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,

                            animation: {
                                duration: 700,
                                easing: 'easeOutQuart'
                            },

                            interaction: {
                                intersect: false,
                                mode: 'index'
                            },

                            plugins: {

                                legend: {
                                    display: berkategori,
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 18
                                    }
                                },

                                tooltip: {
                                    callbacks: {

                                        title: function (items) {
                                            if (!items.length) {
                                                return '';
                                            }

                                            return items[0].label;
                                        },

                                        label: function (context) {
                                            return ' '
                                                + context.dataset.label
                                                + ': '
                                                + formatNumber(
                                                    context.raw,
                                                    data
                                                )
                                                + ' '
                                                + data.satuan;
                                        }
                                    }
                                }
                            },

                            scales: {

                                x: {
                                    grid: {
                                        display: false
                                    },

                                    ticks: {
                                        color: '#64748b',
                                        font: {
                                            size: 11
                                        },

                                        autoSkip: true,

                                        maxTicksLimit:
                                            bulanan ? 24 : 10,

                                        maxRotation:
                                            bulanan ? 45 : 0,

                                        minRotation:
                                            bulanan ? 45 : 0
                                    }
                                },

                                y: {

                                    beginAtZero: false,

                                    grid: {
                                        color:
                                            'rgba(148,163,184,.15)'
                                    },

                                    ticks: {
                                        color: '#64748b',

                                        font: {
                                            size: 11
                                        },

                                        callback: function (value) {
                                            return formatNumber(
                                                value,
                                                data
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                );
            }

            updateChart(select.value);

            select.addEventListener(
                'change',
                function () {
                    updateChart(this.value);
                }
            );
        }

        /* =====================================================
           COUNT UP
        ====================================================== */

        const countElements =
            document.querySelectorAll(
                '[data-count-value]'
            );


        function animateCount(
            element
        ) {


            const target =
                parseFloat(
                    element.dataset.countValue
                );


            const type =
                element.dataset.countType;


            if (
                !Number.isFinite(target)
            ) {

                return;

            }


            const duration =
                1000;


            const startTime =
                performance.now();


            function step(
                currentTime
            ) {


                const progress =
                    Math.min(
                        (
                            currentTime -
                            startTime
                        ) / duration,
                        1
                    );


                const eased =
                    1 -
                    Math.pow(
                        1 - progress,
                        3
                    );


                const current =
                    target *
                    eased;


                const decimals =
                    type === 'angka'
                        ? 0
                        : 2;


                element.textContent =
                    new Intl.NumberFormat(
                        'id-ID',
                        {
                            minimumFractionDigits:
                                decimals,

                            maximumFractionDigits:
                                decimals
                        }
                    ).format(
                        current
                    );


                if (
                    progress < 1
                ) {

                    requestAnimationFrame(
                        step
                    );

                }

            }


            requestAnimationFrame(
                step
            );

        }


        setTimeout(
            function () {


                countElements.forEach(
                    function (
                        element
                    ) {

                        animateCount(
                            element
                        );

                    }
                );


            },
            350
        );


    }
);

</script>

@endsection