<!-- resources/views/marketing/pesanan/index.blade.php -->
@extends('layouts.marketing')

@section('title', 'Pilih Client - Stockiva Marketing')
@section('page-title', 'Pilih Client untuk Pesanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard') }}">Marketing</a></li>
    <li class="breadcrumb-item active">Pilih Client</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Client</h5>
                    <span class="badge bg-primary">{{ $clients->total() }} Client</span>
                </div>
            </div>
            <div class="card-body">
                {{-- Search & Filter --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   id="searchClient" 
                                   placeholder="Cari nama client, PIC, atau lokasi...">
                        </div>
                    </div>
                    {{-- <div class="col-md-2 text-md-end mt-6 mt-md-0">
                        <a href="{{ route('marketing.clients.create') }}" class="btn btn-outline-primary btn-md">
                            <i class="bi bi-plus-circle"></i> Client Baru
                        </a>
                    </div> --}}
                </div>

                {{-- Client Cards --}}
                <div class="row" id="clientContainer">
                    @forelse($clients as $client)
                    <div class="col-xl-4 col-lg-6 mb-4 client-item" 
                         data-nama="{{ strtolower($client->nama_client) }}"
                         data-pic="{{ strtolower($client->nama_pic) }}"
                         data-lokasi="{{ strtolower($client->kabupaten_kota . ' ' . $client->provinsi) }}">
                        <div class="card client-card h-100">
                            <div class="card-body">
                                {{-- Header Client --}}
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">{{ $client->nama_client }}</h5>
                                        {{-- <span class="badge bg-primary-subtle text-primary">
                                            ID: #{{ str_pad($client->id, 4, '0', STR_PAD_LEFT) }}
                                        </span> --}}
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('marketing.pesanan.by-client', $client->id) }}">
                                                    <i class="bi bi-eye me-2"></i>Detail Pesanan
                                                </a>
                                            </li>   
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-primary fw-bold" 
                                                   href="{{ route('marketing.pesanan.create', ['client_id' => $client->id]) }}">
                                                    <i class="bi bi-plus-circle me-2"></i>Buat Pesanan
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Informasi PIC --}}
                                <div class="mb-3 p-3 bg-light rounded">
                                    <div class="d-flex align-items-center mb-2">
                                        {{-- <div class="bg-primary-subtle rounded-circle p-2 me-2">
                                            <i class="bi bi-person text-primary"></i>
                                        </div> --}}
                                        <div>
                                            <div>
                                                Nama PIC: <span class="fw-bold">{{ $client->nama_pic }}</span>
                                            </div>
                                            <small class="text-muted">Jabatan: {{ $client->jabatan_pic }}</small>
                                        </div>
                                    </div>
                                    <div class="small">
                                        <i class="bi bi-envelope me-2 text-muted"></i>
                                        {{ $client->email_pic ?? 'Email tidak tersedia' }}<br>
                                        <i class="bi bi-telephone me-2 text-muted"></i>
                                        {{ $client->no_telp_pic ?? 'Telepon tidak tersedia' }}
                                    </div>
                                </div>

                                {{-- Informasi Lokasi --}}
                                <div class="mb-3 small">
                                    <i class="bi bi-geo-alt me-2 text-muted"></i>
                                    {{ $client->alamat }}, {{ $client->desa }}, {{ $client->kecamatan }}<br>
                                    <span class="ms-4">{{ $client->kabupaten_kota }}, {{ $client->provinsi }}</span>
                                </div>

                                {{-- Footer --}}
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $client->created_at->format('d M Y') }}
                                    </small>
                                    <a href="{{ route('marketing.pesanan.create', ['client_id' => $client->id]) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Buat Pesanan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-building display-1 d-block mb-3"></i>
                            <h4>Belum Ada Client</h4>
                            <p class="mb-3">Mulai dengan menambahkan client baru terlebih dahulu.</p>
                            <a href="{{ route('marketing.clients.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>
                                Tambah Client Baru
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($clients->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">

                    <small class="text-muted">
                        Menampilkan {{ $clients->firstItem() }} 
                        - {{ $clients->lastItem() }} 
                        dari {{ $clients->total() }} client
                    </small>

                    {{ $clients->onEachSide(1)->links('pagination::bootstrap-5') }}

                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Quick View (Opsional) --}}
<div class="modal fade" id="quickViewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="quickViewContent">
                {{-- Isi modal akan diisi via JavaScript --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .client-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: white;
    }
    
    .client-card:hover {
        box-shadow: 0 10px 25px -5px rgba(11, 43, 79, 0.1);
        transform: translateY(-4px);
        border-color: #cbd5e1;
    }
    
    .bg-primary-subtle {
        background: rgba(11, 43, 79, 0.08);
    }
    
    .text-primary {
        color: #0b2b4f !important;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .dropdown-item i {
        width: 1.2rem;
    }
    
    .dropdown-item:hover {
        background: #f1f5f9;
    }
    
    .btn-primary {
        background: #0b2b4f;
        border: none;
    }
    
    .btn-primary:hover {
        background: #1a3a5f;
    }
    
    .pagination {
        gap: 4px;
    }
    
    .page-link {
        border: 1px solid #e2e8f0;
        border-radius: 8px !important;
        color: #475569;
        padding: 0.5rem 0.75rem;
    }
    
    .page-item.active .page-link {
        background: #0b2b4f;
        border-color: #0b2b4f;
    }
    
    /* Animasi untuk client cards */
    .client-item {
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // ========== SEARCH FUNCTIONALITY ==========
        $('#searchClient').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            
            $('.client-item').each(function() {
                var nama = $(this).data('nama');
                var pic = $(this).data('pic');
                var lokasi = $(this).data('lokasi');
                
                if (nama.includes(searchText) || 
                    pic.includes(searchText) || 
                    lokasi.includes(searchText)) {
                    $(this).show();
                    $(this).css('animation', 'fadeIn 0.5s');
                } else {
                    $(this).hide();
                }
            });
            
            // Tampilkan pesan jika tidak ada hasil
            var visibleCount = $('.client-item:visible').length;
            if (visibleCount === 0) {
                if ($('#no-results').length === 0) {
                    $('#clientContainer').append(`
                        <div class="col-12 text-center py-5" id="no-results">
                            <div class="text-muted">
                                <i class="bi bi-search display-4 d-block mb-3"></i>
                                <h5>Tidak Ditemukan</h5>
                                <p>Tidak ada client yang cocok dengan pencarian "${searchText}"</p>
                            </div>
                        </div>
                    `);
                }
            } else {
                $('#no-results').remove();
            }
        });

        // ========== AUTO-HIDE ALERT ==========
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // ========== TOOLTIP INIT ==========
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // ========== QUICK VIEW FUNCTION (Opsional) ==========
        window.showQuickView = function(clientData) {
            // Fungsi ini bisa diisi nanti untuk quick view modal
            // Data client bisa dipassing dari tombol quick view
        };
    });
</script>
@endpush