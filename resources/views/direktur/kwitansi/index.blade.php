@extends('layouts.direktur')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Kwitansi Menunggu TTD</h4>
        <span class="badge bg-warning fs-6">{{ $kwitansiss->count() }} Menunggu</span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-white text-center">
                    <tr>
                        <th>No. Kwitansi</th>
                        <th>No. SPH</th>
                        <th>Client</th>
                        <th>Total Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($kwitansiss as $k)
                    <tr>
                        <td>{{ $k->no_kwitansi }}</td>
                        <td>{{ $k->no_sph_formatted }}</td>
                        <td>{{ $k->client->nama_client }}</td>
                        <td>Rp {{ number_format($k->total_keseluruhan, 0, ',', '.') }}</td>
                        <td>
                            {{-- Preview sebelum TTD --}}
                            @if($k->kwitansi_file)
                            <a href="{{ Storage::url($k->kwitansi_file) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            @endif

                            {{-- Tandatangani & langsung download --}}
                            <form action="{{ route('direktur.kwitansi.approve', $k->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Tandatangani kwitansi ini?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="bi bi-pen"></i> Tandatangani & Unduh
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Tidak ada kwitansi menunggu tanda tangan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection