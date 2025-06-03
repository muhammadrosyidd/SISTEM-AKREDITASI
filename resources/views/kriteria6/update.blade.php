<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kriteria.css') }}">
    <title>Corporate UI by Creative Tim</title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/corporate-ui-dashboard.css?v=1.0.0') }}" rel="stylesheet" />

    <style>
        /* Preview styles */
        [id^="imagePreview"] {
            max-width: 350px;
            max-height: 300px;
            width: auto;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: contain;
        }

        [id^="pdfIcon"] {
            font-size: 80px;
            color: #d9534f;
            display: none;
        }

        .file-preview {
            margin-top: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            position: relative;
            width: 350px;
            height: auto;
            margin: 10px auto;
        }

        .preview-box,
        [id^="imagePreview"] {
            width: 350px;
            height: 300px;
        }

        [id^="imagePreview"] {
            object-fit: contain;
        }

        [id^="closeButton"] {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 20px;
            background: transparent;
            border: none;
            color: rgb(0, 0, 0);
            cursor: pointer;
            display: none;
            z-index: 10;
        }

        [id^="closeButton"]:hover {
            color: darkred;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('layouts.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Kriteria 6</li>
                    </ol>
                </nav>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="custom-form-section p-4">
                            <h4 class="form-title text-right mb-4">Edit Kriteria 6 - Pendidikan</h4>

                            @php
                                $fields = [
                                    ['name' => 'penetapan', 'label' => 'Penetapan', 'id' => 'pendukung_penetapan'],
                                    ['name' => 'pelaksanaan', 'label' => 'Pelaksanaan', 'id' => 'pendukung_pelaksanaan'],
                                    ['name' => 'evaluasi', 'label' => 'Evaluasi', 'id' => 'pendukung_evaluasi'],
                                    ['name' => 'pengendalian', 'label' => 'Pengendalian', 'id' => 'pendukung_pengendalian'],
                                    ['name' => 'peningkatan', 'label' => 'Peningkatan', 'id' => 'pendukung_peningkatan'],
                                ];
                            @endphp

                            <form method="POST" action="{{ route('kriteria6.update', $detail->id_detail_kriteria) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" id="status" value="saved">

                                @foreach ($fields as $index => $field)
                                    <div class="row mb-4">
                                        <div class="col-md-9">
                                            <label for="{{ $field['name'] }}" class="form-label" style="font-size: large; color: #1e293b">
                                                {{ $field['label'] }}
                                            </label>
                                            <textarea
                                                name="{{ $field['name'] }}"
                                                id="{{ $field['name'] }}"
                                                class="form-control @error($field['name']) is-invalid @enderror"
                                                placeholder="Masukkan {{ strtolower($field['label']) }}"
                                            >{{ old($field['name'], $detail->{$field['name']}->deskripsi ?? '') }}</textarea>
                                            @error($field['name'])
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="{{ $field['id'] }}" class="form-label">Pendukung {{ $field['label'] }} (Upload File)</label>
                                            <div class="file-input-wrapper position-relative">
                                                <input
                                                    type="file"
                                                    name="{{ $field['id'] }}"
                                                    id="{{ $field['id'] }}"
                                                    class="uploadButton form-control @error($field['id']) is-invalid @enderror"
                                                    accept="image/*,application/pdf"
                                                    onchange="previewFile('{{ $field['id'] }}')"
                                                >
                                                <label for="{{ $field['id'] }}" class="file-input-label">Choose a file</label>

                                                <div id="filePreview{{ $index + 1 }}" class="file-preview">
                                                    <button
                                                        type="button"
                                                        id="closeButton{{ $index + 1 }}"
                                                        onclick="removePreview('{{ $field['id'] }}', {{ $index + 1 }})"
                                                        style="display: none; position: absolute; top: 5px; right: 5px; font-size: 20px; background: transparent; border: none; color: rgb(0,0,0); cursor: pointer; z-index: 10;"
                                                    >
                                                        &times;
                                                    </button>
                                                    <div id="previewBox{{ $index + 1 }}" class="preview-box" style="width: 350px; height: 300px; border: 2px dashed #ccc; display: flex; align-items: center; justify-content: center;">
                                                        <span id="plusSign{{ $index + 1 }}" class="plus-sign" style="font-size: 48px; color: #ccc;">+</span>
                                                    </div>
                                                    <p id="fileName{{ $index + 1 }}"></p>
                                                    <img id="imagePreview{{ $index + 1 }}" src="#" alt="Image Preview" style="display: none; max-width: 350px; max-height: 300px; object-fit: contain; margin: 0 auto;" />
                                                    <i id="pdfIcon{{ $index + 1 }}" class="fa fa-file-pdf-o" style="display: none; font-size: 80px; color: #d9534f;"></i>
                                                </div>

                                                @error($field['id'])
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                @if(isset($detail->{$field['name']}->pendukung) && $detail->{$field['name']}->pendukung)
                                                <label>Pendukung saat ini </label>
                                                    @php
                                                        $filePath = $detail->{$field['name']}->pendukung;
                                                        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                                        $storagePath = str_starts_with($filePath, 'public/') ? substr($filePath, 7) : $filePath;
                                                        $fileUrl = asset('storage/' . $storagePath);
                                                    @endphp
                                                    <div class="mt-2">
                                                        @if(in_array($ext, ['jpg','jpeg','png','gif']))
                                                            <img src="{{ $fileUrl }}" alt="Preview lama" style="max-width: 150px; max-height: 150px; object-fit: contain;">
                                                        @elseif($ext === 'pdf')
                                                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-danger">
                                                                <i class="fa fa-file-pdf-o"></i> Lihat File PDF Lama
                                                            </a>
                                                        @else
                                                            <a href="{{ $fileUrl }}" target="_blank">Lihat File Pendukung Lama</a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="mt-4 text-end">
                                    <button type="submit" name="status" value="save" class="btn btn-secondary px-4 me-2">Save</button>
    <button type="submit" name="status" value="submitted" class="btn btn-primary px-4">Submit</button>
                                    <a href="{{ route('kriteria6.index') }}" class="btn btn-danger px-4 me-2">Cancel</a>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.1/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: 'textarea#penetapan, textarea#pelaksanaan, textarea#evaluasi, textarea#pengendalian, textarea#peningkatan',
                plugins: 'table lists link image',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | indent outdent | link | bullist numlist | table | image',
                branding: false
            });
        </script>

        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="{{ asset('assets/js/corporate-ui-dashboard.min.js?v=1.0.0') }}"></script>
        <script>
            function setStatus(statusValue) {
                document.getElementById('status').value = statusValue;
                document.querySelector('form').submit();
            }

            function previewFile(inputId) {
                var fileInput = document.getElementById(inputId);
                var file = fileInput.files[0];
                var index = '';

                if (inputId === 'pendukung_penetapan') index = '1';
                else if (inputId === 'pendukung_pelaksanaan') index = '2';
                else if (inputId === 'pendukung_evaluasi') index = '3';
                else if (inputId === 'pendukung_pengendalian') index = '4';
                else if (inputId === 'pendukung_peningkatan') index = '5';

                var previewBox = document.getElementById('previewBox' + index);
                var plusSign = document.getElementById('plusSign' + index);
                var fileName = document.getElementById('fileName' + index);
                var imagePreviewEl = document.getElementById('imagePreview' + index);
                var pdfIcon = document.getElementById('pdfIcon' + index);
                var closeButton = document.getElementById('closeButton' + index);

                fileName.textContent = file.name;

                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreviewEl.src = e.target.result;
                        imagePreviewEl.style.display = 'block';
                        imagePreviewEl.style.width = 'auto';
                        imagePreviewEl.style.height = 'auto';
                        imagePreviewEl.style.maxWidth = '350px';
                        imagePreviewEl.style.maxHeight = '300px';
                        pdfIcon.style.display = 'none';
                        closeButton.style.display = 'block';
                        previewBox.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    imagePreviewEl.style.display = 'none';
                    pdfIcon.style.display = 'block';
                    closeButton.style.display = 'block';
                    previewBox.style.display = 'none';
                }
            }

            function removePreview(inputId, index) {
                var fileInput = document.getElementById(inputId);
                var previewBox = document.getElementById('previewBox' + index);
                var plusSign = document.getElementById('plusSign' + index);
                var fileName = document.getElementById('fileName' + index);
                var imagePreviewEl = document.getElementById('imagePreview' + index);
                var pdfIcon = document.getElementById('pdfIcon' + index);
                var closeButton = document.getElementById('closeButton' + index);

                imagePreviewEl.style.display = 'none';
                pdfIcon.style.display = 'none';
                fileName.textContent = '';
                previewBox.style.display = 'flex';
                plusSign.style.opacity = 1;
                closeButton.style.display = 'none';
                fileInput.value = '';
            }
        </script>
</body>

</html>
