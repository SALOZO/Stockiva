<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\BankPerusahaan;
use App\Models\CompanyProfile;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TagihanDirekturController extends Controller
{
    public function index(){
        $tagihans = Pesanan::with('client')
            ->whereNotNull('no_tagihan')
            ->whereNull('tagihan_approved_at')
            ->latest()
            ->get();

        return view('direktur.tagihan.index', compact('tagihans'));
    }
    public function approve(Pesanan $pesanan){
        if ($pesanan->tagihan_approved_at) {
            return back()->with('error', 'Tagihan sudah ditandatangani.');
        }

        $direktur = auth()->user();

        if (!$direktur->ttd_path) {
            return redirect()->route('direktur.profile')
                ->with('error', 'Anda harus upload tanda tangan terlebih dahulu.');
        }

        try {
            $ttdPath    = storage_path('app/public/' . $direktur->ttd_path);
            $ttdBase64  = file_exists($ttdPath)
                ? 'data:image/png;base64,' . base64_encode(file_get_contents($ttdPath))
                : null;

            $company    = CompanyProfile::first();
            $bank       = BankPerusahaan::where('is_active', true)->first() ?? BankPerusahaan::first();
            $logoBase64 = $this->logoToBase64($company?->logo);

            $pdf = Pdf::loadView('pdf.tagihan-approved', [
                'pesanan'           => $pesanan->load(['client', 'details.barang.satuan']),
                'company'           => $company,
                'bank'              => $bank,
                'noTagihan'         => $pesanan->no_tagihan,
                'tglSurat'          => $pesanan->tagihan_approved_at ? $pesanan->tagihan_approved_at->translatedFormat('d F Y'): now()->translatedFormat('d F Y'),
                'logoPath'          => $logoBase64,
                'ttd_base64'        => $ttdBase64,
                'approved_by'       => $direktur->name,
                'approved_jabatan'  => $direktur->jabatan,
                'approved_at'       => now()->translatedFormat('d F Y'),
            ])->setPaper('A4', 'portrait')->setOptions([
                'isRemoteEnabled'     => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont'         => 'Helvetica',
            ]);

            $filename = 'tagihan/TAGIHAN-APPROVED-' . $pesanan->no_pesanan . '-' . date('Ymd') . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());

            $pesanan->update([
                'tagihan_approved_file' => $filename,
                'tagihan_approved_at'   => now(),
                'tagihan_approved_by'   => $direktur->id,
            ]);

            return redirect()->route('direktur.tagihan.index')
                ->with('success', 'Tagihan berhasil ditandatangani.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal approve tagihan: ' . $e->getMessage());
        }
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
