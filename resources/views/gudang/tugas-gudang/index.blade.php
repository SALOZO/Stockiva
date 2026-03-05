@extends('layouts.gudang')

@section('title', 'Tugas Gudang - Stockiva')
@section('page-title', 'Tugas Gudang')

@section('breadcrumb')
    {{-- <li class="breadcrumb-item"><a href="{{ route('gudang.dashboard') }}">Gudang</a></li> --}}
    <li class="breadcrumb-item active">Tugas Gudang</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar SPH yang Harus Diproses</h5>
                    <span class="badge bg-primary">{{ $tugasList->total() }} Tugas</span>
                </div>
            </div>
            <div class="card-body">
                {{-- Search --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <form method="GET" action="{{ route('gudang.tugas-gudang.index') }}">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       name="search" 
                                       placeholder="Cari no. SPH atau client..."
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-filter"></i> Cari
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('gudang.tugas-gudang.index') }}" 
                                       class="btn btn-secondary">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Tabel Tugas --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">No. SPH</th>
                                <th width="25%">Client</th>
                                <th width="10%">Progress</th>
                                <th width="10%">Kirim</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($tugasList as $index => $tugas)
                            <tr>
                                <td>{{ $tugasList->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $tugas->no_sph ?? 'SPH/'.$tugas->no_pesanan }}</strong>
                                </td>
                                <td class="text-center">
                                    <strong>{{ $tugas->client->nama_client ?? '-' }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-person"></i> {{ $tugas->client->nama_pic ?? '-' }} |
                                        <i class="bi bi-telephone"></i> {{ $tugas->client->no_telp_pic ?? '-' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="text-muted">-</span>
                                </td>
                                <td>
                                    <span class="text-muted">-</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        {{-- Tombol PRODUKSI --}}
                                        <a href="#" 
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" 
                                           title="Produksi Barang">
                                            <i class="bi bi-gear"></i> P
                                        </a>
                                        
                                        {{-- Tombol KIRIM / PENGIRIMAN --}}
                                        <a href="#" 
                                           class="btn btn-sm btn-outline-success"
                                           data-bs-toggle="tooltip" 
                                           title="Pengiriman">
                                            <i class="bi bi-truck"></i> K
                                        </a>
                                        
                                        {{-- Tombol UPLOAD --}}
                                        <a href="#" 
                                           class="btn btn-sm btn-outline-info"
                                           data-bs-toggle="tooltip" 
                                           title="Upload">
                                            <i class="bi bi-cloud-upload"></i> U
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-inbox display-4 d-block mb-3 text-muted"></i>
                                    <h5>Tidak Ada Tugas</h5>
                                    <p class="text-muted">Semua SPH sudah diproses</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($tugasList->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $tugasList->firstItem() }} - {{ $tugasList->lastItem() }} 
                            dari {{ $tugasList->total() }} tugas
                        </small>
                    </div>
                    <div>
                        {{ $tugasList->appends(request()->query())->links() }}
                    </div>
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
        font-size: 0.85rem;
    }
    .btn-group .btn i {
        margin-right: 2px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Tooltip initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush