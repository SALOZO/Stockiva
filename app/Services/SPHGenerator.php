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

    foreach ($pesanan->details as $detail) {
    if ($detail->barang && $detail->barang->foto) {
        $detail->barang->foto_base64 = $this->getBarangImageBase64($detail->barang->foto);
    }
    }
    $jumlahHalamanLampiran = $this->hitungHalamanLampiran($pesanan);
    
    $lampiranText = $jumlahHalamanLampiran .' lembar';

    $data = [
        'company' => $this->company,
        'pesanan' => $pesanan,
        'client' => $pesanan->client,
        'items' => $pesanan->details,
        'tanggal' => now()->format('d F Y'),
        'no_sph' => $noSph,
        'perihal' => $perihal,
        'lampiran_text' => $lampiranText,
        'catatan_ppn' => $this->settings['catatan_ppn'] ?? 'Harga belum termasuk PPN 11%',
        'masa_berlaku' => $this->settings['masa_berlaku'] ?? '14 (empat belas) hari kalender',
        'waktu_pengerjaan' => $this->settings['waktu_pengerjaan'] ?? '25 hari kalender',
        'footer_text' => $this->settings['footer_text'] ?? 'Demikian Surat Penawaran Harga preview...',
        'logo_base64' => $this->getLogoBase64(),
        'is_preview' => true
    ];

    $data2 = [
        'pesanan' => $pesanan,
        'no_sph' => $noSph,
    ];

    // Render HTML dulu
    $htmlHalaman1 = view('pdf.sph', $data)->render();
    $htmlHalaman2 = view('pdf.lampiran-barang', $data2)->render();

    // Gabungkan HTML
    $htmlGabungan = $htmlHalaman1 . $htmlHalaman2;

    // Load ke PDF
    $pdf = Pdf::loadHTML($htmlGabungan)
        ->setPaper('A4', 'portrait');

    return $pdf;
    }

  public function generateWithSignature(Pesanan $pesanan, $ttdPath = null, $user = null)
    {
        $noSph = $this->formatNomorSph($pesanan);
        $perihal = $pesanan->keterangan ?? $this->settings['perihal_default'] ?? 'Surat Penawaran Harga';

        // Konversi foto barang ke base64
        foreach ($pesanan->details as $detail) {
            if ($detail->barang && $detail->barang->foto) {
                $detail->barang->foto_base64 = $this->getBarangImageBase64($detail->barang->foto);
            }
        }

        // Konversi TTD ke base64
        $ttdBase64 = null;
        if ($ttdPath && file_exists($ttdPath)) {
            $imageData = file_get_contents($ttdPath);
            $ttdBase64 = 'data:image/png;base64,' . base64_encode($imageData);
        }

        // Hitung jumlah halaman lampiran
        $jumlahHalamanLampiran = $this->hitungHalamanLampiran($pesanan);
        $lampiranText = $jumlahHalamanLampiran . ' lembar';

        // Data untuk Halaman 1 (SPH Approved)
        $dataSph = [
            'company' => $this->company,
            'pesanan' => $pesanan,
            'client' => $pesanan->client,
            'items' => $pesanan->details,
            'tanggal' => now()->format('d F Y'),
            'no_sph' => $noSph,
            'perihal' => $perihal,
            'lampiran_text' => $lampiranText,
            'catatan_ppn' => $this->settings['catatan_ppn'] ?? 'Harga belum termasuk PPN 11%',
            'masa_berlaku' => $this->settings['masa_berlaku'] ?? '14 (empat belas) hari kalender',
            'waktu_pengerjaan' => $this->settings['waktu_pengerjaan'] ?? '25 hari kalender',
            'footer_text' => $this->settings['footer_text'] ?? 'Demikian Surat Penawaran Harga ini kami buat...',
            'logo_base64' => $this->getLogoBase64(),
            'ttd_base64' => $ttdBase64,
            'approved_by' => $user->name ?? $this->company->nama_direktur ?? 'Direktur',
            'approved_at' => now(),
            'approved_by_name' => $user->name ?? $this->company->nama_direktur ?? 'Direktur',
            'approved_by_jabatan' => $user->jabatan ?? $this->company->jabatan_direktur ?? 'Direktur Utama',
        ];

        // Data untuk Halaman 2 (Lampiran Barang)
        $dataLampiran = [
            'pesanan' => $pesanan,
            'no_sph' => $noSph,
        ];

        // Render HTML
        $htmlHalaman1 = view('pdf.sph-approved', $dataSph)->render();
        $htmlHalaman2 = view('pdf.lampiran-barang', $dataLampiran)->render();

        // Gabungkan HTML
        $htmlGabungan = $htmlHalaman1 . $htmlHalaman2;

        // Load ke PDF
        $pdf = Pdf::loadHTML($htmlGabungan);
        $pdf->setPaper('A4', 'portrait');
        

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
    private function getLogoBase64(){
        if (!$this->company || !$this->company->logo) {
            return null;
        }
        
        $logoPath = $this->company->logo_path;
        if (!$logoPath || !file_exists($logoPath)) {
            return null;
        }
        
        $imageData = file_get_contents($logoPath);
        $type = pathinfo($logoPath, PATHINFO_EXTENSION);
        return 'data:image/' . $type . ';base64,' . base64_encode($imageData);
    }

public function generatePreview(Pesanan $pesanan)
{
    $noSph = $this->formatNomorSph($pesanan);
    $perihal = $pesanan->keterangan ?? $this->settings['perihal_default'] ?? 'Surat Penawaran Harga';

    foreach ($pesanan->details as $detail) {
    if ($detail->barang && $detail->barang->foto) {
        $detail->barang->foto_base64 = $this->getBarangImageBase64($detail->barang->foto);
    }
    }
    $jumlahHalamanLampiran = $this->hitungHalamanLampiran($pesanan);
    
    $lampiranText = $jumlahHalamanLampiran .' lembar';

    $data = [
        'company' => $this->company,
        'pesanan' => $pesanan,
        'client' => $pesanan->client,
        'items' => $pesanan->details,
        'tanggal' => now()->format('d F Y'),
        'no_sph' => $noSph,
        'perihal' => $perihal,
        'lampiran_text' => $lampiranText,
        'catatan_ppn' => $this->settings['catatan_ppn'] ?? 'Harga belum termasuk PPN 11%',
        'masa_berlaku' => $this->settings['masa_berlaku'] ?? '14 (empat belas) hari kalender',
        'waktu_pengerjaan' => $this->settings['waktu_pengerjaan'] ?? '25 hari kalender',
        'footer_text' => $this->settings['footer_text'] ?? 'Demikian Surat Penawaran Harga preview...',
        'logo_base64' => $this->getLogoBase64(),
        'is_preview' => true
    ];

    $data2 = [
        'pesanan' => $pesanan,
        'no_sph' => $noSph,
    ];

    // Render HTML dulu
    $htmlHalaman1 = view('pdf.sph', $data)->render();
    $htmlHalaman2 = view('pdf.lampiran-barang', $data2)->render();

    // Gabungkan HTML
    $htmlGabungan = $htmlHalaman1 . $htmlHalaman2;

    // Load ke PDF
    $pdf = Pdf::loadHTML($htmlGabungan)
        ->setPaper('A4', 'portrait');

    return $pdf;
}

private function getBarangImageBase64($path){
    if (!$path) {
        return null;
    }

    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
        return null;
    }

    $type = pathinfo($fullPath, PATHINFO_EXTENSION);
    $data = file_get_contents($fullPath);

    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

private function hitungHalamanLampiran(Pesanan $pesanan){
    $jumlahItem = $pesanan->details->count();
    
    if ($jumlahItem <= 10) {
        return 1;
    } elseif ($jumlahItem <= 15) {
        return 2;
    } elseif ($jumlahItem <= 20) {
        return 3;
    } else {
        return ceil($jumlahItem / 15); // Pembulatan ke atas
    }
}
}