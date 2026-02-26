@extends('layouts.marketing')

@section('title', 'Manajemen Kategori - Stockiva')
@section('page-title', 'Manajemen Kategori')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h5 class="card-title mb-0">Daftar Kategori</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Kategori
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
                                   placeholder="Cari kategori..."
                                   style="max-width: 250px;">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Total: {{ $kategoris->total() }} kategori
                        </small>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover" id="kategori-table">
                        <thead class="text-center">
                            <tr>
                                <th width="10%">NO</th>
                                <th width="70%">NAMA KATEGORI</th>
                                <th width="20%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($kategoris as $index => $kategori)
                            <tr>
                                <td class="align-middle">{{ $kategoris->firstItem() + $index }}</td>
                                <td class="align-middle">
                                    <span class="fw-medium">{{ $kategori->name_kategori }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEdit{{ $kategori->id }}"
                                                title="Edit Kategori">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDelete{{ $kategori->id }}"
                                                title="Hapus Kategori">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="modalEdit{{ $kategori->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="bi bi-pencil-square me-2 text-primary"></i>
                                                        Edit Kategori
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('marketing.kategori.update', $kategori->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="edit_name_kategori_{{ $kategori->id }}" class="form-label">
                                                                Nama Kategori <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   id="edit_name_kategori_{{ $kategori->id }}" 
                                                                   name="name_kategori" 
                                                                   value="{{ $kategori->name_kategori }}"
                                                                   placeholder="Masukkan nama kategori"
                                                                   required>
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
                                    <div class="modal fade" id="modalDelete{{ $kategori->id }}" tabindex="-1" aria-hidden="true">
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
                                                    <p>Apakah Anda yakin ingin menghapus kategori "{{ $kategori->name_kategori }}"?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('marketing.kategori.destroy', $kategori->id) }}" method="POST">
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
                                <td colspan="3" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-tags display-4 d-block mb-3"></i>
                                        <h5>Belum Ada Data Kategori</h5>
                                        <p class="mb-3">Mulai dengan menambahkan kategori pertama Anda.</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Tambah Kategori Pertama
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($kategoris->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $kategoris->firstItem() }} - {{ $kategoris->lastItem() }} dari {{ $kategoris->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $kategoris->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2 text-primary"></i>
                    Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('marketing.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_kategori" class="form-label">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="name_kategori" 
                               name="name_kategori" 
                               value="{{ old('name_kategori') }}"
                               placeholder="Masukkan nama kategori"
                               required>
                        @error('name_kategori')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
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
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Custom search functionality
        $('#custom-search').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            
            $('#kategori-table tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            
            // Show empty message if no rows visible
            var visibleRows = $('#kategori-table tbody tr:visible').length;
            if (visibleRows === 0) {
                if ($('#no-results-message').length === 0) {
                    $('#kategori-table tbody').append('<tr id="no-results-message"><td colspan="3" class="text-center py-4"><div class="text-muted"><i class="bi bi-search display-4 d-block mb-3"></i><h5>Tidak Ditemukan</h5><p class="mb-0">Tidak ada kategori yang cocok dengan pencarian Anda.</p></div></td></tr>');
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