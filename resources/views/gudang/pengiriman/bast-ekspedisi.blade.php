@extends('layouts.gudang')

@section('title', 'BAST Ekspedisi - Stockiva')
@section('page-title', 'Buat BAST Ekspedisi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}">Pengiriman</a></li>
    <li class="breadcrumb-item active">BAST Ekspedisi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form BAST Ekspedisi</h5>
            </div>
            <div class="card-body">
                {{-- Info Pengiriman (Readonly) --}}
                <div class="row mb-4 p-3 bg-light rounded">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Data Pengiriman</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="35%">No. SPH</td>
                                <td>: <strong>{{ $pengiriman->pesanan->no_sph_formatted }}</strong></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>: {{ $pengiriman->tanggal->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: {!! $pengiriman->status_badge !!}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Data Client</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="35%">Nama Client</td>
                                <td>: <strong>{{ $pengiriman->pesanan->client->nama_client ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td>PIC</td>
                                <td>: {{ $pengiriman->pesanan->client->nama_pic ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $pengiriman->pesanan->client->alamat ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Data Ekspedisi & Kurir --}}
                {{-- <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Data Ekspedisi</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="35%">Ekspedisi</td>
                                <td>: <strong>{{ $pengiriman->ekspedisi->nama_ekspedisi ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td>Nama Kurir</td>
                                <td>: {{ $pengiriman->nama_kurir ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div> --}}

                <form action="{{ route('gudang.pengiriman.cetak-bast-ekspedisi', $pengiriman->id) }}" 
                method="POST">
                @csrf
                    {{-- Daftar Barang --}}
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Barang Kiriman</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="bg-light text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah</th>
                                                    <th>Satuan Kirim</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                @foreach($pengiriman->detailPengiriman as $index => $detail)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $detail->detailPesanan->barang->nama_barang ?? '-' }}</td>
                                                    <td>{{ $detail->jumlah_kirim }}</td>
                                                    <td>
                                                        <select class="form-select form-select-sm @error('satuan_kirim.' . $detail->id) is-invalid @enderror" 
                                                                name="satuan_kirim[{{ $detail->id }}]" 
                                                                required>
                                                            <option value="">-- Pilih Satuan Kirim --</option>
                                                            @foreach($satuanKirimList as $satuan)
                                                                <option value="{{ $satuan->id }}" 
                                                                    {{ old('satuan_kirim.' . $detail->id, $detail->satuanKirim->id ?? '') == $satuan->id ? 'selected' : '' }}>
                                                                    {{ $satuan->nama_satuan }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('satuan_kirim.' . $detail->id)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                            {{-- Form Input Data Tambahan --}}
                <form action="{{ route('gudang.pengiriman.cetak-bast-ekspedisi', $pengiriman->id) }}" 
                      method="POST">
                    @csrf
                        <h6 class="fw-bold mb-3">Data Ekspedisi & Kurir</h6>
                            <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="ekspedisi_id" class="form-label">Ekspedisi</label>

                                        <select class="form-select" disabled>
                                            <option value="">-- Pilih Ekspedisi --</option>
                                            @foreach($ekspedisiList as $ekspedisi)
                                                <option value="{{ $ekspedisi->id }}" 
                                                    {{ $pengiriman->ekspedisi_id == $ekspedisi->id ? 'selected' : '' }}>
                                                    {{ $ekspedisi->nama_ekspedisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="ekspedisi_id" value="{{ $pengiriman->ekspedisi_id }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_kurir" class="form-label">Nama Kurir <span class="text-danger">*</span></label>
                                        <input type="text" 
                                        class="form-control @error('nama_kurir') is-invalid @enderror" 
                                        id="nama_kurir" 
                                        name="nama_kurir" 
                                        value="{{ old('nama_kurir', $pengiriman->nama_kurir ?? '') }}"
                                        required>
                                        @error('nama_kurir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="kurir_no_telp" class="form-label">No Telepon Kurir <span class="text-danger">*</span></label>
                                        <input type="text" 
                                        class="form-control @error('kurir_no_telp') is-invalid @enderror" 
                                        id="kurir_no_telp" 
                                        name="kurir_no_telp" 
                                        value="{{ old('kurir_no_telp', $pengiriman->kurir_no_telp ?? '') }}"
                                        required>
                                        @error('kurir_no_telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="kurir_jenis_identitas" class="form-label">Jenis Identitas <span class="text-danger">*</span></label>
                                        <select class="form-select @error('kurir_jenis_identitas') is-invalid @enderror" 
                                            id="kurir_jenis_identitas" 
                                            name="kurir_jenis_identitas" 
                                            required>
                                            <option value="">-- Pilih Jenis Identitas --</option>
                                            <option value="SIM A" {{ old('kurir_jenis_identitas', $pengiriman->kurir_jenis_identitas ?? '') == 'SIM A' ? 'selected' : '' }}>SIM A</option>
                                            <option value="SIM C" {{ old('kurir_jenis_identitas', $pengiriman->kurir_jenis_identitas ?? '') == 'SIM C' ? 'selected' : '' }}>SIM C</option>
                                            <option value="SIM B1" {{ old('kurir_jenis_identitas', $pengiriman->kurir_jenis_identitas ?? '') == 'SIM B1' ? 'selected' : '' }}>SIM B1</option>
                                            <option value="SIM B2" {{ old('kurir_jenis_identitas', $pengiriman->kurir_jenis_identitas ?? '') == 'SIM B2' ? 'selected' : '' }}>SIM B2</option>
                                            <option value="KTP" {{ old('kurir_jenis_identitas', $pengiriman->kurir_jenis_identitas ?? '') == 'KTP' ? 'selected' : '' }}>KTP</option>
                                            <option value="Lainnya" {{ old('kurir_jenis_identitas', $pengiriman->kurir_jenis_identitas ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        @error('kurir_jenis_identitas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <div class="col-md-6 mb-3">
                                        <label for="kurir_no_identitas" class="form-label">No Identitas <span class="text-danger">*</span></label>
                                        <input type="text" 
                                        class="form-control @error('kurir_no_identitas') is-invalid @enderror" 
                                        id="kurir_no_identitas" 
                                        name="kurir_no_identitas" 
                                        value="{{ old('kurir_no_identitas', $pengiriman->kurir_no_identitas ?? '') }}"
                                        required>
                                        @error('kurir_no_identitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <div class="col-md-6 mb-3">
                                        <label for="kurir_plat_nomor" class="form-label">Plat Nomor Kendaraan <span class="text-danger">*</span></label>
                                        <input type="text" 
                                        class="form-control @error('kurir_plat_nomor') is-invalid @enderror" 
                                        id="kurir_plat_nomor" 
                                        name="kurir_plat_nomor" 
                                        value="{{ old('kurir_plat_nomor', $pengiriman->kurir_plat_nomor ?? '') }}"
                                        required>
                                        @error('kurir_plat_nomor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <div class="col-md-6 mb-3">
                                    <label for="penerima_ekspedisi" class="form-label">
                                        Penerima Ekspedisi <span class="text-danger">*</span>
                                    </label>
                                    
                                    <input type="text" 
                                    class="form-control @error('penerima_ekspedisi') is-invalid @enderror" 
                                    id="penerima_ekspedisi" 
                                    name="penerima_ekspedisi" 
                                    value="{{ old('penerima_ekspedisi', $pengiriman->pesanan->client->nama_pic ?? '-') }}"
                                    readonly>
                                    
                                    @error('penerima_ekspedisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-printer"></i> Cetak BAST Ekspedisi
                                </button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection