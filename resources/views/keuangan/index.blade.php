@extends('layouts.keuangan')

@section('title', 'Data Siap Tagih - Stockiva')
@section('page-title', 'Data Siap Tagih')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Siap Tagih</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Pesanan Siap Tagih</h5>
                    <span class="badge bg-primary">{{ $pesanans->total() }} Pesanan</span>
                </div>
            </div>
            <div class="card-body">
                {{-- Search & Filter --}}
                <div class="row mb-4">
                    <div class="col-md-5">
                        <form method="GET" action="{{ route('keuangan.index') }}" class="d-flex gap-2">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" 
                                       class="form-control form-control-sm" 
                                       name="search" 
                                       placeholder="Cari no. SPH atau client..."
                                       value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-filter"></i> Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">No. SPH</th>
                                <th width="20%">Client</th>
                                <th width="15%">Total Nilai</th>
                                <th width="15%">Tgl Selesai</th>
                                <th width="25%">Aksi</th>
                            </thead>
                        <tbody class="text-center">
                            @forelse($pesanans as $index => $p)
                             <tr>
                                <td class="text-center">{{ $pesanans->firstItem() + $index }}</td>
                                <td class="text-center">
                                    <strong>{{ $p->no_sph }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $p->client->nama_client ?? '-' }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-person"></i> {{ $p->client->nama_pic ?? '-' }}
                                    </small>
                                </td>
                                <td class="text-center fw-bold">
                                    Rp {{ number_format($p->total_keseluruhan, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    {{ $p->keuangan_at ? $p->keuangan_at->format('d/m/Y') : '-' }}
                                    <br>
                                    <small class="text-muted">Siap Tagih</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info"
                                                onclick="cetakInvoice({{ $p->id }})"
                                                title="Cetak Invoice">
                                            <i class="bi bi-receipt"></i> Invoice
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary"
                                                onclick="cetakTagihan({{ $p->id }})"
                                                title="Cetak Tagihan">
                                            <i class="bi bi-file-text"></i> Tagihan
                                        </button>
                                        <a href="{{ route('keuangan.kwitansi.download', $p->id) }}"
                                        class="btn btn-sm btn-outline-success"
                                        title="Download Kwitansi">
                                            <i class="bi bi-receipt"></i> Kwitansi
                                        </a>
                                        <a href="{{ route('keuangan.dokumen.index', $p->id) }}"
                                        class="btn btn-sm btn-outline-secondary"
                                        title="Upload Dokumen">
                                            <i class="bi bi-upload"></i>
                                        </a>
                                    </div>

                                </td>
                            </tr>
                            @empty
                             <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox display-4 d-block mb-3 text-muted"></i>
                                    <h5>Belum Ada Pesanan Siap Tagih</h5>
                                    <p class="text-muted">Pesanan akan muncul setelah produksi & pengiriman selesai.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($pesanans->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $pesanans->firstItem() }} - {{ $pesanans->lastItem() }} 
                            dari {{ $pesanans->total() }} pesanan
                        </small>
                    </div>
                    <div>
                        {{ $pesanans->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function cetakTagihan(id) {
        window.location.href = `/keuangan/tagihan/${id}/download`;
    }
    
    function cetakInvoice(id) {
        window.open('/keuangan/cetak-invoice/' + id, '_blank');
    }
</script>
@endpush