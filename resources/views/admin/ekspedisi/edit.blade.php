@extends('layouts.admin')

@section('title', 'Edit Ekspedisi - Stockiva')
@section('page-title', 'Edit Ekspedisi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.ekspedisi.index') }}">Ekspedisi</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.ekspedisi.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        Form Edit Ekspedisi
                    </h5>
                </div>
            </div>
            
            <div class="card-body">
                {{-- Informasi yang diedit --}}
                <div class="alert alert-info bg-light border-0 d-flex align-items-center mb-4">
                    <div class="bg-primary-subtle rounded-circle p-2 me-3">
                        <i class="bi bi-truck fs-5 text-primary"></i>
                    </div>
                    <div>
                        <strong>Sedang mengedit:</strong> 
                        <span class="fw-bold">{{ $ekspedisi->nama_ekspedisi }}</span>
                    </div>
                </div>

                <form action="{{ route('admin.ekspedisi.update', $ekspedisi->id) }}" method="POST" id="formEditEkspedisi">
                    @csrf
                    @method('PUT')
                    
                    {{-- Alert jika ada error validasi --}}
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mt-2 mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {{-- Hidden fields untuk lokasi --}}
                    <input type="hidden" name="provinsi" id="provinsi_name" value="{{ old('provinsi', $ekspedisi->provinsi) }}">
                    <input type="hidden" name="kabupaten_kota" id="kabupaten_kota_name" value="{{ old('kabupaten_kota', $ekspedisi->kabupaten_kota) }}">
                    <input type="hidden" name="kecamatan" id="kecamatan_name" value="{{ old('kecamatan', $ekspedisi->kecamatan) }}">
                    <input type="hidden" name="desa" id="desa_name" value="{{ old('desa', $ekspedisi->desa) }}">
                    
                    {{-- Informasi Ekspedisi --}}
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-truck me-2"></i>
                            Informasi Ekspedisi
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="nama_ekspedisi" class="form-label">
                                        Nama Ekspedisi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nama_ekspedisi') is-invalid @enderror" 
                                           id="nama_ekspedisi" 
                                           name="nama_ekspedisi" 
                                           value="{{ old('nama_ekspedisi', $ekspedisi->nama_ekspedisi) }}"
                                           placeholder="Contoh: JNE, TIKI, SiCepat"
                                           required>
                                    @error('nama_ekspedisi')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Alamat Ekspedisi dengan API --}}
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            Alamat Ekspedisi
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="provinsi_select" class="form-label">
                                    Provinsi <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('provinsi') is-invalid @enderror" 
                                        id="provinsi_select" 
                                        required>
                                    <option value="">-- Pilih Provinsi --</option>
                                </select>
                                @error('provinsi')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="kabupaten_kota_select" class="form-label">
                                    Kabupaten/Kota <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('kabupaten_kota') is-invalid @enderror" 
                                        id="kabupaten_kota_select" 
                                        required>
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                </select>
                                @error('kabupaten_kota')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="kecamatan_select" class="form-label">
                                    Kecamatan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('kecamatan') is-invalid @enderror" 
                                        id="kecamatan_select" 
                                        required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                                @error('kecamatan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="desa_select" class="form-label">
                                    Desa/Kelurahan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('desa') is-invalid @enderror" 
                                        id="desa_select" 
                                        required>
                                    <option value="">-- Pilih Desa/Kelurahan --</option>
                                </select>
                                @error('desa')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="alamat" class="form-label">
                                    Alamat Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="3" 
                                          placeholder="Nama jalan, gedung, nomor gedung"
                                          required>{{ old('alamat', $ekspedisi->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    {{-- Informasi PIC --}}
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-person-badge me-2"></i>
                            Informasi PIC (Person In Charge)
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_pic" class="form-label">
                                    Nama PIC <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama_pic') is-invalid @enderror" 
                                       id="nama_pic" 
                                       name="nama_pic" 
                                       value="{{ old('nama_pic', $ekspedisi->nama_pic) }}"
                                       placeholder="Nama penanggung jawab"
                                       required>
                                @error('nama_pic')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="no_telp_pic" class="form-label">
                                    No. Telepon PIC <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('no_telp_pic') is-invalid @enderror" 
                                       id="no_telp_pic" 
                                       name="no_telp_pic" 
                                       value="{{ old('no_telp_pic', $ekspedisi->no_telp_pic) }}"
                                       placeholder="08xxxxxxxxxx"
                                       required>
                                @error('no_telp_pic')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                                <div class="col-md-12 mb-3">
                                    <label for="email_pic" class="form-label">
                                        Email PIC <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email_pic') is-invalid @enderror" 
                                           id="email_pic" 
                                           name="email_pic" 
                                           value="{{ old('email_pic', $ekspedisi->email_pic) }}"
                                           placeholder="email@contoh.com">
                                            @error('email_pic')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                 </div>
                            </div>
                    </div>
                    
                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.ekspedisi.index') }}" class="btn btn-light px-4">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-5" id="btnSubmit">
                            <i class="bi bi-save me-2"></i>
                            Update Ekspedisi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }
    
    .card-header {
        background: white;
        border-bottom: 1px solid #eef2f6;
        padding: 1.25rem 1.5rem;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    h6 {
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.75rem;
        margin-bottom: 1.25rem;
    }
    
    h6 i {
        color: #0b2b4f;
    }
    
    .form-label {
        font-weight: 500;
        color: #475569;
    }
    
    .btn-primary {
        background: #0b2b4f;
        border: none;
        padding: 0.6rem 1.5rem;
    }
    
    .btn-primary:hover {
        background: #1a3a5f;
    }
    
    .btn-light {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
    }
    
    .alert-info {
        background: #f0f9ff;
        border-radius: 12px;
    }
    
    .bg-primary-subtle {
        background: rgba(11, 43, 79, 0.08);
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Data lama
        var oldProvinsi = '{{ $ekspedisi->provinsi }}';
        var oldKabupaten = '{{ $ekspedisi->kabupaten_kota }}';
        var oldKecamatan = '{{ $ekspedisi->kecamatan }}';
        var oldDesa = '{{ $ekspedisi->desa }}';
        
        // Load Provinsi dari API
        $.ajax({
            url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#provinsi_select').html('<option value="">-- Pilih Provinsi --</option>');
                
                var selectedProvinceId = '';
                $.each(data, function(key, value) {
                    $('#provinsi_select').append('<option value="' + value.id + '">' + value.name + '</option>');
                    if (value.name === oldProvinsi) {
                        selectedProvinceId = value.id;
                    }
                });
                
                if (selectedProvinceId) {
                    $('#provinsi_select').val(selectedProvinceId).trigger('change');
                }
            }
        });

        // Event change provinsi
        $('#provinsi_select').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var provinceName = selectedOption.text();
            var provinceId = $(this).val();
            
            $('#provinsi_name').val(provinceName);
            $('#kabupaten_kota_select').html('<option value="">Loading...</option>');
            $('#kecamatan_select').html('<option value="">-- Pilih Kecamatan --</option>');
            $('#desa_select').html('<option value="">-- Pilih Desa/Kelurahan --</option>');
            
            if (provinceId) {
                $.ajax({
                    url: 'https://www.emsifa.com/api-wilayah-indonesia/api/regencies/' + provinceId + '.json',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kabupaten_kota_select').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
                        
                        var selectedRegencyId = '';
                        $.each(data, function(key, value) {
                            $('#kabupaten_kota_select').append('<option value="' + value.id + '">' + value.name + '</option>');
                            if (value.name === oldKabupaten) {
                                selectedRegencyId = value.id;
                            }
                        });
                        
                        if (selectedRegencyId) {
                            $('#kabupaten_kota_select').val(selectedRegencyId).trigger('change');
                        }
                    }
                });
            }
        });

        // Event change kabupaten/kota
        $('#kabupaten_kota_select').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var regencyName = selectedOption.text();
            var regencyId = $(this).val();
            
            $('#kabupaten_kota_name').val(regencyName);
            $('#kecamatan_select').html('<option value="">Loading...</option>');
            $('#desa_select').html('<option value="">-- Pilih Desa/Kelurahan --</option>');
            
            if (regencyId) {
                $.ajax({
                    url: 'https://www.emsifa.com/api-wilayah-indonesia/api/districts/' + regencyId + '.json',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kecamatan_select').html('<option value="">-- Pilih Kecamatan --</option>');
                        
                        var selectedDistrictId = '';
                        $.each(data, function(key, value) {
                            $('#kecamatan_select').append('<option value="' + value.id + '">' + value.name + '</option>');
                            if (value.name === oldKecamatan) {
                                selectedDistrictId = value.id;
                            }
                        });
                        
                        if (selectedDistrictId) {
                            $('#kecamatan_select').val(selectedDistrictId).trigger('change');
                        }
                    }
                });
            }
        });

        // Event change kecamatan
        $('#kecamatan_select').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var districtName = selectedOption.text();
            var districtId = $(this).val();
            
            $('#kecamatan_name').val(districtName);
            $('#desa_select').html('<option value="">Loading...</option>');
            
            if (districtId) {
                $.ajax({
                    url: 'https://www.emsifa.com/api-wilayah-indonesia/api/villages/' + districtId + '.json',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#desa_select').html('<option value="">-- Pilih Desa/Kelurahan --</option>');
                        
                        $.each(data, function(key, value) {
                            $('#desa_select').append('<option value="' + value.id + '">' + value.name + '</option>');
                            if (value.name === oldDesa) {
                                $('#desa_select').val(value.id);
                                $('#desa_name').val(value.name);
                            }
                        });
                    }
                });
            }
        });

        // Event change desa
        $('#desa_select').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var villageName = selectedOption.text();
            $('#desa_name').val(villageName);
        });

        // Validasi form sebelum submit
        $('#formEditEkspedisi').on('submit', function(e) {
            if (!$('#provinsi_name').val() || !$('#kabupaten_kota_name').val() || 
                !$('#kecamatan_name').val() || !$('#desa_name').val()) {
                e.preventDefault();
                alert('Harap lengkapi semua pilihan lokasi!');
                return false;
            }
        });

        // Format nomor telepon (hanya angka)
        $('#no_telp_pic').on('input', function() {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
    });
</script>
@endpush