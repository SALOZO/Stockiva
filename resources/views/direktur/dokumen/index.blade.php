@extends('layouts.direktur')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Document Center</h4>
        <span class="badge bg-primary fs-6">{{ $pesanans->total() }} SPH</span>
    </div>

    {{-- Search --}}
    {{-- <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('direktur.dokumen.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari no. SPH atau client..."
                           value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-white text-center">
                    <tr>
                        <th>No. SPH</th>
                        <th>Client</th>
                        <th>Tanggal</th>
                        {{-- <th>Dokumen Tersedia</th> --}}
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($pesanans as $p)
                    <tr>
                        <td><strong>{{ $p->no_sph }}</strong></td>
                        <td>{{ $p->client->nama_client }}</td>
                        <td>{{ $p->tanggal_pesanan->translatedFormat('d F Y') }}</td>
                        {{-- <td>
                            @if($p->sph_approved_file)
                                <span class="badge bg-secondary me-1">SPH</span>
                            @endif
                            @if($p->invoice_file)
                                <span class="badge bg-info me-1">Invoice</span>
                            @endif
                            @if($p->tagihan_approved_file)
                                <span class="badge bg-primary me-1">Tagihan</span>
                            @endif
                            @if($p->kwitansi_approved_file)
                                <span class="badge bg-warning text-dark me-1">Kwitansi</span>
                            @endif
                        </td> --}}
                        <td>
                            <a href="{{ route('direktur.dokumen.detail', $p->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-folder2-open"></i> Lihat Dokumen
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada dokumen
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pesanans->hasPages())
        <div class="card-footer">
            {{ $pesanans->links() }}
        </div>
        @endif
    </div>

</div>
@endsection