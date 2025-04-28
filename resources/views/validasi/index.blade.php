
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>
    Corporate UI by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
  @include('layouts.sidebar')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Validasi</li>
          </ol>
          <h6 class="font-weight-bold mb-0">Validasi</h6>
        </nav>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4 px-5">
      <div class="row">
        <div class="col-12">
          <div class="card border shadow-xs mb-4">
            
            <div class="card mb-4">
                <div class="card-header pb-0">
                  <h6>Daftar Kriteria untuk Divalidasi</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nama Kriteria</th>
                          <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                          <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">Status</th>
                          <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        {{-- @forelse ($kriterias as $kriteria)
                          <tr>
                            <td class="text-sm font-weight-normal">{{ $kriteria->nama_kriteria }}</td>
                            <td class="text-sm text-secondary">{{ \Carbon\Carbon::parse($kriteria->tanggal)->format('d/m/Y') }}</td>
                            <td class="text-sm text-center">
                              @if ($kriteria->status === 'belum')
                                <span class="badge bg-warning text-dark">Belum</span>
                              @else
                                <span class="badge bg-success">Sudah</span>
                              @endif
                            </td>
                            <td class="text-center">
                              <a href="{{ route('kriteria.validasi', $kriteria->id) }}" class="btn btn-sm btn-success">Validasi</a>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="4" class="text-center text-secondary">Tidak ada data kriteria</td>
                          </tr>
                        @endforelse --}}
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              <div class="border-top py-3 px-3 d-flex align-items-center">
                <p class="font-weight-semibold mb-0 text-dark text-sm">Page 1 of 10</p>
                <div class="ms-auto">
                  <button class="btn btn-sm btn-white mb-0">Previous</button>
                  <button class="btn btn-sm btn-white mb-0">Next</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
  <!--   Core JS Files   -->
  <script src="assets/js/core/popperr.min.js"></script>
  <script src="assets/js/core/bbootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Corporate UI Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/corporate-ui-dashboard.min.js?v=1.0.0"></script>
</body>

</html>