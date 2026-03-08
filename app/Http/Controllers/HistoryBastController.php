<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistoryBastController extends Controller
{
    public function index(Request $request)
    {
        $pengiriman = Pengiriman::with(['pesanan.client'])
                        ->where(function($q) {
                            $q->whereNotNull('bast_ekspedisi_file')
                              ->orWhereNotNull('bast_client_file');
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);

        $bastList = collect();
        
        foreach ($pengiriman as $p) {
            if ($p->bast_ekspedisi_file) {
                $bastList->push([
                    'id' => $p->id . '-ekspedisi',
                    'pengiriman_id' => $p->id,
                    'no_bast' => $this->generateNoBast($p, 'ekspedisi'),
                    'jenis' => 'Ekspedisi',
                    'tanggal' => $p->tanggal,
                    'client' => $p->pesanan->client->nama_client ?? '-',
                    'no_pengiriman' => $p->no_pengiriman,
                    'pengiriman_ke' => $p->pengiriman_ke,
                    'file' => $p->bast_ekspedisi_file,
                    'jenis_file' => 'ekspedisi'
                ]);
            }
            
            if ($p->bast_client_file) {
                $bastList->push([
                    'id' => $p->id . '-client',
                    'pengiriman_id' => $p->id,
                    'no_bast' => $this->generateNoBast($p, 'client'),
                    'jenis' => 'Client',
                    'tanggal' => $p->tanggal,
                    'client' => $p->pesanan->client->nama_client ?? '-',
                    'no_pengiriman' => $p->no_pengiriman,
                    'pengiriman_ke' => $p->pengiriman_ke,
                    'file' => $p->bast_client_file,
                    'jenis_file' => 'client'
                ]);
            }
        }

        $bastList = $bastList->sortByDesc('tanggal')->values();
        
        $perPage = 15;
        $currentPage = $request->get('page', 1);
        $pagedData = $bastList->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $bastListPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $bastList->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('history-bast.index', compact('bastListPaginated'));
    }

    public function preview($pengirimanId, $jenis)
    {
        $pengiriman = Pengiriman::findOrFail($pengirimanId);
        
        $file = $jenis == 'ekspedisi' 
            ? $pengiriman->bast_ekspedisi_file 
            : $pengiriman->bast_client_file;
        
        if (!$file || !Storage::exists($file)) {
            abort(404, 'File tidak ditemukan');
        }
        
        $path = storage_path('app/' . $file);
        
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($file) . '"'
        ]);
    }

    public function download($pengirimanId, $jenis)
    {
        $pengiriman = Pengiriman::findOrFail($pengirimanId);
        
        $file = $jenis == 'ekspedisi' 
            ? $pengiriman->bast_ekspedisi_file 
            : $pengiriman->bast_client_file;
        
        if (!$file || !Storage::exists($file)) {
            abort(404, 'File tidak ditemukan');
        }
        
        return Storage::download($file);
    }

    private function generateNoBast($pengiriman, $jenis)
    {
        $noPesanan = $pengiriman->pesanan->no_pesanan;
        $parts = explode('-', $noPesanan);
        $noUrut = (int)end($parts);
        
        $offset = $jenis == 'ekspedisi' ? 1 : 2;
        $noUrutBAST = $noUrut + $offset;
        
        $bulan = $pengiriman->created_at->format('m');
        $tahun = $pengiriman->created_at->format('Y');
        
        return sprintf("%04d", $noUrutBAST) . ' / BAST / RP / ' . $bulan . ' / ' . $tahun;
    }
}