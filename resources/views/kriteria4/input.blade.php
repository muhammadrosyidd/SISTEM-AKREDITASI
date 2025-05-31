<!DOCTYPE
html >
  <html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/kriteria.css')}}">
    <title>Corporate UI by Creative Tim</title>

    <!--     Fonts and icons     -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/corporate-ui-dashboard.css?v=1.0.0')}}" rel="stylesheet" />

    <!-- Custom CSS for file input -->
    <style>
    /* Updated Image preview styles */
    [id^="imagePreview"] {
        max-width: 350px;
        max-height: 300px;
        width: auto;
        height: auto;
        display: block;
        margin: 0 auto;
        object-fit: contain;
    }

    /* PDF icon styles (for PDF files) */
    [id^="pdfIcon"] {
        font-size: 80px;
        color: #d9534f;
        display: none;
    }

    /* File preview container adjustments */
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

    /* Ensure the preview box and image have the same dimensions */
    .preview-box, [id^="imagePreview"] {
        width: 350px;
        height: 300px;
    }

    /* Ensure images maintain aspect ratio but fit within container */
    [id^="imagePreview"] {
        object-fit: contain;
    }

    /* Updated Close button styles to target all close buttons */
    [id^="closeButton"] {
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 20px;
        background: transparent;
        border: none;
        color: rgb(0, 0, 0);
        cursor: pointer;
        display: none; /* Hidden initially */
        z-index: 10; /* Ensure it's above the image */
    }

    /* Hover effect for the close button */
    [id^="closeButton"]:hover {
        color: darkred;
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
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Kriteria 4</li>
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
                            <h4 class="form-title text-right mb-4">Kriteria 4 - VMTS</h4>
                            <form method="POST" action="{{ route('kriteria1.store') }}" enctype="multipart/form-data">
                                @csrf
                                <!-- Hidden status field -->
                                <input type="hidden" name="status" id="status" value="saved">
                                
                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <label for="penetapan" class="form-label"
                                            style="font-size: large; color: #1e293b">Penetapan</label>
                                        <textarea name="penetapan" id="penetapan"
                                            class="form-control @error('penetapan') is-invalid @enderror"
                                            placeholder="Masukkan penetapan">{{ old('penetapan') }}</textarea>
                                        @error('penetapan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="pendukung_penetapan" class="form-label">Pendukung Penetapan (Upload File)</label>
                                        <div class="file-input-wrapper">
                                            <input type="file" name="pendukung_penetapan" id="pendukung_penetapan"
                                                class="uploadButton form-control @error('pendukung_penetapan') is-invalid @enderror"
                                                accept="image/*, application/pdf" onchange="previewFile('pendukung_penetapan')">
                                            <label for="pendukung_penetapan" class="file-input-label">Choose a file</label>
                                            <div id="filePreview1" class="file-preview">
                                                <button type="button" id="closeButton1" onclick="removePreview('pendukung_penetapan', 1)" style="display: none;">&times;</button>
                                                <div id="previewBox1" class="preview-box">
                                                    <span id="plusSign1" class="plus-sign">+</span>
                                                </div>
                                                <p id="fileName1"></p>
                                                <img id="imagePreview1" src="#" alt="Image Preview" style="display: none;">
                                                <i id="pdfIcon1" class="fa fa-file-pdf-o" style="display: none;"></i>
                                            </div>
                                            @error('pendukung_penetapan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <label for="pelaksanaan" class="form-label">Pelaksanaan</label>
                                        <textarea name="pelaksanaan" id="pelaksanaan"
                                            class="form-control @error('pelaksanaan') is-invalid @enderror"
                                            placeholder="Masukkan pelaksanaan">{{ old('pelaksanaan') }}</textarea>
                                        @error('pelaksanaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="pendukung_pelaksanaan" class="form-label">Pendukung Pelaksanaan (Upload File)</label>
                                        <div class="file-input-wrapper">
                                            <input type="file" name="pendukung_pelaksanaan" id="pendukung_pelaksanaan"
                                                class="uploadButton form-control @error('pendukung_pelaksanaan') is-invalid @enderror"
                                                accept="image/*, application/pdf" onchange="previewFile('pendukung_pelaksanaan')">
                                            <label for="pendukung_pelaksanaan" class="file-input-label">Choose a file</label>
                                            <div id="filePreview2" class="file-preview">
                                                <button type="button" id="closeButton2" onclick="removePreview('pendukung_pelaksanaan', 2)" style="display: none;">&times;</button>
                                                <div id="previewBox2" class="preview-box">
                                                    <span id="plusSign2" class="plus-sign">+</span>
                                                </div>
                                                <p id="fileName2"></p>
                                                <img id="imagePreview2" src="#" alt="Image Preview" style="display: none;">
                                                <i id="pdfIcon2" class="fa fa-file-pdf-o" style="display: none;"></i>
                                            </div>
                                            @error('pendukung_pelaksanaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <label for="evaluasi" class="form-label">Evaluasi</label>
                                        <textarea name="evaluasi" id="evaluasi"
                                            class="form-control @error('evaluasi') is-invalid @enderror"
                                            placeholder="Masukkan evaluasi">{{ old('evaluasi') }}</textarea>
                                        @error('evaluasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="pendukung_evaluasi" class="form-label">Pendukung Evaluasi (Upload File)</label>
                                        <div class="file-input-wrapper">
                                            <input type="file" name="pendukung_evaluasi" id="pendukung_evaluasi"
                                                class="uploadButton form-control @error('pendukung_evaluasi') is-invalid @enderror"
                                                accept="image/*, application/pdf" onchange="previewFile('pendukung_evaluasi')">
                                            <label for="pendukung_evaluasi" class="file-input-label">Choose a file</label>
                                            <div id="filePreview3" class="file-preview">
                                                <button type="button" id="closeButton3" onclick="removePreview('pendukung_evaluasi', 3)" style="display: none;">&times;</button>
                                                <div id="previewBox3" class="preview-box">
                                                    <span id="plusSign3" class="plus-sign">+</span>
                                                </div>
                                                <p id="fileName3"></p>
                                                <img id="imagePreview3" src="#" alt="Image Preview" style="display: none;">
                                                <i id="pdfIcon3" class="fa fa-file-pdf-o" style="display: none;"></i>
                                            </div>
                                            @error('pendukung_evaluasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <label for="pengendalian" class="form-label">Pengendalian</label>
                                        <textarea name="pengendalian" id="pengendalian"
                                            class="form-control @error('pengendalian') is-invalid @enderror"
                                            placeholder="Masukkan pengendalian">{{ old('pengendalian') }}</textarea>
                                        @error('pengendalian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="pendukung_pengendalian" class="form-label">Pendukung Pengendalian (Upload File)</label>
                                        <div class="file-input-wrapper">
                                            <input type="file" name="pendukung_pengendalian" id="pendukung_pengendalian"
                                                class="uploadButton form-control @error('pendukung_pengendalian') is-invalid @enderror"
                                                accept="image/*, application/pdf" onchange="previewFile('pendukung_pengendalian')">
                                            <label for="pendukung_pengendalian" class="file-input-label">Choose a file</label>
                                            <div id="filePreview4" class="file-preview">
                                                <button type="button" id="closeButton4" onclick="removePreview('pendukung_pengendalian', 4)" style="display: none;">&times;</button>
                                                <div id="previewBox4" class="preview-box">
                                                    <span id="plusSign4" class="plus-sign">+</span>
                                                </div>
                                                <p id="fileName4"></p>
                                                <img id="imagePreview4" src="#" alt="Image Preview" style="display: none;">
                                                <i id="pdfIcon4" class="fa fa-file-pdf-o" style="display: none;"></i>
                                            </div>
                                            @error('pendukung_pengendalian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <label for="peningkatan" class="form-label">Peningkatan</label>
                                        <textarea name="peningkatan" id="peningkatan" rows="3"
                                            class="form-control @error('peningkatan') is-invalid @enderror"
                                            placeholder="Masukkan peningkatan">{{ old('peningkatan') }}</textarea>
                                        @error('peningkatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="pendukung_peningkatan" class="form-label">Pendukung Peningkatan (Upload File)</label>
                                        <div class="file-input-wrapper">
                                            <input type="file" name="pendukung_peningkatan" id="pendukung_peningkatan"
                                                class="uploadButton form-control @error('pendukung_peningkatan') is-invalid @enderror"
                                                accept="image/*, application/pdf" onchange="previewFile('pendukung_peningkatan')">
                                            <label for="pendukung_peningkatan" class="file-input-label">Choose a file</label>
                                            <div id="filePreview5" class="file-preview">
                                                <button type="button" id="closeButton5" onclick="removePreview('pendukung_peningkatan', 5)" style="display: none;">&times;</button>
                                                <div id="previewBox5" class="preview-box">
                                                    <span id="plusSign5" class="plus-sign">+</span>
                                                </div>
                                                <p id="fileName5"></p>
                                                <img id="imagePreview5" src="#" alt="Image Preview" style="display: none;">
                                                <i id="pdfIcon5" class="fa fa-file-pdf-o" style="display: none;"></i>
                                            </div>
                                            @error('pendukung_peningkatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
    <button type="submit" name="status" value="save" class="btn btn-secondary px-4 me-2">Save</button>
    <button type="submit" name="status" value="submitted" class="btn btn-primary px-4">Submit</button>
    <button type="reset" class="btn btn-warning px-4 me-2">Reset</button>
    <a href="{{ route('kriteria.index') }}" class="btn btn-danger px-4">Cancel</a>
</div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--   Core JS Files   -->
        <script src="{{ asset('assets/js/core/popperr.min.js')}}"></script>
        <script src="{{ asset('assets/js/core/bbootstrap.min.js')}}"></script>
        <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
        <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.1/tinymce.min.js"
            referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: 'textarea#penetapan, textarea#pelaksanaan, textarea#evaluasi, textarea#pengendalian, textarea#peningkatan', 
                plugins: 'table lists link image',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | indent outdent | link | bullist numlist | table | image',
                branding: false
            });
        </script>

        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="{{ asset('assets/js/corporate-ui-dashboard.min.js?v=1.0.0')}}"></script>
        <script>
            // Function to set status and submit form
            function setStatus(statusValue) {
                document.getElementById('status').value = statusValue;
                document.querySelector('form').submit();
            }
            
            // Updated previewFile function to handle multiple file inputs
            function previewFile(inputId) {
                var fileInput = document.getElementById(inputId);
                var file = fileInput.files[0];
                var index = '';
                
                // Determine which file input is being used and set the index
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
                
                // Show file name
                fileName.textContent = file.name;
                
                // Show preview for images
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        const event = e;
                        const size = 'auto';
                        const margin = '0 auto';
                        const object = 'contain';
                        const fit = 'contain';
                        const position = 'absolute';
                        imagePreviewEl.src = event.target.result;
                        imagePreviewEl.style.display = 'block';
                        imagePreviewEl.style.width = size;
                        imagePreviewEl.style.height = size;
                        imagePreviewEl.style.maxWidth = '350px';
                        imagePreviewEl.style.maxHeight = '300px';
                        pdfIcon.style.display = 'none'; // Hide PDF icon if an image is selected
                        closeButton.style.display = 'block'; // Show close button
                        previewBox.style.display = 'none'; // Hide the dashed box and plus sign
                    };
                    reader.readAsDataURL(file);
                }
                // Show PDF icon for PDF files
                else if (file.type === 'application/pdf') {
                    imagePreviewEl.style.display = 'none'; // Hide image preview if it's a PDF
                    pdfIcon.style.display = 'block'; // Show PDF icon
                    closeButton.style.display = 'block'; // Show close button
                    previewBox.style.display = 'none'; // Hide the dashed box and plus sign
                }
            }

            // Updated removePreview function to handle multiple file inputs
            function removePreview(inputId, index) {
                var fileInput = document.getElementById(inputId);
                var previewBox = document.getElementById('previewBox' + index);
                var plusSign = document.getElementById('plusSign' + index);
                var fileName = document.getElementById('fileName' + index);
                var imagePreviewEl = document.getElementById('imagePreview' + index);
                var pdfIcon = document.getElementById('pdfIcon' + index);
                var closeButton = document.getElementById('closeButton' + index);
                
                // Reset the preview area
                imagePreviewEl.style.display = 'none';
                pdfIcon.style.display = 'none';
                fileName.textContent = '';
                
                // Show the plus sign and dashed box again
                previewBox.style.display = 'flex';
                plusSign.style.opacity = 1;
                
                // Hide the close button
                closeButton.style.display = 'none';
                
                // Reset the file input
                fileInput.value = '';
            }

            function resetForm() {
    location.reload(); // ini akan me-refresh halaman dan otomatis menghapus isian
}


        </script>
</body>

</html>
