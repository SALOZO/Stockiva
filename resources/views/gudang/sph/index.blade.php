@extends('layouts.gudang')

@section('title', 'SPH Disetujui - Gudang')
@section('page-title', 'SPH Disetujui')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.sph.index') }}">SPH</a></li>
    <li class="breadcrumb-item active">Disetujui</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar SPH Disetujui</h5>
                    <span class="badge bg-success">{{ $sphList->total() }} SPH</span>
                </div>
            </div>
            <div class="card-body">
                {{-- Search --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   placeholder="Cari no. SPH atau client...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>No. SPH</th>
                                <th>Client</th>
                                <th>Tanggal Approve</th>
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
                                    <strong>SPH/{{ $sph->no_pesanan }}</strong>
                                </td>
                                <td>
                                    {{ $sph->client->nama_client ?? '-' }}
                                    <br>
                                    <small class="text-muted">{{ $sph->client->nama_pic ?? '-' }}</small>
                                </td>
                                <td>
                                    {{ $sph->approved_at ? \Carbon\Carbon::parse($sph->approved_at)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center">{{ $sph->details->count() }} item</td>
                                <td class="fw-bold">
                                    Rp {{ number_format($sph->total_keseluruhan, 0, ',', '.') }}
                                </td>
                                <td>{{ $sph->approvedBy->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('gudang.sph.show', $sph->id) }}" 
                                       class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox display-4 d-block mb-3 text-muted"></i>
                                    <h5>Tidak Ada SPH Disetujui</h5>
                                    <p class="text-muted">Belum ada SPH yang disetujui direktur</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($sphList->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $sphList->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('search')?.addEventListener('keyup', function() {
        let searchText = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });
</script>
@endpush