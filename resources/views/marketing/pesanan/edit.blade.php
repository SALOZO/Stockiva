<!-- resources/views/marketing/pesanan/edit.blade.php -->
@extends('layouts.marketing')

@section('title', 'Edit Pesanan - Stockiva Marketing')
@section('page-title', 'Edit Pesanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('marketing.pesanan.index') }}">Pilih Client</a></li>
    <li class="breadcrumb-item"><a href="{{ route('marketing.pesanan.by-client', $pesanan->client_id) }}">Pesanan Client</a></li>
    <li class="breadcrumb-item active">Edit Pesanan</li>
@endsection

@section('content')
<div class="row">
    <class class="col-12">
        {{-- INFO CLIENT --}}
        
            <div>
                <h5 class="mb-1">Mengedit pesanan untuk:</h5>
                <h4 class="fw-bold mb-1">{{ $pesanan->client->nama_client }}</h4>
                <p class="mb-0">
                    <i class="bi bi-person me-1"></i> {{ $pesanan->client->nama_pic }} ({{ $pesanan->client->jabatan_pic }})
                </p>
            </div>
            <div class="ms-auto">
                <span class="badge bg-primary">{{ $pesanan->no_pesanan }}</span>
            </div>
        </class>
        

        {{-- FORM EDIT PESANAN --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Pesanan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('marketing.pesanan.update', $pesanan->id) }}" method="POST" id="formPesanan">
                    @csrf
                    @method('PUT')
                    
                    {{-- Tanggal dan Status --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="tanggal_pesanan" class="form-label">Tanggal Pesanan <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('tanggal_pesanan') is-invalid @enderror" 
                                   id="tanggal_pesanan" 
                                   name="tanggal_pesanan" 
                                   value="{{ old('tanggal_pesanan', $pesanan->tanggal_pesanan->format('Y-m-d')) }}"
                                   required>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="baru" {{ $pesanan->status == 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" 
                                   class="form-control @error('keterangan') is-invalid @enderror" 
                                   id="keterangan" 
                                   name="keterangan" 
                                   value="{{ old('keterangan', $pesanan->keterangan) }}"
                                   placeholder="Catatan untuk pesanan ini">
                        </div>
                    </div>

                    {{-- DAFTAR ITEM PESANAN --}}
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-cart me-2"></i>
                        Item Pesanan
                    </h6>

                    <div class="table-responsive mb-3">
                        <table class="table table-bordered" id="itemsTable">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th width="18%">Kategori</th>
                                    <th width="18%">Jenis</th>
                                    <th width="22%">Barang</th>
                                    <th width="10%">Satuan</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Subtotal</th>
                                    <th width="7%">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="itemsContainer">
                                {{-- Item akan diisi via JavaScript dari data existing --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-start fw-bold">TOTAL</td>
                                    <td class="fw-bold text-primary text-center" id="totalKeseluruhan">Rp 0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- Tombol Tambah Item --}}
                    <button type="button" class="btn btn-sm btn-outline-primary mb-4" id="tambahItem">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Item
                    </button>

                    {{-- Tombol Submit --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('marketing.pesanan.show', $pesanan->id) }}" class="btn btn-light">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="bi bi-save me-1"></i>
                            Update Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- TEMPLATE ITEM --}}
<template id="itemTemplate">
    <tr class="item-row">
        <td>
            <select class="form-select form-select-sm kategori-item" name="items[INDEX][kategori_id]" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->name_kategori }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select class="form-select form-select-sm jenis-item" name="items[INDEX][jenis_id]" required>
                <option value="">Pilih Jenis</option>
            </select>
        </td>
        <td>
            <select class="form-select form-select-sm barang-item" name="items[INDEX][barang_id]" required>
                <option value="">Pilih Barang</option>
            </select>
        </td>
        <td class="satuan-cell text-center">-</td>
        <td>
            <input type="number" class="form-control form-control-sm jumlah-item" name="items[INDEX][jumlah]" min="1" value="1" required>
        </td>
        <td class="subtotal-cell text-center">Rp 0</td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger hapus-item">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
</template>

{{-- Data existing items untuk di-load JavaScript --}}
@push('scripts')
<script>
    const existingItems = @json($pesanan->details);
    const semuaBarang = @json(\App\Models\Barang::with(['jenis', 'satuan'])->get());
</script>
@endpush
@endsection

@push('styles')
<style>
    .bg-primary-subtle {
        background: rgba(11, 43, 79, 0.08);
    }
    
    .table th {
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .btn-outline-primary {
        border-color: #e2e8f0;
        color: #0b2b4f;
    }
    
    .btn-outline-primary:hover {
        background: #0b2b4f;
        color: white;
        border-color: #0b2b4f;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        let itemIndex = 0;
        const dataBarang = {}; // Menyimpan data barang per index

        // ========== LOAD EXISTING ITEMS ==========
        function loadExistingItems() {
            existingItems.forEach((item, index) => {
                $('#tambahItem').trigger('click');
                const currentRow = $(`#itemsContainer tr:last`);
                
                // Setelah row dibuat, kita perlu mengisi data dengan cara yang benar
                setTimeout(() => {
                    // Set kategori
                    currentRow.find('.kategori-item').val(item.kategori_id).trigger('change');
                    
                    // Setelah kategori berubah dan load jenis, set jenis
                    setTimeout(() => {
                        currentRow.find('.jenis-item').val(item.jenis_id).trigger('change');
                        
                        // Setelah jenis berubah dan load barang, set barang
                        setTimeout(() => {
                            currentRow.find('.barang-item').val(item.barang_id).trigger('change');
                            currentRow.find('.jumlah-item').val(item.jumlah).trigger('input');
                        }, 500);
                    }, 500);
                }, 500);
            });
        }

        // ========== TAMBAH ITEM BARU ==========
        $('#tambahItem').click(function() {
            const template = $('#itemTemplate').html();
            const newItem = template.replace(/INDEX/g, itemIndex);
            $('#itemsContainer').append(newItem);
            
            initItem(itemIndex);
            
            itemIndex++;
        });

        // ========== INITIALISASI ITEM ==========
        function initItem(index) {
            const row = $(`#itemsContainer tr:last`);
            
            // 1. KATEGORI DIPILIH
            row.find('.kategori-item').change(function() {
                const kategoriId = $(this).val();
                const jenisSelect = row.find('.jenis-item');
                const barangSelect = row.find('.barang-item');
                
                jenisSelect.html('<option value="">Loading...</option>');
                barangSelect.html('<option value="">Pilih Barang</option>');
                row.find('.satuan-cell').text('-');
                row.find('.subtotal-cell').text('Rp 0');
                hitungTotal();
                
                if (kategoriId) {
                    // Filter barang by kategori
                    const filtered = semuaBarang.filter(b => b.kategori_id == kategoriId);
                    
                    // Kumpulkan jenis unik
                    const jenisUnik = {};
                    filtered.forEach(barang => {
                        if (barang.jenis) {
                            jenisUnik[barang.jenis_id] = barang.jenis.name_jenis;
                        }
                    });
                    
                    // Buat dropdown jenis
                    let options = '<option value="">Pilih Jenis</option>';
                    Object.keys(jenisUnik).forEach(id => {
                        options += `<option value="${id}">${jenisUnik[id]}</option>`;
                    });
                    jenisSelect.html(options);
                    
                    // Simpan data barang
                    dataBarang[index] = filtered;
                }
            });
            
            // 2. JENIS DIPILIH
            row.find('.jenis-item').change(function() {
                const jenisId = $(this).val();
                const barangSelect = row.find('.barang-item');
                
                barangSelect.html('<option value="">Loading...</option>');
                row.find('.satuan-cell').text('-');
                
                if (jenisId && dataBarang[index]) {
                    const filtered = dataBarang[index].filter(b => b.jenis_id == jenisId);
                    
                    let options = '<option value="">Pilih Barang</option>';
                    filtered.forEach(barang => {
                        const satuan = barang.satuan ? barang.satuan.nama_satuan : '-';
                        options += `<option value="${barang.id}" 
                            data-harga="${barang.harga_satuan}" 
                            data-satuan="${satuan}">
                            ${barang.nama_barang}
                        </option>`;
                    });
                    barangSelect.html(options);
                }
            });
            
            // 3. BARANG DIPILIH
            row.find('.barang-item').change(function() {
                const selected = $(this).find('option:selected');
                const harga = selected.data('harga') || 0;
                const satuan = selected.data('satuan') || '-';
                
                row.find('.satuan-cell').text(satuan);
                row.data('harga', harga);
                hitungSubtotal(row);
            });
            
            // 4. JUMLAH DIUBAH
            row.find('.jumlah-item').on('input', function() {
                hitungSubtotal(row);
            });
            
            // 5. HAPUS ITEM
            row.find('.hapus-item').click(function() {
                row.remove();
                hitungTotal();
            });
        }

        // ========== HITUNG SUBTOTAL ==========
        function hitungSubtotal(row) {
            const harga = row.data('harga') || 0;
            const jumlah = row.find('.jumlah-item').val() || 0;
            const subtotal = harga * jumlah;
            
            row.find('.subtotal-cell').text('Rp ' + formatNumber(subtotal));
            row.data('subtotal', subtotal);
            
            hitungTotal();
        }

        // ========== HITUNG TOTAL ==========
        function hitungTotal() {
            let total = 0;
            $('.item-row').each(function() {
                total += $(this).data('subtotal') || 0;
            });
            $('#totalKeseluruhan').text('Rp ' + formatNumber(total));
        }

        // ========== FORMAT RUPIAH ==========
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // ========== VALIDASI FORM ==========
        $('#formPesanan').submit(function(e) {
            if ($('.item-row').length === 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 item pesanan!');
                return false;
            }
            
            let valid = true;
            $('.item-row').each(function() {
                if (!$(this).find('.barang-item').val()) {
                    valid = false;
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Harap lengkapi semua item pesanan!');
                return false;
            }
            
            $('#btnSubmit').prop('disabled', true)
                          .html('<i class="bi bi-hourglass me-1"></i> Menyimpan...');
        });

        // Load existing items setelah semua siap
        setTimeout(() => {
            loadExistingItems();
        }, 500);
    });
</script>
@endpush