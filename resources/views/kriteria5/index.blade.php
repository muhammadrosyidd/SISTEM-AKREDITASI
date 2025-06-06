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
    <link rel="stylesheet" href="{{ asset('assets/css/kriteria.css')}}" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('layouts.sidebar')

    <main
        class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-2">
                <nav aria-label="breadcrumb">
                    <ol
                        class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a
                                class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-dark active"
                            aria-current="page">Kriteria 5</li>
                    </ol>
                </nav>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div
                            class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Daftar Kriteria</h6>
                            @if (auth()->user()->role->role_kode === 'A5')
    <a href="{{ route('kriteria.5.input') }}" class="btn btn-sm btn-success">
        <i class="fas fa-plus me-1"></i> Input Kriteria
    </a>
@endif
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="px-3 mt-3">
                                @if (session('success'))
                                <div
                                    class="alert alert-success alert-dismissible fade show"
                                    role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close"
                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                @if (session('error'))
                                <div
                                    class="alert alert-danger alert-dismissible fade show"
                                    role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close"
                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                            </div>
                            <div class="table-responsive p-3">
                                <table class="table align-items-center mb-0"
                                    id="table_detail_kriteria" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                width="10%">ID</th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                width="40%">Nama Kriteria</th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center"
                                                width="20%">Status</th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center"
                                                width="30%">Aksi</th>
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

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modalContent">
                <!-- Konten akan dimuat di sini -->
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Memuat data...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Hapus</h5>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="deleteConfirmBtn">Ya,
                        Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript"
        src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        var dataDetail;
        const base_url = "{{ url('kriteria5') }}";
        let deleteId = null;

        // Fungsi untuk memuat detail dan menampilkan modal
        function showDetail(id) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            const modalContent = document.getElementById('modalContent');

            // Tampilkan loading spinner
            modalContent.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Memuat data...</p>
                </div>
            `;

            // Tampilkan modal
            modal.show();

            // Load konten dari server
            fetch(`${base_url}/${id}/show`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    modalContent.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalContent.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Gagal memuat data. Silakan coba lagi.
                        </div>
                    `;
                });
        }

        // Fungsi untuk konfirmasi hapus
        // Modal Konfirmasi Hapus
document.addEventListener('DOMContentLoaded', function() {
    const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    
    // Fungsi untuk konfirmasi hapus
    window.confirmDelete = function(id) {
        deleteId = id;
        confirmDeleteModal.show();
    }
    
    // Tombol "Batal" diklik
    document.querySelector('#confirmDeleteModal .btn-secondary').addEventListener('click', function() {
        confirmDeleteModal.hide();
    });
    
    // Tombol "Ya, Hapus" diklik
    document.getElementById('deleteConfirmBtn').addEventListener('click', function() {
        if (!deleteId) return;

        // Buat form untuk submit DELETE
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `${base_url}/${deleteId}`;

        // CSRF token input
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Spoof method DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
        
        confirmDeleteModal.hide();
    });
});
        
        // Tombol "Ya, Hapus" diklik
        document.getElementById('deleteConfirmBtn').addEventListener('click', function () {
            if (!deleteId) return;

            // Buat form untuk submit DELETE
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `${base_url}/${deleteId}`;

            // CSRF token input
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            // Spoof method DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        });

        $(document).ready(function () {
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = { damping: '0.5' };
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }

            dataDetail = $('#table_detail_kriteria').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('kriteria.5.list') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center align-middle",
                        orderable: false,
                        searchable: false,
                        width: "10%",
                        render: function (data) {
                            return `<span class="text-xs font-weight-bold">${data}</span>`;
                        }
                    },
                    {
                        data: "kriteria.nama_kriteria",
                        className: "align-middle",
                        width: "40%",
                        render: function (data) {
                            return `
                                <div class="d-flex align-items-center">
                                    <span class="text-truncate text-xs font-weight-normal" style="max-width: 100%; display: inline-block;" title="${data}">
                                        ${data}
                                    </span>
                                </div>
                            `;
                        }
                    },
                    {
                        data: "status",
                        className: "text-center align-middle",
                        width: "20%",
                        render: function (data) {
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
                        data: "aksi",
                        className: "text-center align-middle",
                        orderable: false,
                        searchable: false,
                        width: "30%",
                    render: function (data, type, row, meta) {
                    const id = row.id_detail_kriteria;
                    const isEditable = (row.status === 'save' || row.status === 'revisi');
                    const userRole = "{{ Auth::user()->role->role_kode }}";

                        let buttons = `
        <div class="btn-action-group d-flex justify-content-center">
            <button class="btn btn-info btn-sm" onclick="showDetail(${row.id_detail_kriteria})" title="Detail">
                <i class="fas fa-eye fa-xs"></i> Detail
            </button>
    `;

    if (userRole === 'A5') {  // Check role A1 untuk tombol Edit dan Hapus
        buttons += `
            <a href="${base_url}/${row.id_detail_kriteria}/edit" class="btn btn-warning btn-sm ${isEditable ? '' : 'disabled'}" title="Edit">
                <i class="fas fa-edit fa-xs"></i> Edit
            </a>
            <button class="btn btn-danger btn-sm" onclick="confirmDelete(${row.id_detail_kriteria})" title="Hapus">
                <i class="fas fa-trash fa-xs "></i> Hapus
            </button>
        `;
    }

    buttons += `</div>`;
    return buttons;
                }
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json",
                    info: "_TOTAL_ data",
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
                initComplete: function () {
                    const api = this.api();
                    if (api.page.info().pages <= 1) {
                        $(api.table().container()).find('.dataTables_info, .dataTables_paginate').hide();
                    }
                },
                drawCallback: function () {
                    const api = this.api();
                    if (api.page.info().pages <= 1) {
                        $(api.table().container()).find('.dataTables_info, .dataTables_paginate').hide();
                    } else {
                        $(api.table().container()).find('.dataTables_info, .dataTables_paginate').show();
                    }
                }
            });
        });
    </script>
</body>

</html>
