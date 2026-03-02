@extends('layouts.gudang')

@section('title', 'SPH Disetujui - Gudang')
@section('page-title', 'SPH Disetujui')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.sph.index') }}">SPH</a></li>
    <li class="breadcrumb-item active">Disetujui</li>
@endsection

@push('styles')
<style>
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .btn-group .btn i {
        font-size: 0.9rem;
    }
</style>
@endpush

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
                                <td>
                                    {{ $sph->approved_at ? \Carbon\Carbon::parse($sph->approved_at)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center">{{ $sph->details->count() }} item</td>
                                <td class="fw-bold">
                                    Rp {{ number_format($sph->total_keseluruhan, 0, ',', '.') }}
                                </td>
                                <td>{{ $sph->approvedBy->name ?? '-' }}</td>
                                 <td>{!! $sph->gudang_status_badge !!}</td>
                                <td>
                                    <a href="{{ route('gudang.sph.show', $sph->id) }}" 
                                       class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    {{-- SURAT JALAN --}}
                                    <a href="#" 
                                        class="btn btn-sm btn-primary"
                                        data-bs-toggle="tooltip" 
                                        title="Buat Surat Jalan">
                                        <i class="bi bi-truck"></i>
                                    </a>
                                    {{-- BAST PENGIRIMAN --}}
                                    <a href="#" 
                                        class="btn btn-sm btn-warning text-white"
                                        data-bs-toggle="tooltip" 
                                        title="Buat BAST Pengiriman">
                                        <i class="bi bi-box-seam"></i>
                                    </a>
                                    {{-- TOMBOL BAST CLIENT --}}
                                    <a href="#" 
                                        class="btn btn-sm btn-success"
                                        data-bs-toggle="tooltip" 
                                        title="Buat BAST Client">
                                        <i class="bi bi-file-text"></i>
                                    </a>
                                            {{-- TOMBOL UBAH STATUS --}}
                                    <button type="button" 
                                            class="btn btn-sm btn-secondary"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#ubahStatusModal{{ $sph->id }}"
                                            data-bs-toggle="tooltip" 
                                            title="Ubah Status">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                      {{-- Modal Ubah Status --}}
                                        <div class="modal fade" id="ubahStatusModal{{ $sph->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Ubah Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                     <form action="{{ route('gudang.sph.update-status', $sph->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">SPH: <strong>SPH/{{ $sph->no_pesanan }}</strong></label>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Status</label>
                                                                    <select class="form-select" name="gudang_status" required>
                                                                            <option value="Menunggu" {{ $sph->gudang_status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                                            <option value="Sedang diproses" {{ $sph->gudang_status == 'Sedang diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                                                            <option value="Siap_dikirim" {{ $sph->gudang_status == 'Siap_dikirim' ? 'selected' : '' }}>Siap Dikirim</option>
                                                                            <option value="Dikirim" {{ $sph->gudang_status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                                                            <option value="Diterima" {{ $sph->gudang_status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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
    document.getElementById('search')?.addEventListener('keyup', function() {
        let searchText = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush