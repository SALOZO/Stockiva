@extends('layouts.direktur') {{-- sesuaikan dengan layout direktur yang sudah ada --}}

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Daftar Tagihan Menunggu Approval</h4>
        <span class="badge bg-warning fs-6">{{ $tagihans->count() }} Menunggu</span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-white text-center">
                    <tr>
                        <th>No. Tagihan</th>
                        <th>No. SPH</th>
                        <th>Client</th>
                        <th>Total Nilai</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($tagihans as $t)
                    <tr>
                        <td>{{ $t->no_tagihan }}</td>
                        <td>{{ $t->no_sph }}</td>
                        <td>{{ $t->client->nama_client }}</td>
                        <td>Rp {{ number_format($t->total_keseluruhan, 0, ',', '.') }}</td>
                        <td>{{ $t->created_at->translatedFormat('d F Y') }}</td>
                        <td>
                            {{-- Preview PDF sebelum approve --}}
                            @if($t->tagihan_file)
                            <a href="{{ Storage::url($t->tagihan_file) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-secondary me-1"
                               title="Preview">
                                <i class="bi bi-eye"></i>
                            </a>
                            @endif

                            {{-- Tombol Approve --}}
                            <form action="{{ route('direktur.tagihan.approve', $t->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Tandatangani tagihan ini?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="bi bi-pen"></i> Tandatangani
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Tidak ada tagihan menunggu approval
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection