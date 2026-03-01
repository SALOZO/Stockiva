<nav class="sidebar">
    <div class="sidebar-brand">
        <h4>Stockiva</h4>
        <small class="text-muted">Direktur Panel</small>
    </div>
    
    <div class="sidebar-user">
        <div class="user-info">
            <div class="fw-bold">{{ Auth::user()->name }}</div>
            <small><i class="bi bi-briefcase me-1"></i>{{ Auth::user()->jabatan }}</small>
        </div>
    </div>
    
    <ul class="sidebar-menu">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('direktur.sph.index') ? 'active' : '' }}" 
               href="">
                <i class="bi bi-file-text"></i>
                <span>Daftar SPH</span>
                @if(request()->routeIs('direktur.sph.index'))
                    <span class="active-indicator"></span>
                @endif
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('direktur.profile') ? 'active' : '' }}" 
               href="">
                <i class="bi bi-person-circle"></i>
                <span>Profile & TTD</span>
                @if(request()->routeIs('direktur.profile'))
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
    /* Gunakan style yang sama dengan sidebar marketing/admin */
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
        line-height: 1.2;
    }
    
    .sidebar-brand small {
        font-size: 0.7rem;
        color: #64748b;
    }
    
    .sidebar-user {
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        background: #f8fafc;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-radius: 0;
    }
    
    .user-info {
        line-height: 1.4;
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
        position: relative;
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
        width: 100%;
        border: none;
        background: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .nav-link i {
        font-size: 1.2rem;
        width: 1.5rem;
        color: #64748b;
        transition: all 0.2s;
    }
    
    .nav-link:hover {
        background: #f1f5f9;
        color: #0b2b4f;
        transform: translateX(4px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
    }
    
    .nav-link:hover i {
        color: #0b2b4f;
    }
    
    .nav-link.active {
        background: #0b2b4f;
        color: white;
        box-shadow: 0 8px 16px -4px rgba(11, 43, 79, 0.2);
        transform: translateX(2px);
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
        box-shadow: -2px 0 8px rgba(255, 255, 255, 0.5);
    }
    
    .nav-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 1rem 1.5rem;
    }
    
    .nav-link.text-danger {
        color: #dc2626 !important;
    }
    
    .nav-link.text-danger i {
        color: #dc2626;
    }
    
    .nav-link.text-danger:hover {
        background: #fee2e2;
        color: #b91c1c !important;
    }
    
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .sidebar.show {
            transform: translateX(0);
        }
    }
</style>