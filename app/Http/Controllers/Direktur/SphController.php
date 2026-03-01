<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Services\SPHGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SphController extends Controller
{
    public function index(){
        $sphList = Pesanan::where('sph_status', 'menunggu')->with('client', 'createdBy')->latest()->paginate(10);
        
        return view('direktur.sph.index', compact('sphList'));
    }

    public function show(Pesanan $pesanan){
        $pesanan->load(['client', 'details.barang', 'details.kategori', 'details.jenis', 'createdBy']);
        
        return view('direktur.sph.show', compact('pesanan'));
    }

    public function previewPdf(Pesanan $pesanan){
        if (auth()->user()->jabatan !== 'Direktur') {
            abort(code: 403);
        }

        $file = $pesanan->sph_file; 
        
        if (!$file || !Storage::exists($file)) {
            abort(404, 'File tidak ditemukan');
        }
        
        
        $path = storage_path('app/private/' . $file);
        
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($file) . '"'
        ]);
    }

    public function approve(Pesanan $pesanan)
{
    // Validasi status
    if ($pesanan->sph_status !== 'menunggu') {
        return back()->with('error', 'SPH tidak dalam status menunggu');
    }

    // Validasi TTD direktur
    $direktur = auth()->user();
    if (!$direktur->ttd_path) {
        return redirect()->route('direktur.profile')
            ->with('error', 'Anda harus upload tanda tangan terlebih dahulu');
    }

    try {
        // Generate PDF final dengan TTD
        $generator = new SPHGenerator();
        $ttdPath = storage_path('app/public/' . $direktur->ttd_path);
        
        // Kirim data user yang approve
        $pdf = $generator->generateWithSignature($pesanan, $ttdPath, $direktur);
        
        // Simpan file approved
        $filename = 'SPH-APPROVED-' . $pesanan->no_pesanan . '-' . date('Ymd') . '.pdf';
        $path = 'private/sph-approved/' . $filename;
        
        if (!Storage::exists('private/sph-approved')) {
            Storage::makeDirectory('private/sph-approved');
        }
        
        Storage::put($path, $pdf->output());
        
        // Update pesanan
        $pesanan->update([
            'sph_status' => 'disetujui',
            'sph_approved_file' => $path,
            'approved_by' => $direktur->id,
            'approved_at' => now()
        ]);
        
        return redirect()->route('direktur.sph.index')
            ->with('success', 'SPH berhasil disetujui');
            
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal approve SPH: ' . $e->getMessage());
    }
}

    public function reject(Request $request, Pesanan $pesanan){
        // Validasi status
        if ($pesanan->sph_status !== 'menunggu') {
            return back()->with('error', 'SPH tidak dalam status menunggu');
        }

        // Validasi input
        $request->validate([
            'approval_notes' => 'required|string|min:5'
        ]);

        // Update pesanan
        $pesanan->update([
            'sph_status' => 'ditolak',
            'approval_notes' => $request->approval_notes
        ]);

        return redirect()->route('direktur.sph.index')
            ->with('success', 'SPH ditolak');
    }

    public function downloadApproved(Pesanan $pesanan){
        if (!$pesanan->sph_approved_file || !Storage::exists($pesanan->sph_approved_file)) {
            return back()->with('error', 'File approved tidak ditemukan');
        }

        return Storage::download($pesanan->sph_approved_file);
    }

}
