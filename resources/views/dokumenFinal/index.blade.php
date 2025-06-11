<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/polinema_logo.png" />
    <title>Dokumen Final</title>

    <!-- Fonts and icons -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />

    <!-- CSS Files -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <style>
/* Badge transparan success */
.badge-button-success {
    background-color: #28a745; /* hijau success (bisa pakai #198754 juga kalau mau Bootstrap 5) */
    color: #fff;
    padding: 0.5em 1.2em; /* lebar biar kayak button */
    font-size: 0.85em;
    font-weight: 600;
    border-radius: 0.5rem; /* rounded */
    display: inline-block;
    white-space: nowrap;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
}

.badge-button-success:hover {
    background-color: #218838; /* hover lebih gelap */
    cursor: default; /* biar nggak kayak link */
}


/* Table cell padding */
table#dokumenFinalTable td, 
table#dokumenFinalTable th {
    padding: 0.75rem 1rem !important;
    vertical-align: middle;
}

/* Tombol Action */
.btn-action-group .btn {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
    border-radius: 0.375rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    transition: all 0.2s ease-in-out;
}

.btn-action-group .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
}

/* Optional: bikin datatables pagination lebih smooth */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.25rem 0.6rem;
    margin: 0 0.1rem;
    border-radius: 0.375rem;
    font-size: 0.8rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background-color: #6f42c1 !important; /* ungu yang kamu pakai */
    color: #fff !important;
    border: none;
}

/* Responsive tweaks (optional) */
@media (max-width: 768px) {
    .btn-action-group {
        flex-direction: column;
        gap: 0.4rem;
    }
}
</style>

</head>

<body class="g-sidenav-show bg-gray-100">

    @include('layouts.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dokumen Final</li>
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
                            <h6 class="mb-0">Daftar Dokumen Final</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-3">
                                <table id="dokumenFinalTable" class="table table-bordered mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Batch</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Status</th>
                                            <th>Action</th>
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

    <!-- Modal Preview PDF -->
    <div class="modal fade" id="previewPdfModal" tabindex="-1" aria-labelledby="previewPdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewPdfModalLabel">Preview Dokumen Final</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" src="" style="width:100%; height:80vh;" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap BUNDLE (includes Popper + Modal support) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Smooth scrollbar etc (optional, untuk corporate template) -->
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>

    <!-- Script DataTables & Modal Preview -->
    <script>
    $(document).ready(function() {
        $('#dokumenFinalTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dokumenFinal.list') }}",
                type: "POST",
                data: function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
           columns: [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
    { data: 'nama_pengisian', name: 'nama_pengisian' },
    { data: 'tanggal', name: 'tanggal' },
    {
        data: 'status',
        name: 'status',
        render: function(data, type, row) {
            return '<span class="badge badge-button-success">' + data + '</span>';
        },
        orderable: false,
        searchable: false
    },
    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
],

            order: [[2, 'desc']]
        });

        // Handle Preview button click
        $(document).on('click', '.btn-preview-pdf', function() {
            var pdfUrl = $(this).data('url');

            // Set iframe ke kosong dulu, tampilkan spinner
            $('#pdfIframe').attr('src', '');
            $('#pdfIframe').parent().append('<div id="pdfLoading" class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

            var previewModal = new bootstrap.Modal(document.getElementById('previewPdfModal'), {
                backdrop: 'static',
                keyboard: true
            });
            previewModal.show();

            // Setelah modal show, set iframe src → PDF load
            setTimeout(function() {
                $('#pdfIframe').on('load', function() {
                    $('#pdfLoading').remove();
                });
                $('#pdfIframe').attr('src', pdfUrl);
            }, 300);
        });

        // Clear iframe when modal closed
        $('#previewPdfModal').on('hidden.bs.modal', function () {
            $('#pdfIframe').attr('src', '');
        });
    });
    </script>

</body>
</html>
