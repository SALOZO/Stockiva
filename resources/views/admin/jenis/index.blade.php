@extends('layouts.admin')

@section('title', 'Manajemen Jenis - Stockiva')
@section('page-title', 'Manajemen Jenis')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Jenis</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h5 class="card-title mb-0">Daftar Jenis</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Jenis
                    </button>
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
                                   placeholder="Cari jenis..."
                                   style="max-width: 250px;">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Total: {{ $jenis->total() }} jenis
                        </small>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover" id="jenis-table">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">NO</th>
                                <th width="25%">NAMA JENIS</th>
                                <th width="25%">KATEGORI</th>
                                <th width="15%">DIBUAT</th>
                                <th width="15%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($jenis as $index => $item)
                            <tr>
                                <td class="align-middle">{{ $jenis->firstItem() + $index }}</td>
                                <td class="align-middle">
                                    <span class="fw-medium">{{ $item->name_jenis }}</span>
                                </td>
                                <td class="align-middle">
                                    @if($item->kategori)
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                            <i class="bi bi-tags me-1"></i>
                                            {{ $item->kategori->name_kategori }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div>{{ $item->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEdit{{ $item->id }}"
                                                title="Edit Jenis">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDelete{{ $item->id }}"
                                                title="Hapus Jenis">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="bi bi-pencil-square me-2 text-primary"></i>
                                                        Edit Jenis
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.jenis.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="edit_nama_jenis_{{ $item->id }}" class="form-label">
                                                                Nama Jenis <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   id="edit_nama_jenis_{{ $item->id }}" 
                                                                   name="name_jenis" 
                                                                   value="{{ $item->name_jenis }}"
                                                                   placeholder="Masukkan nama jenis"
                                                                   required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label for="edit_kategori_id_{{ $item->id }}" class="form-label">
                                                                Kategori <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-select" 
                                                                    id="edit_kategori_id_{{ $item->id }}" 
                                                                    name="kategori_id" 
                                                                    required>
                                                                <option value="">-- Pilih Kategori --</option>
                                                                @foreach($kategoris as $kategori)
                                                                    <option value="{{ $kategori->id }}" 
                                                                        {{ $item->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                                        {{ $kategori->name_kategori }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bi bi-save me-1"></i>
                                                            Update
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal Delete --}}
                                    <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" aria-hidden="true">
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
                                                    <p>Apakah Anda yakin ingin menghapus jenis "{{ $item->name_jenis }}"?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.jenis.destroy', $item->id) }}" method="POST">
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
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-diagram-3 display-4 d-block mb-3"></i>
                                        <h5>Belum Ada Data Jenis</h5>
                                        <p class="mb-3">Mulai dengan menambahkan jenis pertama Anda.</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Tambah Jenis Pertama
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($jenis->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $jenis->firstItem() }} - {{ $jenis->lastItem() }} dari {{ $jenis->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $jenis->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah (di luar loop, cukup satu) --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2 text-primary"></i>
                    Tambah Jenis Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.jenis.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_jenis" class="form-label">
                            Nama Jenis <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name_jenis') is-invalid @enderror" 
                               id="name_jenis" 
                               name="name_jenis" 
                               value="{{ old('name_jenis') }}"
                               placeholder="Masukkan nama jenis"
                               required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                id="kategori_id" 
                                name="kategori_id" 
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->name_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan
                    </button>
                </div>
            </form>
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
    
    .btn-group .btn {
        padding: 0.4rem 0.8rem;
    }
    
    .badge {
        font-weight: 500;
        font-size: 0.85rem;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Custom search functionality
        $('#custom-search').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            
            $('#jenis-table tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            
            // Show empty message if no rows visible
            var visibleRows = $('#jenis-table tbody tr:visible').length;
            if (visibleRows === 0) {
                if ($('#no-results-message').length === 0) {
                    $('#jenis-table tbody').append('<tr id="no-results-message"><td colspan="5" class="text-center py-4"><div class="text-muted"><i class="bi bi-search display-4 d-block mb-3"></i><h5>Tidak Ditemukan</h5><p class="mb-0">Tidak ada jenis yang cocok dengan pencarian Anda.</p></div></td></tr>');
                }
            } else {
                $('#no-results-message').remove();
            }
        });
        
        // Auto-hide alert setelah 5 detik
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
        
        // Jika ada error validasi dari server, tampilkan modal tambah kembali
        @if($errors->any())
            $('#modalTambah').modal('show');
        @endif
    });
</script>
@endpush