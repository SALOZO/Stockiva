@extends('layouts.direktur')

@section('title', 'Invoice Menunggu Approval - Stockiva')
@section('page-title', 'Invoice Menunggu Approval')

@section('breadcrumb')
    {{-- <li class="breadcrumb-item"><a href="{{ route('direktur.dashboard') }}">Direktur</a></li> --}}
    <li class="breadcrumb-item active">Invoice</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Invoice Perlu Approval</h5>
                    <span class="badge bg-warning">{{ $invoices->total() }} Menunggu</span>
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
                                   placeholder="Cari no. invoice atau client...">
                        </div>
                    </div>
                </div>

                {{-- Tabel Invoice --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>No. Invoice</th>
                                <th>No. SPH</th>
                                <th>Client</th>
                                <th>Tanggal</th>
                                <th>Nilai</th>
                                <th>Dibuat Oleh</th>
                                <th>Status</th>
                                <th>Aksi</th>
                             </thead>
                        <tbody class="text-center">
                            @forelse($invoices as $inv)
                              <tr class="text-center">
                                <td><strong>{{ $inv->no_invoice }}</strong></td>
                                <td>{{ $inv->no_sph_formatted }}</td>
                                <td>
                                    {{ $inv->client->nama_client }}
                                    <br><small>{{ $inv->client->nama_pic }}</small>
                                </td>
                                <td>{{ $inv->created_at->format('d/m/Y') }}</td>
                                <td>Rp {{ number_format($inv->total_keseluruhan, 0, ',', '.') }}</td>
                                <td>{{ $inv->createdBy->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-warning">Menunggu TTD</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('direktur.invoice.preview', $inv->id) }}" 
                                           class="btn btn-sm btn-info" target="_blank">
                                            <i class="bi bi-eye"></i> Preview
                                        </a>
                                        <form action="{{ route('direktur.invoice.approve', $inv->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Setujui invoice ini?')">
                                                <i class="bi bi-check-circle"></i> Setujui
                                            </button>
                                        </form>
                                    </div>
                                </td>
                              </tr>
                            @empty
                              <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-inbox display-4 d-block mb-3 text-muted"></i>
                                    <h5>Tidak Ada Invoice Menunggu</h5>
                                    <p class="text-muted">Semua invoice sudah diproses</p>
                                </td>
                              </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($invoices->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $invoices->links() }}
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