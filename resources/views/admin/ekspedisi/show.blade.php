<!-- resources/views/admin/ekspedisi/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Detail Ekspedisi - Stockiva')
@section('page-title', 'Detail Ekspedisi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.ekspedisi.index') }}">Ekspedisi</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-lg-10 mx-auto">
        {{-- Card Utama --}}
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('admin.ekspedisi.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h5 class="card-title mb-0">
                            <i class="bi bi-eye me-2"></i>
                            Detail Ekspedisi
                        </h5>
                    </div>
                    <div>
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                            ID: #{{ str_pad($ekspedisi->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                {{-- Header Info Ekspedisi --}}
                <div class="border-bottom pb-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h2 class="mb-1">{{ $ekspedisi->nama_ekspedisi }}</h2>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                {{-- <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Aktif
                                </span>
                                <span class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Terdaftar {{ $ekspedisi->created_at->diffForHumans() }}
                                </span> --}}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Grid Informasi --}}
                <div class="row g-4">
                    {{-- Kolom Kiri: Informasi Ekspedisi & Alamat --}}
                    <div class="col-md-6">
                        {{-- Informasi Ekspedisi --}}
                        <div class="detail-section mb-4">
                            <h6 class="section-title">
                                <i class="bi bi-truck me-2"></i>
                                Informasi Ekspedisi
                            </h6>
                            
                            <div class="detail-item">
                                <div class="detail-label">Nama Ekspedisi</div>
                                <div class="detail-value">{{ $ekspedisi->nama_ekspedisi }}</div>
                            </div>
                        </div>

                        {{-- Alamat Lengkap --}}
                        <div class="detail-section">
                            <h6 class="section-title">
                                <i class="bi bi-geo-alt me-2"></i>
                                Alamat Ekspedisi
                            </h6>
                            
                            <div class="detail-item">
                                <div class="detail-label">Provinsi</div>
                                <div class="detail-value">{{ $ekspedisi->provinsi }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Kabupaten/Kota</div>
                                <div class="detail-value">{{ $ekspedisi->kabupaten_kota }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Kecamatan</div>
                                <div class="detail-value">{{ $ekspedisi->kecamatan }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Desa/Kelurahan</div>
                                <div class="detail-value">{{ $ekspedisi->desa }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Alamat Lengkap</div>
                                <div class="detail-value">{{ $ekspedisi->alamat }}</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Kolom Kanan: Informasi PIC & Metadata --}}
                    <div class="col-md-6">
                        {{-- Informasi PIC --}}
                        <div class="detail-section mb-4">
                            <h6 class="section-title">
                                <i class="bi bi-person-badge me-2"></i>
                                Informasi PIC
                            </h6>
                            
                            <div class="detail-item">
                                <div class="detail-label">Nama PIC</div>
                                <div class="detail-value">{{ $ekspedisi->nama_pic }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">No. Telepon PIC</div>
                                <div class="detail-value">
                                    <a href="tel:{{ $ekspedisi->no_telp_pic }}" class="text-decoration-none">
                                        <i class="bi bi-telephone me-1"></i>
                                        {{ $ekspedisi->no_telp_pic }}
                                    </a>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Email PIC</div>
                                <div class="detail-value">
                                    <a href="mailto:{{ $ekspedisi->email_pic }}" class="text-decoration-none">
                                        <i class="bi bi-envelope me-1"></i>
                                        {{ $ekspedisi->email_pic }}
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                        
                        {{-- Informasi Metadata --}}
                        <div class="detail-section">
                            <h6 class="section-title">
                                <i class="bi bi-info-circle me-2"></i>
                                Informasi Sistem
                            </h6>
                            
                            <div class="detail-item">
                                <div class="detail-label">Dibuat Oleh</div>
                                <div class="detail-value">
                                    @if($ekspedisi->createdBy)
                                        {{ $ekspedisi->createdBy->nama }}
                                        <small class="text-muted d-block">
                                            {{ $ekspedisi->createdBy->jabatan ?? 'Admin' }}
                                        </small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Dibuat Pada</div>
                                <div class="detail-value">
                                    {{ $ekspedisi->created_at->format('d F Y H:i') }}
                                    <small class="text-muted d-block">
                                        {{-- {{ $ekspedisi->created_at->diffForHumans() }} --}}
                                    </small>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Terakhir Diperbarui</div>
                                <div class="detail-value">
                                    {{ $ekspedisi->updated_at->format('d F Y H:i') }}
                                    <small class="text-muted d-block">
                                        {{-- {{ $ekspedisi->updated_at->diffForHumans() }} --}}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alamat Lengkap (Ringkasan) --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-light border-start border-4 border-primary d-flex align-items-center py-3">
                            <i class="bi bi-geo-alt-fill fs-4 me-3 text-primary"></i>
                            <div>
                                <strong>Alamat Lengkap:</strong>
                                <p class="mb-0 mt-1">
                                    {{ $ekspedisi->alamat }}, {{ $ekspedisi->desa }}, 
                                    {{ $ekspedisi->kecamatan }}, {{ $ekspedisi->kabupaten_kota }}, 
                                    {{ $ekspedisi->provinsi }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer dengan Tombol Aksi --}}
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Halaman detail menampilkan informasi lengkap ekspedisi
                    </small>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.ekspedisi.edit', $ekspedisi->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i>
                            Edit Ekspedisi
                        </a>
                        <button type="button" 
                                class="btn btn-outline-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalDelete">
                            <i class="bi bi-trash me-1"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Delete --}}
