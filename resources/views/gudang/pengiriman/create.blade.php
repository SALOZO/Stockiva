@extends('layouts.gudang')

@section('title', 'Buat Pengiriman - Stockiva')
@section('page-title', 'Buat Pengiriman Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.pengiriman.index', $pesanan->id) }}">Pengiriman</a></li>
    <li class="breadcrumb-item active">Buat Baru</li>
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
                                <td>Client</td>
                                <td>: <strong>{{ $pesanan->client->nama_client ?? '-' }}</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">Tanggal</td>
                                <td width="70%">: {{ $pesanan->created_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Total Produksi</td>
                                <td>: {{ $pesanan->details->sum('produced_qty') }}/{{ $pesanan->details->sum('jumlah') }} item</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Pengiriman --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pilih Barang yang Akan Dikirim</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('gudang.pengiriman.store', $pesanan->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Pengiriman <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control @error('tanggal') is-invalid @enderror" 
                               id="tanggal" 
                               name="tanggal" 
                               value="{{ old('tanggal', date('Y-m-d')) }}"
                               style="width: 200px;"
                               required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                                    <th>Sudah Produksi</th>
                                    <th>Jumlah Kirim</th>
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
                                    <td>
                                        <input type="number" 
                                               class="form-control form-control-sm kirim-input"
                                               name="kirim[{{ $detail->id }}]" 
                                               value="0"
                                               min="0"
                                               max="{{ $detail->produced_qty }}"
                                               data-max="{{ $detail->produced_qty }}"
                                               data-nama="{{ $detail->barang->nama_barang }}"
                                               style="width: 100px; margin: 0 auto;">
                                        <small class="text-muted">Maks: {{ $detail->produced_qty }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                  id="catatan" 
                                  name="catatan" 
                                  rows="2">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('gudang.pengiriman.index', $pesanan->id) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="bi bi-save"></i> Buat Pengiriman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Validasi client-side
        $('form').submit(function(e) {
            let valid = true;
            let totalKirim = 0;
            
            $('.kirim-input').each(function() {
                let val = parseInt($(this).val()) || 0;
                let max = parseInt($(this).data('max'));
                let nama = $(this).data('nama');
                
                if (val > max) {
                    alert('Jumlah kirim ' + nama + ' melebihi stok produksi (' + max + ')');
                    valid = false;
                    return false;
                }
                
                totalKirim += val;
            });
            
            if (totalKirim === 0) {
                alert('Minimal harus mengirim 1 barang');
                valid = false;
            }
            
            if (!valid) {
                e.preventDefault();
            } else {
                $('#btnSubmit').prop('disabled', true).html('<i class="bi bi-hourglass"></i> Menyimpan...');
            }
        });
    });
</script>
@endpush