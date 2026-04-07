@extends($layout)

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Document Center</h4>
        <span class="badge bg-primary fs-6">{{ $pesanans->total() }} SPH</span>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-white text-center">
                    <tr>
                        <th>No. SPH</th>
                        <th>Client</th>
                        <th>Tanggal</th>
                        @if(in_array(auth()->user()->jabatan, ['Marketing', 'Direktur']))
                        <th>Status</th>
                        @endif
                        {{-- <th>Dokumen Tersedia</th> --}}
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($pesanans as $p)
                    <tr>
                        <td><strong>{{ $p->no_sph }}</strong></td>
                        <td>{{ $p->client->nama_client }}</td>
                        <td>{{ $p->tanggal_pesanan->translatedFormat('d F Y') }}</td>
                        @if(in_array(auth()->user()->jabatan, ['Marketing', 'Direktur']))
                            <td>
                                @if($p->status_terbit)
                                    <span class="badge bg-success">Sudah Terbit</span>
                                @else
                                    <span class="badge bg-secondary">Belum Terbit</span>
                                @endif
                            </td>
                        @endif
                        <td>
                            <a href="{{ route('direktur.dokumen.detail', $p->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-folder2-open"></i> Lihat Dokumen
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada dokumen
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pesanans->hasPages())
        <div class="card-footer">
            {{ $pesanans->links() }}
        </div>
        @endif
    </div>

</div>
@endsection