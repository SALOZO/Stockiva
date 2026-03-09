@extends('layouts.gudang')

@section('title', 'Upload Dokumen - Stockiva')
@section('page-title', 'Upload Dokumen')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('gudang.tugas-gudang.index') }}">Tugas Gudang</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.pengiriman.index', $pengiriman->pesanan_id) }}">Pengiriman</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gudang.upload.index', $pengiriman->id) }}">Upload</a></li>
    <li class="breadcrumb-item active">Upload {{ str_replace('_', ' ', ucwords($jenis)) }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    Upload 
                    @switch($jenis)
                        @case('surat_jalan') Surat Jalan @break
                        @case('bast_ekspedisi') BAST Ekspedisi @break
                        @case('bast_client') BAST Client @break
                    @endswitch
                </h5>
            </div>
            <div class="card-body">
                {{-- Info Pengiriman --}}
                {{-- <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Pengiriman:</strong> {{ $pengiriman->no_pengiriman }} (Ke-{{ $pengiriman->pengiriman_ke }})
                    <br>
                    <strong>Client:</strong> {{ $pengiriman->pesanan->client->nama_client ?? '-' }}
                </div> --}}

                {{-- Form Upload --}}
                <form action="{{ route('gudang.upload.store', [$pengiriman->id, $jenis]) }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="file" class="form-label">
                            Pilih File <span class="text-danger">*</span>
                        </label>
                        <input type="file" 
                               class="form-control @error('file') is-invalid @enderror" 
                               id="file" 
                               name="file" 
                               accept=".pdf,.jpg,.jpeg,.png"
                               required>
                        <small class="text-muted">
                            Format: PDF, JPG, JPEG, PNG. Maks: 5MB
                        </small>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                  id="catatan" 
                                  name="catatan" 
                                  rows="3">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('gudang.upload.index', $pengiriman->id) }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-upload"></i> Upload
                        </button>
                    </div>
                </form>

                {{-- Preview File Lama (Jika Ada) --}}
                @php
                    $dokumenLama = \App\Models\DokumenPengiriman::where('pengiriman_id', $pengiriman->id)
                                    ->where('jenis', $jenis)
                                    ->latest()
                                    ->first();
                @endphp

                @if($dokumenLama)
                <hr>
                <div class="mt-3">
                    <h6 class="fw-bold">File Sebelumnya</h6>
                    <div class="alert alert-light border">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                {{ basename($dokumenLama->file_path) }}
                                <br>
                                <small class="text-muted">
                                    Diupload: {{ $dokumenLama->uploaded_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <a href="{{ route('gudang.upload.download', $dokumenLama->id) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>
                    </div>
                    <small class="text-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        Upload file baru akan menambah riwayat baru, tidak menghapus yang lama.
                    </small>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview file name
    document.getElementById('file').addEventListener('change', function(e) {
        let fileName = e.target.files[0]?.name;
        if (fileName) {
            // Optional: tampilkan nama file yang dipilih
        }
    });
</script>
@endpush