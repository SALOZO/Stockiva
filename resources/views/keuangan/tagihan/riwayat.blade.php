@extends(auth()->user()->jabatan == 'Keuangan' ? 'layouts.keuangan' : (auth()->user()->jabatan == 'Direktur' ? 'layouts.direktur' : 'layouts.gudang'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Riwayat Tagihan</h4>
        <span class="badge bg-primary fs-6">{{ $tagihans->count() }} Tagihan</span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-white text-center">
                    <tr>
                        <th>No. Tagihan</th>
                        <th>No. SPH</th>
                        <th>Client</th>
                        <th>Tanggal Approve</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($tagihans as $t)
                    <tr>
                        <td><strong>{{ $t->no_tagihan }}</strong></td>
                        <td>{{ $t->no_sph }}</td>
                        <td>{{ $t->client->nama_client }}</td>
                        <td>{{ $t->tagihan_approved_at->translatedFormat('d/m/Y') }}</td>
                        <td>Rp {{ number_format($t->total_keseluruhan, 0, ',', '.') }}</td>
                        <td>
                            @if($t->tagihan_approved_file)
                            <a href="{{ Storage::url($t->tagihan_approved_file) }}"
                               target="_blank"
                               class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i> Preview
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada tagihan yang disetujui
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection