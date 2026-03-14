<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class TugasGudangController extends Controller
{
    public function index(Request $request){
        $query = Pesanan::with(['client', 'details'])
                        ->where('sph_status', 'disetujui')
                        ->where('is_ready_for_gudang', true)
                        ->orderBy('approved_at', 'desc');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_pesanan', 'like', "%{$search}%")
                ->orWhereHas('client', function($clientQuery) use ($search) {
                    $clientQuery->where('nama_client', 'like', "%{$search}%");
                });
            });
        }

        $tugasList = $query->paginate(15)->withQueryString();

        return view('gudang.tugas-gudang.index', compact('tugasList'));
    }
}
