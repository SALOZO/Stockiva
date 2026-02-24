@extends('layouts.admin')

@section('title', 'Manajemen Ekspedisi - Stockiva')
@section('page-title', 'Manajemen Ekspedisi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Ekspedisi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h5 class="card-title mb-0">Daftar Ekspedisi</h5>
                    <a href="{{ route('admin.ekspedisi.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Ekspedisi
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
                                   placeholder="Cari ekspedisi..."
                                   style="max-width: 250px;">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Total: {{ $ekspedisi->total() }} ekspedisi
                        </small>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover" id="ekspedisi-table">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">NO</th>
                                <th width="15%">NAMA EKSPEDISI</th>
                                <th width="15%">PIC</th>
                                <th width="12%">NO. TELP</th>
                                <th width="15%">LOKASI</th>
                                <th width="10%">DIBUAT OLEH</th>
                                <th width="10%">TANGGAL</th>
                                <th width="8%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($ekspedisi as $index => $item)
                            <tr>
                                <td class="align-middle">{{ $ekspedisi->firstItem() + $index }}</td>
                                <td class="align-middle">
                                    <span class="fw-medium">{{ $item->nama_ekspedisi }}</span>
                                </td>
                                <td class="align-middle">
                                    <div>{{ $item->nama_pic }}</div>
                                </td>
                                <td class="align-middle">
                                    <i class="bi bi-telephone text-secondary me-1"></i>
                                    {{ $item->no_telp_pic }}
                                </td>
                                <td class="align-middle">
                                    <div>{{ $item->kabupaten_kota }}</div>
                                    <small class="text-muted">{{ $item->provinsi }}</small>
                                </td>
                                <td class="align-middle">
                                    @if($item->createdBy)
                                        {{ $item->createdBy->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div>{{ $item->created_at->format('d/m/Y') }}</div>
                                    {{-- <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small> --}}
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.ekspedisi.show', $item->id) }}" 
                                           class="btn btn-sm btn-outline-secondary" 
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.ekspedisi.edit', $item->id) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           title="Edit Ekspedisi">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDelete{{ $item->id }}"
                                                title="Hapus Ekspedisi">
                                            <i class="bi bi-trash"></i>
                                        </button>
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
                                                    <p>Apakah Anda yakin ingin menghapus ekspedisi "{{ $item->nama_ekspedisi }}"?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.ekspedisi.destroy', $item->id) }}" method="POST">
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
                                        <i class="bi bi-truck display-4 d-block mb-3"></i>
                                        <h5>Belum Ada Data Ekspedisi</h5>
                                        <p class="mb-3">Mulai dengan menambahkan ekspedisi pertama Anda.</p>
                                        <a href="{{ route('admin.ekspedisi.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Tambah Ekspedisi Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($ekspedisi->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $ekspedisi->firstItem() }} - {{ $ekspedisi->lastItem() }} dari {{ $ekspedisi->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $ekspedisi->links() }}
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
    .table td {
        vertical-align: middle;
    }
    
    .btn-group .btn {
        padding: 0.4rem 0.8rem;
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
        // Search functionality
        $('#custom-search').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            
            $('#ekspedisi-table tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            
            var visibleRows = $('#ekspedisi-table tbody tr:visible').length;
            if (visibleRows === 0) {
                if ($('#no-results-message').length === 0) {
                    $('#ekspedisi-table tbody').append('<tr id="no-results-message"><td colspan="8" class="text-center py-4"><div class="text-muted"><i class="bi bi-search display-4 d-block mb-3"></i><h5>Tidak Ditemukan</h5><p class="mb-0">Tidak ada ekspedisi yang cocok dengan pencarian Anda.</p></div></td></tr>');
                }
            } else {
                $('#no-results-message').remove();
            }
        });
        
        // Auto-hide alert
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