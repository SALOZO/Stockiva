@extends(auth()->user()->jabatan == 'Keuangan' ? 'layouts.keuangan' : (auth()->user()->jabatan == 'Direktur' ? 'layouts.direktur' : 'layouts.gudang'))

@section('title', 'Riwayat Invoice - Stockiva')
@section('page-title', 'Riwayat Invoice')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('keuangan.index') }}">Keuangan</a></li>
    <li class="breadcrumb-item active">Riwayat Invoice</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Invoice</h5>
                    <span class="badge bg-primary">{{ $invoices->total() }} Invoice</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>No. Invoice</th>
                                <th>No. SPH</th>
                                <th>Client</th>
                                <th>Tanggal Approve</th>
                                <th>Total</th>
                                <th>Aksi</th>
                             </thead>
                        <tbody>
                            @forelse($invoices as $inv)
                              <tr class="text-center">
                                <td><strong>{{ $inv->no_invoice }}</strong></td>
                                <td>{{ $inv->no_sph }}</td>
                                <td>{{ $inv->client->nama_client }}</td>
                                <td>{{ $inv->invoice_approved_at ? \Carbon\Carbon::parse($inv->invoice_approved_at)->format('d/m/Y') : '-' }}</td>
                                <td>Rp {{ number_format($inv->total_keseluruhan, 0, ',', '.') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('keuangan.preview-invoice', $inv->id) }}" 
                                           class="btn btn-sm btn-info" target="_blank">
                                            <i class="bi bi-eye"></i> Preview
                                        </a>
                                        {{-- <a href="{{ route('keuangan.download-invoice', $inv->id) }}" 
                                           class="btn btn-sm btn-primary" target="_blank">
                                            <i class="bi bi-download"></i> Download
                                        </a> --}}
                                    </div>
                                </td>
                               </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-inbox display-4 d-block mb-3 text-muted"></i>
                                        <h5>Belum Ada Invoice</h5>
                                        <p class="text-muted">Belum ada invoice yang ditandatangani</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                     </table>
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection