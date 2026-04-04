<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\BankPerusahaan;
use App\Models\CompanyProfile;
use App\Models\DocumentCounter;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class KwitansiDirekturController extends Controller
{
    public function index()
    {
        $kwitansiss = Pesanan::with('client')
            ->whereNotNull('no_kwitansi')
            ->whereNull('kwitansi_approved_at')
            ->latest()
            ->get();

        return view('direktur.kwitansi.index', compact('kwitansiss'));
    }

    public function approve(Pesanan $pesanan)
    {
        if ($pesanan->kwitansi_approved_at) {
            return back()->with('error', 'Kwitansi sudah ditandatangani.');
        }

        $direktur = auth()->user();

        if (!$direktur->ttd_path) {
            return redirect()->route('direktur.profile')
                ->with('error', 'Anda harus upload tanda tangan terlebih dahulu.');
        }

        try {
            $ttdPath   = storage_path('app/public/' . $direktur->ttd_path);
            $ttdBase64 = file_exists($ttdPath)
                ? 'data:image/png;base64,' . base64_encode(file_get_contents($ttdPath))
                : null;

            $pesanan->load(['client', 'details.barang']);

            $company    = CompanyProfile::first();
            $bank       = BankPerusahaan::where('is_active', true)->first() ?? BankPerusahaan::first();
            $logoBase64 = $this->logoToBase64($company?->logo);

            $untukPembayaran = $pesanan->details
                ->map(fn($d) => $d->barang?->nama_barang)
                ->filter()
                ->implode(', ');

            $pdf = Pdf::loadView('pdf.kwitansi-approved', [
                'pesanan'         => $pesanan,
                'company'         => $company,
                'bank'            => $bank,
                'noKwitansi'      => $pesanan->no_kwitansi,
                'tglSurat'        => now()->translatedFormat('d F Y'),
                'logo'            => $logoBase64,
                'untukPembayaran' => $untukPembayaran,
                'terbilang'       => ucwords(strtolower($this->terbilang($pesanan->total_keseluruhan))) . ' Rupiah',
                'ttd_base64'      => $ttdBase64,
                'approved_by'     => $direktur->name,
                'approved_jabatan'=> $direktur->jabatan,
            ])->setPaper('A4', 'portrait')->setOptions([
                'isRemoteEnabled'     => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont'         => 'Helvetica',
            ]);

            $filename = 'KWITANSI-APPROVED-' . $pesanan->no_pesanan . '-' . date('Ymd') . '.pdf';
            $path     = 'kwitansi/' . $filename;
            Storage::disk('public')->put($path, $pdf->output());

            $pesanan->update([
                'kwitansi_approved_file' => $path,
                'kwitansi_approved_at'   => now(),
                'kwitansi_approved_by'   => $direktur->id,
            ]);

            return Storage::disk('public')->download($path, $filename);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal approve kwitansi: ' . $e->getMessage());
        }
    }

    private function logoToBase64(?string $logo): ?string
    {
        if (!$logo) return null;
        $path = public_path('storage/' . $logo);
        return file_exists($path) ? 'data:image/png;base64,' . base64_encode(file_get_contents($path)) : null;
    }

    private function terbilang($angka): string
    {
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
}