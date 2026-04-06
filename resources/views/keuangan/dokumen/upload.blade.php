@extends('layouts.keuangan')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('keuangan.index') }}">Data Siap Tagih</a></li>
            <li class="breadcrumb-item active">Upload Dokumen</li>
        </ol>
    </nav>

    <h4 class="fw-bold mb-4">Upload Dokumen Keuangan</h4>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Info Pesanan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Informasi Pesanan</h6>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td class="text-muted" style="width:140px;">No. SPH</td>
                            <td>: <strong>{{ $pesanan->no_sph }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Client</td>
                            <td>: {{ $pesanan->client->nama_client }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td class="text-muted" style="width:140px;">Total Nilai</td>
                            <td>: Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. Invoice</td>
                            <td>: {{ $pesanan->no_invoice ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. Tagihan</td>
                            <td>: {{ $pesanan->no_tagihan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Upload --}}
    <div class="row g-4 mb-4">

        {{-- Kwitansi --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100 text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-receipt" style="font-size:3rem; color:#f59e0b;"></i>
                </div>
                <h5 class="fw-bold mb-3">Kwitansi</h5>
                <button class="btn btn-outline-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#modalUpload"
                        data-jenis="kwitansi"
                        data-label="Kwitansi">
                    <i class="bi bi-upload me-1"></i> Upload Kwitansi
                </button>
            </div>
        </div>

        {{-- Faktur Pajak --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100 text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-file-earmark-text" style="font-size:3rem; color:#3b82f6;"></i>
                </div>
                <h5 class="fw-bold mb-3">Faktur Pajak</h5>
                <button class="btn btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalUpload"
                        data-jenis="faktur_pajak"
                        data-label="Faktur Pajak">
                    <i class="bi bi-upload me-1"></i> Upload Faktur Pajak
                </button>
            </div>
        </div>

    </div>

    {{-- Riwayat Upload --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Dokumen Upload</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Jenis Dokumen</th>
                        <th>Tanggal Upload</th>
                        <th>Upload Oleh</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($dokumens as $i => $dok)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            @if($dok->jenis === 'kwitansi')
                                <span class="badge bg-warning text-dark">Kwitansi</span>
                            @else
                                <span class="badge bg-primary">Faktur Pajak</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($dok->uploaded_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $dok->uploader->name ?? '-' }}</td>
                        <td>{{ $dok->catatan ?? '-' }}</td>
                        <td>
                            {{-- Preview --}}
                            <a href="{{ Storage::url($dok->file_path) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-info"
                               title="Preview">
                                <i class="bi bi-eye"></i>
                            </a>
                            {{-- Download --}}
                            <a href="{{ Storage::url($dok->file_path) }}"
                               download
                               class="btn btn-sm btn-outline-primary"
                               title="Download">
                                <i class="bi bi-download"></i>
                            </a>
                            {{-- Hapus --}}
                            <form action="{{ route('keuangan.dokumen.destroy', $dok->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus dokumen ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Belum ada dokumen diupload
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal Upload --}}
<div class="modal fade" id="modalUpload" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('keuangan.dokumen.store', $pesanan->id) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis" id="inputJenis">

                <div class="modal-header">
                    <h5 class="modal-title">Upload <span id="labelJenis"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih File <span id="labelJenis2"></span></label>
                        <input type="file" name="file" class="form-control"
                               accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="form-text">Format: PDF, JPG, PNG. Maksimal 5MB.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan catatan (jika ada)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Set jenis dokumen saat modal dibuka
document.getElementById('modalUpload').addEventListener('show.bs.modal', function (e) {
    const btn   = e.relatedTarget;
    const jenis = btn.getAttribute('data-jenis');
    const label = btn.getAttribute('data-label');

    document.getElementById('inputJenis').value = jenis;
    document.getElementById('labelJenis').textContent  = label;
    document.getElementById('labelJenis2').textContent = label;
});
</script>
@endsection