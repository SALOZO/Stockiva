<!-- resources/views/marketing/pesanan/show.blade.php -->
@extends('layouts.marketing')

@section('title', 'Detail Pesanan - Stockiva Marketing')
@section('page-title', 'Detail Pesanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('marketing.pesanan.index') }}">Pilih Client</a></li>
    <li class="breadcrumb-item"><a href="{{ route('marketing.pesanan.index') }}">Pesanan</a></li>
    <li class="breadcrumb-item active">Detail Pesanan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        {{-- HEADER PESANAN --}}
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Pesanan</h5>
                    <div>
                        <span class="badge bg-primary me-2">{{ $pesanan->no_pesanan }}</span>
                        {!! $pesanan->status_badge !!}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Info Client --}}
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-building me-2"></i>
                            Data Client
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">Nama Client</td>
                                <td width="70%">: <strong>{{ $pesanan->client->nama_client }}</strong></td>
                            </tr>
                            <tr>
                                <td>PIC</td>
                                <td>: {{ $pesanan->client->nama_pic }} ({{ $pesanan->client->jabatan_pic }})</td>
                            </tr>
                            <tr>
                                <td>Kontak</td>
                                <td>: {{ $pesanan->client->email_pic ?? '-' }} / {{ $pesanan->client->no_telp_pic ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $pesanan->client->alamat }}, {{ $pesanan->client->desa }}, {{ $pesanan->client->kecamatan }}, {{ $pesanan->client->kabupaten_kota }}, {{ $pesanan->client->provinsi }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    {{-- Info Pesanan --}}
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-cart me-2"></i>
                            Data Pesanan
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">No. Pesanan</td>
                                <td width="70%">: <strong>{{ $pesanan->no_pesanan }}</strong></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>: {{ $pesanan->tanggal_pesanan->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: {!! $pesanan->status_badge !!}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>: {{ $pesanan->keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Dibuat Oleh</td>
                                <td>: {{ $pesanan->createdBy->name ?? '-' }} ({{ $pesanan->createdBy->jabatan ?? '-' }})</td>
                            </tr>
                            <tr>
                                <td>Dibuat Pada</td>
                                <td>: {{ $pesanan->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

                    {{-- Info Status SPH --}}
            @if($pesanan->sph_status != 'draft')
            <div class="mt-3">
                <strong>Status SPH:</strong> 
                @switch($pesanan->sph_status)
                    @case('menunggu')
                        <span class="badge bg-warning">Menunggu Approval Direktur</span>
                        @break
                    @case('disetujui')
                        <span class="badge bg-success">Disetujui {{ $pesanan->approved_at ? $pesanan->approved_at->format('d/m/Y') : '' }}</span>
                        @break
                    @case('ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                        @if($pesanan->approval_notes)
                            <p class="mt-2 mb-0"><strong>Catatan:</strong> {{ $pesanan->approval_notes }}</p>
                        @endif
                        @break
                @endswitch
            </div>
            @endif

        <br>

        {{-- DAFTAR ITEM PESANAN --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Detail Item Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Kategori</th>
                                <th width="15%">Jenis</th>
                                <th width="20%">Nama Barang</th>
                                <th width="10%">Satuan</th>
                                <th width="10%">Jumlah</th>
                                <th width="10%">Harga</th>
                                <th width="20%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($pesanan->details as $index => $detail)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $detail->kategori->name_kategori ?? '-' }}</td>
                                <td>{{ $detail->jenis->name_jenis ?? '-' }}</td>
                                <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                                <td class="text-center">{{ $detail->barang->satuan->nama_satuan ?? '-' }}</td>
                                <td class="text-center">{{ $detail->jumlah }}</td>
                                <td class="text-center">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-center fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-start fw-bold">TOTAL</td>
                                <td class="text-center fw-bold text-primary">
                                    Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('marketing.pesanan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>

            <div class="d-flex gap-2">
                    {{-- Tombol Generate SPH (hanya muncul jika status draft) --}}
                    @if($pesanan->sph_status == 'draft')
                    <form action="{{ route('marketing.pesanan.generate-sph', $pesanan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Buat SPH?')">
                            <i class="bi bi-file-pdf me-1"></i>Cetak SPH
                        </button>
                    </form>
                    @endif
                    
                    {{-- Tombol Download SPH (jika sudah ada file) --}}
                    @if($pesanan->sph_file || $pesanan->sph_approved_file)
                    <a href="{{ route('marketing.pesanan.download-sph', $pesanan->id) }}" 
                    class="btn btn-info" target="_blank">
                        <i class="bi bi-download me-1"></i>Download SPH
                    </a>
                    @endif
                    
                    {{-- Tombol Edit (hanya jika status draft/menunggu) --}}
                    @if(in_array($pesanan->sph_status, ['draft', 'menunggu']))
                    <a href="{{ route('marketing.pesanan.edit', $pesanan->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    @endif
                </div>
            </div>

            <div>
                {{-- @if($pesanan->status == 'baru')
                <a href="{{ route('marketing.pesanan.edit', $pesanan->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Pesanan
                </a>
                @endif --}}
                {{-- <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>
                    Cetak
                </button> --}}
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
    
    .badge {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
    
    .bg-info {
        background-color: #0dcaf0 !important;
    }
    
    .bg-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }
    
    .bg-success {
        background-color: #198754 !important;
    }
    
    .bg-danger {
        background-color: #dc3545 !important;
    }
    
    @media print {
        .sidebar, .btn, .card-header, .breadcrumb, footer {
            display: none !important;
        }
        .main-content {
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>
@endpush