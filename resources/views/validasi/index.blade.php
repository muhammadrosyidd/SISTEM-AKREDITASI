<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />

    <!-- Fonts and icons -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />

    <!-- CSS Files -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('layouts.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                                href="javascript:;">Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Validasi Kriteria</li>
                    </ol>
                </nav>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Daftar Kriteria untuk Validasi</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center mb-0" id="table_detail_kriteria"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                width="10%">ID</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                width="35%">Nama Kriteria</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                width="20%">Tanggal</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center"
                                                width="15%">Status</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center"
                                                width="20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        const base_url = "{{ url('validasi') }}";

        $(document).ready(function() {
            $('#table_detail_kriteria').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('validasi.list') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center align-middle",
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<span class="text-xs font-weight-bold">${data}</span>`;
                        }
                    },
                    {
                        data: "nama_kriteria",
                        className: "align-middle",
                        render: function(data, type, row) {
                            return `<span class="text-xs font-weight-normal" title="${data}">${data}</span>`;
                        }
                    },
                    {
                        data: "tanggal",
                        className: "align-middle",
                        render: function(data) {
                            const options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            };
                            const dateObj = new Date(data);
                            return `<span class="text-xs">${dateObj.toLocaleDateString('id-ID', options)}</span>`;
                        }
                    },
                    {
                        data: "status",
                        className: "text-center align-middle",
                        render: function(data) {
                            let badgeStyle = '';
                            let displayText = '';
                            switch (data) {
                                case 'save':
                                    badgeStyle = 'background-color:#6c757d; color:white';
                                    displayText = 'Draft';
                                    break;
                                case 'submitted':
                                    badgeStyle = 'background-color:#0d6efd; color:white';
                                    displayText = 'Submitted';
                                    break;
                                case 'revisi':
                                    badgeStyle = 'background-color:#ffc107; color:#212529';
                                    displayText = 'Revisi';
                                    break;
                                case 'acc1':
                                    badgeStyle = 'background-color:#198754; color:white';
                                    displayText = 'Disetujui';
                                    break;
                                case 'acc2':
                                    badgeStyle = 'background-color:#0dcaf0; color:white';
                                    displayText = 'Final';
                                    break;
                                default:
                                    badgeStyle = 'background-color:#6c757d; color:white';
                                    displayText = data;
                            }
                            return `<span class="badge" style="${badgeStyle}">${displayText}</span>`;
                        }
                    },
                    {
                        data: null,
                        className: "text-center align-middle",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <a href="${base_url}/${row.id}/validasi" class="btn btn-success btn-sm" title="Validasi">
                                    <i class="fas fa-check"></i> Validasi
                                </a>
                            `;
                        }
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json",
                    info: "TOTAL data",
                    infoEmpty: "",
                    infoFiltered: "",
                    paginate: {
                        first: "",
                        last: "",
                        next: "",
                        previous: ""
                    }
                },
                dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
                initComplete: function() {
                    const api = this.api();
                    if (api.page.info().pages <= 1) {
                        $(api.table().container()).find('.dataTables_info, .dataTables_paginate')
                            .hide();
                    }
                },
                drawCallback: function() {
                    const api = this.api();
                    if (api.page.info().pages <= 1) {
                        $(api.table().container()).find('.dataTables_info, .dataTables_paginate')
                            .hide();
                    } else {
                        $(api.table().container()).find('.dataTables_info, .dataTables_paginate')
                            .show();
                    }
                }
            });
        });
    </script>
</body>

</html>
