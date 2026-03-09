@extends(auth()->user()->jabatan == 'Marketing' ? 'layouts.marketing' : 
        (auth()->user()->jabatan == 'Direktur' ? 'layouts.direktur' : 'layouts.gudang'))

@section('title', 'History BAST - Stockiva')
@section('page-title', 'History BAST')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">History BAST</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Semua BAST</h5>
                    <span class="badge bg-primary">{{ $bastListPaginated->total() }} BAST</span>
                </div>
            </div>
            <div class="card-body">
                {{-- Search --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               placeholder="Cari no. BAST atau client...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="jenisFilter">
                            <option value="">Semua Jenis</option>
                            <option value="Ekspedisi">Ekspedisi</option>
                            <option value="Client">Client</option>
                        </select>
                    </div>
                </div>

                {{-- Tabel BAST --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>No</th>
                                <th>No. BAST</th>
                                <th>No. SPH</th>
                                <th>Client</th>
                                <th>Pengiriman</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($bastListPaginated as $index => $bast)
                            <tr>
                                <td>{{ $bastListPaginated->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $bast['no_bast'] }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $bast['no_sph'] }}</strong>
                                </td>
                                <td>{{ $bast['client'] }}</td>
                                <td>
                                    Pengiriman Ke : {{ $bast['pengiriman_ke'] }}
                                </td>
                                <td>
                                    @if($bast['jenis'] == 'Ekspedisi')
                                        <span class="badge bg-info">Ekspedisi</span>
                                    @else
                                        <span class="badge bg-success">Client</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($bast['tanggal'])->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('history.bast.preview', [$bast['pengiriman_id'], $bast['jenis_file']]) }}" 
                                           class="btn btn-sm btn-outline-info"
                                           target="_blank"
                                           data-bs-toggle="tooltip" 
                                           title="Preview PDF">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('history.bast.download', [$bast['pengiriman_id'], $bast['jenis_file']]) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" 
                                           title="Download PDF">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-file-earmark-text display-4 d-block mb-3 text-muted"></i>
                                    <h5>Tidak Ada Data BAST</h5>
                                    <p class="text-muted">Belum ada BAST yang dibuat</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($bastListPaginated->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $bastListPaginated->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Search functionality
        $('#search').on('keyup', function() {
            let searchText = this.value.toLowerCase();
            
            $('tbody tr').each(function() {
                let noBast = $(this).find('td:eq(1)').text().toLowerCase();
                let client = $(this).find('td:eq(3)').text().toLowerCase();
                
                if (noBast.includes(searchText) || client.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Filter by jenis
        $('#jenisFilter').on('change', function() {
            let jenis = this.value.toLowerCase();
            
            $('tbody tr').each(function() {
                let jenisCell = $(this).find('td:eq(4)').text().toLowerCase();
                
                if (jenis === '' || jenisCell.includes(jenis)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Tooltip initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush