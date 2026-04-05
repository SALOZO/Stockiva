<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;

class DocumentCenterController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with('client')
            ->whereNotNull('sph_approved_file')
            ->latest()
            ->paginate(15);

        return view('direktur.dokumen.index', compact('pesanans'));
    }

    public function detail(Pesanan $pesanan)
    {
        $pesanan->load([
            'client',
            'dokumenKontrak',
            'pengiriman',
        ]);

        // $pengirimanIds = $pesanan->pengiriman
        //     ? [$pesanan->pengiriman->id]
        //     : [];

        $pengirimanIds = $pesanan->pengiriman->pluck('id')->toArray();

        $dokumenPengiriman = \App\Models\DokumenPengiriman::whereIn('pengiriman_id', $pengirimanIds)
            ->get()
            ->groupBy('jenis');

        return view('direktur.dokumen.detail', compact('pesanan', 'dokumenPengiriman'));
    }
}