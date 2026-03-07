@extends('layouts.gudang')

@section('title', 'Update Penerima Client - Stockiva')
@section('page-title', 'Update Penerima Client')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}">Pengiriman</a></li>
    <li class="breadcrumb-item active">Update Client</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Update Penerima Client</h5>
            </div>
            <div class="card-body">
                {{-- Info Pengiriman --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%"><strong>No. SPH</strong></td>
                                <td>: {{ $pengiriman->pesanan->no_sph_formatted ?? 'SPH/'.$pengiriman->pesanan->no_pesanan }}</td>
                            </tr>
                            <tr>
                                <td><strong>Client</strong></td>
                                <td>: {{ $pengiriman->pesanan->client->nama_client ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pengiriman Ke</strong></td>
                                <td>: {{ $pengiriman->pengiriman_ke }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Tanggal Kirim</strong></td>
                                <td>: {{ $pengiriman->tanggal->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ekspedisi</strong></td>
                                <td>: {{ $pengiriman->ekspedisi->nama_ekspedisi ?? '-' }} ({{ $pengiriman->nama_kurir ?? '-' }})</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Detail Item --}}
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Detail Item Pengiriman</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Kirim</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach($pengiriman->detailPengiriman as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail->detailPesanan->barang->nama_barang ?? '-' }}</td>
                                        <td>{{ $detail->jumlah_kirim }}</td>
                                        <td>{{ $detail->detailPesanan->barang->satuan->nama_satuan ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Form Update Client --}}
                <form action="{{ route('gudang.pengiriman.update-client', $pengiriman->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="penerima_client" class="form-label">Nama Penerima Client <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('penerima_client') is-invalid @enderror" 
                               id="penerima_client" 
                               name="penerima_client" 
                               value="{{ old('penerima_client', $pengiriman->penerima_client) }}"
                               placeholder="Masukkan nama penerima dari client"
                               required>
                        @error('penerima_client')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file_bast_client" class="form-label">Upload BAST Client</label>
                        <input type="file" 
                               class="form-control @error('file_bast_client') is-invalid @enderror" 
                               id="file_bast_client" 
                               name="file_bast_client" 
                               accept=".pdf">
                        <small class="text-muted">Format: PDF, Maks: 2MB</small>
                        @error('file_bast_client')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($pengiriman->bast_client_file)
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="bi bi-check-circle"></i> 
                                    File sudah ada: {{ basename($pengiriman->bast_client_file) }}
                                </small>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection