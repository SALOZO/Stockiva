<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\BankPerusahaan;
use App\Models\CompanyProfile;
use App\Models\DocumentCounter;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KwitansiController extends Controller
{
    public function download(Pesanan $pesanan)
    {
        if (!$pesanan->no_kwitansi) {
            $bulan      = now()->format('m');
            $tahun      = now()->format('Y');
            $nomor      = DocumentCounter::getNextNumber(now()->format('Y-m'));
            $noKwitansi = sprintf("%04d", $nomor) . '/KWI/' . $bulan . '/' . $tahun;
            $pesanan->update(['no_kwitansi' => $noKwitansi]);
        }

        $pesanan->load(['client', 'details.barang']);

        $company    = CompanyProfile::first();
        $bank       = BankPerusahaan::where('is_active', true)->first() ?? BankPerusahaan::first();
        $logoBase64 = $this->logoToBase64($company?->logo);

        $untukPembayaran = $pesanan->details
            ->map(fn($d) => $d->barang?->nama_barang)
            ->filter()
            ->implode(', ');

        $pdf = Pdf::loadView('pdf.kwitansi', [
            'pesanan'         => $pesanan,
            'company'         => $company,
            'bank'            => $bank,
            'noKwitansi'      => $pesanan->no_kwitansi,
            'tglSurat'        => now()->translatedFormat('d F Y'),
            'logo'            => $logoBase64,
            'untukPembayaran' => $untukPembayaran,
        //     'terbilang'       => ucwords(strtolower(terbilang($pesanan->total_keseluruhan))) . ' Rupiah',
        // ])->setPaper('A4', 'portrait')->setOptions([
        //     'isRemoteEnabled'     => true,
        //     'isHtml5ParserEnabled' => true,
        //     'defaultFont'         => 'Helvetica',
        ]);

        $filename = 'KWITANSI-' . $pesanan->no_pesanan . '-' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    private function logoToBase64(?string $logo): ?string
    {
        if (!$logo) return null;
        $path = public_path('storage/' . $logo);
        return file_exists($path)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($path))
            : null;
    }
}
