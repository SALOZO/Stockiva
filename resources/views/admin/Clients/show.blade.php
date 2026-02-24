@extends('layouts.admin')

@section('title', 'Detail Client - Stockiva')
@section('page-title', 'Detail Client')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Clients</a></li>
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
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h5 class="card-title mb-0">
                            <i class="bi bi-eye me-2"></i>
                            Detail Client
                        </h5>
                    </div>
                    <div>
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                            ID: #{{ str_pad($client->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                {{-- Header Info Client --}}
                <div class="border-bottom pb-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h2 class="mb-1">{{ $client->nama_client }}</h2>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <span class="text-muted">
                                    <i class="bi bi-building me-1"></i>Perusahaan
                                </span>
                            </div>
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-calendar3 me-1"></i>
                            Client sejak {{ $client->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                {{-- Grid Informasi --}}
                <div class="row g-4">
                    {{-- Kolom Kiri: Informasi Perusahaan --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <h6 class="section-title">
                                <i class="bi bi-building me-2"></i>
                                Informasi Perusahaan
                            </h6>
                            
                            <div class="detail-item">
                                <div class="detail-label">Nama Perusahaan</div>
                                <div class="detail-value">{{ $client->nama_client }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Provinsi</div>
                                <div class="detail-value">{{ $client->provinsi }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Kabupaten/Kota</div>
                                <div class="detail-value">{{ $client->kabupaten_kota }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Kecamatan</div>
                                <div class="detail-value">{{ $client->kecamatan }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Desa/Kelurahan</div>
                                <div class="detail-value">{{ $client->desa }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Alamat Lengkap</div>
                                <div class="detail-value">{{ $client->alamat }}</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Kolom Kanan: Informasi PIC --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <h6 class="section-title">
                                <i class="bi bi-person-badge me-2"></i>
                                Informasi PIC
                            </h6>
                            
                            <div class="detail-item">
                                <div class="detail-label">Nama PIC</div>
                                <div class="detail-value">{{ $client->nama_pic }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Jabatan PIC</div>
                                <div class="detail-value">{{ $client->jabatan_pic }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Email PIC</div>
                                <div class="detail-value">
                                    @if($client->email_pic)
                                        <a href="mailto:{{ $client->email_pic }}" class="text-decoration-none">
                                            {{ $client->email_pic }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">No. Telepon PIC</div>
                                <div class="detail-value">
                                    @if($client->no_telp_pic)
                                        <a href="tel:{{ $client->no_telp_pic }}" class="text-decoration-none">
                                            {{ $client->no_telp_pic }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Informasi Metadata --}}
                        <div class="detail-section mt-4">
                            <h6 class="section-title">
                                <i class="bi bi-info-circle me-2"></i>
                                Informasi Lainnya
                            </h6>
                            
                            <div class="detail-item">
                                <div class="detail-label">Dibuat Oleh</div>
                                <div class="detail-value">
                                    @if($client->createdBy)
                                        {{ $client->createdBy->nama }} 
                                        <small class="text-muted">({{ $client->createdBy->jabatan ?? 'Admin' }})</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Dibuat Pada</div>
                                <div class="detail-value">
                                    {{ $client->created_at->format('d F Y H:i') }}
                                    <small class="text-muted d-block">{{ $client->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Terakhir Update</div>
                                <div class="detail-value">
                                    {{ $client->updated_at->format('d F Y H:i') }}
                                    <small class="text-muted d-block">{{ $client->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alamat Lengkap (Card Khusus) --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-light border-start border-4 border-primary d-flex align-items-center py-3">
                            <i class="bi bi-geo-alt-fill fs-4 me-3 text-primary"></i>
                            <div>
                                <strong>Alamat Lengkap:</strong>
                                <p class="mb-0 mt-1">
                                    {{ $client->alamat }}, {{ $client->desa }}, 
                                    {{ $client->kecamatan }}, {{ $client->kabupaten_kota }}, 
                                    {{ $client->provinsi }}
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
                        Halaman detail menampilkan informasi lengkap client
                    </small>
                    <div class="d-flex gap-2">
                        <a href="" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i>
                            Edit Client
                        </a>
                        <button type="button" 
                                class="btn btn-outline-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal{{ $client->id }}">
                            <i class="bi bi-trash me-1"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal{{ $client->id }}" tabindex="-1" aria-hidden="true">
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
                <p class="mb-3">Apakah Anda yakin ingin menghapus client berikut?</p>
                <div class="alert alert-light border p-3">
                    <strong class="d-block">{{ $client->nama_client }}</strong>
                    <small class="text-muted">PIC: {{ $client->nama_pic }}</small>
                    <small class="text-muted d-block">{{ $client->email_pic ?? '-' }}</small>
                    <small class="text-muted d-block">{{ $client->kabupaten_kota }}, {{ $client->provinsi }}</small>
                </div>
                <div class="alert alert-danger mt-3 py-2 small">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    Tindakan ini tidak dapat dibatalkan. Semua data terkait client akan hilang.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-trash me-1"></i>
                        Ya, Hapus Client
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Card styling konsisten */
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
        margin-bottom: 1.5rem;
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