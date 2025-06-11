<!DOCTYPE html>
<html>
<head>
    <title>Preview Dokumen Akreditasi</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 13px;
            margin: 60px;
            color: #000;
        }

        .cover {
            text-align: center;
            margin-top: 100px;
            page-break-after: always;
        }

        .cover img {
            width: 300px;
            height: auto;
            margin: 40px 0;
        }

        .cover h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .cover h2 {
            font-size: 18px;
            margin: 5px 0 30px 0;
            font-weight: normal;
        }

        .footer {
            text-align: center;
            margin-top: 80px;
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            font-size: 13px;
        }

        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            width: 20%;
        }

        h3 {
            font-size: 16px;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        p {
            margin: 5px 0;
            text-align: justify;
        }

        .section {
            margin-bottom: 30px;
        }

        hr {
            border: none;
            border-top: 1px solid #999;
            margin: 40px 0;
        }

        .gambar-pendukung {
            margin-top: 10px;
        }

        .gambar-pendukung img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
            padding: 6px;
            margin-top: 10px;
            display: block;
        }
    </style>
</head>
<body>

    <!-- COVER HALAMAN DEPAN -->
    <div class="cover">
        <h1>PEDOMAN PENYUSUNAN DOKUMEN AKREDITASI</h1>

        <img src="{{ public_path('images/logo-polinema.jpg') }}" alt="Logo Polinema">

        <h2>Detail Kriteria: {{ $detail->kriteria->nama_kriteria ?? '-' }}</h2>

        <div class="footer">
            POLITEKNIK NEGERI MALANG<br>
            TAHUN {{ date('Y') }}<br>
            Jl. Soekarno Hatta No.9 65141 Malang Jawa Timur<br>
        </div>
    </div>

    <!-- ISI DOKUMEN -->

    @foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $bagian)
        <div class="section">
            <h3>{{ ucfirst($bagian) }}</h3>

            <p><strong>Deskripsi:</strong></p>
            <p>{!! $bagianData[$bagian]['deskripsi'] !!}</p> 

            <p><strong>Gambar Pendukung:</strong></p>
            <div class="gambar-pendukung">
                {!! $bagianData[$bagian]['pendukung'] !!}
            </div>
        </div>
        <hr>
    @endforeach

</body>
</html>
