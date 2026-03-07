@extends('layouts.gudang')

@section('title', 'Update Ekspedisi - Stockiva')
@section('page-title', 'Update Ekspedisi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}">Pengiriman</a></li>
    <li class="breadcrumb-item active">Update Ekspedisi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Update Data Ekspedisi</h5>
            </div>
            <div class="card-body">
                {{-- Info Pengiriman --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%"><strong>No. SPH</strong></td>
                                <td>: {{ $pengiriman->pesanan->no_sph_formatted}}</td>
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
                                <td><strong>Tanggal</strong></td>
                                <td>: {{ $pengiriman->tanggal->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>: {!! $pengiriman->status_badge !!}</td>
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

                {{-- Form Update Ekspedisi --}}
                <form action="{{ route('gudang.pengiriman.update-ekspedisi', $pengiriman->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_ekspedisi" class="form-label">Nama Ekspedisi <span class="text-danger">*</span></label>
                            <select class="form-select @error('ekspedisi') is-invalid @enderror"
                                    id="ekspedisi"
                                    name="ekspedisi"
                                    required>

                                <option value="">-- Pilih Ekspedisi --</option>

                                @foreach($ekspedisiList as $ekspedisi)
                                <option value="{{ $ekspedisi->nama_ekspedisi }}"
                                    @selected(old('ekspedisi', $pengiriman->ekspedisi) == $ekspedisi->nama_ekspedisi)>

                                    {{ $ekspedisi->nama_ekspedisi }}

                                    @if($ekspedisi->nama_pic)
                                        ({{ $ekspedisi->nama_pic }})
                                    @endif

                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama_kurir" class="form-label">Nama Kurir <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_kurir') is-invalid @enderror" 
                                   id="nama_kurir" 
                                   name="nama_kurir" 
                                   value="{{ old('nama_kurir', $pengiriman->nama_kurir) }}"
                                   placeholder="Masukkan nama kurir"
                                   required>
                            @error('nama_kurir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="file_bast" class="form-label">Upload BAST Ekspedisi</label>
                        <input type="file" 
                               class="form-control @error('file_bast') is-invalid @enderror" 
                               id="file_bast" 
                               name="file_bast" 
                               accept=".pdf">
                        <small class="text-muted">Format: PDF, Maks: 2MB</small>
                        @error('file_bast')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($pengiriman->bast_ekspedisi_file)
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="bi bi-check-circle"></i> 
                                    File sudah ada: {{ basename($pengiriman->bast_ekspedisi_file) }}
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