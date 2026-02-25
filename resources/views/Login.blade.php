<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Stockiva</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts: Inter untuk tampilan profesional -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f0f2f5;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-container {
            max-width: 1000px;
            width: 100%;
            display: flex;
            background: white;
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        }

        /* Left Panel - Branding */
        .brand-panel {
            flex: 1;
            background: #0b2b4f;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }

        .brand-panel h1 {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .brand-panel .brand-sub {
            font-size: 1rem;
            opacity: 0.8;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .feature-list {
            list-style: none;
            margin-top: 2rem;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .feature-list li i {
            margin-right: 1rem;
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* Right Panel - Form */
        .form-panel {
            flex: 1;
            padding: 3rem 2.5rem;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .greeting {
            margin-bottom: 2rem;
        }

        .greeting h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .greeting p {
            color: #64748b;
            font-size: 0.95rem;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.9rem;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .input-group {
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }

        .input-group:focus-within {
            border-color: #0b2b4f;
            box-shadow: 0 0 0 3px rgba(11, 43, 79, 0.1);
        }

        .input-group-text {
            background: #f8fafc;
            border: none;
            color: #64748b;
            padding-left: 1.25rem;
        }

        .form-control {
            border: none;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            background: #f8fafc;
        }

        .form-control:focus {
            box-shadow: none;
            background: #ffffff;
        }

        .forgot-password {
            text-align: right;
            margin: 0.5rem 0 1.5rem;
        }

        .forgot-password a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password a:hover {
            color: #0b2b4f;
        }

        .btn-login {
            background: #0b2b4f;
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 0.9rem;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            transition: all 0.2s;
            margin-bottom: 1.5rem;
        }

        .btn-login:hover {
            background: #1a3a5f;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(11, 43, 79, 0.2);
        }

        .create-account {
            text-align: center;
            margin-bottom: 1rem;
        }

        .create-account a {
            color: #0b2b4f;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .create-account a:hover {
            text-decoration: underline;
        }

        .demo-info {
            background: #f8fafc;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-top: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .demo-info small {
            color: #64748b;
            font-size: 0.85rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .demo-info .credential {
            font-family: monospace;
            background: white;
            padding: 0.5rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            font-size: 0.85rem;
            color: #0b2b4f;
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            background: #fee2e2;
            color: #991b1b;
            font-size: 0.9rem;
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            color: #94a3b8;
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 450px;
            }
            
            .brand-panel {
                padding: 2rem;
            }
            
            .form-panel {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Panel: Branding -->
        <div class="brand-panel">
            <h1>Stockiva</h1>
            <div class="brand-sub">
                Aplikasi Manajemen Stok & Pengiriman Barang untuk perusahaan Anda
            </div>
            
            <ul class="feature-list">
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    Kelola stok barang dengan mudah
                </li>
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    Pencatatan dan kontrol distribusi barang
                </li>
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    Manajemen client & ekspedisi
                </li>
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    Laporan lengkap & akurat
                </li>
            </ul>
        </div>

        <!-- Right Panel: Form -->
        <div class="form-panel">
            <div class="greeting">
                <h2>Hello!</h2>
                <p>Beautiful Day !</p>
            </div>

            {{-- Pesan error --}}
            @if($errors->any())
                <div class="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ $errors->first('login') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                
                {{-- Username --}}
                <div class="mb-4">
                    <label for="login" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="login" 
                               name="login" 
                               value="{{ old('login') }}" 
                               placeholder="Masukkan username atau email"
                               required 
                               autofocus>
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••"
                               required>
                    </div>
                </div>

                {{-- Forgot Password --}}
                <div class="forgot-password">
                    <a href="#">forget password?</a>
                </div>

                {{-- Tombol login --}}
                <button type="submit" class="btn-login">
                    Login
                </button>
            </form>
        </div>
    </div>

    {{-- <div class="footer">
        &copy; {{ date('Y') }} Stockiva. All rights reserved. | Version 1.0.0
    </div> --}}

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Auto-hide alert setelah 5 detik --}}
    <script>
        setTimeout(function() {
            let alert = document.querySelector('.alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>