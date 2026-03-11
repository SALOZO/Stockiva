<!-- resources/views/gudang/pengiriman/surat-jalan.blade.php -->
@extends('layouts.gudang')

@section('title', 'Surat Jalan - Stockiva')
@section('page-title', 'Cetak Surat Jalan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}">Pengiriman</a></li>
    <li class="breadcrumb-item active">Surat Jalan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Preview Surat Jalan</h5>
            </div>
            <div class="card-body">
                {{-- Informasi Pengiriman --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%"><strong>No. Surat Jalan</strong></td>
                                <td>: <strong class="text-primary">{{ $noSJ }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal</strong></td>
                                <td>: {{ $pengiriman->tanggal->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ekspedisi</strong></td>
                                <td>: {{ $pengiriman->ekspedisi ?? $pengiriman->ekspedisiRelasi->nama_ekspedisi ?? '-' }}</td>
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
                                <td><strong>PIC</strong></td>
                                <td>: {{ $pengiriman->pesanan->client->nama_pic ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Form untuk generate Surat Jalan --}}
                <form action="{{ route('gudang.pengiriman.cetak-surat-jalan', $pengiriman->id) }}" method="POST">
                    @csrf
                    
                    {{-- Informasi yang akan ditampilkan di Surat Jalan --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Data Surat Jalan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Penerima</label>
                                    <p class="form-control-plaintext fw-bold">
                                        {{ $pengiriman->pesanan->client->nama_pic ?? '-' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ekspedisi</label>
                                    <p class="form-control-plaintext fw-bold">
                                        {{ $pengiriman->ekspedisi ?? $pengiriman->ekspedisiRelasi->nama_ekspedisi ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Alamat Penerima</label>
                                <p class="form-control-plaintext">
                                    {{ $pengiriman->pesanan->client->alamat ?? '' }}, 
                                    {{ $pengiriman->pesanan->client->desa ?? '' }}, 
                                    {{ $pengiriman->pesanan->client->kecamatan ?? '' }}, 
                                    {{ $pengiriman->pesanan->client->kabupaten_kota ?? '' }}, 
                                    {{ $pengiriman->pesanan->client->provinsi ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Barang --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Detail Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pengiriman->detailPengiriman as $index => $detail)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $detail->detailPesanan->barang->nama_barang ?? '-' }}</td>
                                            <td class="text-center">{{ $detail->jumlah_kirim }}</td>
                                            {{-- <td class="text-center">{{$detail->detailPesanan->produced_qty}}</td> --}}
                                            <td class="text-center">{{ $detail->detailPesanan->barang->satuan->nama_satuan }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-printer"></i> Cetak Surat Jalan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection