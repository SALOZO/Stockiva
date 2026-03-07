@extends('layouts.gudang')

@section('title', 'Pengiriman Barang - Stockiva')
@section('page-title', 'Pengiriman Barang')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item active">Pengiriman</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Info SPH --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi SPH</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">No. SPH</td>
                                <td width="70%">: <strong>{{ $pesanan->no_sph_formatted }}</strong></td>
                            </tr>
                            <tr>
                                <td>Client</td>
                                <td>: <strong>{{ $pesanan->client->nama_client ?? '-' }}</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">Total Item</td>
                                <td width="70%">: {{ $pesanan->details->sum('jumlah') }} item</td>
                            </tr>
                            <tr>
                                <td>Progress Produksi</td>
                                <td>: {{ $pesanan->details->sum('produced_qty') }}/{{ $pesanan->details->sum('jumlah') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Pengiriman --}}
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Pengiriman</h5>
                    <a href="{{ route('gudang.pengiriman.create', $pesanan->id) }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Buat Pengiriman Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($pengiriman->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-truck display-4 d-block mb-3 text-muted"></i>
                        <h5>Belum Ada Pengiriman</h5>
                        <p class="text-muted">Klik tombol "Buat Pengiriman Baru" untuk memulai.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Pengiriman Ke</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Penerima Ekspedisi</th>
                                    <th>Penerima Client</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($pengiriman as $index => $kirim)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>Pengiriman Ke-{{ $kirim->pengiriman_ke }}</strong>
                                    </td>
                                    <td>{{ $kirim->tanggal->format('d/m/Y') }}</td>
                                    <td>{!! $kirim->status_badge !!}</td>
                                    <td>{{ $kirim->ekspedisi ?? '-' }}
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> {{ $kirim->nama_kurir }}
                                        </small>
                                    </td>
                                    <td>{{ $kirim->penerima_client ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#pilihUpdateModal{{ $kirim->id }}"
                                                    data-bs-toggle="tooltip" 
                                                    title="Update Kiriman">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                            <a href="#" 
                                               class="btn btn-sm btn-outline-primary"
                                               data-bs-toggle="tooltip" 
                                               title="Buat Document">
                                                <i class="bi bi-file-text"></i>
                                            </a>
                                            <a href="" 
                                               class="btn btn-sm btn-outline-info"
                                               data-bs-toggle="tooltip" 
                                               title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="pilihUpdateModal{{ $kirim->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="bi bi-pencil-square me-2 text-warning"></i>
                                                    Pilih Jenis Update
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-muted mb-3">
                                                    Pengiriman: <strong>{{ $pesanan->no_sph_formatted }}</strong>
                                                </p>
                                                <div class="d-grid gap-3">
                                                
                                                <a href="{{ route('gudang.pengiriman.edit-ekspedisi', $kirim->id) }}" 
                                                class="btn btn-outline-success btn-lg w-100">
                                                    <i class="bi bi-truck me-2"></i>
                                                    Update Ekspedisi
                                                </a>
                                                
                                                    <a href="{{ route('gudang.pengiriman.edit-client', $kirim->id) }}" 
                                                    class="btn btn-outline-primary btn-lg w-100">
                                                        <i class="bi bi-person me-2"></i>
                                                        Update Client
                                                    </a>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="bi bi-x-circle"></i> Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-borderless td {
        padding: 0.3rem 0;
    }
    .btn-group .btn {
        padding: 0.4rem 0.6rem;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush