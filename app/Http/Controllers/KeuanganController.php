<?php

namespace App\Http\Controllers;

use App\Models\BankPerusahaan;
use App\Models\CompanyProfile;
use App\Models\DocumentCounter;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function cetakInvoice(Pesanan $pesanan){
        $pesanan->load(['client', 'details.barang']);

        $bank = BankPerusahaan::where('is_active', true)->first();

        $tahunBulan = now()->format('Y-m');
        $nomor = DocumentCounter::getNextNumber($tahunBulan);
        $noInvoice = sprintf("%04d", $nomor) . '/INV/RP/' . now()->format('m') . '/' . now()->format('Y');

        // Jatuh tempo (30 hari dari tanggal invoice)
        $jatuhTempo = now()->addDays(30);

        // $numberToWords = new NumberToWords();
        // $numberTransformer = $numberToWords->getNumberTransformer('id');

        // $terbilang = $numberTransformer->toWords($pesanan->total_keseluruhan);

        $company = CompanyProfile::first();

        $pdf = Pdf::loadView('pdf.invoice', [
            'pesanan' => $pesanan,
            'company' => $company,
            'bank' => $bank,
            'no_invoice' => $noInvoice,
            'jatuh_tempo' => $jatuhTempo,
            // 'terbilang' => $terbilang,
            'tanggal' => now()->format('d F Y'),
        ]);

        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('invoice-' . $pesanan->no_pesanan . '.pdf');
    }
}
