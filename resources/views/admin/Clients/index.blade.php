
@extends('layouts.admin')

@section('title', 'Manajemen Clients - Stockiva')
@section('page-title', 'Manajemen Clients')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Clients</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h5 class="card-title mb-0">Daftar Clients</h5>
                    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Client
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                {{-- Filter & Search Row --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-nowrap mb-0">Cari:</label>
                            <input type="text" 
                                   class="form-control form-control-sm" 
                                   id="custom-search" 
                                   placeholder="Cari client..."
                                   style="max-width: 250px;">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Total: {{ $clients->total() }} clients
                        </small>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover" id="clients-table">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">NO</th>
                                <th width="15%">NAMA CLIENT</th>
                                <th width="15%">PIC</th>
                                <th width="10%">JABATAN</th>
                                <th width="15%">KONTAK PIC</th>
                                <th width="15%">LOKASI</th>
                                <th width="10%">DIBUAT</th>
                                <th width="10%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($clients as $index => $client)
                            <tr>
                                <td class="align-middle">{{ $clients->firstItem() + $index }}</td>
                                <td class="align-middle">
                                    <div class="fw-medium">{{ $client->nama_client }}</div>
                                    <small class="text-muted">ID: #{{ str_pad($client->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </td>
                                <td class="align-middle">
                                    <div>{{ $client->nama_pic }}</div>
                                    @if($client->email_pic)
                                        <small class="text-muted">{{ $client->email_pic }}</small>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($client->jabatan_pic)
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                            {{ $client->jabatan_pic }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($client->no_telp_pic)
                                        <div>
                                            <i class="bi bi-telephone text-secondary me-1"></i>
                                            {{ $client->no_telp_pic }}
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div>
                                        <i class="bi bi-geo-alt text-secondary me-1"></i>
                                        {{ $client->kabupaten_kota }}
                                    </div>
                                    <small class="text-muted">{{ $client->provinsi }}</small>
                                </td>
                                <td class="align-middle">
                                    <div>{{ $client->created_at->format('d/m/Y') }}</div>
                                    {{-- <small class="text-muted">{{ $client->created_at->diffForHumans() }}</small> --}}
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.clients.show', $client->id) }}" 
                                           class="btn btn-sm btn-outline-secondary" 
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.clients.edit', $client->id) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" 
                                           title="Edit Client">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $client->id }}"
                                                title="Hapus Client">
                                            <i class="bi bi-trash"></i>
                                        </button>
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
                                                    </div>
                                                    <div class="alert alert-danger mt-3 py-2 small">
                                                        <i class="bi bi-exclamation-circle me-1"></i>
                                                        Tindakan ini tidak dapat dibatalkan. Semua data terkait client akan hilang.
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger px-4">
                                                            <i class="bi bi-trash me-1"></i>
                                                            Ya, Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-building display-4 d-block mb-3"></i>
                                        <h5>Belum Ada Data Client</h5>
                                        <p class="mb-3">Mulai dengan menambahkan client pertama Anda.</p>
                                        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Tambah Client Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($clients->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $clients->firstItem() }} - {{ $clients->lastItem() }} dari {{ $clients->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $clients->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-primary-subtle {
        background: rgba(11, 43, 79, 0.08);
    }
    
    .text-primary {
        color: #0b2b4f !important;
    }
    
    .table td {
        vertical-align: middle;
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
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                placement: 'top'
            })
        });
        
        // Custom search functionality
        $('#custom-search').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            
            $('#clients-table tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            
            // Show empty message if no rows visible
            var visibleRows = $('#clients-table tbody tr:visible').length;
            if (visibleRows === 0) {
                if ($('#no-results-message').length === 0) {
                    $('#clients-table tbody').append('<tr id="no-results-message"><td colspan="8" class="text-center py-4"><div class="text-muted"><i class="bi bi-search display-4 d-block mb-3"></i><h5>Tidak Ditemukan</h5><p class="mb-0">Tidak ada client yang cocok dengan pencarian Anda.</p></div></td></tr>');
                }
            } else {
                $('#no-results-message').remove();
            }
        });
    });
</script>
@endpush