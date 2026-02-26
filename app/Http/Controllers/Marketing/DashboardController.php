<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Client;
use App\Models\Jenis;
use App\Models\Kategori;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function index()
    {
        // ========== STATISTIK ==========
        $totalPesanan = Pesanan::count();
        $totalClient = Client::count();
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalJenis = Jenis::count();
        
        // Pesanan bulan ini
        $pesananBulanIni = Pesanan::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        
        // Client baru bulan ini
        $clientBaruBulanIni = Client::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        
        // Total nilai pesanan
        $totalNilaiPesanan = Pesanan::sum('total_keseluruhan');
        $rataRataNilaiPesanan = $totalPesanan > 0 ? $totalNilaiPesanan / $totalPesanan : 0;
        
        // ========== STATUS PESANAN ==========
        $statusPesanan = Pesanan::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status')->toArray();
        
        $statusLabels = array_keys($statusPesanan);
        $statusData = array_values($statusPesanan);
        
        // ========== GRAFIK PESANAN PER BULAN (6 bulan terakhir) ==========
        $bulan = [];
        $dataPesanan = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $bulan[] = now()->subMonths($i)->format('M Y');
            $dataPesanan[] = Pesanan::whereMonth('created_at', now()->subMonths($i)->month)->whereYear('created_at', now()->subMonths($i)->year)->count();
        }
        
        // ========== PESANAN TERBARU ==========
        $pesananTerbaru = Pesanan::with(['client', 'details'])->latest()->limit(5)->get();
        
        // ========== CLIENT TERBARU ==========
        $clientTerbaru = Client::latest()->limit(6)->get();
        
        return view('marketing.dashboard', compact(
            'totalPesanan',
            'totalClient',
            'totalBarang',
            'totalKategori',
            'totalJenis',
            'pesananBulanIni',
            'clientBaruBulanIni',
            'totalNilaiPesanan',
            'rataRataNilaiPesanan',
            'statusPesanan',
            'statusLabels',
            'statusData',
            'bulan',
            'dataPesanan',
            'pesananTerbaru',
            'clientTerbaru'
        ));
    }

        private function getAktivitasTerbaru()
    {
        $aktivitas = [];
        
        // Ambil 5 pesanan terbaru
        $pesananTerbaru = Pesanan::with('client')
                                  ->latest()
                                  ->limit(3)
                                  ->get();
        
        foreach ($pesananTerbaru as $pesanan) {
            $aktivitas[] = [
                'icon' => 'cart',
                'pesan' => 'Pesanan baru: ' . $pesanan->no_pesanan . ' - ' . ($pesanan->client->nama_client ?? 'Unknown'),
                'waktu' => $pesanan->created_at->diffForHumans()
            ];
        }
        
        // Ambil 2 client terbaru
        $clientTerbaru = Client::latest()->limit(2)->get();
        
        foreach ($clientTerbaru as $client) {
            $aktivitas[] = [
                'icon' => 'building',
                'pesan' => 'Client baru: ' . $client->nama_client,
                'waktu' => $client->created_at->diffForHumans()
            ];
        }
        
        // Urutkan berdasarkan waktu (terbaru dulu)
        usort($aktivitas, function($a, $b) {
            return strtotime($b['waktu']) - strtotime($a['waktu']);
        });
        
        return array_slice($aktivitas, 0, 5);
    }

}
