@extends('layouts.gudang')

@section('title', 'Detail Dokumen - Stockiva')
@section('page-title', 'Detail Dokumen')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.pengiriman.index', $dokumen->pengiriman->pesanan_id) }}">Pengiriman</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.upload.index', $dokumen->pengiriman_id) }}">Upload</a></li>
    <li class="breadcrumb-item active">Detail Dokumen</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Detail Dokumen</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Jenis Dokumen</th>
                        <td>
                            @switch($dokumen->jenis)
                                @case('surat_jalan') Surat Jalan @break
                                @case('bast_ekspedisi') BAST Ekspedisi @break
                                @case('bast_client') BAST Client @break
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>No. Pengiriman</th>
                        <td>{{ $dokumen->pengiriman->no_pengiriman }}</td>
                    </tr>
                    <tr>
                        <th>Client</th>
                        <td>{{ $dokumen->pengiriman->pesanan->client->nama_client ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Upload</th>
                        <td>{{ $dokumen->uploaded_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Upload Oleh</th>
                        <td>{{ $dokumen->uploader->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{!! $dokumen->status_badge !!}</td>
                    </tr>
                    @if($dokumen->catatan)
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $dokumen->catatan }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>File</th>
                        <td>
                            <a href="{{ route('gudang.upload.download', $dokumen->id) }}" 
                               class="btn btn-sm btn-primary" target="_blank">
                                <i class="bi bi-download"></i> Download File
                            </a>
                        </td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('gudang.upload.index', $dokumen->pengiriman_id) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        {{-- Preview PDF (Jika file PDF) --}}
        @if(pathinfo($dokumen->file_path, PATHINFO_EXTENSION) == 'pdf')
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Preview</h5>
            </div>
            <div class="card-body p-0">
                <iframe src="{{ Storage::url($dokumen->file_path) }}" 
                        style="width: 100%; height: 500px; border: none;">
                </iframe>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection