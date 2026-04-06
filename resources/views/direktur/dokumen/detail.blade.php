@extends('layouts.direktur')

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('direktur.dokumen.index') }}">Document Center</a>
            </li>
            <li class="breadcrumb-item active">{{ $pesanan->no_sph }}</li>
        </ol>
    </nav>

    {{-- Info SPH --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
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
                            <td class="text-muted">Tanggal</td>
                            <td>: {{ $pesanan->tanggal_pesanan->translatedFormat('d F Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- DOKUMEN KONTRAK (SPK/PO/SP) --}}
    @if($pesanan->dokumenKontrak->count() > 0)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-bold">
            <i class="bi bi-file-earmark-ruled me-2 text-dark"></i>Dokumen Kontrak
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>Jenis</th>
                        <th>Nomor Kontrak</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($pesanan->dokumenKontrak as $kontrak)
                    <tr>
                        <td><span class="badge bg-dark">{{ $kontrak->jenis }}</span></td>
                        <td>{{ $kontrak->nomor_kontrak }}</td>
                        <td>{{ $kontrak->tanggal_kontrak->translatedFormat('d F Y') }}</td>
                        <td>@include('direktur.dokumen._aksi', ['path' => $kontrak->file_path])</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- DOKUMEN PESANAN --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-bold">
            <i class="bi bi-file-earmark-text me-2 text-primary"></i>Dokumen Pesanan
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width:25%;">Jenis Dokumen</th>
                        <th style="width:30%;">Nomor</th>
                        <th style="width:25%;">Tanggal TTD</th>
                        <th style="width:20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td><span class="badge bg-secondary">SPH</span></td>
                        <td>{{ $pesanan->no_sph }}</td>
                        <td>{{ $pesanan->approved_at?->translatedFormat('d F Y') ?? '-' }}</td>
                        <td>
                            @if($pesanan->sph_approved_file)
                                @include('direktur.dokumen._aksi', ['path' => $pesanan->sph_approved_file])
                            @else
                                <span class="text-muted small">Belum ada</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-info">Invoice</span></td>
                        <td>{{ $pesanan->no_invoice ?? '-' }}</td>
                        <td>{{ $pesanan->invoice_approved_at?->translatedFormat('d F Y') ?? '-' }}</td>
                        <td>
                            @if($pesanan->invoice_file)
                                @include('direktur.dokumen._aksi', ['path' => $pesanan->invoice_file])
                            @else
                                <span class="text-muted small">Belum ada</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-primary">Tagihan</span></td>
                        <td>{{ $pesanan->no_tagihan ?? '-' }}</td>
                        <td>{{ $pesanan->tagihan_approved_at?->translatedFormat('d F Y') ?? '-' }}</td>
                        <td>
                            @if($pesanan->tagihan_approved_file)
                                @include('direktur.dokumen._aksi', ['path' => $pesanan->tagihan_approved_file])
                            @else
                                <span class="text-muted small">Belum ada</span>
                            @endif
                        </td>
                    </tr>
                        @php
                            $kwitansi = $dokumenPengiriman->get('kwitansi',collect())->first();
                        @endphp
                    <tr>
                        <td><span class="badge bg-warning text-dark">Kwitansi</span></td>
                        <td>{{ $kwitansi ? $kwitansi->nomor_dokumen ?? '-' : '-' }}</td>
                        <td>{{ $kwitansi ? \Carbon\Carbon::parse($kwitansi->uploaded_at)->translatedFormat('d F Y') : '-' }}</td>
                        <td>
                            @if($kwitansi)
                                @include('direktur.dokumen._aksi', ['path' => $kwitansi->file_path])
                            @else
                                <span class="text-muted small">Belum ada</span>
                            @endif
                        </td>
                    </tr>
                        @php
                            $fakturPajak = $dokumenPengiriman->get('faktur_pajak', collect())->first();
                        @endphp
                    <tr>
                        <td><span class="badge bg-danger">Faktur Pajak</span></td>
                        <td>{{ $fakturPajak ? $fakturPajak->nomor_dokumen ?? '-' : '-' }}</td>
                        <td>{{ $fakturPajak ? \Carbon\Carbon::parse($fakturPajak->uploaded_at)->translatedFormat('d F Y') : '-' }}</td>
                        <td>
                            @if($fakturPajak)
                                @include('direktur.dokumen._aksi', ['path' => $fakturPajak->file_path])
                            @else
                                <span class="text-muted small">Belum ada</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- DOKUMEN PENGIRIMAN (SEMUA PENGIRIMAN) --}}
    @if($pesanan->pengiriman && $pesanan->pengiriman->count() > 0)
        @foreach($pesanan->pengiriman as $pengirimanItem)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-truck me-2 text-success"></i>
                Dokumen Pengiriman ke-{{ $pengirimanItem->pengiriman_ke }}
                @if($pengirimanItem->tanggal_pengiriman)
                    <small class="text-muted ms-2">({{ $pengirimanItem->tanggal_pengiriman->translatedFormat('d F Y') }})</small>
                @endif
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width:25%;">Jenis Dokumen</th>
                            <th style="width:25%;">Tanggal Upload</th>
                            <th style="width:15%;">Upload Oleh</th>
                            <th style="width:20%;">Catatan</th>
                            <th style="width:15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php
                            $jenisMap = [
                                'surat_jalan'   => ['label' => 'Surat Jalan',    'class' => 'bg-success'],
                                'bast_ekspedisi' => ['label' => 'BAST Ekspedisi', 'class' => 'bg-dark'],
                                'bast_client'   => ['label' => 'BAST Client',    'class' => 'bg-warning text-dark'],
                            ];
                            $adaDokumen = false;
                        @endphp

                        @foreach($jenisMap as $jenis => $config)
                            @foreach($dokumenPengiriman->get($jenis, collect()) as $dok)
                                @if($dok->pengiriman_id == $pengirimanItem->id)
                                    @php $adaDokumen = true; @endphp
                                    <tr>
                                        <td>
                                            <span class="badge {{ $config['class'] }}">
                                                {{ $config['label'] }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($dok->uploaded_at)->translatedFormat('d F Y H:i') }}</td>
                                        <td>{{ $dok->uploader->name ?? '-' }}</td>
                                        <td>{{ $dok->catatan ?? '-' }}</td>
                                        <td>@include('direktur.dokumen._aksi', ['path' => $dok->file_path])</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach

                        @if(!$adaDokumen)
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">
                                Belum ada dokumen untuk pengiriman ke-{{ $pengirimanItem->pengiriman_ke }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    @else
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center text-muted py-4">
                <i class="bi bi-truck fs-1"></i>
                <p class="mt-2 mb-0">Belum ada data pengiriman</p>
            </div>
        </div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

</div>
@endsection