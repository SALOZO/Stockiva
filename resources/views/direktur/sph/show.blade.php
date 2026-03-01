@extends('layouts.direktur')

@section('title', 'Detail SPH - Stockiva')
@section('page-title', 'Detail SPH')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('direktur.sph.index') }}">SPH</a></li>
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
                    <span class="badge bg-warning">Menunggu Approval</span>
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
                                <td>: {{ $pesanan->client->email_pic ?? '-' }} / {{ $pesanan->client->no_telp_pic ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Informasi Pesanan</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">Tanggal</td>
                                <td>: {{ $pesanan->created_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Dibuat Oleh</td>
                                <td>: {{ $pesanan->createdBy->name ?? '-' }} ( {{ $pesanan->createdBy->jabatan ?? '-' }} )</td>
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

        {{-- Daftar Item --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Detail Item</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan->details as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                                <td>{{ $item->kategori->name_kategori ?? '-' }}</td>
                                <td>{{ $item->jenis->name_jenis ?? '-' }}</td>
                                <td class="text-center">{{ $item->barang->satuan->nama_satuan ?? '-' }}</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                <td class="text-end">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-end fw-bold">TOTAL</td>
                                <td class="text-end fw-bold">Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Preview PDF (iframe) --}}
        @if($pesanan->sph_file)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Preview SPH</h5>
            </div>
            <div class="card-body">
                <iframe src="{{ route('direktur.sph.preview', $pesanan->id) }}" 
                        style="width: 100%; height: 500px; border: 1px solid #ddd; border-radius: 8px;"></iframe>
            </div>
        </div>
        @endif

        {{-- Tombol Approve/Reject --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('direktur.sph.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            
            <div class="d-flex gap-2">
                {{-- Tombol Reject --}}
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="bi bi-x-circle"></i> Tolak
                </button>
                
                {{-- Tombol Approve --}}
                <form action="{{ route('direktur.sph.approve', $pesanan->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" 
                            onclick="return confirm('Setujui SPH ini? Tanda tangan akan ditambahkan.')">
                        <i class="bi bi-check-circle"></i> Approve
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Reject --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('direktur.sph.reject', $pesanan->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tolak SPH</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="notes" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak SPH</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection