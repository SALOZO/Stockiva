<!-- resources/views/gudang/pengiriman/bast-client.blade.php -->
@extends('layouts.gudang')

@section('title', 'BAST Client - Stockiva')
@section('page-title', 'Buat BAST Client')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}">Pengiriman</a></li>
    <li class="breadcrumb-item active">BAST Client</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Info SPH & Pengiriman --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pengiriman</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%"><strong>No. SPH</strong></td>
                                <td>: {{ $pengiriman->pesanan->no_sph_formatted }}</td>
                            </tr>
                            {{-- <tr>
                                <td><strong>No. Pengiriman</strong></td>
                                <td>: {{ $pengiriman->no_pengiriman }}</td>
                            </tr> --}}
                            <tr>
                                <td><strong>Pengiriman Ke</strong></td>
                                <td>: {{ $pengiriman->pengiriman_ke }}</td>
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
            </div>
        </div>

        {{-- Form BAST Client --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form BAST Client</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('gudang.pengiriman.cetak-bast-client', $pengiriman->id) }}" method="POST">
                    @csrf
                    
                    {{-- Data Penyerahan --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hari_penyerahan" class="form-label">Hari Penyerahan <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('hari_penyerahan') is-invalid @enderror" 
                                   id="hari_penyerahan" 
                                   name="hari_penyerahan" 
                                   value="{{ old('hari_penyerahan', $pengiriman->hari_penyerahan ?? '') }}"
                                   placeholder="Contoh: Senin"
                                   required>
                            @error('hari_penyerahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_penyerahan" class="form-label">Tanggal Penyerahan <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('tanggal_penyerahan') is-invalid @enderror" 
                                   id="tanggal_penyerahan" 
                                   name="tanggal_penyerahan" 
                                   value="{{ old('tanggal_penyerahan', $pengiriman->tanggal_penyerahan ?? date('Y-m-d')) }}"
                                   required>
                            @error('tanggal_penyerahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Data Penerima --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="penerima_client" class="form-label">
                                Nama Penerima <span class="text-danger">*</span>
                            </label>

                            <input type="text" 
                                class="form-control @error('penerima_client') is-invalid @enderror" 
                                id="penerima_client" 
                                name="penerima_client" 
                                value="{{ old('penerima_client', $pengiriman->penerima_client ?? '') }}"
                                required>

                            @error('penerima_client')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan_penerima" class="form-label">Jabatan Penerima <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('jabatan_penerima') is-invalid @enderror" 
                                   id="jabatan_penerima" 
                                   name="jabatan_penerima" 
                                   value="{{ old('jabatan_penerima', $pengiriman->jabatan_penerima ?? '') }}"
                                   placeholder="Contoh: Manager"
                                   required>
                            @error('jabatan_penerima')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Data Ekspedisi (Readonly) --}}
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Data Ekspedisi</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Ekspedisi:</strong> {{ $pengiriman->ekspedisi ?? '-' }}</p>
                                    <p><strong>Nama Kurir:</strong> {{ $pengiriman->nama_kurir ?? '-' }}</p>
                                    <p><strong>No Telp Kurir:</strong> {{ $pengiriman->kurir_no_telp ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Identitas:</strong> {{ $pengiriman->kurir_jenis_identitas ?? '-' }}</p>
                                    <p><strong>No. Identitas:</strong> {{ $pengiriman->kurir_no_identitas ?? '-' }}</p>
                                    <p><strong>Plat Nomer :</strong> {{ $pengiriman->kurir_plat_nomor ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Preview Barang --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Barang yang Dikirim</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        {{-- <th>Satuan Kirim</th> --}}
                                        <th>Satuan Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengiriman->detailPengiriman as $index => $detail)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $detail->detailPesanan->barang->nama_barang ?? '-' }}</td>
                                        <td class="text-center">{{ $detail->jumlah_kirim }}</td>
                                        {{-- <td class="text-center">{{ $detail->satuanKirim->nama_satuan ?? 'Koli' }}</td> --}}
                                        <td class="text-center">{{ $detail->detailPesanan->barang->satuan->nama_satuan ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Sebanyak</h6>
                            @php
                                $grouped = $pengiriman->detailPengiriman->groupBy('satuan_kirim_id');
                            @endphp
                            
                            @foreach($pengiriman->detailPengiriman as $detail)
                                <div>
                                    {{-- {{ $detail->detailPesanan->barang->nama_barang ?? '-' }}:  --}}
                                    {{ $detail->jumlah_kirim }} {{ $detail->satuanKirim->nama_satuan ?? 'Koli' }}
                                </div>
                            @endforeach
        
                            
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-printer"></i> Cetak BAST Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection