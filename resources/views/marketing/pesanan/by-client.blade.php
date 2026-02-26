<!-- resources/views/marketing/pesanan/by-client.blade.php -->
@extends('layouts.marketing')

@section('title', 'Pesanan Client - Stockiva Marketing')
@section('page-title', 'Pesanan Client: ' . $client->nama_client)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('marketing.pesanan.index') }}">Pilih Client</a></li>
    <li class="breadcrumb-item active">Pesanan {{ $client->nama_client }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Info Client --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="mb-1">{{ $client->nama_client }}</h4>
                        <p class="mb-0 text-muted">
                            <i class="bi bi-person me-1"></i>{{ $client->nama_pic }} ({{ $client->jabatan_pic }})<br>
                            <i class="bi bi-envelope me-1"></i>{{ $client->email_pic ?? '-' }} | 
                            <i class="bi bi-telephone me-1"></i>{{ $client->no_telp_pic ?? '-' }}
                        </p>
                    </div>
                    <a href="{{ route('marketing.pesanan.create', ['client_id' => $client->id]) }}" 
                       class="btn btn-primary ms-auto">
                        <i class="bi bi-plus-circle me-1"></i>Buat Pesanan Baru
                    </a>
                </div>
            </div>
        </div>

{{-- Daftar Pesanan --}}
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Riwayat Pesanan</h5>
    </div>
    <div class="card-body">
        @if($pesanans->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-light text-center">
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Tanggal</th>
                        <th>Jumlah Item</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($pesanans as $pesanan)
                    <tr>
                        <td><strong>{{ $pesanan->no_pesanan }}</strong></td>
                        <td>{{ $pesanan->tanggal_pesanan->format('d/m/Y') }}</td>
                        <td>{{ $pesanan->details->count() }} item</td>
                        <td class="fw-bold">Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</td>
                        <td>{!! $pesanan->status_badge !!}</td>
                        <td>
                            <div class="btn-group" role="group">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('marketing.pesanan.show', $pesanan->id) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   data-bs-toggle="tooltip" 
                                   title="Lihat Detail Pesanan">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                {{-- Tombol Hapus --}}
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#hapusPesananModal{{ $pesanan->id }}"
                                        title="Hapus Pesanan">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            {{-- Modal Hapus Pesanan --}}
                            <div class="modal fade" id="hapusPesananModal{{ $pesanan->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                                                Konfirmasi Hapus Pesanan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin menghapus pesanan berikut?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('marketing.pesanan.destroy', $pesanan->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger px-4">
                                                    <i class="bi bi-trash me-1"></i>
                                                    Ya, Hapus Pesanan
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $pesanans->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-4 d-block mb-3 text-muted"></i>
            <h5>Belum Ada Pesanan</h5>
            <p class="mb-3">Client ini belum memiliki riwayat pesanan.</p>
            <a href="{{ route('marketing.pesanan.create', ['client_id' => $client->id]) }}" 
               class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Buat Pesanan Pertama
            </a>
        </div>
        @endif
    </div>
</div>


        {{-- Tombol Kembali --}}
        <div class="mt-3">
            <a href="{{ route('marketing.pesanan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Client
            </a>
        </div>
    </div>
</div>
@endsection