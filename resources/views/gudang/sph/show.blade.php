<!-- resources/views/gudang/sph/show.blade.php -->
@extends('layouts.gudang')

@section('title', 'Detail SPH - Gudang')
@section('page-title', 'Detail SPH')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.sph.index') }}">SPH Disetujui</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Info SPH --}}
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">SPH/{{ $pesanan->no_pesanan }}</h5>
                    <span class="badge bg-success">DISETUJUI</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informasi Client</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">Client</td>
                                <td>: <strong>{{ $pesanan->client->nama_client ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td>PIC</td>
                                <td>: {{ $pesanan->client->nama_pic ?? '-' }} ({{ $pesanan->client->jabatan_pic ?? '-' }})</td>
                            </tr>
                            <tr>
                                <td>Kontak</td>
                                <td>: {{ $pesanan->client->no_telp_pic ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Informasi Approval</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">Disetujui Oleh</td>
                                <td>: {{ $pesanan->approvedBy->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>
                                    {{ $pesanan->approved_at ? \Carbon\Carbon::parse($pesanan->approved_at)->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Total Nilai</td>
                                <td>: <strong>Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Barang --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Daftar Barang</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($pesanan->details as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                                <td>{{ $item->kategori->name_kategori ?? '-' }}</td>
                                <td>{{ $item->jenis->name_jenis ?? '-' }}</td>
                                <td class="text-center">{{ $item->barang->satuan->nama_satuan ?? '-' }}</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('gudang.sph.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            
            @if($pesanan->sph_approved_file)
            <a href="{{ route('gudang.sph.download', $pesanan->id) }}" 
               class="btn btn-primary" target="_blank">
                <i class="bi bi-download"></i> Download PDF
            </a>
            @endif
        </div>
    </div>
</div>
@endsection