@extends('layouts.admin')

@section('title', 'Edit User - Stockiva')
@section('page-title', 'Edit User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $user->id) }}">{{ $user->nama }}</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-secondary me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        Form Edit User
                    </h5>
                </div>
            </div>
            
            <div class="card-body">
                {{-- Informasi User yang diedit --}}
                <div class="alert alert-info bg-light border-0 d-flex align-items-center mb-4">
                    <div>
                        <strong>Sedang mengedit:</strong> 
                        <span class="fw-bold">{{ $user->nama }}</span> 
                        <span class="text-muted">({{ $user->email }})</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" id="formEditUser">
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
                    
                    {{-- Form Row 1: Nama Lengkap & Username --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       placeholder="Masukkan nama lengkap"
                                       required>
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="username" class="form-label">
                                Username <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-at"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       id="username" 
                                       name="username" 
                                       value="{{ old('username', $user->username) }}" 
                                       placeholder="Masukkan username"
                                       required>
                            </div>
                            @error('username')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Form Row 2: Email & Jabatan --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       placeholder="contoh@email.com"
                                       required>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    <div class="col-md-6">
                        <label for="jabatan" class="form-label">Jabatan </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-briefcase"></i>
                            </span>

                            <select 
                                class="form-select @error('jabatan') is-invalid @enderror" 
                                id="jabatan" 
                                name="jabatan">

                                <option value="">-- Pilih Jabatan --</option>

                                <option value="Admin"
                                    {{ old('jabatan', $user->jabatan ?? '') == 'Admin' ? 'selected' : '' }}>
                                    Admin
                                </option>

                                <option value="Marketing"
                                    {{ old('jabatan', $user->jabatan ?? '') == 'Marketing' ? 'selected' : '' }}>
                                    Marketing
                                </option>

                                <option value="Gudang"
                                    {{ old('jabatan', $user->jabatan ?? '') == 'Gudang' ? 'selected' : '' }}>
                                    Gudang
                                </option>

                                <option value="Keuangan"
                                    {{ old('jabatan', $user->jabatan ?? '') == 'Keuangan' ? 'selected' : '' }}>
                                    Keuangan
                                </option>

                            </select>
                        </div>

                        @error('jabatan')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Form Row 3: No Telepon --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="no_telp" class="form-label">No. Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('no_telp') is-invalid @enderror" 
                                       id="no_telp" 
                                       name="no_telp" 
                                       value="{{ old('no_telp', $user->no_telp) }}" 
                                       placeholder="08xxxxxxxxxx">
                            </div>
                            @error('no_telp')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            {{-- Kosong untuk spacing --}}
                        </div>
                    </div>
                    
                    {{-- Divider untuk bagian Password --}}
                    <hr class="my-4">
                    
                    <div class="mb-3">
                        <h6 class="fw-semibold">
                            <i class="bi bi-lock me-2"></i>
                            Ubah Password 
                            <small class="text-muted fw-normal">(Kosongkan jika tidak ingin mengubah password)</small>
                        </h6>
                    </div>
                    
                    {{-- Form Row 4: Password Baru --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Minimal 6 karakter">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ketik ulang password baru">
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning bg-light border-0 d-flex align-items-center mt-3 mb-4">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-warning"></i>
                        <div>
                            <strong>Perhatian:</strong> Jika Anda mengisi password, user harus login dengan password baru setelah ini.
                        </div>
                    </div>
                    
                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-light px-4">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-5" id="btnSubmit">
                            <i class="bi bi-save me-2"></i>
                            Update
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
    /* Card styling konsisten */
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
    
    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    /* Form styling */
    .form-label {
        font-weight: 500;
        font-size: 0.9rem;
        color: #475569;
        margin-bottom: 0.5rem;
    }
    
    .input-group-text {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #64748b;
    }
    
    .form-control {
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s;
    }
    
    .form-control:focus {
        border-color: #0b2b4f;
        box-shadow: 0 0 0 3px rgba(11, 43, 79, 0.1);
    }
    
    .form-control.is-invalid {
        border-color: #dc2626;
        background-image: none;
    }
    
    .text-danger.small {
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }
    
    /* Alert styling */
    .alert {
        border-radius: 12px;
        border: none;
    }
    
    .alert-info {
        background: #f0f9ff;
        color: #0369a1;
    }
    
    .alert-warning {
        background: #fffbeb;
        color: #b45309;
    }
    
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .bg-primary-subtle {
        background: rgba(11, 43, 79, 0.08);
    }
    
    /* Button styling */
    .btn-light {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
    }
    
    .btn-light:hover {
        background: #e2e8f0;
        border-color: #cbd5e1;
    }
    
    .btn-primary {
        background: #0b2b4f;
        border: none;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
    }
    
    .btn-primary:hover {
        background: #1a3a5f;
    }
    
    .btn-outline-secondary {
        border: 1px solid #e2e8f0;
        color: #64748b;
    }
    
    .btn-outline-secondary:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #1e293b;
    }
    
    /* Animation untuk loading */
    .btn-primary.loading {
        position: relative;
        color: transparent;
    }
    
    .btn-primary.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid white;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 0.8s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Divider */
    hr {
        border-top: 1px solid #e2e8f0;
        opacity: 1;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        .btn {
            width: 100%;
            margin-top: 0.5rem;
        }
        
        .d-flex.justify-content-end {
            flex-direction: column;
        }
        
        .d-flex.justify-content-end .btn {
            margin-left: 0 !important;
        }
        
        .d-flex.gap-2 {
            flex-direction: column;
            width: 100%;
        }
        
        .d-flex.gap-2 .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Toggle password visibility
        $('#togglePassword').click(function() {
            const passwordInput = $('#password');
            const icon = $(this).find('i');
            
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });
        
        // Validasi password match sebelum submit (hanya jika password diisi)
        $('#formEditUser').on('submit', function(e) {
            const password = $('#password').val();
            const confirmPassword = $('#password_confirmation').val();
            
            // Jika password diisi, validasi
            if (password || confirmPassword) {
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Password dan konfirmasi password tidak cocok!');
                    return false;
                }
                
                if (password.length < 6) {
                    e.preventDefault();
                    alert('Password minimal 6 karakter!');
                    return false;
                }
            }
            
            // Tampilkan loading state
            $('#btnSubmit').addClass('loading').prop('disabled', true);
        });
        
        // Auto-uppercase untuk username? (opsional)
        $('#username').on('input', function() {
            // Hapus spasi
            $(this).val($(this).val().replace(/\s/g, ''));
        });
        
        // Format nomor telepon (hanya angka)
        $('#no_telp').on('input', function() {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
    });
</script>
@endpush