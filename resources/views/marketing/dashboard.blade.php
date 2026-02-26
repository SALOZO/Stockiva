<!-- resources/views/marketing/dashboard.blade.php -->
@extends('layouts.marketing')

@section('title', 'Dashboard Marketing - Stockiva')
@section('page-title', 'Dashboard Marketing')

@section('content')
<div class="row">
    {{-- ========== SELAMAT DATANG ========== --}}
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-2">Selamat Datang, {{ Auth::user()->name }}!</h4>
                <p class="text-muted mb-0">
                    <i class="bi bi-calendar3 me-2"></i>{{ now()->format('l, d F Y') }}
                </p>
            </div>
        </div>
    </div>

    {{-- ========== STATISTIK CARD ========== --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold">Total Pesanan</div>
                        <div class="h2 mb-0 fw-bold">{{ $totalPesanan ?? 0 }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-cart"></i>
                    </div>
                </div>
                <div class="mt-2 text-muted small">
                    <i class="bi bi-clock-history me-1"></i>
                    {{ $pesananBulanIni ?? 0 }} 
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold">Total Client</div>
                        <div class="h2 mb-0 fw-bold">{{ $totalClient ?? 0 }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
                <div class="mt-2 text-muted small">
                    <i class="bi bi-person-plus me-1"></i>
                    {{ $clientBaruBulanIni ?? 0 }} 
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold">Total Barang</div>
                        <div class="h2 mb-0 fw-bold">{{ $totalBarang ?? 0 }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-box"></i>
                    </div>
                </div>
                <div class="mt-2 text-muted small">
                    <i class="bi bi-tags me-1"></i>
                    {{ $totalKategori ?? 0 }} kategori
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold">Nilai Pesanan</div>
                        <div class="h4 mb-0 fw-bold">Rp {{ number_format($totalNilaiPesanan ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ========== STATUS PESANAN ========== --}}
    <div class="col-md-12  mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Status Pesanan</h6>
            </div>
            <div class="card-body">
                @forelse($statusPesanan ?? [] as $status => $jumlah)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        @php
                            $badgeClass = match($status) {
                                'baru' => 'bg-info',
                                'diproses' => 'bg-warning',
                                'selesai' => 'bg-success',
                                'dibatalkan' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} me-2">{{ ucfirst($status) }}</span>
                    </div>
                    <div class="fw-bold">{{ $jumlah }}</div>
                </div>
                @empty
                <p class="text-muted text-center mb-0">Belum ada data pesanan</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ========== PESANAN TERBARU ========== --}}
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Pesanan Terbaru</h6>
                <a href="{{ route('marketing.pesanan.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Client</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesananTerbaru ?? [] as $pesanan)
                            <tr>
                                <td><strong>{{ $pesanan->no_pesanan }}</strong></td>
                                <td>{{ $pesanan->client->nama_client ?? '-' }}</td>
                                <td>{{ $pesanan->tanggal_pesanan->format('d/m/Y') }}</td>
                                <td>Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</td>
                                <td>{!! $pesanan->status_badge !!}</td>
                                <td>
                                    <a href="{{ route('marketing.pesanan.show', $pesanan->id) }}" 
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">
                                    <p class="text-muted mb-0">Belum ada pesanan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .stat-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s;
        background: white;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        background: rgba(11, 43, 79, 0.08);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #0b2b4f;
    }
    
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    
    .card-header {
        background: white;
        border-bottom: 1px solid #eef2f6;
        padding: 1rem 1.25rem;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge {
        padding: 0.5rem 1rem;
        font-weight: 500;
    }
</style>
@endpush