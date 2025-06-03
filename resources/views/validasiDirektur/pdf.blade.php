<!DOCTYPE html>
<html>
<head>
    <title>Preview Detail Kriteria PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2, h3 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background-color: #eee; }
        a {color: blue; text-decoration: underline;}
        p[style*="text-align:center"] {
            text-align: center;
        }
        hr { margin: 40px 0; border: 0; border-top: 1px solid #ccc; }
        .section-title {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 14pt;
            text-transform: capitalize;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Detail Kriteria Batch: {{ $batch->nama_pengisian ?? '-' }}</h1>
    <p style="text-align:center; margin-bottom: 30px;">
        Tanggal: {{ $batch->created_at ? \Carbon\Carbon::parse($batch->created_at)->format('d M Y') : '-' }}
    </p>

    @foreach($details as $index => $detail)
        <h2>Kriteria {{ $index + 1 }}: {{ $detail->kriteria->nama_kriteria ?? '-' }}</h2>


        @php
            // Mengumpulkan data bagian untuk memudahkan looping
            $bagianData = [
                'penetapan' => $detail->penetapan ?? null,
                'pelaksanaan' => $detail->pelaksanaan ?? null,
                'evaluasi' => $detail->evaluasi ?? null,
                'pengendalian' => $detail->pengendalian ?? null,
                'peningkatan' => $detail->peningkatan ?? null,
            ];
        @endphp

        @foreach ($bagianData as $bagian => $data)
            <div class="section-title">{{ $bagian }}</div>

            @if ($data)
                <p><strong>Deskripsi:</strong></p>
                <p>{!! $data->deskripsi ?? '-' !!}</p>

                <p><strong>Gambar Pendukung:</strong></p>
                <div>
                    {!! $data->pendukung ?? '-' !!}
                </div>
            @else
                <p><em>Data {{ $bagian }} tidak tersedia.</em></p>
            @endif

            <hr>
        @endforeach
    @endforeach

</body>
</html>
