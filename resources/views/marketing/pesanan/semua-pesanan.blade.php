@extends('layouts.marketing')

@section('title', 'Semua Pesanan - Stockiva Marketing')
@section('page-title', 'Semua Pesanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard') }}">Marketing</a></li>
    <li class="breadcrumb-item active">Semua Pesanan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h5 class="mb-0">Daftar Semua Pesanan</h5>
                    <span class="badge bg-primary">{{ $pesanans->total() }} Total Pesanan</span>
                </div>
            </div>
            <div class="card-body">
                {{-- Filter & Search --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <form action="{{ route('marketing.semua-pesanan') }}" method="GET" class="row g-3">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           name="search" 
                                           placeholder="Cari no. pesanan atau nama client..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="status">
                                    <option value="">Semua Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search me-1"></i> Search
                                </button>
                            </div>

                            {{-- <div class="col-md-2">
                                <a href="{{ route('marketing.semua-pesanan') }}" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                </a>
                            </div> --}}
                        </form>
                    </div>
                </div>

                {{-- Tabel Pesanan --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">No. Pesanan</th>
                                <th width="15%">Client</th>
                                <th width="10%">Tanggal</th>
                                <th width="10%">Jumlah Item</th>
                                <th width="15%">Total Harga</th>
                                <th width="10%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($pesanans as $index => $pesanan)
                            <tr>
                                <td>{{ $pesanans->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $pesanan->no_pesanan }}</strong>
                                </td>
                                <td class="text-center">
                                    <span class="fw-medium">{{ $pesanan->client->nama_client ?? '-' }}</span>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-person"></i> {{ $pesanan->client->nama_pic ?? '-' }}
                                    </small>
                                </td>
                                <td>{{ $pesanan->tanggal_pesanan->format('d/m/Y') }}</td>
                                <td>{{ $pesanan->details->count() }} item</td>
                                <td class="fw-bold text-center">
                                    Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}
                                </td>
                                <td>{!! $pesanan->status_badge !!}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('marketing.pesanan.show', $pesanan->id) }}" 
                                           class="btn btn-sm btn-outline-info"
                                           data-bs-toggle="tooltip"
                                           title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        {{-- <a href="{{ route('marketing.pesanan.edit', $pesanan->id) }}" 
                                           class="btn btn-sm btn-outline-warning"
                                           data-bs-toggle="tooltip"
                                           title="Edit Pesanan">
                                            <i class="bi bi-pencil"></i>
                                        </a> --}}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-cart-x display-4 d-block mb-3"></i>
                                        <h5>Tidak Ada Pesanan</h5>
                                        <p class="mb-0">Belum ada data pesanan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($pesanans->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">

                    <small class="text-muted">
                        Menampilkan {{ $pesanans->firstItem() }} 
                        - {{ $pesanans->lastItem() }} 
                        dari {{ $pesanans->total() }} pesanan
                    </small>

                    {{ $pesanans->onEachSide(1)->links('pagination::bootstrap-5') }}

                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table td {
        vertical-align: middle;
    }
    
    .btn-group .btn {
        padding: 0.4rem 0.6rem;
    }
    
    .pagination {
        gap: 4px;
    }
    
    .page-link {
        border: 1px solid #e2e8f0;
        border-radius: 8px !important;
        color: #475569;
        padding: 0.5rem 0.75rem;
    }
    
    .page-item.active .page-link {
        background: #0b2b4f;
        border-color: #0b2b4f;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush