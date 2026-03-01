<?php

namespace App\Services;

use App\Models\Pesanan;
use App\Models\CompanyProfile;
use App\Models\SphSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SPHGenerator
{
    protected $company;
    protected $settings;

    public function __construct(){
        $this->company = CompanyProfile::first();
        
        $this->settings = SphSetting::all()->pluck('value', 'key')->toArray();
    }

    public function generate(Pesanan $pesanan)
    {
        $noSph = $this->formatNomorSph($pesanan);
        
        $perihal = $pesanan->keterangan ?? $this->settings['perihal_default'] ?? 'Surat Penawaran Harga';

        $logoBase64 = null;

        if ($this->company && $this->company->logo_path) {
            $type = pathinfo($this->company->logo_path, PATHINFO_EXTENSION);
            $data = file_get_contents($this->company->logo_path);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        
        $data = [
            'company' => $this->company,
            'pesanan' => $pesanan,
            'client' => $pesanan->client,
            'items' => $pesanan->details,
            'tanggal' => now()->format('d F Y'),
            'no_sph' => $noSph,
            'perihal' => $perihal,
            'catatan_ppn' => $this->settings['catatan_ppn'] ?? 'Harga belum termasuk PPN 11%',
            'masa_berlaku' => $this->settings['masa_berlaku'] ?? '14 (empat belas) hari kalender',
            'waktu_pengerjaan' => $this->settings['waktu_pengerjaan'] ?? '25 hari kalender',
            'footer_text' => $this->settings['footer_text'] ?? 'Demikian Surat Penawaran Harga kami buat...',
            'logo_base64' => $logoBase64,
        ];

        // dd($this->company?->logo_path);
        
        $pdf = Pdf::loadView('pdf.sph', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'margin_left' => 20,
            'margin_right' => 20,
            'margin_top' => 25,
            'margin_bottom' => 25,
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true
        ]);
        
        return $pdf;
    }

    public function generateWithSignature(Pesanan $pesanan, $signaturePath = null){
        $noSph = $this->formatNomorSph($pesanan);
        
        if (!$signaturePath && $this->company && $this->company->ttd_path) {
            $signaturePath = storage_path('app/public/' . $this->company->ttd_path);
        }
        
        $data = [
            'company' => $this->company,
            'pesanan' => $pesanan,
            'client' => $pesanan->client,
            'items' => $pesanan->details,
            'tanggal' => now()->format('d F Y'),
            'no_sph' => $noSph,
            'perihal' => $pesanan->keterangan ?? $this->settings['perihal_default'] ?? 'Surat Penawaran Harga',
            'catatan_ppn' => $this->settings['catatan_ppn'] ?? 'Harga belum termasuk PPN 11%',
            'masa_berlaku' => $this->settings['masa_berlaku'] ?? '14 (empat belas) hari kalender',
            'waktu_pengerjaan' => $this->settings['waktu_pengerjaan'] ?? '25 hari kalender',
            'footer_text' => $this->settings['footer_text'] ?? 'Demikian Surat Penawaran Harga kami buat...',
            'logo_path' => $this->getLogoPath(),
            'ttd' => $signaturePath,
            'approved_at' => now()->format('d F Y'),
            'approved_by' => auth()->user()->nama ?? $this->company->nama_direktur ?? 'Direktur'
        ];
        
        $pdf = Pdf::loadView('pdf.sph-approved', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'margin_left' => 20,
            'margin_right' => 20,
            'margin_top' => 25,
            'margin_bottom' => 25,
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true
        ]);
        
        return $pdf;
    }

    private function formatNomorSph(Pesanan $pesanan)
    {
        $format = $this->settings['nomor_format'] ?? 'SPH/{{no_pesanan}}';
        
        $replacements = [
            '{{no_pesanan}}' => $pesanan->no_pesanan,
            '{{id}}' => $pesanan->id,
            '{{tahun}}' => now()->format('Y'),
            '{{bulan}}' => now()->format('m'),
            '{{tanggal}}' => now()->format('d'),
        ];
        
        return str_replace(array_keys($replacements), array_values($replacements), $format);
    }

    private function getLogoPath()
    {
        if (!$this->company || !$this->company->logo) {
            return null;
        }
        
        $publicPath = public_path($this->company->logo);
        if (file_exists($publicPath)) {
            return $publicPath;
        }

        $storagePath = storage_path('public/' . $this->company->logo);
        if (file_exists($storagePath)) {
            return $storagePath;
        }
        
        return null;
    }
}