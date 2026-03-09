@extends('layouts.gudang')

@section('title', 'Upload Dokumen - Stockiva')
@section('page-title', 'Upload Dokumen Pengiriman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}">Pengiriman</a></li>
    <li class="breadcrumb-item active">Upload Dokumen</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Info Pengiriman --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pengiriman</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            {{-- <tr>
                                <td width="30%"><strong>No. Pengiriman</strong></td>
                                <td>: {{ $pengiriman->no_pengiriman }}</td>
                            </tr> --}}
                            <tr>
                                <td><strong>Pengiriman Ke</strong></td>
                                <td>: {{ $pengiriman->pengiriman_ke }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal</strong></td>
                                <td>: {{ $pengiriman->tanggal->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%"><strong>Client</strong></td>
                                <td>: {{ $pengiriman->pesanan->client->nama_client ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ekspedisi</strong></td>
                                <td>: {{ $pengiriman->ekspedisi ?? $pengiriman->ekspedisiRelasi->nama_ekspedisi ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Upload per Jenis --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-truck display-4 text-info"></i>
                        <h6 class="mt-2">Surat Jalan</h6>
                        <a href="{{ route('gudang.upload.create', [$pengiriman->id, 'surat_jalan']) }}" 
                           class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-cloud-upload"></i> Upload Surat Jalan
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-text display-4 text-success"></i>
                        <h6 class="mt-2">BAST Ekspedisi</h6>
                        <a href="{{ route('gudang.upload.create', [$pengiriman->id, 'bast_ekspedisi']) }}" 
                           class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-cloud-upload"></i> Upload BAST Ekspedisi
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-person display-4 text-warning"></i>
                        <h6 class="mt-2">BAST Client</h6>
                        <a href="{{ route('gudang.upload.create', [$pengiriman->id, 'bast_client']) }}" 
                           class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-cloud-upload"></i> Upload BAST Client
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Dokumen yang Sudah Diupload --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Upload Dokumen</h5>
            </div>
            <div class="card-body">
                @if($dokumen->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-file-earmark display-4 d-block mb-3 text-muted"></i>
                        <h5>Belum Ada Dokumen</h5>
                        <p class="text-muted">Klik tombol di atas untuk upload dokumen.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Tanggal Upload</th>
                                    <th>Upload Oleh</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($dokumen as $index => $doc)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @switch($doc->jenis)
                                            @case('surat_jalan')
                                                <span class="badge bg-info">Surat Jalan</span>
                                                @break
                                            @case('bast_ekspedisi')
                                                <span class="badge bg-success">BAST Ekspedisi</span>
                                                @break
                                            @case('bast_client')
                                                <span class="badge bg-warning">BAST Client</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ $doc->uploaded_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $doc->uploader->name ?? '-' }}</td>
                                    {{-- <td>{!! $doc->status_badge !!}</td> --}}
                                    <td>{{ $doc->catatan ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('gudang.upload.download', $doc->id) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           target="_blank">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <form action="{{ route('gudang.upload.destroy', $doc->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip"
                                                    title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus dokumen ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-3">
            <a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pengiriman
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 10px;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>
@endpush