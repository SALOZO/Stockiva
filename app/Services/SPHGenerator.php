<?php

namespace App\Services;

use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SPHGenerator
{
    public function generate(Pesanan $pesanan){
        $data = [
            'pesanan' => $pesanan,
            'client' => $pesanan->client,
            'items' => $pesanan->details,
            'tanggal' => now()->format('d F Y'),
            'no_sph' => 'SPH/' . $pesanan->no_pesanan,
            'masa_berlaku' => now()->addDays(7)->format('d F Y') // Masa berlaku 7 hari
        ];
        
        $pdf = Pdf::loadView('pdf.sph', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf;
    }

    public function generateWithSignature(Pesanan $pesanan, $signaturePath = null)    {
        // Jika tidak ada path signature, gunakan default
        if (!$signaturePath) {
            $signaturePath = public_path('images/ttd-default.png');
        }
        
        $data = [
            'pesanan' => $pesanan,
            'client' => $pesanan->client,
            'items' => $pesanan->details,
            'tanggal' => now()->format('d F Y'),
            'no_sph' => 'SPH/' . $pesanan->no_pesanan,
            'ttd' => $signaturePath,
            'approved_at' => now()->format('d F Y'),
            'approved_by' => auth()->user()->nama ?? 'Direktur'
        ];
        
        $pdf = Pdf::loadView('pdf.sph-approved', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf;
    }
}