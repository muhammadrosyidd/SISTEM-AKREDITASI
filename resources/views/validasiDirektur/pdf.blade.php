<!DOCTYPE html>Add commentMore actions
<html>
<head>
    <title>Preview Detail Kriteria PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 30px;
        }
        h1, h2, h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
        }
        th {
            background-color: #eee;
        }
        a {
            color: blue;
            text-decoration: underline;
        }
        p[style*="text-align:center"] {
            text-align: center;
        }
        hr {
            margin: 40px 0;
            border: 0;
            border-top: 1px solid #ccc;
        }
        .section-title {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 14pt;
            text-transform: capitalize;
        }
        .image-container {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .image-container img {
            max-width: 300px;
            max-height: 300px;
            border: 1px solid #ddd;
            padding: 5px;
            background-color: #fafafa;
        }
        .fallback-text {
            text-align: center;
            font-style: italic;
            color: #999;
            margin: 10px 0;
        }
        .toc {
            margin-bottom: 40px;
        }
        .toc h2 {
            text-align: left;
            margin-bottom: 10px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }
        .toc ul {
            list-style-type: decimal;
            padding-left: 20px;
        }
        .toc ul li {
            margin-bottom: 5px;
        }
        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <h1>{{ $batch->nama_pengisian ?? '-' }}</h1>
    <p style="text-align:center; margin-bottom: 30px;">
        Tanggal: {{ $batch->created_at ? \Carbon\Carbon::parse($batch->created_at)->format('d M Y') : '-' }}
    </p>

    {{-- TOC --}}
    <div class="toc">
        <h2>Daftar Isi</h2>
        <ul>
            @foreach($details as $index => $detail)
                <li>
                    Kriteria {{ $index + 1 }}: {{ $detail->kriteria->nama_kriteria ?? '-' }}
                </li>
            @endforeach
        </ul>
    </div>

    {{-- CONTENT --}}
    @foreach($details as $index => $detail)
        {{-- Page Break Manual (jika mau per Kriteria 1 halaman, bisa aktifkan yang di bawah) --}}
        {{-- <div style="page-break-before: always;"></div> --}}

        <h2>Kriteria {{ $index + 1 }}: {{ $detail->kriteria->nama_kriteria ?? '-' }}</h2>

        @php
            // Siapkan data untuk looping
            $bagianData = [
                'penetapan' => [
                    'data' => $detail->penetapan ?? null,
                    'image' => $detail->penetapan_image ?? ''
                ],
                'pelaksanaan' => [
                    'data' => $detail->pelaksanaan ?? null,
                    'image' => $detail->pelaksanaan_image ?? ''
                ],
                'evaluasi' => [
                    'data' => $detail->evaluasi ?? null,
                    'image' => $detail->evaluasi_image ?? ''
                ],
                'pengendalian' => [
                    'data' => $detail->pengendalian ?? null,
                    'image' => $detail->pengendalian_image ?? ''
                ],
                'peningkatan' => [
                    'data' => $detail->peningkatan ?? null,
                    'image' => $detail->peningkatan_image ?? ''
                ],
            ];
        @endphp

        @foreach ($bagianData as $bagian => $bagianInfo)
            <div class="section-title">{{ ucfirst($bagian) }}</div>

            @if ($bagianInfo['data'])
                <p><strong>Deskripsi:</strong></p>
                <p>{!! $bagianInfo['data']->deskripsi ?? '-' !!}</p>

                <p><strong>Gambar Pendukung:</strong></p>
                <div class="image-container">
                    {!! $bagianInfo['image'] !!}
                </div>
            @else
                <p class="fallback-text">Data {{ $bagian }} tidak tersedia.</p>
            @endif

            <hr>
        @endforeach
    @endforeach

    {{-- FOOTER --}}
    <div class="footer">
        Page {PAGE_NUM} of {PAGE_COUNT}
    </div>

</body>
</html>