@extends($layout)

@section('title', 'History SPH - Stockiva')
@section('page-title', 'History SPH')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">History SPH</li>
@endsection

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
        --primary: #2563EB;
        --primary-light: #EFF6FF;
        --primary-hover: #1D4ED8;
        --success: #059669;
        --success-light: #ECFDF5;
        --warning: #D97706;
        --warning-light: #FFFBEB;
        --danger: #DC2626;
        --danger-light: #FEF2F2;
        --info: #0891B2;
        --info-light: #ECFEFF;
        --muted: #64748B;
        --surface: #F8FAFC;
        --border: #E2E8F0;
        --card-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.07), 0 1px 2px -1px rgb(0 0 0 / 0.07);
        --card-shadow-hover: 0 10px 30px -5px rgb(37 99 235 / 0.12), 0 4px 12px -4px rgb(0 0 0 / 0.08);
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); }

    /* ── Page Header ── */
    .sph-page-header {
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 24px 0 0;
        margin-bottom: 28px;
    }
    .sph-page-header .header-inner {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        padding-bottom: 20px;
    }
    .page-eyebrow {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--primary);
        margin-bottom: 4px;
    }
    .page-title-main {
        font-size: 26px;
        font-weight: 800;
        color: #0F172A;
        margin: 0;
        line-height: 1.2;
    }
    .total-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--primary);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 999px;
        letter-spacing: .02em;
    }
    .total-pill i { font-size: 14px; }

    /* ── Card ── */
    .sph-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    .sph-card-body { padding: 24px; }

    /* ── Search Bar ── */
    .search-wrap {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    .search-box {
        position: relative;
        flex: 1;
        min-width: 220px;
    }
    .search-box .bi-search {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 14px;
    }
    .search-box input {
        padding-left: 40px;
        height: 42px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        color: #1E293B;
        background: var(--surface);
        transition: border-color .18s, box-shadow .18s;
        width: 100%;
    }
    .search-box input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgb(37 99 235 / .12);
        background: #fff;
    }
    .search-box input::placeholder { color: #94A3B8; }

    .status-select {
        height: 42px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        color: #1E293B;
        background: var(--surface);
        padding: 0 36px 0 14px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        cursor: pointer;
        transition: border-color .18s, box-shadow .18s;
        min-width: 160px;
    }
    .status-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgb(37 99 235 / .12);
        background-color: #fff;
    }

    .btn-filter {
        height: 42px;
        padding: 0 20px;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        cursor: pointer;
        transition: background .18s, transform .1s;
        white-space: nowrap;
    }
    .btn-filter:hover { background: var(--primary-hover); }
    .btn-filter:active { transform: scale(.97); }

    /* ── Table ── */
    .table-wrap { overflow-x: auto; margin: 0 -24px; padding: 0 24px; }

    .sph-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13.5px;
        table-layout: fixed;
    }
    .sph-table colgroup col:nth-child(1)  { width: 52px; }
    .sph-table colgroup col:nth-child(2)  { width: 180px; }
    .sph-table colgroup col:nth-child(3)  { width: 120px; }
    .sph-table colgroup col:nth-child(4)  { width: 110px; }
    .sph-table colgroup col:nth-child(5)  { width: 120px; }
    .sph-table colgroup col:nth-child(6)  { width: 90px; }
    .sph-table colgroup col:nth-child(7)  { width: 90px; }
    .sph-table colgroup col:nth-child(8)  { width: 130px; }
    .sph-table colgroup col:nth-child(9)  { width: 130px; }
    .sph-table colgroup col:nth-child(10) { width: 140px; }

    .sph-table thead tr th {
        padding: 12px 14px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: var(--muted);
        background: var(--surface);
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
        text-align: center;
    }
    .sph-table thead tr th:first-child { text-align: center; border-radius: 0; }

    .sph-table tbody tr {
        transition: background .14s;
    }
    .sph-table tbody tr:hover { background: #F8FAFC; }
    .sph-table tbody tr td {
        padding: 14px 14px;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
        text-align: center;
        color: #334155;
    }
    .sph-table tbody tr:last-child td { border-bottom: none; }

    /* ── Client cell ── */
    .client-cell { text-align: left !important; }
    .client-name {
        font-weight: 600;
        color: #1E293B;
        font-size: 13.5px;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .client-pic {
        font-size: 11.5px;
        color: var(--muted);
        display: block;
        margin-top: 2px;
    }

    /* ── Row number ── */
    .row-num {
        font-size: 12px;
        font-weight: 600;
        color: #94A3B8;
        font-family: 'JetBrains Mono', monospace;
    }

    /* ── Date ── */
    .date-cell {
        font-family: 'JetBrains Mono', monospace;
        font-size: 12.5px;
        color: #475569;
        font-weight: 500;
    }

    /* ── Value ── */
    .value-cell {
        font-family: 'JetBrains Mono', monospace;
        font-size: 13px;
        font-weight: 700;
        color: #1E293B;
    }

    /* ── Item count ── */
    .item-count {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 3px 9px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }

    /* ── Status Badges ── */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .02em;
        white-space: nowrap;
    }
    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }
    .badge-siap     { background: var(--success-light); color: var(--success); }
    .badge-siap::before { background: var(--success); }
    .badge-draft    { background: #F1F5F9; color: #64748B; }
    .badge-draft::before { background: #94A3B8; }
    .badge-menunggu { background: var(--warning-light); color: var(--warning); }
    .badge-menunggu::before { background: var(--warning); animation: pulse-dot 1.5s ease-in-out infinite; }
    .badge-disetujui{ background: var(--info-light); color: var(--info); }
    .badge-disetujui::before { background: var(--info); }
    .badge-ditolak  { background: var(--danger-light); color: var(--danger); }
    .badge-ditolak::before { background: var(--danger); }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: .5; transform: scale(.8); }
    }

    /* ── Kontrak icon ── */
    .kontrak-ok   { color: var(--success); font-size: 16px; }
    .kontrak-none { color: #CBD5E1; font-size: 16px; }

    /* ── Action buttons ── */
    .action-group { display: flex; align-items: center; justify-content: center; gap: 6px; }
    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        cursor: pointer;
        transition: transform .12s, opacity .12s, box-shadow .12s;
        text-decoration: none;
        flex-shrink: 0;
    }
    .btn-action:hover { transform: translateY(-2px); opacity: .9; box-shadow: 0 4px 10px rgb(0 0 0 / .15); }
    .btn-action:active { transform: scale(.94); }
    .btn-view   { background: var(--info-light); color: var(--info); }
    .btn-edit   { background: var(--warning-light); color: var(--warning); }
    .btn-upload { background: var(--primary-light); color: var(--primary); position: relative; }

    /* Dropdown upload */
    .upload-dropdown { position: relative; }
    .upload-dropdown .dropdown-toggle::after { display: none; }
    .upload-menu {
        min-width: 110px;
        border: 1px solid var(--border);
        border-radius: 10px;
        box-shadow: 0 8px 24px rgb(0 0 0 / .1);
        padding: 6px;
        overflow: hidden;
    }
    .upload-menu .dropdown-item {
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        padding: 7px 12px;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .upload-menu .dropdown-item:hover { background: var(--primary-light); color: var(--primary); }
    .upload-menu .dropdown-item i { font-size: 12px; }

    /* ── Empty state ── */
    .empty-state {
        padding: 64px 24px;
        text-align: center;
    }
    .empty-icon-wrap {
        width: 72px;
        height: 72px;
        background: var(--surface);
        border: 2px dashed var(--border);
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 28px;
        color: #CBD5E1;
    }
    .empty-title { font-size: 16px; font-weight: 700; color: #1E293B; margin-bottom: 6px; }
    .empty-sub   { font-size: 13.5px; color: var(--muted); }

    /* ── Pagination ── */
    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        background: var(--surface);
    }
    .pagination-info { font-size: 13px; color: var(--muted); }
    .pagination-info strong { color: #334155; font-weight: 600; }

    /* ── Modal ── */
    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 25px 60px rgb(0 0 0 / .15);
        overflow: hidden;
    }
    .modal-header {
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 20px 24px;
    }
    .modal-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
    }
    .modal-body { padding: 24px; }
    .modal-footer {
        background: var(--surface);
        border-top: 1px solid var(--border);
        padding: 16px 24px;
    }

    .form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .form-control {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        color: #1E293B;
        padding: 9px 14px;
        transition: border-color .18s, box-shadow .18s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgb(37 99 235 / .12);
    }

    .btn-modal-cancel {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        padding: 9px 18px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-modal-cancel:hover { background: #E2E8F0; }

    .btn-modal-save {
        background: var(--primary);
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        padding: 9px 22px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-modal-save:hover { background: var(--primary-hover); }

    /* Preview modal */
    #previewModal .modal-dialog { max-width: 900px; }
    #previewModal .modal-content { border-radius: 16px; }
    #previewModal .modal-body { padding: 0; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <p class="page-eyebrow mb-1"><i class="bi bi-clock-history me-1"></i> Riwayat Dokumen</p>
            <h1 class="page-title-main">History SPH</h1>
        </div>
        <div class="total-pill">
            <i class="bi bi-file-earmark-text"></i>
            {{ $sphList->total() }} SPH
        </div>
    </div>

    <div class="sph-card">
        <div class="sph-card-body">

            {{-- Search & Filter --}}
            <form method="GET" action="{{ route('history.sph.index') }}" class="search-wrap mb-4">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text"
                           name="search"
                           placeholder="Cari no. SPH atau nama client..."
                           value="{{ request('search') }}">
                </div>
                <select class="status-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="draft"     {{ request('status') == 'draft'     ? 'selected' : '' }}>Draft</option>
                    <option value="menunggu"  {{ request('status') == 'menunggu'  ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak"   {{ request('status') == 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button type="submit" class="btn-filter">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                @if(request('search') || request('status'))
                <a href="{{ route('history.sph.index') }}" class="btn-filter" style="background:#64748B; text-decoration:none;">
                    <i class="bi bi-x-lg"></i> Reset
                </a>
                @endif
            </form>

            {{-- Table --}}
            <div class="table-wrap">
                <table class="sph-table">
                    <colgroup>
                        <col><col><col><col><col><col><col><col><col><col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Client</th>
                            <th>Tanggal Buat</th>
                            <th>Dibuat Oleh</th>
                            <th>Status</th>
                            <th>Kontrak</th>
                            <th>Item</th>
                            <th>Total Nilai</th>
                            <th>Disetujui Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sphList as $index => $sph)
                        <tr>
                            <td><span class="row-num">{{ str_pad($sphList->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</span></td>

                            <td>
                                <span class="client-name">{{ $sph->client->nama_client ?? '-' }}</span>
                                <span class="client-pic"><i class="bi bi-person me-1"></i>{{ $sph->client->nama_pic ?? '-' }}</span>
                            </td>

                            <td><span class="date-cell">{{ $sph->created_at->format('d/m/Y') }}</span></td>

                            <td style="font-size:13px; color:#475569; font-weight:500;">{{ $sph->createdBy->name ?? '-' }}</td>

                            <td>
                                @if($sph->sph_status == 'disetujui' && $sph->sudah_upload_kontrak)
                                    <span class="status-badge badge-siap">Siap Gudang</span>
                                @else
                                    @switch($sph->sph_status)
                                        @case('draft')    <span class="status-badge badge-draft">Draft</span>    @break
                                        @case('menunggu') <span class="status-badge badge-menunggu">Menunggu</span> @break
                                        @case('disetujui')<span class="status-badge badge-disetujui">Disetujui</span> @break
                                        @case('ditolak')  <span class="status-badge badge-ditolak">Ditolak</span>  @break
                                        @default          <span class="status-badge badge-draft">-</span>
                                    @endswitch
                                @endif
                            </td>

                            <td>
                                @if($sph->sudah_upload_kontrak)
                                    <i class="bi bi-patch-check-fill kontrak-ok" title="Kontrak telah diupload"></i>
                                @else
                                    <i class="bi bi-dash-circle kontrak-none" title="Belum ada kontrak"></i>
                                @endif
                            </td>

                            <td>
                                <span class="item-count">
                                    <i class="bi bi-box-seam" style="font-size:11px;"></i>
                                    {{ $sph->details->count() }}
                                </span>
                            </td>

                            <td><span class="value-cell">Rp {{ number_format($sph->total_keseluruhan, 0, ',', '.') }}</span></td>

                            <td style="font-size:13px; color:#475569;">{{ $sph->approvedBy->name ?? '—' }}</td>

                            <td>
                                <div class="action-group">
                                    {{-- View --}}
                                    <button class="btn-action btn-view"
                                            onclick="showPreview('{{ $sph->id }}')"
                                            title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    @if(auth()->user()->jabatan == 'Marketing')
                                        @if(!$sph->sudah_upload_kontrak)
                                        {{-- Edit --}}
                                        <a href="{{ route('marketing.pesanan.edit', $sph->id) }}"
                                           class="btn-action btn-edit"
                                           title="Edit SPH">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Upload Kontrak --}}
                                        <div class="upload-dropdown dropdown">
                                            <button class="btn-action btn-upload dropdown-toggle"
                                                    data-bs-toggle="dropdown"
                                                    title="Upload Kontrak">
                                                <i class="bi bi-upload"></i>
                                            </button>
                                            <ul class="dropdown-menu upload-menu">
                                                @foreach(['SPK','PO','SP'] as $jenis)
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#modalKontrak{{ $sph->id }}"
                                                       data-jenis="{{ $jenis }}">
                                                        <i class="bi bi-file-earmark-arrow-up"></i> {{ $jenis }}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                    @endif
                                </div>

                                {{-- Modal Upload Kontrak --}}
                                <div class="modal fade" id="modalKontrak{{ $sph->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="bi bi-file-earmark-arrow-up text-primary me-2"></i>
                                                    Upload <span class="jenis-label fw-bold"></span>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('marketing.pesanan.upload-kontrak', $sph->id) }}"
                                                  method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="jenis_kontrak" id="jenis_kontrak{{ $sph->id }}" value="">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nomor Kontrak <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="nomor_kontrak" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Kontrak <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="tanggal_kontrak"
                                                               value="{{ date('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="mb-1">
                                                        <label class="form-label">Upload File <span class="text-danger">*</span></label>
                                                        <input type="file" class="form-control" name="file"
                                                               accept=".pdf,.jpg,.jpeg,.png" required>
                                                        <small class="text-muted" style="font-size:12px;">
                                                            <i class="bi bi-info-circle me-1"></i>Format: PDF, JPG, PNG &nbsp;·&nbsp; Maks: 2MB
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer gap-2">
                                                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn-modal-save">
                                                        <i class="bi bi-cloud-arrow-up"></i> Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-icon-wrap">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <p class="empty-title">Tidak Ada Data SPH</p>
                                    <p class="empty-sub">Belum ada SPH yang sesuai dengan filter yang dipilih.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($sphList->hasPages())
        <div class="pagination-wrap">
            <p class="pagination-info mb-0">
                Menampilkan <strong>{{ $sphList->firstItem() }}–{{ $sphList->lastItem() }}</strong>
                dari <strong>{{ $sphList->total() }}</strong> data
            </p>
            {{ $sphList->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Modal Preview PDF --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-file-pdf text-danger me-2"></i>
                    Preview SPH
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="previewFrame" src="" style="width:100%; height:72vh; border:none;"></iframe>
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Tutup
                </button>
                <a href="#" id="downloadLink" class="btn-modal-save" target="_blank">
                    <i class="bi bi-download"></i> Download PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showPreview(sphId) {
        document.getElementById('previewFrame').src = '/history-sph/' + sphId + '/preview';
        document.getElementById('downloadLink').href = '/history-sph/' + sphId + '/download';
        new bootstrap.Modal(document.getElementById('previewModal')).show();
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="modalKontrak"]').forEach(modal => {
            modal.addEventListener('show.bs.modal', function (e) {
                const btn   = e.relatedTarget;
                const jenis = btn.getAttribute('data-jenis');
                const sphId = modal.id.replace('modalKontrak', '');
                const input = modal.querySelector('#jenis_kontrak' + sphId);
                const label = modal.querySelector('.jenis-label');
                if (input) input.value = jenis;
                if (label) label.innerText = jenis;
            });
        });
    });
</script>
@endpush