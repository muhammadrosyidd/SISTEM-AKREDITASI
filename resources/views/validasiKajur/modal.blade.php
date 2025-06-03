<div class="modal fade modal-zoom" id="modal-master" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            @if (empty($detail))
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelError">Kesalahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="fas fa-ban"></i> Gagal Memuat Data!</h5>
                        <p>{{ $message ?? 'Data detail kriteria tidak dapat ditemukan atau terjadi masalah saat memuat.' }}
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            @else
                <div class="modal-header pb-2">
                    <h5 class="modal-title fw-bold" id="modalLabel">
                        <i class="fas fa-clipboard-check me-2 text-primary"></i>Validasi Kajur
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-validasi" data-id="{{ $detail->id_detail_kriteria }}">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="mb-2 d-flex">
                                    <span class="info-label">Judul Kriteria:</span>
                                    <span class="text-dark ms-2">{{ $detail->kriteria->nama_kriteria ?? '-' }}</span>
                                </div>
                                <div class="mb-3 d-flex">
                                    <span class="info-label">Di Submit Pada:</span>
                                    <span class="text-muted ms-2">
                                        {{ $detail->created_at ? \Carbon\Carbon::parse($detail->created_at)->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <strong>Status Validasi:</strong>
                                    <div class="mt-2 ms-2">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="status_validasi"
                                                id="acc1" value="acc1" required
                                                {{ $detail->status == 'acc1' ? 'checked' : '' }}>
                                            <label class="form-check-label text-success fw-bold" for="acc1">
                                                <i class="fas fa-check-circle me-2"></i>Diterima
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="status_validasi"
                                                id="revisi" value="revisi"
                                                {{ $detail->status == 'revisi' ? 'checked' : '' }}>
                                            <label class="form-check-label text-danger fw-bold" for="revisi">
                                                <i class="fas fa-times-circle me-2"></i>Revisi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <label for="catatan" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-comment-alt me-2"></i>Komentar
                                    </label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Masukkan komentar validasi...">{{ old('catatan', $existingCommentText ?? '') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="border rounded p-2 bg-white h-100">
                                    <h6 class="fw-bold text-center mb-3 text-dark">
                                        <i class="fas fa-file-pdf me-2 text-danger"></i>Preview Dokumen
                                    </h6>
                                    <iframe src="{{ url('validasi/' . $detail->id_detail_kriteria . '/preview-pdf') }}"
                                        width="100%" height="300px" style="border: none; border-radius: 4px;"
                                        title="Preview Validasi Kajur"></iframe>
                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Pratinjau dokumen yang akan divalidasi
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" id="btn-batal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-simpan-validasi">
                        <i class="fas fa-save me-1"></i>Simpan Validasi
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
