<?php

namespace App\Http\Controllers;

use App\Models\BankPerusahaan;
use App\Models\CompanyProfile;
use App\Models\DocumentCounter;
use App\Models\Pesanan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if (!$pesanan->no_invoice) {
            $tahunBulan = now()->format('Y-m');
            $nomor = DocumentCounter::getNextNumber($tahunBulan);
            $noInvoice = sprintf("%04d", $nomor) . '/INV/RP/' . now()->format('m') . '/' . now()->format('Y');
            $pesanan->update(['no_invoice' => $noInvoice]);
        }

        $bank = BankPerusahaan::where('is_active', true)->first();
        $company = CompanyProfile::first();

        $logoPath = public_path('storage/' . $company->logo);

        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // dd($company->logo);
        $pdf = Pdf::loadView('pdf.invoice', [
            'pesanan' => $pesanan,
            'company' => $company,
            'bank' => $bank,
            'no_invoice' => $pesanan->no_invoice,
            'jatuh_tempo' => $pesanan->created_at->addDays(30),
            'tanggal' => now()->format('d F Y'),
            'logo' => $logoBase64,
        ]);

        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont' => 'Helvetica'
        ]);

        $filename = 'INVOICE-' . $pesanan->no_pesanan . '-' . date('Ymd') . '.pdf';
        $path = 'invoice/temp/' . $filename;
        Storage::disk('public')->put($path, $pdf->output());


        return Storage::disk('public')->download($path, $filename);
    }

    public function riwayatInvoice(){
        $invoices = Pesanan::with(['client', 'details.barang'])
            ->whereNotNull('no_invoice')
            ->whereNotNull('invoice_approved_at')
            ->orderBy('invoice_approved_at', 'desc')
            ->paginate(15);

        return view('keuangan.invoice.riwayat', compact('invoices'));
    }

 public function previewInvoice(Pesanan $pesanan)
{
    if (!$pesanan->no_invoice) {
        abort(404);
    }

    $bank = BankPerusahaan::where('is_active', true)->first();
    $company = CompanyProfile::first();


    // Ambil TTD dari direktur yang approve
    $ttdBase64 = null;
    if ($pesanan->invoice_approved_by) {
        $direktur = User::find($pesanan->invoice_approved_by);
        if ($direktur && $direktur->ttd_path) {
            $ttdPath = storage_path('app/public/' . $direktur->ttd_path);
            if (file_exists($ttdPath)) {
                $imageData = file_get_contents($ttdPath);
                $mime = mime_content_type($ttdPath);
                $ttdBase64 = 'data:' . $mime . ';base64,' . base64_encode($imageData);
            }
        }
    }

        $logoPath = public_path('storage/' . $company->logo);

        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

    $pdf = Pdf::loadView('pdf.invoice-approved', [
        'pesanan' => $pesanan,
        'company' => $company,
        'bank' => $bank,
        'no_invoice' => $pesanan->no_invoice,
        'jatuh_tempo' => $pesanan->created_at->addDays(30),
        'tanggal' => now()->format('d F Y'),
        'approved_by' => $pesanan->approvedBy->name ?? 'Direktur',
        'approved_at' => $pesanan->invoice_approved_at ? $pesanan->invoice_approved_at->format('d F Y') : '-',
        'ttd_base64' => $ttdBase64,
        'logo' => $logoBase64,
    ]);

    return $pdf->stream('invoice-' . $pesanan->no_pesanan . '.pdf');
}

    // public function downloadInvoice(Pesanan $pesanan){
    //     if (!$pesanan->invoice_file) {
    //         abort(404, 'File invoice tidak ditemukan');
    //     }

    //     return Storage::disk('public')->download($pesanan->invoice_file);
    // }
}
