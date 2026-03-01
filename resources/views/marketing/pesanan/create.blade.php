<!-- resources/views/marketing/pesanan/create.blade.php -->
@extends('layouts.marketing')

@section('title', 'Buat Pesanan - Stockiva Marketing')
@section('page-title', 'Buat Pesanan Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('marketing.pesanan.index') }}">Pilih Client</a></li>
    <li class="breadcrumb-item active">Buat Pesanan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        {{-- INFO CLIENT --}}
        <div>
            <div>
                {{-- <h5 class="mb-1">Anda sedang membuat pesanan untuk:</h5> --}}
                <h4 class="fw-bold mb-1">{{ $client->nama_client }}</h4>
                <p class="mb-0">
                    <i class="bi bi-person me-1"></i> {{ $client->nama_pic }} ({{ $client->jabatan_pic }})<br>
                    <i class="bi bi-geo-alt me-1"></i> {{ $client->alamat }}, {{ $client->kabupaten_kota }}, {{ $client->provinsi }}
                </p>
                <input type="hidden" id="client_id" value="{{ $client->id }}">
            </div>
        </div>

        {{-- FORM PESANAN --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Pesanan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('marketing.pesanan.store') }}" method="POST" id="formPesanan">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    
                    {{-- Tanggal Pesanan --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="tanggal_pesanan" class="form-label">Tanggal Pesanan <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('tanggal_pesanan') is-invalid @enderror" 
                                   id="tanggal_pesanan" 
                                   name="tanggal_pesanan" 
                                   value="{{ old('tanggal_pesanan', date('Y-m-d')) }}"
                                   required>
                        </div>
                        <div class="col-md-8">
                            <label for="keterangan" class="form-label">Perihal</label>
                            <input type="text" 
                                   class="form-control @error('keterangan') is-invalid @enderror" 
                                   id="keterangan" 
                                   name="keterangan" 
                                   value="{{ old('keterangan') }}"
                                   placeholder="Catatan untuk pesanan ini (opsional)">
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
                                    <th width="20%">Kategori</th>
                                    <th width="20%">Jenis</th>
                                    <th width="25%">Barang</th>
                                    <th width="10%">Satuan</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Subtotal</th>
                                    <th width="5%">DELETE</th>
                                </tr>
                            </thead>
                            <tbody id="itemsContainer">
                                {{-- Item akan ditambahkan via JavaScript --}}
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <td colspan="5" class="text-start fw-bold">TOTAL</td>
                                    <td class="fw-bold text-primary" id="totalKeseluruhan">Rp 0</td>
                                    <td></td>
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
                        <a href="{{ route('marketing.pesanan.index') }}" class="btn btn-light">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="bi bi-save me-1"></i>
                            Simpan Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- TEMPLATE ITEM (untuk di-clone via JavaScript) --}}
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
    
    .form-select-sm, .form-control-sm {
        font-size: 0.85rem;
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
        const itemsData = {}; // Menyimpan data barang

        // ========== TAMBAH ITEM ==========
        $('#tambahItem').click(function() {
            const template = $('#itemTemplate').html();
            const newItem = template.replace(/INDEX/g, itemIndex);
            $('#itemsContainer').append(newItem);
            
            // Inisialisasi event untuk item baru
            initItemEvents(itemIndex);
            
            itemIndex++;
        });

        // ========== INIT ITEM EVENTS ==========
        function initItemEvents(index) {
            const row = $(`#itemsContainer tr:last-child`);
            
            // Event change kategori
            row.find('.kategori-item').change(function() {
                const kategoriId = $(this).val();
                const jenisSelect = row.find('.jenis-item');
                const barangSelect = row.find('.barang-item');
                
                // Reset
                jenisSelect.html('<option value="">Pilih Jenis</option>');
                barangSelect.html('<option value="">Pilih Barang</option>');
                row.find('.satuan-cell').text('-');
                row.find('.subtotal-cell').text('Rp 0');
                updateTotal();
                
                if (kategoriId) {
                    jenisSelect.html('<option value="">Loading...</option>');
                    
                    $.ajax({
                        url: '/marketing/get-barang-by-kategori/' + kategoriId,
                        type: 'GET',
                        success: function(barangs) {
                            // Group barang by jenis
                            const grouped = {};
                            barangs.forEach(barang => {
                                const jenisId = barang.jenis_id;
                                if (!grouped[jenisId]) {
                                    grouped[jenisId] = {
                                        nama_jenis: barang.jenis ? barang.jenis.name_jenis : 'Unknown',
                                        items: []
                                    };
                                }
                                grouped[jenisId].items.push(barang);
                            });
                            
                            // Buat option jenis
                            let jenisOptions = '<option value="">Pilih Jenis</option>';
                            Object.keys(grouped).forEach(jenisId => {
                                jenisOptions += `<option value="${jenisId}">${grouped[jenisId].nama_jenis}</option>`;
                            });
                            jenisSelect.html(jenisOptions);
                            
                            // Simpan data barang
                            itemsData[index] = grouped;
                        },
                        error: function(xhr) {
                            console.error('Error loading barang:', xhr);
                            jenisSelect.html('<option value="">Error loading data</option>');
                        }
                    });
                }
            });
            
            // Event change jenis
            row.find('.jenis-item').change(function() {
                const jenisId = $(this).val();
                const barangSelect = row.find('.barang-item');
                
                barangSelect.html('<option value="">Loading...</option>');
                row.find('.satuan-cell').text('-');
                row.find('.subtotal-cell').text('Rp 0');
                updateTotal();
                
                if (jenisId && itemsData[index] && itemsData[index][jenisId]) {
                    const grouped = itemsData[index][jenisId];
                    let barangOptions = '<option value="">Pilih Barang</option>';
                    
                    grouped.items.forEach(barang => {
                        const satuan = barang.satuan ? barang.satuan.nama_satuan : '-';
                        barangOptions += `<option value="${barang.id}" data-harga="${barang.harga_satuan}" data-satuan="${satuan}">${barang.nama_barang}</option>`;
                    });
                    
                    barangSelect.html(barangOptions);
                } else {
                    barangSelect.html('<option value="">Pilih Barang</option>');
                }
            });
            
            // Event change barang
            row.find('.barang-item').change(function() {
                const selected = $(this).find('option:selected');
                const harga = selected.data('harga') || 0;
                const satuan = selected.data('satuan') || '-';
                
                row.find('.satuan-cell').text(satuan);
                row.data('harga', harga);
                
                hitungSubtotal(row);
            });
            
            // Event input jumlah
            row.find('.jumlah-item').on('input', function() {
                hitungSubtotal(row);
            });
            
            // Event hapus item
            row.find('.hapus-item').click(function() {
                row.remove();
                updateTotal();
            });
        }

        // ========== HITUNG SUBTOTAL ==========
        function hitungSubtotal(row) {
            const harga = row.data('harga') || 0;
            const jumlah = parseInt(row.find('.jumlah-item').val()) || 0;
            const subtotal = harga * jumlah;
            
            row.find('.subtotal-cell').text('Rp ' + formatNumber(subtotal));
            row.data('subtotal', subtotal);
            
            updateTotal();
        }

        // ========== UPDATE TOTAL ==========
        function updateTotal() {
            let total = 0;
            $('.item-row').each(function() {
                const subtotal = $(this).data('subtotal') || 0;
                total += subtotal;
            });
            $('#totalKeseluruhan').text('Rp ' + formatNumber(total));
        }

        // ========== FORMAT NUMBER ==========
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // ========== VALIDASI FORM ==========
        $('#formPesanan').submit(function(e) {
            if ($('.item-row').length === 0) {
                e.preventDefault();
                alert('Minimal harus menambah 1 item pesanan!');
                return false;
            }
            
            // Validasi setiap item sudah lengkap
            let valid = true;
            $('.item-row').each(function() {
                const kategori = $(this).find('.kategori-item').val();
                const jenis = $(this).find('.jenis-item').val();
                const barang = $(this).find('.barang-item').val();
                
                if (!kategori || !jenis || !barang) {
                    valid = false;
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Harap lengkapi semua item pesanan!');
                return false;
            }
            
            $('#btnSubmit').prop('disabled', true).html('<i class="bi bi-hourglass me-1"></i> Menyimpan...');
        });

        // Tambahkan 1 item default saat halaman dimuat
        $('#tambahItem').trigger('click');
    });
</script>
@endpush