<nav class="sidebar">
    <div class="p-3">
        <h4 class="fw-bold text-primary">Stockiva</h4>
        <small class="text-muted">Keuangan Panel</small>
    </div>
    
    <div class="p-3 border-top border-bottom bg-light">
        <div class="fw-bold">{{ Auth::user()->name }}</div>
        <small class="text-muted">{{ Auth::user()->jabatan }}</small>
    </div>
    
    <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('keuangan.bank*') ? 'active' : '' }}" 
            href="{{ route('keuangan.bank.index') }}">
                <i class="bi bi-bank"></i>
                <span>Setting DOC Bank Perusahaan</span>
            </a>
    </li>

    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('keuangan.index') ? 'active' : '' }}" 
               href="{{ route('keuangan.index') }}">
                <i class="bi bi-receipt"></i> Data Siap Tagih
            </a>
        </li>
        
        <a href="{{ route('direktur.dokumen.index') }}"
        class="nav-link {{ request()->routeIs('direktur.dokumen.*') ? 'active' : '' }}">
            <i class="bi bi-folder2 me-2"></i>
            Document Center
        </a>

        {{-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('keuangan.invoice.riwayat') ? 'active' : '' }}" 
            href="{{ route('keuangan.invoice.riwayat') }}">
                <i class="bi bi-archive"></i>
                <span>History Invoice yang sudah di approve</span>
            </a>
        </li>
        <a href="{{ route('keuangan.tagihan.riwayat') }}"
        class="nav-link {{ request()->routeIs('keuangan.tagihan.riwayat') ? 'active' : '' }}">
            <i class="bi bi-clock-history me-2"></i>
            History Tagihan yang sudah di approve
        </a> --}}
        
        <li class="nav-item mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </li>
    </ul>
</nav>

<style>
    .sidebar { width: 260px; background: white; height: 100vh; position: fixed; top: 0; left: 0; border-right: 1px solid #eef2f6; }
    .nav-link { color: #4a5568; padding: 0.75rem 1.5rem; display: flex; align-items: center; gap: 0.75rem; }
    .nav-link:hover { background: #f1f5f9; color: #0b2b4f; }
    .nav-link.active { background: #0b2b4f; color: white; }
    .nav-link i { font-size: 1.2rem; width: 1.5rem; }
    .nav-link.active i { color: white; }
</style>