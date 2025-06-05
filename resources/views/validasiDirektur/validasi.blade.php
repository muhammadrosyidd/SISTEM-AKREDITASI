<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="modal fade modal-zoom show" id="modal-master" tabindex="-1" aria-modal="true" role="dialog" style="display: block;">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            @empty($details)
                <!-- ... (kode error tetap sama) ... -->
            @else
                <div class="modal-header pb-2">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-clipboard-check me-2 text-primary"></i>Validasi Batch: {{ $batch->nama_pengisian ?? '-' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Tanggal Batch:</strong> {{ $batch->created_at ? \Carbon\Carbon::parse($batch->created_at)->format('d/m/Y H:i') : '-' }}</p>
                    
                    <div class="mb-3">
                        <strong>Status Validasi:</strong>
                        <div class="mt-2 ms-2">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="status_validasi" id="acc" value="acc">
                                <label class="form-check-label text-success fw-bold" for="acc1">
                                    <i class="fas fa-check-circle me-2"></i>Diterima
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="status_validasi" id="revisi" value="revisi">
                                <label class="form-check-label text-danger fw-bold" for="revisi">
                                    <i class="fas fa-times-circle me-2"></i>Revisi
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Kriteria yang Bisa Dipilih untuk Revisi -->
                    <div id="kriteria-revisi-section" style="display: none;">
            <div class="mb-3">
                <label class="form-label fw-bold text-dark mb-2">
                    <i class="fas fa-list-check me-2"></i>Pilih Kriteria yang Perlu Revisi
                </label>
                <div class="border p-3 rounded">
                    @foreach($details as $detail)
                    <div class="mb-3 kriteria-item">
                        <div class="form-check">
                            <input class="form-check-input kriteria-checkbox" type="checkbox" 
                                   name="kriteria_revisi[]" 
                                   value="{{ $detail->id_detail_kriteria }}"
                                   id="kriteria_{{ $detail->id_detail_kriteria }}"
                                   data-detail="{{ $detail->id_detail_kriteria }}"
                                   @if($detail->status == 'revisi') checked @endif>
                            <label class="form-check-label" for="kriteria_{{ $detail->id_detail_kriteria }}">
                                <strong>Kriteria {{ $detail->kriteria->kode_kriteria ?? '#' }}:</strong> 
                                {{ $detail->kriteria->nama_kriteria ?? '-' }}
                                @if($detail->status == 'revisi') <span class="badge bg-danger ms-2">Perlu Revisi</span> @endif
                            </label>
                        </div>
                        <div class="catatan-kriteria ms-4 mt-2" 
                             id="catatan_kriteria_{{ $detail->id_detail_kriteria }}" 
                             style="display: {{ $detail->status == 'revisi' ? 'block' : 'none' }};">
                            <label for="catatan_{{ $detail->id_detail_kriteria }}" class="form-label small text-muted">
                                Catatan untuk kriteria ini:
                            </label>
                            <textarea class="form-control catatan-field" 
                                      id="catatan_{{ $detail->id_detail_kriteria }}" 
                                      name="catatan_kriteria[{{ $detail->id_detail_kriteria }}]" 
                                      rows="2">{{ $detail->komentar->komen ?? '' }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

                    <iframe src="{{ url('validasiDirektur/' . $batch->id_pengisian . '/pdf') }}" width="100%" height="600px" style="border:1px solid #ccc; border-radius:4px;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btn-simpan-validasi">
                        <i class="fas fa-save me-1"></i>Simpan Validasi
                    </button>
                </div>
            @endempty
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Setup global AJAX CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Toggle kriteria revisi section berdasarkan status validasi
    $('input[name="status_validasi"]').change(function() {
        if ($(this).val() === 'revisi') {
            $('#kriteria-revisi-section').show();
        } else {
            $('#kriteria-revisi-section').hide();
            // Uncheck all ketika pindah ke status ACC
            $('.kriteria-checkbox').prop('checked', false).trigger('change');
        }
    });

    // Inisialisasi status awal
    @if($details->where('status', 'revisi')->count() > 0)
        $('input[name="status_validasi"][value="revisi"]').prop('checked', true).trigger('change');
    @else
        $('input[name="status_validasi"][value="acc"]').prop('checked', true);
    @endif

    // Toggle catatan untuk kriteria yang dipilih
    $(document).on('change', '.kriteria-checkbox', function() {
        const detailId = $(this).data('detail');
        const catatanDiv = $('#catatan_kriteria_' + detailId);
        
        if ($(this).is(':checked')) {
            catatanDiv.show();
        } else {
            catatanDiv.hide();
        }
    });

    // Validasi sebelum submit
    $('#btn-simpan-validasi').click(function() {
        const status = $('input[name="status_validasi"]:checked').val();
        
        if (!status) {
            alert('Pilih status validasi terlebih dahulu!');
            return;
        }
        
        if (status === 'revisi') {
            const checkedKriteria = $('.kriteria-checkbox:checked').length;
            
            if (checkedKriteria === 0) {
                alert('Pilih minimal satu kriteria yang perlu direvisi!');
                return;
            }
            
            // Validasi catatan untuk setiap kriteria yang dipilih
            let isValid = true;
            $('.kriteria-checkbox:checked').each(function() {
                const detailId = $(this).data('detail');
                const catatan = $('#catatan_' + detailId).val().trim();
                
                if (catatan === '') {
                    isValid = false;
                    $('#catatan_' + detailId).addClass('is-invalid');
                    alert(`Harap isi catatan untuk kriteria yang dipilih!`);
                } else {
                    $('#catatan_' + detailId).removeClass('is-invalid');
                }
            });
            
            if (!isValid) return;
        }
        
        // Proses submit data
        simpanValidasi();
    });

    function simpanValidasi() {
        const formData = {
            id_pengisian: '{{ $batch->id_pengisian }}',
            status: $('input[name="status_validasi"]:checked').val(),
            detail_revisi: [], // Berisi id_detail_kriteria yang perlu revisi
            catatan_kriteria: {} // Format: {id_detail_kriteria: catatan}
        };

        // Kumpulkan detail dan catatan yang dipilih
        $('.kriteria-checkbox:checked').each(function() {
            const detailId = $(this).data('detail');
            formData.detail_revisi.push(detailId);
            formData.catatan_kriteria[detailId] = $('#catatan_' + detailId).val();
        });

        // Kirim data ke server
        $.ajax({
            url: '{{ route("validasi.update") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                alert(response.message);
                $('#modal-master').modal('hide');
                window.location.reload();
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
            }
        });
    }
});
</script>
