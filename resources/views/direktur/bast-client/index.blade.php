@extends('layouts.direktur')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">BAST Client Menunggu TTD</h4>
        <span class="badge bg-warning fs-6">{{ $bastList->count() }} Menunggu</span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-white text-center">
                    <tr>
                        <th>No. BAST</th>
                        <th>Client</th>
                        <th>Pengiriman Ke</th>
                        <th>Tanggal Cetak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($bastList as $bast)
                    <tr>
                        <td>{{ $bast->no_bast }}</td>
                        <td>{{ $bast->pesanan->client->nama_client }}</td>
                        <td>{{ $bast->pengiriman_ke }}</td>
                        <td>{{ $bast->updated_at->translatedFormat('d F Y') }}</td>
                        <td>
                            {{-- Preview PDF sebelum TTD --}}
                            @if($bast->bast_client_file)
                            <a href="{{ Storage::url($bast->bast_client_file) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            @endif

                            {{-- Tombol TTD --}}
                            <form action="{{ route('direktur.bast-client.approve', $bast->id) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Tambahkan tanda tangan ke BAST Client ini?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="bi bi-pen"></i> Approved
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Tidak ada BAST Client menunggu tanda tangan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection