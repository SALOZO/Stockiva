<!-- resources/views/admin/users/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Manajemen Users - Stockiva')
@section('page-title', 'Manajemen Users')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h5 class="card-title mb-0">Daftar Users</h5>
                    <a href=" {{ route('admin.users.create') }} " class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah User
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
                                   placeholder="Cari Nama User..."
                                   style="max-width: 250px;">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Total: {{ $users->total() }} users
                        </small>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover" id="users-table">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">NO</th>
                                <th width="15%">NAMA</th>
                                <th width="10%">USERNAME</th>
                                <th width="20%">EMAIL</th>
                                <th width="10%">JABATAN</th>
                                <th width="12%">NO. TELP</th>
                                <th width="15%">DIBUAT PADA</th>
                                <th width="8%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($users as $index => $user)
                            <tr>
                                <td class="align-middle">{{ $users->firstItem() + $index }}</td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <span class="fw-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary">@</span>{{ $user->username }}
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary">{{ $user->email }}</span>
                                </td>
                                <td class="align-middle">
                                    @if($user->jabatan)
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                            {{ $user->jabatan }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($user->no_telp)
                                        <span>{{ $user->no_telp }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div>{{ $user->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.show', $user->id) }}" 
                                           class="btn btn-sm btn-outline-secondary" 
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" 
                                           title="Edit User">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $user->id }}"
                                                title="Hapus User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

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
                                                    <div class="alert alert-light border d-flex align-items-center p-3">
                                                        <div>
                                                            <strong class="d-block">{{ $user->nama }}</strong>
                                                            <small class="text-muted">{{ $user->email }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="alert alert-danger mt-3 py-2 small">
                                                        <i class="bi bi-exclamation-circle me-1"></i>
                                                        Tindakan ini tidak dapat dibatalkan.
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger px-4">
                                                            <i class="bi bi-trash me-1"></i>
                                                            Hapus
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
                                        <i class="bi bi-people display-4 d-block mb-3"></i>
                                        <h5>Belum Ada Data User</h5>
                                        <p class="mb-3">Mulai dengan menambahkan user pertama Anda.</p>
                                        <a href="" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Tambah User Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $users->links() }}
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
    /* Card styling */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
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
    }
    
    /* Table styling */
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 0.75rem;
        white-space: nowrap;
    }
    
    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #eef2f6;
        color: #334155;
    }
    
    .table tbody tr:hover {
        background: #f8fafc;
    }
    
    /* Badge styling */
    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .bg-primary-subtle {
        background: rgba(11, 43, 79, 0.08);
    }
    
    .text-primary {
        color: #0b2b4f !important;
    }
    
    /* Button group styling */
    .btn-group .btn {
        border: 1px solid #e2e8f0;
        padding: 0.4rem 0.6rem;
    }
    
    .btn-group .btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    
    .btn-outline-secondary {
        color: #64748b;
    }
    
    .btn-outline-primary {
        color: #0b2b4f;
    }
    
    .btn-outline-danger {
        color: #dc2626;
    }
    
    /* Pagination styling */
    .pagination {
        gap: 4px;
    }
    
    .page-link {
        border: 1px solid #e2e8f0;
        border-radius: 6px !important;
        color: #475569;
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
    }
    
    .page-link:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0b2b4f;
    }
    
    .page-item.active .page-link {
        background: #0b2b4f;
        border-color: #0b2b4f;
    }
    
    /* Modal styling (Anda suka ini, saya pertahankan) */
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
    
    /* Form control */
    .form-control-sm {
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem;
    }
    
    .form-control-sm:focus {
        border-color: #0b2b4f;
        box-shadow: 0 0 0 3px rgba(11, 43, 79, 0.1);
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
            
            $('#users-table tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            
            // Show empty message if no rows visible
            var visibleRows = $('#users-table tbody tr:visible').length;
            if (visibleRows === 0) {
                if ($('#no-results-message').length === 0) {
                    $('#users-table tbody').append('<tr id="no-results-message"><td colspan="8" class="text-center py-4"><div class="text-muted"><i class="bi bi-search display-4 d-block mb-3"></i><h5>Tidak Ditemukan</h5><p class="mb-0">Tidak ada user yang cocok dengan pencarian Anda.</p></div></td></tr>');
                }
            } else {
                $('#no-results-message').remove();
            }
        });
    });
</script>
@endpush