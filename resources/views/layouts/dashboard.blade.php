<!--
=========================================================
* Corporate UI - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/corporate-ui
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <title>
        Corporate UI by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Nucleo Icons -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
    <style>
        .navbar .fa-bell {
            font-size: 1.25rem;
            color: #4b5563;
        }

        .dropdown-menu .dropdown-header {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .dropdown-menu .dropdown-item {
            font-size: 0.875rem;
        }

        .dropdown-menu .text-secondary {
            font-size: 0.75rem;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('layouts.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                                href="javascript:;">Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
                    </ol>
                    <h6 class="font-weight-bold mb-0">Dashboard</h6>
                </nav>
                <!-- Notification Bell Dropdown -->
                <ul class="navbar-nav align-items-center ms-auto">
                    <li class="nav-item dropdown pe-3 d-flex align-items-center">
                        <a href="#" class="nav-link text-body p-0 position-relative" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            @if (!$notifications->isEmpty())
                                <span
                                    class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n3"
                            aria-labelledby="dropdownMenuButton" style="max-height: 300px; overflow-y: auto;">
                            <li>
                                <h6 class="dropdown-header text-uppercase font-weight-bold">Notifikasi</h6>
                            </li>
                            @if ($notifications->isEmpty())
                                <li class="dropdown-item text-sm text-muted">Tidak ada notifikasi baru.</li>
                            @else
                                @foreach ($notifications as $notification)
                                    <li class="dropdown-item border-bottom">
                                        <div class="d-flex flex-column">
                                            <span class="text-sm font-weight-bold">{{ $notification['message'] }}</span>
                                            <small
                                                class="text-xs text-secondary">{{ \Carbon\Carbon::parse($notification['created_at'])->format('d M Y H:i') }}</small>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-md-flex align-items-center mb-3 mx-2">
                        <div class="mb-md-0 mb-3">
                            <h3 class="font-weight-bold mb-0">Hello, TIM 4</h3>
                            <p class="mb-0">Ayo ndang dimarekno</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-0">
            <div class="row">
                <div class="position-relative overflow-hidden">
                    <div class="swiper mySwiper mt-4 mb-2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div>
                                    <a href="{{ route('kriteria.index') }}">
                                        <div
                                            class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                            <div class="full-background bg-cover"
                                                style="background-image: url('assets/img/img-2.jpg')"></div>
                                            <div class="card-body text-start px-3 py-0 w-100">
                                                <div class="row mt-12">
                                                    <div class="col-sm-3 mt-auto">
                                                        <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">
                                                            Name</p>
                                                        <h5 class="text-dark font-weight-bolder">VMTS</h5>
                                                    </div>
                                                    <div class="col-sm-3 ms-auto mt-auto">
                                                        <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">
                                                            Kriteria</p>
                                                        <h5 class="text-dark font-weight-bolder">1</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('assets/img/img-1.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Tata Kelola</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Kategori
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">2</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('assets/img/img-3.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Mahasiswa</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Kategori
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">3</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('assets/img/img-4.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Keuangan, Sarana, dan
                                                    Prasarana</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Kategori
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">4</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('assets/img/img-5.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Pendidikan</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Design</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('assets/img/img-1.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Penelitian</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Security</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
        <!--   Core JS Files   -->
        <script src="assets/js/core/popperr.min.js"></script>
        <script src="assets/js/core/bbootstrap.min.js"></script>
        <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
        <script src="assets/js/plugins/chartjs.min.js"></script>
        <script src="assets/js/plugins/swiper-bundle.min.js" type="text/javascript"></script>
        <script>
            if (document.getElementsByClassName('mySwiper')) {
                var swiper = new Swiper(".mySwiper", {
                    effect: "cards",
                    grabCursor: true,
                    initialSlide: 1,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            };


            var ctx = document.getElementById("chart-bars").getContext("2d");

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
                    datasets: [{
                            label: "Sales",
                            tension: 0.4,
                            borderWidth: 0,
                            borderSkipped: false,
                            backgroundColor: "#2ca8ff",
                            data: [450, 200, 100, 220, 500, 100, 400, 230, 500, 200],
                            maxBarThickness: 6
                        },
                        {
                            label: "Sales",
                            tension: 0.4,
                            borderWidth: 0,
                            borderSkipped: false,
                            backgroundColor: "#7c3aed",
                            data: [200, 300, 200, 420, 400, 200, 300, 430, 400, 300],
                            maxBarThickness: 6
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#1e293b',
                            bodyColor: '#1e293b',
                            borderColor: '#e9ecef',
                            borderWidth: 1,
                            usePointStyle: true
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            stacked: true,
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [4, 4],
                            },
                            ticks: {
                                beginAtZero: true,
                                padding: 10,
                                font: {
                                    size: 12,
                                    family: "Noto Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#64748B"
                            },
                        },
                        x: {
                            stacked: true,
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    family: "Noto Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#64748B"
                            },
                        },
                    },
                },
            });


            var ctx2 = document.getElementById("chart-line").getContext("2d");

            var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

            gradientStroke1.addColorStop(1, 'rgba(45,168,255,0.2)');
            gradientStroke1.addColorStop(0.2, 'rgba(45,168,255,0.0)');
            gradientStroke1.addColorStop(0, 'rgba(45,168,255,0)'); //blue colors

            var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

            gradientStroke2.addColorStop(1, 'rgba(119,77,211,0.4)');
            gradientStroke2.addColorStop(0.7, 'rgba(119,77,211,0.1)');
            gradientStroke2.addColorStop(0, 'rgba(119,77,211,0)'); //purple colors

            new Chart(ctx2, {
                plugins: [{
                    beforeInit(chart) {
                        const originalFit = chart.legend.fit;
                        chart.legend.fit = function fit() {
                            originalFit.bind(chart.legend)();
                            this.height += 40;
                        }
                    },
                }],
                type: "line",
                data: {
                    labels: ["Aug 18", "Aug 19", "Aug 20", "Aug 21", "Aug 22", "Aug 23", "Aug 24", "Aug 25", "Aug 26",
                        "Aug 27", "Aug 28", "Aug 29", "Aug 30", "Aug 31", "Sept 01", "Sept 02", "Sept 03", "Aug 22",
                        "Sept 04", "Sept 05", "Sept 06", "Sept 07", "Sept 08", "Sept 09"
                    ],
                    datasets: [{
                            label: "Volume",
                            tension: 0,
                            borderWidth: 2,
                            pointRadius: 3,
                            borderColor: "#2ca8ff",
                            pointBorderColor: '#2ca8ff',
                            pointBackgroundColor: '#2ca8ff',
                            backgroundColor: gradientStroke1,
                            fill: true,
                            data: [2828, 1291, 3360, 3223, 1630, 980, 2059, 3092, 1831, 1842, 1902, 1478, 1123,
                                2444, 2636, 2593, 2885, 1764, 898, 1356, 2573, 3382, 2858, 4228
                            ],
                            maxBarThickness: 6

                        },
                        {
                            label: "Trade",
                            tension: 0,
                            borderWidth: 2,
                            pointRadius: 3,
                            borderColor: "#832bf9",
                            pointBorderColor: '#832bf9',
                            pointBackgroundColor: '#832bf9',
                            backgroundColor: gradientStroke2,
                            fill: true,
                            data: [2797, 2182, 1069, 2098, 3309, 3881, 2059, 3239, 6215, 2185, 2115, 5430, 4648,
                                2444, 2161, 3018, 1153, 1068, 2192, 1152, 2129, 1396, 2067, 1215, 712, 2462,
                                1669, 2360, 2787, 861
                            ],
                            maxBarThickness: 6
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                boxWidth: 6,
                                boxHeight: 6,
                                padding: 20,
                                pointStyle: 'circle',
                                borderRadius: 50,
                                usePointStyle: true,
                                font: {
                                    weight: 400,
                                },
                            },
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#1e293b',
                            bodyColor: '#1e293b',
                            borderColor: '#e9ecef',
                            borderWidth: 1,
                            pointRadius: 2,
                            usePointStyle: true,
                            boxWidth: 8,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [4, 4]
                            },
                            ticks: {
                                callback: function(value, index, ticks) {
                                    return parseInt(value).toLocaleString() + ' EUR';
                                },
                                display: true,
                                padding: 10,
                                color: '#b2b9bf',
                                font: {
                                    size: 12,
                                    family: "Noto Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#64748B"
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [4, 4]
                            },
                            ticks: {
                                display: true,
                                color: '#b2b9bf',
                                padding: 20,
                                font: {
                                    size: 12,
                                    family: "Noto Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#64748B"
                            }
                        },
                    },
                },
            });
        </script>
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
