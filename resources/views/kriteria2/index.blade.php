<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

  <link rel="stylesheet" href="{{ asset('assets/css/kriteria.css') }}">
  <title>Kriteria 1 - Corporate UI</title>

  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="{{ asset('assets/css/corporate-ui-dashboard.css?v=1.0.0') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  @include('layouts.sidebar')

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="#">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Kriteria</li>
          </ol>
          <h6 class="font-weight-bold mb-0">Kriteria 1</h6>
        </nav>
      </div>
    </nav>
    <!-- End Navbar -->

    <div class="container-fluid py-4 px-5">
      <div class="row">
        <div class="col-12">
          <div class="card border shadow-xs mb-4">
            <div class="custom-form-section p-4">
              <h4 class="form-title text-right mb-4">Kriteria 1 - Statuta POLINEMA</h4>

              <form method="POST" action="{{ url('/kriteria1') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="penetapan" class="form-label">Penetapan</label>
                    <input type="text" name="penetapan" id="penetapan" class="form-control @error('penetapan') is-invalid @enderror" value="{{ old('penetapan') }}" placeholder="Masukkan penetapan">
                    @error('penetapan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="pelaksanaan" class="form-label">Pelaksanaan</label>
                    <input type="text" name="pelaksanaan" id="pelaksanaan" class="form-control @error('pelaksanaan') is-invalid @enderror" value="{{ old('pelaksanaan') }}" placeholder="Masukkan pelaksanaan">
                    @error('pelaksanaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="evaluasi" class="form-label">Evaluasi</label>
                    <input type="text" name="evaluasi" id="evaluasi" class="form-control @error('evaluasi') is-invalid @enderror" value="{{ old('evaluasi') }}" placeholder="Masukkan evaluasi">
                    @error('evaluasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="pengendalian" class="form-label">Pengendalian</label>
                    <input type="text" name="pengendalian" id="pengendalian" class="form-control @error('pengendalian') is-invalid @enderror" value="{{ old('pengendalian') }}" placeholder="Masukkan pengendalian">
                    @error('pengendalian')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="peningkatan" class="form-label">Peningkatan</label>
                    <input type="text" name="peningkatan" id="peningkatan" class="form-control @error('peningkatan') is-invalid @enderror" value="{{ old('peningkatan') }}" placeholder="Masukkan peningkatan">
                    @error('peningkatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="pendukung" class="form-label">Pendukung (Upload Gambar)</label>
                    <input type="file" name="pendukung" id="pendukung" class="form-control @error('pendukung') is-invalid @enderror" accept="image/*">
                    @error('pendukung')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="mt-4 text-end">
                  <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/popperr.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bbootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
      var win = navigator.platform.indexOf('Win') > -1;
      if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
          damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
      }
    </script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('assets/js/corporate-ui-dashboard.min.js?v=1.0.0') }}"></script>
  </main>
</body>

</html>
