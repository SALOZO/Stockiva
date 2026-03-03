@extends('layouts.marketing')

@section('title', 'Manajemen Barang - Stockiva')
@section('page-title', 'Manajemen Barang')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Barang</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h5 class="card-title mb-0">Daftar Barang</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Barang
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
                                   placeholder="Cari barang..."
                                   style="max-width: 250px;">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Total: {{ $barang->total() }} barang
                        </small>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover" id="barang-table">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">NO</th>
                                <th>FOTO</th>
                                <th width="15%">NAMA BARANG</th>
                                <th width="10%">KATEGORI</th>
                                <th width="10%">JENIS</th>
                                <th width="10%">SATUAN</th>
                                <th width="10%">HARGA SATUAN</th>
                                <th width="15%">DIBUAT OLEH</th>
                                <th width="10%">TANGGAL</th>
                                <th width="8%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($barang as $index => $item)
                            <tr>
                                <td class="align-middle">{{ $barang->firstItem() + $index }}</td>
                                <td class="align-middle">
                                    @if($item->foto)
                                        <img src="{{ $item->foto_url }}" alt="foto" style="max-width: 90px; max-height: 90px; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span class="fw-medium">{{ $item->nama_barang }}</span>
                                </td>
                                <td class="align-middle">
                                    @if($item->kategori)
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                            {{ $item->kategori->name_kategori }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($item->jenis)
                                        <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">
                                            {{ $item->jenis->name_jenis }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($item->satuan)
                                        <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
                                            {{ $item->satuan->nama_satuan }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($item->harga_satuan > 0)
                                        <span class="fw-semibold text-success">
                                            Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($item->createdBy)
                                        {{ $item->createdBy->name }}
                                        <br>
                                        <small>Jabatan: {{ $item->createdBy->jabatan }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div>{{ $item->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEdit{{ $item->id }}"
                                                title="Edit Barang">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDelete{{ $item->id }}"
                                                title="Hapus Barang">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDetail{{ $item->id }}"
                                                title="Detail Barang">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                    <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="bi bi-info-circle me-2 text-info"></i>
                                                        Detail Barang
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    <div class="row">
                                                        {{-- Kolom Foto --}}
                                                        <div class="col-md-5 text-center mb-3">
                                                            @if($item->foto)
                                                                <img src="{{ $item->foto_url }}" 
                                                                    alt="{{ $item->nama_barang }}" 
                                                                    class="img-fluid rounded border"
                                                                    style="max-height: 250px; object-fit: contain;">
                                                            @else
                                                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                                                    style="height: 200px; width: 100%;">
                                                                    <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                                                                    <p class="text-muted mt-2">Tidak ada foto</p>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Kolom Informasi --}}
                                                        <div class="col-md-7">
                                                            <table class="table table-sm table-borderless">
                                                                <tr>
                                                                    <td width="35%"><strong>Nama Barang</strong></td>
                                                                    <td width="65%">: {{ $item->nama_barang }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Kategori</strong></td>
                                                                    <td>: {{ $item->kategori->name_kategori ?? '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Jenis</strong></td>
                                                                    <td>: {{ $item->jenis->name_jenis ?? '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Satuan</strong></td>
                                                                    <td>: {{ $item->satuan->nama_satuan ?? '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Harga Satuan</strong></td>
                                                                    <td>: <strong class="text-primary">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Dibuat Oleh</strong></td>
                                                                    <td>: {{ $item->createdBy->name ?? '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Tanggal Dibuat</strong></td>
                                                                    <td>: {{ $item->created_at->format('d/m/Y H:i') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Terakhir Update</strong></td>
                                                                    <td>: {{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    {{-- Spesifikasi --}}
                                                    @if($item->spesifikasi)
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <div class="card bg-light">
                                                                <div class="card-body">
                                                                    <h6 class="fw-bold mb-2">
                                                                        <i class="bi bi-file-text me-2"></i>Spesifikasi Barang
                                                                    </h6>
                                                                    <p class="mb-0" style="white-space: pre-line;">{{ $item->spesifikasi }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        <i class="bi bi-x-circle me-1"></i> Tutup
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-primary"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEdit{{ $item->id }}"
                                                            data-bs-dismiss="modal">
                                                        <i class="bi bi-pencil me-1"></i> Edit Barang
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                 {{-- Modal Edit --}}
                                    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="bi bi-pencil-square me-2 text-primary"></i>
                                                        Edit Barang
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                
                                                <form action="{{ route('marketing.barang.update', $item->id) }}" 
                                                    method="POST" 
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="modal-body">
                                                        {{-- Nama Barang --}}
                                                        <div class="mb-3">
                                                            <label for="edit_nama_barang_{{ $item->id }}" class="form-label">
                                                                Nama Barang <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" 
                                                                class="form-control" 
                                                                id="edit_nama_barang_{{ $item->id }}" 
                                                                name="nama_barang" 
                                                                value="{{ $item->nama_barang }}"
                                                                placeholder="Masukkan nama barang"
                                                                required>
                                                        </div>

                                                        {{-- Spesifikasi --}}
                                                        <div class="mb-3">
                                                            <label for="edit_spesifikasi_{{ $item->id }}" class="form-label">Spesifikasi Barang</label>
                                                            <textarea class="form-control" 
                                                                    id="edit_spesifikasi_{{ $item->id }}" 
                                                                    name="spesifikasi" 
                                                                    rows="3" 
                                                                    placeholder="Masukkan spesifikasi lengkap barang">{{ $item->spesifikasi }}</textarea>
                                                        </div>

                                                        {{-- Foto Barang --}}
                                                        <div class="mb-3">
                                                            <label for="edit_foto_{{ $item->id }}" class="form-label">Foto Barang</label>
                                                            
                                                            {{-- Preview foto lama --}}
                                                            @if($item->foto)
                                                            <div class="mb-2 p-2 border rounded bg-light">
                                                                <div class="align-items-center">
                                                                    <img src="{{ $item->foto_url }}" 
                                                                        style="max-height: 80px; max-width: 80px; object-fit: cover; border-radius: 4px;" 
                                                                        class="me-3">
                                                                </div>
                                                            </div>
                                                            @endif
                                                            
                                                            <input type="file" 
                                                                class="form-control" 
                                                                id="edit_foto_{{ $item->id }}" 
                                                                name="foto" 
                                                                accept="image/jpeg,image/png,image/jpg">
                                                            <small class="text-muted">Format: JPG, PNG. Maks: 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                                                            
                                                            {{-- Preview foto baru --}}
                                                            <div id="previewEditFoto{{ $item->id }}" class="mt-2" style="display: none;">
                                                                <img src="#" alt="Preview" style="max-height: 100px; border-radius: 4px;">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            {{-- Kategori --}}
                                                            <div class="col-md-4 mb-3">
                                                                <label for="edit_kategori_id_{{ $item->id }}" class="form-label">
                                                                    Kategori <span class="text-danger">*</span>
                                                                </label>
                                                                <select class="form-select edit-kategori" 
                                                                        name="kategori_id"
                                                                        id="edit_kategori_id_{{ $item->id }}" 
                                                                        data-target="edit_jenis_id_{{ $item->id }}"
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

                                                            {{-- Jenis (Dynamic) --}}
                                                            <div class="col-md-4 mb-3">
                                                                <label for="edit_jenis_id_{{ $item->id }}" class="form-label">
                                                                    Jenis <span class="text-danger">*</span>
                                                                </label>
                                                                <select class="form-select" 
                                                                        id="edit_jenis_id_{{ $item->id }}" 
                                                                        name="jenis_id" 
                                                                        required>
                                                                    <option value="">-- Pilih Jenis --</option>
                                                                    @foreach($jenis as $j)
                                                                        @if($j->kategori_id == $item->kategori_id)
                                                                            <option value="{{ $j->id }}" 
                                                                                {{ $item->jenis_id == $j->id ? 'selected' : '' }}>
                                                                                {{ $j->name_jenis }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            {{-- Satuan --}}
                                                            <div class="col-md-4 mb-3">
                                                                <label for="edit_satuan_id_{{ $item->id }}" class="form-label">
                                                                    Satuan <span class="text-danger">*</span>
                                                                </label>
                                                                <select class="form-select" 
                                                                        id="edit_satuan_id_{{ $item->id }}" 
                                                                        name="satuan_id" 
                                                                        required>
                                                                    <option value="">-- Pilih Satuan --</option>
                                                                    @foreach($satuans as $satuan)
                                                                        <option value="{{ $satuan->id }}" 
                                                                            {{ $item->satuan_id == $satuan->id ? 'selected' : '' }}>
                                                                            {{ $satuan->nama_satuan }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        {{-- Harga --}}
                                                        <div class="mb-3">
                                                            <label for="edit_harga_satuan_{{ $item->id }}" class="form-label">
                                                                Harga Satuan <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-light">Rp</span>
                                                                <input type="number" 
                                                                    class="form-control" 
                                                                    id="edit_harga_satuan_{{ $item->id }}" 
                                                                    name="harga_satuan" 
                                                                    value="{{ $item->harga_satuan }}"
                                                                    placeholder="0"
                                                                    min="0"
                                                                    step="1000"
                                                                    required>
                                                            </div>
                                                            <small class="text-muted">Masukkan dalam angka (contoh: 50000)</small>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                            <i class="bi bi-x-circle me-1"></i> Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bi bi-save me-1"></i> Update
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
                                                    <p>Apakah Anda yakin ingin menghapus barang: {{ $item->nama_barang }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('marketing.barang.destroy', $item->id) }}" method="POST">
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
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-box display-4 d-block mb-3"></i>
                                        <h5>Belum Ada Data Barang</h5>
                                        <p class="mb-3">Mulai dengan menambahkan barang pertama Anda.</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Tambah Barang Pertama
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($barang->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $barang->firstItem() }} - {{ $barang->lastItem() }} dari {{ $barang->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $barang->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2 text-primary"></i>
                    Tambah Barang Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('marketing.barang.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                
                <div class="modal-body">
                    {{-- Nama Barang --}}
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">
                            Nama Barang <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_barang') is-invalid @enderror" 
                               id="nama_barang" 
                               name="nama_barang" 
                               value="{{ old('nama_barang') }}"
                               placeholder="Masukkan nama barang"
                               required>
                        @error('nama_barang')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Spesifikasi --}}
                    <div class="mb-3">
                        <label for="spesifikasi" class="form-label">Spesifikasi Barang</label>
                        <textarea class="form-control @error('spesifikasi') is-invalid @enderror" 
                                  id="spesifikasi" 
                                  name="spesifikasi" 
                                  rows="3" 
                                  placeholder="Masukkan spesifikasi lengkap barang (warna, bahan, ukuran, dll)">{{ old('spesifikasi') }}</textarea>
                        @error('spesifikasi')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Foto Barang --}}
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Barang</label>
                        <input type="file" 
                               class="form-control @error('foto') is-invalid @enderror" 
                               id="foto" 
                               name="foto" 
                               accept="image/jpeg,image/png,image/jpg">
                        <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                        @error('foto')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        
                        {{-- Preview foto sementara --}}
                        <div id="previewFoto" class="mt-2" style="display: none;">
                            <img src="#" alt="Preview" style="max-height: 100px; border-radius: 4px;">
                        </div>
                    </div>

                    <div class="row">
                        {{-- Kategori --}}
                        <div class="col-md-4 mb-3">
                            <label for="kategori_id" class="form-label">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                    id="kategori_id" 
                                    name="kategori_id" 
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" 
                                        {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->name_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis (Dynamic) --}}
                        <div class="col-md-4 mb-3">
                            <label for="jenis_id" class="form-label">
                                Jenis <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('jenis_id') is-invalid @enderror" 
                                    id="jenis_id" 
                                    name="jenis_id" 
                                    required>
                                <option value="">-- Pilih Kategori Terlebih Dahulu --</option>
                            </select>
                            @error('jenis_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Satuan --}}
                        <div class="col-md-4 mb-3">
                            <label for="satuan_id" class="form-label">
                                Satuan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('satuan_id') is-invalid @enderror" 
                                    id="satuan_id" 
                                    name="satuan_id" 
                                    required>
                                <option value="">-- Pilih Satuan --</option>
                                @foreach($satuans as $satuan)
                                    <option value="{{ $satuan->id }}" 
                                        {{ old('satuan_id') == $satuan->id ? 'selected' : '' }}>
                                        {{ $satuan->nama_satuan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('satuan_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div class="mb-3">
                        <label for="harga_satuan" class="form-label">
                            Harga Satuan <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" 
                                   class="form-control @error('harga_satuan') is-invalid @enderror" 
                                   id="harga_satuan" 
                                   name="harga_satuan" 
                                   value="{{ old('harga_satuan') }}"
                                   placeholder="0"
                                   min="0"
                                   step="1000"
                                   required>
                        </div>
                        @error('harga_satuan')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Masukkan dalam angka (contoh: 50000)</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="bi bi-save me-1"></i> Simpan Barang
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
    
    .bg-info-subtle {
        background: rgba(2, 136, 209, 0.08);
    }
    
    .bg-secondary-subtle {
        background: rgba(100, 116, 139, 0.08);
    }
    
    .text-info {
        color: #0288d1 !important;
    }
    
    .text-secondary {
        color: #475569 !important;
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
    
    .input-group-text {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }
        .table-borderless td {
        padding: 0.5rem 0;
    }
    .modal-lg {
        max-width: 800px;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Dynamic dropdown untuk modal tambah
        $('#kategori_id').on('change', function() {
            var kategoriId = $(this).val();
            var jenisSelect = $('#jenis_id');
            
            jenisSelect.html('<option value="">Loading...</option>');
            
            if (kategoriId) {
                $.ajax({
                    url: '/marketing/get-jenis-by-kategori/' + kategoriId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        jenisSelect.html('<option value="">-- Pilih Jenis --</option>');
                        $.each(data, function(key, value) {
                            jenisSelect.append('<option value="' + value.id + '">' + value.name_jenis + '</option>');
                        });
                    },
                    error: function() {
                        jenisSelect.html('<option value="">-- Gagal memuat data --</option>');
                    }
                });
            } else {
                jenisSelect.html('<option value="">-- Pilih Kategori Terlebih Dahulu --</option>');
            }
        });
        

        // Dynamic dropdown untuk setiap modal edit
        $(document).on('change', '.edit-kategori', function() {
            var kategoriId = $(this).val();
            var targetId = $(this).data('target');
            var jenisSelect = $('#' + targetId);
            
            jenisSelect.html('<option value="">Loading...</option>');
            
            if (kategoriId) {
                $.ajax({
                    url: '/marketing/get-jenis-by-kategori/' + kategoriId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        jenisSelect.html('<option value="">-- Pilih Jenis --</option>');
                        $.each(data, function(key, value) {
                            jenisSelect.append('<option value="' + value.id + '">' + value.name_jenis + '</option>');
                        });
                    },
                    error: function() {
                        jenisSelect.html('<option value="">-- Gagal memuat data --</option>');
                    }
                });
            } else {
                jenisSelect.html('<option value="">-- Pilih Kategori Terlebih Dahulu --</option>');
            }
        });

        // Custom search functionality
        $('#custom-search').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            
            $('#barang-table tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            
            var visibleRows = $('#barang-table tbody tr:visible').length;
            if (visibleRows === 0) {
                if ($('#no-results-message').length === 0) {
                    $('#barang-table tbody').append('<tr id="no-results-message"><td colspan="9" class="text-center py-4"><div class="text-muted"><i class="bi bi-search display-4 d-block mb-3"></i><h5>Tidak Ditemukan</h5><p class="mb-0">Tidak ada barang yang cocok dengan pencarian Anda.</p></div></td></tr>');
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
        
        // Jika ada error validasi dari server, tampilkan modal tambah kembali
        @if($errors->any())
            $('#modalTambah').modal('show');
        @endif
    });
</script>
@endpush