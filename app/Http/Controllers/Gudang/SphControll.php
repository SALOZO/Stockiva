<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SphControll extends Controller
{
    public function index(){
        $sphList = Pesanan::where('sph_status', 'disetujui')->with(['client', 'createdBy', 'approvedBy'])->latest('approved_at')->paginate(5);
        
        return view('gudang.sph.index', compact('sphList'));
    }

    public function show(Pesanan $pesanan){
        // Validasi hanya bisa lihat yang sudah disetujui
        if ($pesanan->sph_status !== 'disetujui') {
            return redirect()->route('gudang.sph.index')->with('error', 'SPH belum disetujui');
        }

        $pesanan->load(['client', 'details.barang', 'details.kategori', 'details.jenis', 'createdBy', 'approvedBy']);
        
        return view('gudang.sph.show', compact('pesanan'));
    }

    public function download(Pesanan $pesanan){
        if ($pesanan->sph_status !== 'disetujui' || !$pesanan->sph_approved_file) {
            return back()->with('error', 'File tidak tersedia');
        }

        if (!Storage::exists($pesanan->sph_approved_file)) {
            return back()->with('error', 'File tidak ditemukan');
        }

        return Storage::download($pesanan->sph_approved_file);
    }

    public function updateStatus(Request $request, Pesanan $pesanan){
        $request->validate([
            'gudang_status' => 'required|in:Menunggu,Sedang diproses,Siap_dikirim,Dikirim,Diterima'
        ]);

        $pesanan->update([
            'gudang_status' => $request->gudang_status
        ]);

        return redirect()->route('gudang.sph.index')
            ->with('success', 'Status berhasil diperbarui.');
    }
}
