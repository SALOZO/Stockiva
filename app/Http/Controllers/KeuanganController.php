<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(){
        $pesanans = Pesanan::with(['client', 'details'])
            ->whereExists(function($query) {
                $query->selectRaw('1')
                    ->from('detail_pesanans')
                    ->whereColumn('detail_pesanans.pesanan_id', 'pesanans.id')
                    ->groupBy('pesanan_id')
                    ->havingRaw('SUM(produced_qty) = SUM(jumlah)')
                    ->havingRaw('SUM(shipped_qty) = 0');
            })
            ->whereExists(function($query) {
                $query->selectRaw('1')
                    ->from('pengiriman')
                    ->whereColumn('pengiriman.pesanan_id', 'pesanans.id')
                    ->whereNotNull('bast_client_file')
                    ->orderBy('pengiriman.id', 'desc')
                    ->limit(1);
            })
            ->orderBy('keuangan_at', 'desc')
            ->paginate(10);

        return view('keuangan.index', compact('pesanans'));
    }
}
