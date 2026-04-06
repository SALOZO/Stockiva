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
        $layout = $this->getLayoutByRole();


        return view('direktur.dokumen.index', compact('pesanans', 'layout'));
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

        $jabatan  = auth()->user()->jabatan;
        $aksesDok = $this->getAksesDokumen($jabatan);
        $layout = $this->getLayoutByRole();

        $dokumenPengiriman = \App\Models\DokumenPengiriman::whereIn('pengiriman_id', $pengirimanIds)
            ->get()
            ->groupBy('jenis');

        return view('direktur.dokumen.detail', compact('pesanan', 'dokumenPengiriman','aksesDok', 'layout'));
    }

    private function getLayoutByRole(){
        $user = auth()->user();
        
        return match($user->jabatan) {
            'Marketing' => 'layouts.marketing',
            'Direktur'  => 'layouts.direktur',
            'Gudang'    => 'layouts.gudang',
            'Keuangan'  => 'layouts.keuangan',
            default     => 'layouts.app'
        };
    }

    private function getAksesDokumen(string $jabatan): array
    {
        return match($jabatan) {
            'Gudang' => [
                'pesanan'    => ['sph'],
                'pengiriman' => ['surat_jalan', 'bast_ekspedisi', 'bast_client'],
                'kontrak'    => true,
            ],
            'Keuangan' => [
                'pesanan'    => ['invoice', 'tagihan', 'kwitansi', 'faktur_pajak'],
                'pengiriman' => [],
                'kontrak'    => false,
            ],
            // 'Marketing' => [
            //     'pesanan'    => ['sph', 'invoice', 'tagihan', 'kwitansi', 'faktur_pajak'],
            //     'pengiriman' => ['surat_jalan'],
            //     'kontrak'    => true,
            // ],
            default => [ // direktur & marketing: lihat semua
                'pesanan'    => ['sph', 'invoice', 'tagihan', 'kwitansi', 'faktur_pajak'],
                'pengiriman' => ['surat_jalan', 'bast_ekspedisi', 'bast_client'],
                'kontrak'    => true,
            ],
        };
    }
}