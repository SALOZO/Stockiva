<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\BankPerusahaan;
use App\Models\CompanyProfile;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index(){
            $invoices = Pesanan::with(['client', 'details.barang'])
                ->whereNotNull('no_invoice')
                ->whereNull('invoice_approved_at')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('direktur.invoice.index', compact('invoices'));
    }

    private function terbilang($angka): string{
        $angka = abs((int) $angka);
        $huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima',
                'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];

        if ($angka < 12)         return $huruf[$angka];
        if ($angka < 20)         return $this->terbilang($angka - 10) . ' Belas';
        if ($angka < 100)        return $this->terbilang((int)($angka / 10)) . ' Puluh ' . $this->terbilang($angka % 10);
        if ($angka < 200)        return 'Seratus ' . $this->terbilang($angka - 100);
        if ($angka < 1000)       return $this->terbilang((int)($angka / 100)) . ' Ratus ' . $this->terbilang($angka % 100);
        if ($angka < 2000)       return 'Seribu ' . $this->terbilang($angka - 1000);
        if ($angka < 1000000)    return $this->terbilang((int)($angka / 1000)) . ' Ribu ' . $this->terbilang($angka % 1000);
        if ($angka < 1000000000) return $this->terbilang((int)($angka / 1000000)) . ' Juta ' . $this->terbilang($angka % 1000000);

        return $this->terbilang((int)($angka / 1000000000)) . ' Miliar ' . $this->terbilang($angka % 1000000000);
    }

    public function approve(Pesanan $pesanan)
    {
        if ($pesanan->invoice_approved_at) {
            return back()->with('error', 'Invoice sudah ditandatangani.');
        }

        $direktur = auth()->user();

        if (!$direktur->ttd_path) {
            return redirect()->route('direktur.profile')
                ->with('error', 'Anda harus upload tanda tangan terlebih dahulu');
        }

        try {

            $ttdPath = storage_path('app/public/' . $direktur->ttd_path);
            

            $bank = BankPerusahaan::where('is_active', true)->first();
            $company = CompanyProfile::first();

            $ttdBase64 = null;
            if (file_exists($ttdPath)) {
                $imageData = file_get_contents($ttdPath);
                $ttdBase64 = 'data:image/png;base64,' . base64_encode($imageData);
            }

            // dd([
            //     'ttd_path' => $ttdPath,
            //     'file_exists' => file_exists($ttdPath),
            //     'ttd_base64_null' => is_null($ttdBase64),
            //     'panjang_base64' => $ttdBase64 ? strlen($ttdBase64) : 0,
            //     'preview_base64' => $ttdBase64 ? substr($ttdBase64, 0, 100) : null
            // ]);

            // Generate PDF
            $pdf = Pdf::loadView('pdf.invoice-approved', [
                'pesanan' => $pesanan,
                'company' => $company,
                'bank' => $bank,
                'no_invoice' => $pesanan->no_invoice,
                'jatuh_tempo' => $pesanan->created_at->addDays(30),
                'tanggal' => now()->format('d F Y'),
                'approved_by' => $direktur->nama,
                'approved_by_jabatan' => $direktur->jabatan,
                'approved_at' => now()->format('d F Y'),
                'ttd_base64' => $ttdBase64,
                'terbilang' => ucwords(strtolower($this->terbilang($pesanan->total_keseluruhan))) . ' Rupiah',
            ]);
            
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont' => 'Helvetica'
            ]);

            $filename = 'INVOICE-APPROVED-' . $pesanan->no_pesanan . '-' . date('Ymd') . '.pdf';
            $path = 'invoice/' . $filename;
            Storage::disk('public')->put($path, $pdf->output());

            $pesanan->update([
                'invoice_file' => $path,
                'invoice_approved_at' => now(),
                'invoice_approved_by' => $direktur->id,
            ]);

            return redirect()->route('direktur.invoice.index')
                ->with('success', 'Invoice berhasil ditandatangani.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal approve invoice: ' . $e->getMessage());
        }
    }
    
        public function preview(Pesanan $pesanan)
        {
            $bank = BankPerusahaan::where('is_active', true)->first();
            $company = CompanyProfile::first();
            // $terbilang = Terbilang::angka($pesanan->total_keseluruhan) . ' Rupiah';
            $logoPath = public_path('storage/' . $company->logo);

            $logoBase64 = null;
            if (file_exists($logoPath)) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
            }

            $pdf = Pdf::loadView('pdf.invoice', [
                'pesanan' => $pesanan,
                'company' => $company,
                'bank' => $bank,
                'no_invoice' => $pesanan->no_invoice,
                'jatuh_tempo' => $pesanan->created_at->addDays(30),
                // 'terbilang' => $terbilang,
                'tanggal' => now()->format('d F Y'),
                'logo' => $logoBase64,
                'terbilang'  => ucwords(strtolower($this->terbilang($pesanan->total_keseluruhan))) . ' Rupiah',
            ]);

            return $pdf->stream('invoice-' . $pesanan->no_pesanan . '.pdf');
        }
    }
