@extends($layout)

@section('title', 'History SPH - Stockiva')
@section('page-title', 'History SPH')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">History SPH</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Semua SPH</h5>
                    <span class="badge bg-primary">{{ $sphList->total() }} SPH</span>
                </div>
            </div>
            <div class="card-body">
                {{-- Search & Filter --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <form method="GET" action="{{ route('history.sph.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="input-group" style="max-width: 320px;">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" 
                                    class="form-control" 
                                    name="search" 
                                    placeholder="Cari no. SPH atau client..."
                                    value="{{ request('search') }}">
                            </div>
                            <select class="form-select flex-shrink-0" name="status" style="width: 160px;">
                                <option value="">Semua Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <button type="submit" class="btn btn-primary flex-shrink-0">
                                <i class="bi bi-filter"></i> Filter
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Tabel History --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>No. SPH</th>
                                <th>Client</th>
                                <th>Tanggal Buat</th>
                                <th>Dibuat Oleh</th>
                                <th>Status SPH</th>
                                <th>Total Item</th>
                                <th>Total Nilai</th>
                                <th>Disetujui Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($sphList as $sph)
                            <tr>
                                <td>
                                    <strong>{{ $sph->no_sph_formatted }}</strong>
                                </td>
                                <td>
                                    {{ $sph->client->nama_client ?? '-' }}
                                    <br>
                                    <small class="text-muted">{{ $sph->client->nama_pic ?? '-' }}</small>
                                </td>
                                <td>{{ $sph->created_at->format('d/m/Y') }}</td>
                                <td>{{ $sph->createdBy->name ?? '-' }}</td>
                                <td>
                                    @if($sph->sph_status == 'disetujui')
                                        @if($sph->is_ready_for_gudang)
                                            <span class="badge bg-success">Siap Gudang</span>
                                        @else
                                            <span class="badge bg-warning">Menunggu Kontrak</span>
                                        @endif
                                    @else
                                        {!! $sph->status_badge !!}
                                    @endif
                                </td>
                                <td>{{ $sph->details->count() }} item</td>
                                <td class="fw-bold">
                                    Rp {{ number_format($sph->total_keseluruhan, 0, ',', '.') }}
                                </td>
                                <td>{{ $sph->approvedBy->name ?? '-' }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-1 flex-nowrap">
                                        {{-- Tombol Detail --}}
                                        <button type="button"
                                            class="btn btn-sm btn-info"
                                            style="white-space:nowrap;"
                                            onclick="showPreview('{{ $sph->id }}')"
                                            title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        {{-- Tombol Upload (khusus Marketing) --}}
                                        @auth
                                            @if (auth()->user()->jabatan == 'Marketing')
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn btn-sm btn-success dropdown-toggle"
                                                    style="white-space:nowrap;"
                                                    data-bs-toggle="dropdown"
                                                    title="Upload">
                                                    <i class="bi bi-upload"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalKontrak{{ $sph->id }}"
                                                            data-jenis="SPK">
                                                            <i class="bi bi-file-earmark-text me-1"></i> SPK
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalKontrak{{ $sph->id }}"
                                                            data-jenis="PO">
                                                            <i class="bi bi-file-earmark-text me-1"></i> PO
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalKontrak{{ $sph->id }}"
                                                            data-jenis="SP">
                                                            <i class="bi bi-file-earmark-text me-1"></i> SP
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            @endif
                                        @endauth

                                        {{-- Tombol Edit --}}
                                        {{-- <button class="btn btn-sm btn-warning"
                                                title="Edit"
                                                onclick="editKontrak({{ $sph->id }})">
                                            <i class="bi bi-pencil"></i>
                                        </button> --}}

                                        {{-- Tombol Hapus --}}
                                        {{-- <button class="btn btn-sm btn-danger"
                                                title="Hapus"
                                                onclick="hapusKontrak({{ $sph->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button> --}}
                                    </div>

                                    {{-- MODAL INPUT KONTRAK --}}
                                    <div class="modal fade" id="modalKontrak{{ $sph->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="bi bi-file-text me-2"></i>
                                                        Input <span class="jenis-label"></span>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('marketing.pesanan.upload-kontrak', $sph->id) }}" 
                                                    method="POST" 
                                                    enctype="multipart/form-data"
                                                    id="formKontrak{{ $sph->id }}">
                                                    @csrf
                                                    <input type="hidden" name="jenis_kontrak" id="jenis_kontrak{{ $sph->id }}">
                                                    
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nomor Kontrak <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="nomor_kontrak" required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Kontrak <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" name="tanggal_kontrak" value="{{ date('Y-m-d') }}" required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Upload File </label>
                                                            <input type="file" class="form-control" name="file" accept=".pdf,.jpg,.jpeg,.png">
                                                            <small class="text-muted">Format: PDF, JPG, PNG. Maks: 2MB</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bi bi-save"></i> Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="bi bi-inbox display-4 d-block mb-3 text-muted"></i>
                                    <h5>Tidak Ada Data SPH</h5>
                                    <p class="text-muted">Belum ada SPH yang dibuat</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($sphList->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $sphList->firstItem() }} - {{ $sphList->lastItem() }} 
                            dari {{ $sphList->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $sphList->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Preview PDF --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-file-pdf text-danger me-2"></i>
                    Preview SPH
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="previewFrame" 
                        src="" 
                        style="width: 100%; height: 70vh; border: none;">
                </iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
                <a href="#" id="downloadLink" class="btn btn-primary" target="_blank">
                    <i class="bi bi-download"></i> Download PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showPreview(sphId) {
        let previewUrl = '/history-sph/' + sphId + '/preview';
        let downloadUrl = '/history-sph/' + sphId + '/download';
        
        $('#previewFrame').attr('src', previewUrl);
        $('#downloadLink').attr('href', downloadUrl);
        $('#previewModal').modal('show');
    }
    $('.dropdown-item').click(function() {
        let jenis = $(this).data('jenis');
        let sphId = $(this).closest('.modal').attr('id').replace('modalKontrak', '');
        
        $('#jenis_kontrak' + sphId).val(jenis);
        $('.jenis-label').text(jenis);
        
        // Update action form
        let action = "{{ route('marketing.pesanan.upload-kontrak', ['pesanan' => ':id', 'jenis' => ':jenis']) }}";
        action = action.replace(':id', sphId).replace(':jenis', jenis);
        $('#formKontrak' + sphId).attr('action', action);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const modals = document.querySelectorAll('[id^="modalKontrak"]');
        
        modals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                
                const jenis = button.getAttribute('data-jenis');
                const sphId = modal.id.replace('modalKontrak', '');
                
                const inputJenis = modal.querySelector('#jenis_kontrak' + sphId);
                const labelJenis = modal.querySelector('.jenis-label');
                
                if (inputJenis) inputJenis.value = jenis;
                if (labelJenis) labelJenis.innerText = jenis;
            });
        });
    });
</script>
@endpush