@extends('layouts.direktur')

@section('title', 'Profile - Stockiva')
@section('page-title', 'Profile & Tanda Tangan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('direktur.profile') }}">Profile</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Profile</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%">Nama</td>
                        <td>: <strong>{{ Auth::user()->nama }}</strong></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>: {{ Auth::user()->username }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: {{ Auth::user()->email }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>: {{ Auth::user()->jabatan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Upload Tanda Tangan --}}
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Upload Tanda Tangan</h5>
            </div>
            <div class="card-body">
                @if(Auth::user()->ttd_path)
                <div class="mb-3 text-center">
                    <p class="mb-2">Tanda Tangan Saat Ini:</p>
                    <img src="{{ Storage::url(Auth::user()->ttd_path) }}" 
                         alt="TTD" 
                         style="max-width: 200px; max-height: 80px; border: 1px solid #ddd; padding: 10px; border-radius: 8px;">
                    <br>
                    <small class="text-muted">Upload ulang akan mengganti yang lama</small>
                </div>
                @endif

                <form action="{{ route('direktur.profile.upload-ttd') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="ttd" class="form-label">File Tanda Tangan</label>
                        <input type="file" 
                               class="form-control @error('ttd') is-invalid @enderror" 
                               id="ttd" 
                               name="ttd" 
                               accept="image/png"
                               required>
                        <small class="text-muted">Format: PNG, Maks: 1MB, Background transparan</small>
                        @error('ttd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload"></i> Upload Tanda Tangan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection