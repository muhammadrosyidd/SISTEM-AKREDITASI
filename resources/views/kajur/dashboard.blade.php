@php
    // --- Blok untuk mengambil data langsung dari database ---
    use App\Models\DetailKriteriaModel;
    use Carbon\Carbon;

    // 1. Mengambil data untuk kartu statistik
    $totalDokumen = DetailKriteriaModel::count();
    $dokumenBaru = DetailKriteriaModel::where('created_at', '>=', Carbon::now()->subWeek())->count();
    $submittedCount = DetailKriteriaModel::where('status', 'submitted')->count();
    $revisiCount = DetailKriteriaModel::where('status', 'revisi')->count();
    $selesaiCount = DetailKriteriaModel::whereIn('status', ['acc1', 'acc2'])->count();

    // 2. Menghitung persentase progres
    $progressPercentage = $totalDokumen > 0 ? ($selesaiCount / $totalDokumen) * 100 : 0;

    // 3. Menentukan status setiap kriteria (Lengkap / Dikerjakan)
    $allDetails = DetailKriteriaModel::all();
    $groupedByKriteria = $allDetails->groupBy('id_kriteria');
    $kriteriaLengkapIds = [];
    $kriteriaDikerjakanIds = [];

    foreach ($groupedByKriteria as $id => $details) {
        $isLengkap = $details->every(function ($item) {
            return in_array($item->status, ['acc1', 'acc2']);
        });

        if ($isLengkap) {
            $kriteriaLengkapIds[] = $id;
        } else {
            $kriteriaDikerjakanIds[] = $id;
        }
    }
    sort($kriteriaLengkapIds);
    sort($kriteriaDikerjakanIds);

    $kriteriaLengkap = !empty($kriteriaLengkapIds) ? implode(', ', $kriteriaLengkapIds) : 'N/A';
    $kriteriaDikerjakan = !empty($kriteriaDikerjakanIds) ? implode(', ', $kriteriaDikerjakanIds) : 'N/A';

    // 4. Mengambil 3 aktivitas terbaru
    $aktivitasTerbaru = DetailKriteriaModel::with('kriteria')->latest('updated_at')->take(3)->get();
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>
        Dashboard Kajur - Sistem Akreditasi
    </title>
    <!--     Fonts and icons     -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/corporate-ui-dashboard.css?v=1.0.0') }}" rel="stylesheet" />

    <style>
        .main-content {
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-animated {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
            animation-fill-mode: both;
        }

        .card.card-animated:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .row>.col-xl-3:nth-child(1) .card-animated {
            animation-delay: 0.1s;
        }

        .row>.col-xl-3:nth-child(2) .card-animated {
            animation-delay: 0.2s;
        }

        .row>.col-xl-3:nth-child(3) .card-animated {
            animation-delay: 0.3s;
        }

        .row>.col-xl-3:nth-child(4) .card-animated {
            animation-delay: 0.4s;
        }

        .row.mt-4>.col-lg-7 .card-animated {
            animation-delay: 0.5s;
        }

        .row.mt-4>.col-lg-5 .card-animated {
            animation-delay: 0.6s;
        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
                    </ol>
                    <h6 class="font-weight-bold mb-0">Dashboard Ketua Jurusan</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        {{-- Kosong, bisa untuk search bar --}}
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="sidenav-toggler">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            {{-- [PERBAIKAN] Menambahkan header --}}
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        <div class="me-auto">
                            <h3 class="font-weight-bold mb-0">Dashboard Ketua Jurusan</h3>
                            <p class="mb-0 text-secondary">Selamat datang! Berikut ringkasan status akreditasi jurusan
                                Anda.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Baris untuk Kartu Statistik --}}
            <div class="row">
                {{-- Card 1: Total Dokumen --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card card-animated">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Dokumen</p>
                                        <h5 class="font-weight-bolder">{{ $totalDokumen }} Dokumen</h5>
                                        <p class="mb-0">
                                            <span
                                                class="text-success text-sm font-weight-bolder">+{{ $dokumenBaru }}</span>
                                            sejak minggu lalu
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="bi bi-file-earmark-text text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Menunggu Validasi (Submitted) --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card card-animated">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Menunggu Validasi</p>
                                        <h5 class="font-weight-bolder">{{ $submittedCount }} Dokumen</h5>
                                        <p class="mb-0">
                                            <span class="text-warning text-sm font-weight-bolder">Perlu dicek</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="bi bi-hourglass-split text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Perlu Revisi --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card card-animated">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Perlu Revisi</p>
                                        <h5 class="font-weight-bolder">{{ $revisiCount }} Dokumen</h5>
                                        <p class="mb-0">
                                            <span class="text-danger text-sm font-weight-bolder">Dikembalikan</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="bi bi-exclamation-triangle text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Selesai (acc1 & acc2) --}}
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-animated">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Selesai Disetujui</p>
                                        <h5 class="font-weight-bolder">{{ $selesaiCount }} Dokumen</h5>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">Tervalidasi</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="bi bi-check2-circle text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Baris untuk Progress dan Aktivitas --}}
            <div class="row mt-4">
                {{-- Kolom Progress --}}
                <div class="col-lg-7 mb-lg-0 mb-4">
                    <div class="card h-100 card-animated">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize">Progress Pengerjaan Borang</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-arrow-up text-success"></i>
                                <span class="font-weight-bold">{{ number_format($progressPercentage, 0) }}%</span>
                                dari total
                            </p>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-3">
                                <span
                                    class="text-sm font-weight-bold">{{ number_format($progressPercentage, 0) }}%</span>
                                <div class="progress w-100 ms-2" style="height: 10px;">
                                    <div class="progress-bar bg-gradient-success"
                                        style="width: {{ $progressPercentage }}%;" role="progressbar"
                                        aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="text-sm">
                                <p class="mb-1"><i
                                        class="bi bi-check-circle-fill text-success me-2"></i><strong>Kriteria
                                        {{ $kriteriaLengkap }}</strong> sudah lengkap.</p>
                                <p class="mb-0"><i
                                        class="bi bi-hourglass-top text-warning me-2"></i><strong>Kriteria
                                        {{ $kriteriaDikerjakan }}</strong> sedang dalam pengerjaan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Aktivitas Terbaru --}}
                <div class="col-lg-5">
                    <div class="card h-100 card-animated">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">Aktivitas Terbaru Jurusan</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="timeline timeline-one-side">
                                @forelse($aktivitasTerbaru as $aktivitas)
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            @if ($aktivitas->status == 'submitted')
                                                <i class="bi bi-file-earmark-arrow-up text-info"></i>
                                            @elseif($aktivitas->status == 'revisi')
                                                <i class="bi bi-pencil-square text-warning"></i>
                                            @elseif(in_array($aktivitas->status, ['acc1', 'acc2']))
                                                <i class="bi bi-check-lg text-success"></i>
                                            @else
                                                <i class="bi bi-arrow-repeat text-secondary"></i>
                                            @endif
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">
                                                {{ $aktivitas->kriteria->nama_kriteria ?? 'Kriteria' }}
                                                <span class="font-weight-normal">telah di-update ke status</span>
                                                "{{ $aktivitas->status }}"
                                            </h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                {{ $aktivitas->updated_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-secondary">Belum ada aktivitas terbaru.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <!-- Control Center for Corporate UI Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/corporate-ui-dashboard.min.js?v=1.0.0') }}"></script>
</body>

</html>
