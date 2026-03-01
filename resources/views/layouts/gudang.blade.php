<!-- resources/views/layouts/gudang.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gudang Panel') - Stockiva</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f8fafc;
        }
        
        .main-content {
            margin-left: 260px;
            padding: 2rem;
            min-height: 100vh;
        }
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .content-header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .breadcrumb {
            background: none;
            padding: 0;
        }
        
        .card {
            border: none;
            border-radius: 1rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }
        
        .btn-primary {
            background: #0b2b4f;
            border: none;
        }
        
        .btn-primary:hover {
            background: #1a3a5f;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.sidebar-gudang')
    
    <main class="main-content">
        <div class="content-header">
            <h2>@yield('page-title')</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(a => a.remove());
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>