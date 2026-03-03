@extends('layouts.marketing')

@section('title', 'Pengaturan SPH - Stockiva')
@section('page-title', 'Pengaturan SPH')

@section('breadcrumb')
    {{-- <li class="breadcrumb-item"><a href="{{ route('marketing.sph.index') }}">SPH</a></li> --}}
    <li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pengaturan Surat Penawaran Harga (SPH)</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Ubah pengaturan berikut untuk menyesuaikan format SPH yang akan digenerate.
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th width="30%">Pengaturan</th>
                                <th width="50%">Nilai Saat Ini</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settings as $setting)
                            <tr>
                                <td>
                                    <strong>{{ ucwords(str_replace('_', ' ', $setting->key)) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $setting->description }}</small>
                                </td>
                                <td>
                                    @if($setting->type == 'boolean')
                                        <span class="badge {{ $setting->value == '1' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $setting->value == '1' ? 'Ya' : 'Tidak' }}
                                        </span>
                                    @elseif($setting->type == 'textarea')
                                        <div style="max-width: 300px; white-space: pre-wrap;">{{ $setting->value }}</div>
                                    @else
                                        {{ $setting->value }}
                                    @endif
                                </td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal{{ $setting->id }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT UNTUK SETIAP SETTING --}}
@foreach($settings as $setting)
<div class="modal fade" id="editModal{{ $setting->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('marketing.sph-settings.update', $setting->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <p class="text-muted small">{{ $setting->description }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="value_{{ $setting->id }}" class="form-label">Nilai</label>
                        
                        @if($setting->type == 'boolean')
                            <select class="form-select" 
                                    id="value_{{ $setting->id }}" 
                                    name="value" 
                                    required>
                                <option value="1" {{ $setting->value == '1' ? 'selected' : '' }}>Ya</option>
                                <option value="0" {{ $setting->value == '0' ? 'selected' : '' }}>Tidak</option>
                            </select>
                        @elseif($setting->type == 'textarea')
                            <textarea class="form-control" 
                                      id="value_{{ $setting->id }}" 
                                      name="value" 
                                      rows="4"
                                      required>{{ $setting->value }}</textarea>
                        @else
                            <input type="text" 
                                   class="form-control" 
                                   id="value_{{ $setting->id }}" 
                                   name="value" 
                                   value="{{ $setting->value }}"
                                   required>
                        @endif
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('styles')
<style>
    .table td {
        vertical-align: middle;
    }
    .modal-content {
        border-radius: 12px;
    }
    .modal-header {
        background: #f8fafc;
    }
</style>
@endpush