<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus ekspedisi berikut {{ $ekspedisi->nama_ekspedisi }}?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.ekspedisi.destroy', $ekspedisi->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-trash me-1"></i>
                        Ya, Hapus Ekspedisi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }
    
    .card-header {
        background: white;
        border-bottom: 1px solid #eef2f6;
        padding: 1.25rem 1.5rem;
    }
    
    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .card-footer {
        background: #f8fafc;
        border-top: 1px solid #eef2f6;
        padding: 1rem 1.5rem;
    }
    
    /* Section styling */
    .detail-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        height: fit-content;
    }
    
    .section-title {
        color: #1e293b;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .section-title i {
        color: #0b2b4f;
    }
    
    /* Detail item styling */
    .detail-item {
        margin-bottom: 1.25rem;
    }
    
    .detail-item:last-child {
        margin-bottom: 0;
    }
    
    .detail-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 0.25rem;
    }
    
    .detail-value {
        font-size: 1rem;
        color: #1e293b;
        font-weight: 500;
        line-height: 1.5;
    }
    
    .detail-value small {
        font-weight: normal;
        font-size: 0.85rem;
    }
    
    /* Badge styling */
    .bg-primary-subtle {
        background: rgba(11, 43, 79, 0.08);
    }
    
    .text-primary {
        color: #0b2b4f !important;
    }
    
    .badge {
        font-weight: 500;
    }
    
    /* Alert styling */
    .alert-light {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }
    
    .border-start.border-4 {
        border-left-width: 4px !important;
    }
    
    /* Modal styling */
    .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }
    
    .modal-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
    }
    
    .modal-title {
        font-weight: 600;
        color: #1e293b;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        border-top: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
        background: #f8fafc;
    }
    
    /* Button styling */
    .btn-primary {
        background: #0b2b4f;
        border: none;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
    }
    
    .btn-primary:hover {
        background: #1a3a5f;
    }
    
    .btn-outline-danger {
        border: 1px solid #e2e8f0;
        color: #dc2626;
        background: white;
    }
    
    .btn-outline-danger:hover {
        background: #fee2e2;
        border-color: #dc2626;
        color: #991b1b;
    }
    
    .btn-outline-secondary {
        border: 1px solid #e2e8f0;
        color: #64748b;
    }
    
    .btn-outline-secondary:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #1e293b;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        .detail-section {
            padding: 1.25rem;
        }
        
        .card-footer .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .card-footer .btn {
            width: 100%;
        }
        
        .d-flex.gap-2 {
            width: 100%;
        }
        
        .d-flex.gap-2 .btn {
            flex: 1;
        }
    }
</style>
@endpush