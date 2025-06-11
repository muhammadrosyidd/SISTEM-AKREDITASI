@php
    // --- Blok untuk mengambil data langsung dari database untuk Direktur ---
    use App\Models\DetailKriteriaModel;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    // Mengambil data untuk kartu statistik
    $totalDokumenInstitusi = DetailKriteriaModel::count();
    $approvalAndaCount = DetailKriteriaModel::where('status', 'acc1')->count();

    // Mengambil antrian validasi final (dokumen berstatus 'acc1')
    $antrianValidasi = DetailKriteriaModel::with('kriteria')
        ->where('status', 'acc1')
        ->latest('updated_at')
        ->take(5)
        ->get();

@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>
        Dashboard Direktur - Sistem Akreditasi
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

        .row>.col-md-6:nth-child(1) .card-animated {
            animation-delay: 0.1s;
        }

        .row>.col-md-6:nth-child(2) .card-animated {
            animation-delay: 0.2s;
        }

        .row.mt-4>.col-lg-12 .card-animated {
            animation-delay: 0.3s;
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
                    <h6 class="font-weight-bold mb-0">Dashboard Direktur</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        {{-- Kosong --}}
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
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        <div class="me-auto">
                            <h3 class="font-weight-bold mb-0">Dashboard Direktur</h3>
                            <p class="mb-0 text-secondary">Selamat datang! Berikut ringkasan progres akreditasi tingkat
                                institusi.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Baris untuk Kartu Statistik --}}
            <div class="row">
                {{-- [PERBAIKAN] Mengubah lebar kolom menjadi col-md-6 --}}
                <div class="col-md-6 mb-4">
                    <div class="card card-animated">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Dokumen</p>
                                        <h5 class="font-weight-bolder">{{ $totalDokumenInstitusi }} Dokumen</h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="bi bi-building text-lg opacity-10"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card card-animated">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Approval Anda</p>
                                        <h5 class="font-weight-bolder">{{ $approvalAndaCount }} Dokumen</h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="bi bi-pen text-lg opacity-10"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card card-animated">
                        <div class="card-header pb-0">
                            <h6>Antrian Validasi Final</h6>
                            <p class="text-sm">Dokumen yang telah disetujui Kajur</p>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-group">
                                @forelse ($antrianValidasi as $item)
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                <i class="bi bi-file-earmark-check text-white"></i>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">
                                                    {{ $item->kriteria->nama_kriteria ?? 'Kriteria' }}</h6>
                                                <span class="text-xs">Diajukan pada
                                                    {{ $item->updated_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <a href="{{ route('validasi.index') }}"
                                                class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                                    class="ni ni-bold-right" aria-hidden="true"></i></a>
                                        </div>
                                    </li>
                                @empty
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <p class="text-center text-secondary">Tidak ada antrian validasi.</p>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
</body>

</html>
