@extends('layouts.keuangan')

@section('title', 'Manajemen Bank - Stockiva')
@section('page-title', 'Manajemen Bank Perusahaan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Bank</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Rekening Bank</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle"></i> Tambah Bank
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bank</th>
                                <th>Cabang</th>
                                <th>No. Rekening</th>
                                <th>Atas Nama</th>
                                <th>Status</th>
                                <th>Aksi</th>
                             </thead>
                        <tbody>
                            @forelse($banks as $index => $bank)
                              <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $bank->nama_bank }}</strong></td>
                                <td>{{ $bank->cabang ?? '-' }}</td>
                                <td>{{ $bank->nomor_rekening }}</td>
                                <td>{{ $bank->atas_nama }}</td>
                                <td>
                                    @if($bank->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $bank->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('keuangan.bank.destroy', $bank->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus bank ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                              </tr>

                              {{-- MODAL EDIT --}}
                              <div class="modal fade" id="modalEdit{{ $bank->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('keuangan.bank.update', $bank->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Bank</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Nama Bank *</label>
                                                    <input type="text" class="form-control" name="nama_bank" value="{{ $bank->nama_bank }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Cabang</label>
                                                    <input type="text" class="form-control" name="cabang" value="{{ $bank->cabang }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Nomor Rekening *</label>
                                                    <input type="text" class="form-control" name="nomor_rekening" value="{{ $bank->nomor_rekening }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Atas Nama *</label>
                                                    <input type="text" class="form-control" name="atas_nama" value="{{ $bank->atas_nama }}" required>
                                                </div>
                                                <div class="mb-3 form-check">
                                                    <input type="hidden" name="is_active" value="0">
                                                    <input type="checkbox" class="form-check-input" name="is_active" value="1"
                                                        {{ $bank->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label">Aktif</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                              </div>
                            @empty
                              <tr><td colspan="7" class="text-center">Belum ada data bank.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('keuangan.bank.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Bank Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Bank *</label>
                        <input type="text" class="form-control" name="nama_bank" required>
                    </div>
                    <div class="mb-3">
                        <label>Cabang</label>
                        <input type="text" class="form-control" name="cabang">
                    </div>
                    <div class="mb-3">
                        <label>Nomor Rekening *</label>
                        <input type="text" class="form-control" name="nomor_rekening" required>
                    </div>
                    <div class="mb-3">
                        <label>Atas Nama *</label>
                        <input type="text" class="form-control" name="atas_nama" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="is_active" value="1">
                        <label class="form-check-label">Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection