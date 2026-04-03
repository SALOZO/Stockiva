<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Pengiriman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class BastClientController extends Controller
{
    public function index()
    {
        $bastList = Pengiriman::with('pesanan.client')
            ->whereNotNull('no_bast')
            ->whereNull('bast_approved_at')
            ->latest()
            ->get();

        return view('direktur.bast-client.index', compact('bastList'));
    }

    public function approve(Pengiriman $pengiriman)
    {
        if ($pengiriman->bast_approved_at) {
            return back()->with('error', 'BAST Client sudah ditandatangani.');
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

            $company = CompanyProfile::first();

            $pengiriman->load([
                'pesanan.client',
                'detailPengiriman.detailPesanan.barang',
                'detailPengiriman.satuanKirim',
            ]);

            $pdf = Pdf::loadView('pdf.bast-client-approved', [
                'pengiriman'  => $pengiriman,
                'company'     => $company,
                'no_bast'     => $pengiriman->no_bast,
                'perihal'     => 'Berita Acara Serah Terima Barang Pengiriman untuk Pelanggan',
                'ttd_base64'  => $ttdBase64,
                'approved_by' => $direktur->name,
                'approved_at' => now()->translatedFormat('d F Y'),
            ])->setPaper('A4', 'portrait')->setOptions([
                'isRemoteEnabled'     => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont'         => 'Helvetica',
            ]);

            $filename = 'BAST-CLIENT-APPROVED-' . $pengiriman->id . '-' . date('Ymd') . '.pdf';
            $path     = 'bast-client/approved/' . $filename;

            Storage::disk('public')->put($path, $pdf->output());

            $pengiriman->update([
                'bast_approved_file' => $path,
                'bast_approved_at'   => now(),
                'bast_approved_by'   => $direktur->id,
            ]);

            return Storage::disk('public')->download($path, $filename);
            // return redirect()->route('direktur.bast-client.index')
            //     ->with('success', 'BAST Client berhasil ditandatangani.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal approve BAST Client: ' . $e->getMessage());
        }
    }
}