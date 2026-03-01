<!-- resources/views/partials/sidebar-gudang.blade.php -->
<nav class="sidebar">
    <div class="sidebar-brand">
        <h4>Stockiva</h4>
        <small class="text-muted">Gudang Panel</small>
    </div>
    
    <div class="sidebar-user">
        <div class="user-info">
            <div class="fw-bold">{{ Auth::user()->nama }}</div>
            <small><i class="bi bi-briefcase me-1"></i>{{ Auth::user()->jabatan }}</small>
        </div>
    </div>
    
    <ul class="sidebar-menu">
        {{-- MENU UTAMA: SPH DISETUJUI (LANGSUNG HALAMAN PERTAMA) --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('gudang.sph.index') ? 'active' : '' }}" 
               href="{{ route('gudang.sph.index') }}">
                <i class="bi bi-check-circle"></i>
                <span>SPH Disetujui</span>
                @if(request()->routeIs('gudang.sph.index'))
                    <span class="active-indicator"></span>
                @endif
            </a>
        </li>

        {{-- DIVIDER --}}
        <li class="nav-divider"></li>

        {{-- LOGOUT --}}
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
    /* Gunakan style yang sama dengan sidebar lainnya */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px;
        height: 100vh;
        background: white;
        box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        overflow-y: auto;
        z-index: 1000;
    }
    
    .sidebar-brand {
        padding: 1.5rem 1.5rem 0.5rem;
    }
    
    .sidebar-brand h4 {
        font-weight: 700;
        color: #0b2b4f;
        margin: 0;
    }
    
    .sidebar-user {
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        background: #f8fafc;
    }
    
    .user-info .fw-bold {
        font-size: 0.95rem;
        color: #1e293b;
    }
    
    .user-info small {
        font-size: 0.8rem;
        color: #64748b;
    }
    
    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .nav-item {
        margin: 0.25rem 0.5rem;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #4a5568;
        text-decoration: none;
        border-radius: 0.5rem;
        transition: all 0.2s;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .nav-link i {
        font-size: 1.2rem;
        width: 1.5rem;
        color: #64748b;
    }
    
    .nav-link:hover {
        background: #f1f5f9;
        color: #0b2b4f;
    }
    
    .nav-link.active {
        background: #0b2b4f;
        color: white;
    }
    
    .nav-link.active i {
        color: white;
    }
    
    .active-indicator {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: white;
        border-radius: 4px 0 0 4px;
    }
    
    .nav-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 1rem 1.5rem;
    }
    
    .nav-link.text-danger {
        color: #dc2626 !important;
    }
    
    .nav-link.text-danger:hover {
        background: #fee2e2;
    }
    
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s;
        }
        .sidebar.show {
            transform: translateX(0);
        }
    }
</style>