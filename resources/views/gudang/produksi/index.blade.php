@extends('layouts.gudang')

@section('title', 'Produksi Barang - Stockiva')
@section('page-title', 'Produksi Barang')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item active">Produksi</li>
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
                                <td>Tanggal</td>
                                <td>: {{ $pesanan->created_at->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">Client</td>
                                <td width="70%">: <strong>{{ $pesanan->client->nama_client ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td>PIC</td>
                                <td>: {{ $pesanan->client->nama_pic ?? '-' }} ({{ $pesanan->client->jabatan_pic ?? '-' }})</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Produksi --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Input Progres Produksi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('gudang.produksi.update', $pesanan->id) }}" method="POST">
                    @csrf
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Jenis</th>
                                    <th>Satuan</th>
                                    <th>Jumlah Pesanan</th>
                                    <th>Sudah Diproduksi</th>
                                    <th>Tambah Produksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesanan->details as $index => $detail)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                                    <td class="text-center">{{ $detail->kategori->name_kategori ?? '-' }}</td>
                                    <td class="text-center">{{ $detail->jenis->name_jenis ?? '-' }}</td>
                                    <td class="text-center">{{ $detail->barang->satuan->nama_satuan ?? '-' }}</td>
                                    <td class="text-center">{{ $detail->jumlah }}</td>
                                    <td class="text-center">{{ $detail->produced_qty }}</td>
                                    <td class="text-center">
                                        <input type="number" 
                                            class="form-control form-control-sm" 
                                            name="tambah[{{ $detail->id }}]" 
                                            placeholder="0"
                                            min="0"
                                            max="{{ $detail->jumlah - $detail->produced_qty }}"
                                            placeholder="Tambah"
                                            style="width: 100px; margin: 0 auto;">
                                        <small class="text-muted">Sisa: {{ $detail->jumlah - $detail->produced_qty }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('gudang.tugas-gudang.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Progres
                        </button>
                    </div>
                </form>
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
    .table-borderless td {
        padding: 0.3rem 0;
    }
</style>
@endpush