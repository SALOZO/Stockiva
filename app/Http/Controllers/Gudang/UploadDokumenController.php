<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\DokumenPengiriman;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadDokumenController extends Controller
{
    public function index(Pengiriman $pengiriman){
        $dokumen = DokumenPengiriman::where('pengiriman_id', $pengiriman->id)->orderBy('created_at', 'desc')->get();
        
        return view('gudang.upload.index', compact('pengiriman', 'dokumen'));
    }

    public function create(Pengiriman $pengiriman, $jenis){
        $validJenis = ['surat_jalan', 'bast_ekspedisi', 'bast_client'];
        if (!in_array($jenis, $validJenis)) {
            abort(404);
        }
        
        return view('gudang.upload.create', compact('pengiriman', 'jenis'));
    }

    public function store(Request $request, Pengiriman $pengiriman, $jenis){
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:5120', 
            'catatan' => 'nullable|string'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $jenis . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('dokumen-pengiriman/' . $pengiriman->id, $filename, 'public');

        DokumenPengiriman::create([
            'pengiriman_id' => $pengiriman->id,
            'jenis' => $jenis,
            'file_path' => $path,
            'status' => 'pending',
            'catatan' => $request->catatan,
            'uploaded_by' => auth()->id(),
            'uploaded_at' => now()
        ]);

        return redirect()
            ->route('gudang.upload.index', $pengiriman->id)
            ->with('success', 'Dokumen berhasil diupload');
    }

    public function download(DokumenPengiriman $dokumen){
        if (!Storage::disk('public')->exists($dokumen->file_path)) {
            abort(404);
        }
        
        return Storage::disk('public')->download($dokumen->file_path);
    }

    public function verify(Request $request, DokumenPengiriman $dokumen){
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'required_if:status,rejected|nullable|string'
        ]);

        $dokumen->update([
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);

        return back()->with('success', 'Status dokumen diperbarui');
    }

    public function destroy(DokumenPengiriman $dokumen){
        if (Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }
        
        $pengirimanId = $dokumen->pengiriman_id;
        
        $dokumen->delete();

        return redirect()
            ->route('gudang.upload.index', $pengirimanId)
            ->with('success', 'Dokumen berhasil dihapus');
    }

}
