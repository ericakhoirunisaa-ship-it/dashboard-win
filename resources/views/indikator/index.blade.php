<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Indikator Strategis — WIN
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            background: #f4f7ff;
            color: #172554;
            font-family:
                Inter,
                system-ui,
                -apple-system,
                "Segoe UI",
                sans-serif;
        }

        .container-win {
            max-width: 1120px;
            margin: auto;
        }

        .top {
            padding: 45px 0 25px;
        }

        .back {
            color: #1769e0;
            font-size: 13px;
            font-weight: 600;
        }

        .title {
            margin-top: 18px;
            font-size: 30px;
            font-weight: 800;
        }

        .subtitle {
            color: #8194b8;
            font-size: 14px;
            margin-top: 7px;
        }

        .group {
            margin-top: 30px;
        }

        .group-title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .indicator-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .indicator {
            background: white;
            border: 1px solid #d9e4f6;
            border-radius: 14px;
            padding: 19px;
            transition: .2s;
        }

        .indicator:hover {
            transform: translateY(-3px);
            box-shadow:
                0 12px 25px rgba(35,70,130,.08);
            border-color: #b9cdef;
        }

        .indicator-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #edf4ff;
            color: #1769e0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .indicator-name {
            font-size: 14px;
            font-weight: 700;
            line-height: 1.45;
        }

        .indicator-unit {
            margin-top: 6px;
            color: #8496b7;
            font-size: 11px;
        }

        .indicator-link {
            display: inline-block;
            margin-top: 15px;
            color: #1769e0;
            font-size: 11px;
            font-weight: 700;
        }

        @media(max-width: 800px) {

            .indicator-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }

        @media(max-width: 550px) {

            .container-win {
                padding: 0 18px;
            }

            .indicator-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>

<div class="container-win">


    <div class="top">

        <a
            href="{{ route('home') }}"
            class="back"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke Beranda
        </a>

        <div class="title">
            Indikator Strategis
        </div>

        <div class="subtitle">
            Jelajahi indikator strategis Kabupaten Wonosobo
            berdasarkan kelompok bidang.
        </div>

    </div>


    @foreach($kelompok as $item)

        <section class="group">

            <div class="group-title">
                {{ $item->nama_kelompok }}
            </div>


            <div class="indicator-grid">

                @foreach($item->indikator as $indikator)

                    <a
                        href="{{ route('indikator.show', $indikator->slug) }}"
                        class="indicator"
                    >

                        <div class="indicator-icon">

                            <i class="bi bi-bar-chart-fill"></i>

                        </div>


                        <div class="indicator-name">

                            {{ $indikator->nama_indikator }}

                        </div>


                        <div class="indicator-unit">

                            Satuan:
                            {{ $indikator->satuan }}

                        </div>


                        <div class="indicator-link">

                            Lihat detail
                            <i class="bi bi-arrow-right"></i>

                        </div>

                    </a>

                @endforeach

            </div>

        </section>

    @endforeach


</div>

</body>

</html>