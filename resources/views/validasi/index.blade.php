<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Validasi Kriteria - Corporate UI</title>
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="{{ asset('assets/css/corporate-ui-dashboard.css?v=1.0.0') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background: #f8f9fb;
        }

        .main-content {
            background: #f8f9fb;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(94, 114, 228, 0.05);
        }

        #table_detail_kriteria th,
        #table_detail_kriteria td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        #table_detail_kriteria th {
            font-size: 1rem;
            font-weight: 700;
            background: transparent !important;
            color: #344767;
            border-bottom: 2px solid #e9ecef;
        }

        #table_detail_kriteria td {
            font-size: 0.97rem;
            padding-top: 0.45rem !important;
            padding-bottom: 0.45rem !important;
            height: 44px;
        }

        .badge-status-submitted {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            font-size: 1rem;
            font-weight: 500;
            padding: 6px 18px;
            border-radius: 12px;
            border: none;
            box-sizing: border-box;
        }

        .badge-status-revisi {
            display: inline-block;
            background: #f8d7da;
            color: #721c24;
            font-size: 1rem;
            font-weight: 500;
            padding: 6px 18px;
            border-radius: 12px;
            border: none;
            box-sizing: border-box;
        }

        .badge-status-acc1 {
            display: inline-block;
            background: #d4edda;
            color: #155724;
            font-size: 1rem;
            font-weight: 500;
            padding: 6px 18px;
            border-radius: 12px;
            border: none;
            box-sizing: border-box;
        }

        .badge-status-default {
            display: inline-block;
            background: #e2e3e5;
            color: #383d41;
            font-size: 1rem;
            font-weight: 500;
            padding: 6px 18px;
            border-radius: 12px;
            border: none;
            box-sizing: border-box;
        }

        .btn-validasi {
            display: inline-block;
            background: #7ed957;
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            padding: 6px 18px;
            border: none;
            border-radius: 12px;
            box-sizing: border-box;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            outline: none;
            text-align: center;
            text-decoration: none;
        }

        .btn-validasi:hover,
        .btn-validasi:focus {
            background: #5cbf2a;
            color: #fff;
        }

        .modal-zoom.fade:not(.show) .modal-dialog {
            transform: scale(0.8);
            transition: transform 0.3s ease-in-out;
        }

        .modal-zoom.show .modal-dialog {
            transform: scale(1);
            animation: modalZoomIn 0.3s ease-out;
        }

        @keyframes modalZoomIn {
            0% {
                transform: scale(0.7);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal.fade .modal-backdrop {
            opacity: 0;
            transition: opacity 0.15s linear;
        }

        .modal.show .modal-backdrop {
            opacity: 0.5;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            font-size: 0.96rem;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 0.3rem;
            display: flex;
            justify-content: center !important;
            align-items: center;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 5px;
            margin: 0 1px;
            font-weight: 500;
            border: none;
            background: #f8f9fa;
            color: #5e72e4 !important;
            transition: background 0.2s, color 0.2s;
            padding: 0.18em 0.7em;
            font-size: 0.92rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #5e72e4 !important;
            color: #fff !important;
            box-shadow: 0 2px 8px rgba(94, 114, 228, 0.08);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e9ecef;
            color: #5e72e4 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: #f8f9fa !important;
            color: #bbb !important;
            cursor: not-allowed !important;
        }

        .hide-pagination .dataTables_paginate {
            display: none !important;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('layouts.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="#">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Validasi Kriteria</li>
                    </ol>
                    <h6 class="font-weight-bold mb-0">Validasi Kriteria</h6>
                </nav>
            </div>
        </nav>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Daftar Kriteria untuk Validasi</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-2">
                                <table class="table align-items-center mb-0" id="table_detail_kriteria"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kriteria</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Data diisi otomatis oleh DataTables --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modal-container"></div>

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table_detail_kriteria').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('validasi.list') }}',
                order: [
                    [2, 'desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_kriteria',
                        name: 'kriteria.nama_kriteria' // Untuk searching dan ordering di sisi server jika relasi di-join
                    },
                    {
                        data: {
                            '_': 'tanggal.display',
                            'sort': 'tanggal.timestamp'
                        },
                        name: 'detail_kriteria.created_at', // Pastikan ini nama kolom yang benar untuk ordering
                        type: 'num'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            if (data === 'submitted') {
                                return '<span class="badge-status-submitted">' + data + '</span>';
                            } else if (data === 'revisi') {
                                return '<span class="badge-status-revisi">' + data + '</span>';
                            } else if (data === 'acc1') {
                                return '<span class="badge-status-acc1">' + data + '</span>';
                            } else {
                                return '<span class="badge-status-default">' + data + '</span>';
                            }
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (data.status === 'acc1') {
                                return '';
                            } else {
                                return '<button class="btn-validasi btn-detail" data-id="' + row
                                    .id_detail_kriteria + '">Validasi</button>';
                            }
                        }
                    }
                ],
                language: {
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>"
                    },
                    lengthMenu: "Show _MENU_ entries",
                    search: "Search:"
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var pages = api.page.info().pages;
                    if (pages <= 1) {
                        $(api.table().container()).addClass('hide-pagination');
                    } else {
                        $(api.table().container()).removeClass('hide-pagination');
                    }
                }
            });

            $('#table_detail_kriteria').on('click', '.btn-detail', function() {
                var id = $(this).data('id');
                $('#modal-container').html(''); // Kosongkan container sebelum memuat modal baru
                $.get("{{ url('validasi') }}/" + id + "/detail-modal", function(html) {
                    $('#modal-container').html(html);
                    var modalElement = document.getElementById('modal-master');
                    if (modalElement) {
                        var modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    } else {
                        alert('Gagal menginisialisasi modal.');
                    }
                }).fail(function(xhr) {
                    let errorMsg = 'Gagal memuat detail validasi.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        // Coba tampilkan response text jika ada, mungkin berisi pesan error HTML dari server
                        // Ini bisa sangat panjang, jadi mungkin lebih baik log ke console
                        console.error("Error loading modal content:", xhr.responseText);
                        // errorMsg += " Lihat console untuk detail." // Opsional
                    }
                    alert(errorMsg);
                });
            });

            $(document).on('click', '#btn-simpan-validasi', function() {
                let id = $('#form-validasi').data('id');
                let status = $('input[name="status_validasi"]:checked').val();
                let comment = $('#catatan').val();

                if (!status) {
                    alert('Mohon pilih status validasi (Diterima/Revisi).');
                    return;
                }

                $.ajax({
                    url: '{{ route('validasi.submit') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_detail_kriteria: id,
                        action: status,
                        comment: comment
                    },
                    success: function(response) {
                        if (response.success) {
                            var modalElement = document.getElementById('modal-master');
                            if (modalElement) {
                                var modalInstance = bootstrap.Modal.getInstance(modalElement);
                                if (modalInstance) {
                                    modalInstance.hide();
                                }
                            }
                            table.ajax.reload(null, false); // false menjaga paginasi saat ini
                            // alert(response.message || 'Validasi berhasil disimpan.'); // Opsional: notifikasi sukses
                        } else {
                            alert(response.message ||
                                'Gagal menyimpan validasi. Silakan coba lagi.');
                        }
                    },
                    error: function(xhr, ajaxStatus, thrownError) {
                        let errorMessage = 'Terjadi kesalahan saat menyimpan!\n';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                errorMessage += 'Server: ' + xhr.responseJSON.message + '\n';
                            }
                            if (xhr.responseJSON.errors) { // Laravel validation errors
                                for (const key in xhr.responseJSON.errors) {
                                    errorMessage += key + ': ' + xhr.responseJSON.errors[key]
                                        .join(', ') + '\n';
                                }
                            }
                        } else if (xhr.responseText) { // Jika bukan JSON, mungkin error HTML
                            // Jangan tampilkan seluruh responseText di alert karena bisa sangat panjang
                            errorMessage += 'Detail error ada di console browser.\n';
                            console.error("Full error responseText:", xhr.responseText);
                        } else {
                            errorMessage += 'Status: ' + ajaxStatus + ', Error: ' + thrownError;
                        }
                        alert(errorMessage);
                        console.error("XHR Object:", xhr);
                    }
                });
            });

            // Handler untuk tombol batal di dalam modal
            $(document).on('click', '#modal-master #btn-batal', function() {
                var modalElement = document.getElementById('modal-master');
                if (modalElement) {
                    var modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            });

            // Membersihkan modal dari DOM setelah ditutup untuk mencegah ID duplikat
            // dan memastikan konten selalu baru saat modal dibuka lagi.
            $(document).on('hidden.bs.modal', '#modal-master', function() {
                $(this).remove(); // Menghapus elemen modal dari DOM
            });
        });
    </script>
</body>

</html>
