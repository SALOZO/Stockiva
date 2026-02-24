<!-- resources/views/partials/sidebar.blade.php -->
<nav class="sidebar">
    <div class="sidebar-brand">
        <h4>Stockiva</h4>
    </div>
    
    <div class="sidebar-user">
        <div class="user-info">
            <div class="fw-bold">{{ Auth::user()->name }}</div>
            <small>Jabatan: {{ Auth::user()->jabatan }}</small>
        </div>
    </div>
    
    <ul class="sidebar-menu">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
               href="{{ route('admin.user.index') }}">
                <i class="bi bi-people"></i>
                <span>Users</span>
                @if(request()->routeIs('admin.users*'))
                    <span class="active-indicator"></span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.clients*') ? 'active' : '' }}" 
               href="#">
                <i class="bi bi-building"></i>
                <span>Clients</span>
                @if(request()->routeIs('admin.clients*'))
                    <span class="active-indicator"></span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.barang*') ? 'active' : '' }}" 
               href="#">
                <i class="bi bi-box"></i>
                <span>Barang</span>
                @if(request()->routeIs('admin.barang*'))
                    <span class="active-indicator"></span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.ekspedisi*') ? 'active' : '' }}" 
               href="#">
                <i class="bi bi-truck"></i>
                <span>Ekspedisi</span>
                @if(request()->routeIs('admin.ekspedisi*'))
                    <span class="active-indicator"></span>
                @endif
            </a>
        </li>
        
        {{-- Divider --}}
        <li class="nav-divider"></li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}" 
               href="#">
                <i class="bi bi-tags"></i>
                <span>Kategori</span>
                @if(request()->routeIs('admin.kategori*'))
                    <span class="active-indicator"></span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.jenis*') ? 'active' : '' }}" 
               href="#">
                <i class="bi bi-diagram-3"></i>
                <span>Jenis</span>
                @if(request()->routeIs('admin.jenis*'))
                    <span class="active-indicator"></span>
                @endif
            </a>
        </li>
        
        {{-- Logout --}}
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
        padding: 1.5rem 1.5rem 1rem;
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
    
    /* Hover effect */
    .nav-link:hover {
        background: #f1f5f9;
        color: #0b2b4f;
        transform: translateX(4px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
    }
    
    .nav-link:hover i {
        color: #0b2b4f;
    }
    
    /* Active state - dengan bayangan dan indikator */
    .nav-link.active {
        background: #0b2b4f;
        color: white;
        box-shadow: 0 8px 16px -4px rgba(11, 43, 79, 0.2), 0 2px 4px rgba(0, 0, 0, 0.05);
        transform: translateX(2px);
    }
    
    .nav-link.active i {
        color: white;
    }
    
    /* Indikator samping untuk menu aktif */
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
    
    /* Efek bayangan tambahan untuk menu aktif */
    .nav-link.active::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.2), transparent 70%);
        pointer-events: none;
        border-radius: inherit;
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
    
    .nav-link.text-danger:hover i {
        color: #b91c1c;
    }
    
    /* Efek hover yang lebih halus untuk semua item */
    .nav-item {
        transition: transform 0.2s;
    }
    
    .nav-item:hover {
        transform: scale(1.02);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            box-shadow: 2px 0 20px rgba(0,0,0,0.1);
        }
        
        .sidebar.show {
            transform: translateX(0);
        }
        
        .nav-item:hover {
            transform: none;
        }
    }
</style>