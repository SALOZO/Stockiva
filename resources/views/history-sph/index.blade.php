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
                                    @switch($sph->sph_status)
                                        @case('draft')
                                            <span class="badge bg-secondary">Draft</span>
                                            @break
                                        @case('menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                            @break
                                        @case('disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                            @break
                                        @case('ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                            @break
                                        @default
                                            <span class="badge bg-dark">-</span>
                                    @endswitch
                                </td>
                                <td>{{ $sph->details->count() }} item</td>
                                <td class="fw-bold">
                                    Rp {{ number_format($sph->total_keseluruhan, 0, ',', '.') }}
                                </td>
                                <td>{{ $sph->approvedBy->name ?? '-' }}</td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-sm btn-info"
                                            onclick="showPreview('{{ $sph->id }}')">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
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
</script>
@endpush