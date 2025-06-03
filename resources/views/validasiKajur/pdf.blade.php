<!DOCTYPE html>
<html>

<head>
    <title>Preview Detail Kriteria PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
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
    </style>
</head>

<body>
    <h2>Detail Kriteria: {{ $detail->kriteria->nama_kriteria ?? '-' }}</h2>

    <table>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($detail->status) ?? '-' }}</td>
        </tr>
        <tr>
            <th>Komentar</th>
            <td>{{ $detail->komentar->komentar ?? 'Belum ada komentar' }}</td>
        </tr>
    </table>

    @foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $bagian)
        <h2>{{ ucfirst($bagian) }}</h2>

        <p><strong>Deskripsi:</strong></p>
        <p>{!! $bagianData[$bagian]['deskripsi'] !!}</p>

        <p><strong>Gambar Pendukung:</strong></p>
        <div>
            {!! $bagianData[$bagian]['pendukung'] !!}
        </div>
        <hr>
    @endforeach



</body>

</html>
