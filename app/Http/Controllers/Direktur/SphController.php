<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
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
        //nanti
    }

    public function reject(Request $request, Pesanan $pesanan)
    {
        //nanti
    }

}
