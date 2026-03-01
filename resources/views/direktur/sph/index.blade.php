@extends('layouts.direktur')

@section('title', 'Daftar SPH - Stockiva')
@section('page-title', 'Daftar SPH Menunggu Approval')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('direktur.sph.index') }}">SPH</a></li>
    <li class="breadcrumb-item active">Daftar</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">SPH Perlu Approval</h5>
                    <span class="badge bg-warning">{{ $sphList->total() }} Menunggu</span>
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

                {{-- Tabel SPH --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>No. SPH</th>
                                <th>Client</th>
                                <th>Tanggal</th>
                                <th>Nilai</th>
                                <th>Dibuat Oleh</th>
                                <th>Status</th>
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
                                <td>{{ $sph->created_at->format('d/m/Y') }}</td>
                                <td class="fw-bold">
                                    Rp {{ number_format($sph->total_keseluruhan, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ $sph->createdBy->name ?? '-' }}
                                   ( {{ $sph->createdBy->jabatan ?? '-' }} )
                                </td>
                                <td>
                                    <span class="badge bg-warning">Menunggu</span>
                                </td>
                                <td>
                                    <a href="{{ route('direktur.sph.show', $sph->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox display-4 d-block mb-3 text-muted"></i>
                                    <h5>Tidak Ada SPH Menunggu</h5>
                                    <p class="text-muted">Semua SPH sudah diproses</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
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
    // Search functionality
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