<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\BankPerusahaan;
use App\Models\CompanyProfile;
use App\Models\DocumentCounter;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TagihanController extends Controller
{
    public function riwayat()
    {
        $tagihans = Pesanan::with('client')
            ->whereNotNull('tagihan_approved_at')
            ->latest('tagihan_approved_at')
            ->get();

        return view('keuangan.tagihan.riwayat', compact('tagihans'));
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
    public function download(Pesanan $pesanan){
        // Generate nomor tagihan sekali saja (tidak berubah tiap klik)
        if (!$pesanan->no_tagihan) {
            $bulan     = now()->format('m');
            $tahun     = now()->format('Y');
            $nomor     = DocumentCounter::getNextNumber(now()->format('Y-m'));
            $noTagihan = sprintf("%04d", $nomor) . ' / Tagihan / RP / ' . $bulan . ' / ' . $tahun;
            $pesanan->update(['no_tagihan' => $noTagihan]);
        }

        $company  = CompanyProfile::first();
        $bank     = BankPerusahaan::where('is_active', true)->first() ?? BankPerusahaan::first();
        $logoBase64 = $this->logoToBase64($company?->logo);

        $pdf = Pdf::loadView('pdf.tagihan', [
            'pesanan'   => $pesanan->load(['client', 'details.barang.satuan']),
            'company'   => $company,
            'bank'      => $bank,
            'noTagihan' => $pesanan->no_tagihan,
            'tglSurat'  => now()->translatedFormat('d F Y'),
            'logoPath'      => $logoBase64,
            'terbilang'  => ucwords(strtolower($this->terbilang($pesanan->total_keseluruhan))) . ' Rupiah',
        ])->setPaper('A4', 'portrait')->setOptions([
            'isRemoteEnabled'    => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont'        => 'Helvetica',
        ]);

        // Simpan file PDF ke storage
        $filename = 'tagihan/temp/TAGIHAN-' . $pesanan->no_pesanan . '-' . date('Ymd') . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());
        $pesanan->update(['tagihan_file' => $filename]);

        return Storage::disk('public')->download($filename, basename($filename));
    }

    private function logoToBase64(?string $logo): ?string
    {
        if (!$logo) return null;
        $path = public_path('storage/' . $logo);
        return file_exists($path)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($path)): null;
    }
}
