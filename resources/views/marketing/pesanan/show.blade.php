<!-- resources/views/marketing/pesanan/show.blade.php -->
@extends('layouts.marketing')

@section('title', 'Detail Pesanan - Stockiva Marketing')
@section('page-title', 'Detail Pesanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('marketing.pesanan.index') }}">Pilih Client</a></li>
    <li class="breadcrumb-item"><a href="{{ route('marketing.semua-pesanan') }}">Semua Pesanan</a></li>
    <li class="breadcrumb-item active">Detail Pesanan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        {{-- HEADER PESANAN --}}
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Pesanan</h5>
                    {{-- <div>
                        <span class="badge bg-primary me-2">{{ $pesanan->no_pesanan }}</span>
                        {!! $pesanan->status_badge !!}
                    </div> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Info Client --}}
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-building me-2"></i>
                            Data Client
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">Nama Client</td>
                                <td width="70%">: <strong>{{ $pesanan->client->nama_client }}</strong></td>
                            </tr>
                            <tr>
                                <td>PIC</td>
                                <td>: {{ $pesanan->client->nama_pic }} ({{ $pesanan->client->jabatan_pic }})</td>
                            </tr>
                            <tr>
                                <td>Kontak</td>
                                <td>: {{ $pesanan->client->email_pic ?? '-' }} / {{ $pesanan->client->no_telp_pic ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $pesanan->client->alamat }}, {{ $pesanan->client->desa }}, {{ $pesanan->client->kecamatan }}, {{ $pesanan->client->kabupaten_kota }}, {{ $pesanan->client->provinsi }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    {{-- Info Pesanan --}}
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-cart me-2"></i>
                            Data Pesanan
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">No. Pesanan</td>
                                <td width="70%">: <strong>{{ $pesanan->no_sph_formatted }}</strong></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>: {{ $pesanan->tanggal_pesanan->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: {!! $pesanan->status_badge !!}</td>
                            </tr>
                            <tr>
                                <td>Dibuat Oleh</td>
                                <td>: {{ $pesanan->createdBy->name ?? '-' }} ({{ $pesanan->createdBy->jabatan ?? '-' }})</td>
                            </tr>
                            <tr>
                                <td>Dibuat Pada</td>
                                <td>: {{ $pesanan->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status SPH --}}
        @if($pesanan->sph_status != 'draft')
            <div class="mb-3">
                <strong>Status SPH:</strong> 
                @switch($pesanan->sph_status)
                    @case('menunggu')
                        <span class="badge bg-warning">Menunggu Approval Direktur</span>
                        @break
                    @case('disetujui')
                        <span class="badge bg-success">
                            Disetujui {{ $pesanan->approved_at?->format('d/m/Y') }}
                        </span>
                        @break
                    @case('ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                        @if($pesanan->approval_notes)
                            <p class="mt-2 mb-0"><strong>Catatan:</strong> {{ $pesanan->approval_notes }}</p>
                        @endif
                        @break
                @endswitch
            </div>
        </div>
        @endif

        {{-- DAFTAR ITEM PESANAN --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Detail Item Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Kategori</th>
                                <th width="15%">Jenis</th>
                                <th width="20%">Nama Barang</th>
                                <th width="10%">Satuan</th>
                                <th width="10%">Jumlah</th>
                                <th width="10%">Harga</th>
                                <th width="20%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($pesanan->details as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->kategori->name_kategori ?? '-' }}</td>
                                <td>{{ $detail->jenis->name_jenis ?? '-' }}</td>
                                <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                                <td>{{ $detail->barang->satuan->nama_satuan ?? '-' }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-end fw-bold">TOTAL</td>
                                <td class="text-center fw-bold text-primary">
                                    Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="d-flex justify-content-between align-items-start mt-4">
            <a href="{{ route('marketing.semua-pesanan') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>

            <div class="d-flex gap-2 align-items-start">
                {{-- Shortcut ke Pengaturan SPH --}}
                <a href="{{ route('marketing.sph-settings.index') }}" 
                   class="btn btn-outline-secondary" 
                   target="_blank"
                   data-bs-toggle="tooltip" 
                   title="Atur format SPH">
                    <i class="bi bi-gear"></i> Pengaturan SPH
                </a>

                {{-- Preview SPH --}}
                <div class="d-flex flex-column align-items-center">
                    <button type="button" 
                            class="btn btn-info"
                            id="btnPreview"
                            data-pesanan-id="{{ $pesanan->id }}">
                        <i class="bi bi-eye"></i> Preview SPH
                    </button>
                </div>

                {{-- Cetak SPH (draft) --}}
                @if($pesanan->sph_status == 'draft')
                <form action="{{ route('marketing.pesanan.generate-sph', $pesanan->id) }}" 
                      method="POST" 
                      class="d-inline">
                    @csrf
                    <button type="submit" 
                            class="btn btn-success"
                            onclick="return confirm('Buat SPH?')">
                        <i class="bi bi-file-pdf"></i> Cetak SPH
                    </button>
                </form>
                @endif

                {{-- Download SPH (jika sudah ada file) --}}
                @if($pesanan->sph_file || $pesanan->sph_approved_file)
                <a href="{{ route('marketing.pesanan.download-sph', $pesanan->id) }}" 
                   class="btn btn-info"
                   target="_blank">
                    <i class="bi bi-download"></i> Download SPH
                </a>
                @endif

                {{-- Edit (hanya jika draft/menunggu) --}}
                @if(in_array($pesanan->sph_status, ['draft']))
                <a href="{{ route('marketing.pesanan.edit', $pesanan->id) }}" 
                   class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                @endif
            </div>
        </div>

        {{-- AREA PREVIEW PDF --}}
        <div class="card mt-4" id="previewArea" style="display: none;">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-file-pdf text-danger me-2"></i>
                    <strong>Preview SPH</strong> - {{ $pesanan->no_sph_formatted }}
                </span>
                <div>
                    <span class="badge bg-warning me-2">PREVIEW</span>
                    <button type="button" class="btn-close" id="closePreview"></button>
                </div>
            </div>
            <div class="card-body p-0">
                <iframe id="previewFrame" 
                        src="" 
                        style="width: 100%; height: 600px; border: none; border-radius: 0 0 8px 8px;">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-borderless td {
        padding: 0.3rem 0;
    }
    
    .badge {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
    
    .btn {
        padding: 0.6rem 1.2rem;
    }
    
    .btn i {
        margin-right: 0.3rem;
    }
    
    .table td, .table th {
        vertical-align: middle;
    }
    
    @media print {
        .sidebar, .btn, .card-header, .breadcrumb, footer, #previewArea {
            display: none !important;
        }
        .main-content {
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // ========== PREVIEW SPH ==========
        $('#btnPreview').click(function() {
            let pesananId = $(this).data('pesanan-id');
            
            // Tampilkan loading
            $('#previewArea').slideDown();
            $('#previewFrame').attr('src', 'about:blank');
            
            // Set iframe source
            let previewUrl = '/marketing/pesanan/' + pesananId + '/preview-sph';
            $('#previewFrame').attr('src', previewUrl);
            
            // Scroll ke preview
            $('html, body').animate({
                scrollTop: $('#previewArea').offset().top - 20
            }, 500);
        });

        // ========== TUTUP PREVIEW ==========
        $('#closePreview').click(function() {
            $('#previewFrame').attr('src', '');
            $('#previewArea').slideUp();
        });

        // ========== TOOLTIP ==========
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // ========== AUTO HIDE ALERT ==========
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    });
</script>
@endpush