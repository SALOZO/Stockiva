@extends('layouts.admin')

@section('title', 'Detail User - Stockiva')
@section('page-title', 'Detail User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        {{-- Card Utama --}}
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h5 class="card-title mb-0">
                            <i class="bi bi-eye me-2"></i>
                            Detail User
                        </h5>
                    </div>
                    <div>
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                            ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="border-bottom pb-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h2 class="mb-1">{{ $user->name }}</h2>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <span class="text-muted">
                                    <i class="bi bi-at me-1"></i>{{ $user->username }}
                                </span>
                                @if($user->jabatan)
                                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                    <i class="bi bi-briefcase me-1"></i>
                                    {{ $user->jabatan }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-calendar3 me-1"></i>
                            Di buat sejak {{ $user->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                {{-- Informasi Detail dalam Grid --}}
                <div class="row g-4">
                    {{-- Email --}}
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-envelope text-primary"></i>
                                Email
                            </div>
                            <div class="detail-value">
                                @if($user->email)
                                    <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                        {{ $user->email }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Username --}}
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-person text-primary"></i>
                                Username
                            </div>
                            <div class="detail-value">
                                {{ $user->username }}
                            </div>
                        </div>
                    </div>

                    {{-- No Telepon --}}
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-telephone text-primary"></i>
                                No. Telepon
                            </div>
                            <div class="detail-value">
                                @if($user->no_telp)
                                    <a href="tel:{{ $user->no_telp }}" class="text-decoration-none">
                                        {{ $user->no_telp }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Jabatan --}}
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-briefcase text-primary"></i>
                                Jabatan
                            </div>
                            <div class="detail-value">
                                {{ $user->jabatan ?? '-' }}
                            </div>
                        </div>
                    </div>

                    {{-- Dibuat Pada --}}
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-calendar-plus text-primary"></i>
                                Dibuat Pada
                            </div>
                            <div class="detail-value">
                                <div>{{ $user->created_at->format('d F Y') }}</div>
                                {{-- <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small> --}}
                            </div>
                        </div>
                    </div>

                    {{-- Terakhir Update --}}
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-pencil-square text-primary"></i>
                                Terakhir Update
                            </div>
                            <div class="detail-value">
                                <div>{{ $user->updated_at->format('d F Y') }}</div>
                                {{-- <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small> --}}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informasi Tambahan --}}
                {{-- <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-light border-start border-4 border-primary d-flex align-items-center py-3">
                            <i class="bi bi-shield-check fs-4 me-3 text-primary"></i>
                            <div>
                                <strong>Informasi Akun:</strong>
                                <span class="badge bg-success-subtle text-success ms-2 px-3">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Status Aktif
                                </span>
                                <div class="text-muted small mt-1">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Terakhir login: <em>Belum ada data login</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- Aktivitas Terakhir (Placeholder) --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="mb-3">
                            <i class="bi bi-activity me-2"></i>
                            Aktivitas Terakhir
                        </h6>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <p class="mb-1">User dibuat</p>
                                    <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                            @if($user->created_at != $user->updated_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <p class="mb-1">Data diperbarui</p>
                                    <small class="text-muted">{{ $user->updated_at->format('d M Y') }}</small>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>

            {{-- Footer dengan Tombol Aksi --}}
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Halaman detail menampilkan informasi lengkap user
                    </small>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i>
                            Edit User
                        </a>
                        <button type="button" 
                                class="btn btn-outline-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal{{ $user->id }}">
                            <i class="bi bi-trash me-1"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Pop up --}}
<div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
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
                <p class="mb-3">Apakah Anda yakin ingin menghapus user berikut?</p>
                {{-- <div class="alert alert-light border d-flex align-items-center p-3">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" 
                         style="width: 48px; height: 48px; background: #e2e8f0 !important;">
                        <i class="bi bi-person fs-4 text-secondary"></i>
                    </div>
                    <div>
                        <strong class="d-block">{{ $user->nama }}</strong>
                        <small class="text-muted">{{ $user->email }}</small>
                        <small class="text-muted d-block">@ {{ $user->username }}</small>
                    </div>
                </div>
                <div class="alert alert-danger mt-3 py-2 small">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    Tindakan ini tidak dapat dibatalkan. Semua data terkait user akan hilang.
                </div>
            </div> --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-trash me-1"></i>
                        Ya, Hapus User
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
    
    /* Detail item styling */
    .detail-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.25rem;
        height: 100%;
        transition: all 0.2s;
    }
    
    .detail-item:hover {
        background: #f1f5f9;
    }
    
    .detail-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 0.5rem;
    }
    
    .detail-label i {
        margin-right: 0.5rem;
        font-size: 0.9rem;
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
    
    .bg-success-subtle {
        background: rgba(34, 197, 94, 0.08);
    }
    
    .text-success {
        color: #16a34a !important;
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
    
    /* Timeline styling */
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-marker {
        position: absolute;
        left: -1.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        transform: translateX(-5px);
        margin-top: 4px;
        z-index: 1;
    }
    
    .timeline-content {
        padding-left: 1rem;
    }
    
    /* Modal styling (Anda suka ini) */
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
        
        .detail-item {
            padding: 1rem;
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