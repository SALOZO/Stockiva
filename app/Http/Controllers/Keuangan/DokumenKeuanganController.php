<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\DokumenPengiriman;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenKeuanganController extends Controller
{
    public function index(Pesanan $pesanan)
    {
        $pengiriman = Pengiriman::where('pesanan_id', $pesanan->id)->firstOrFail();

        $dokumens = DokumenPengiriman::where('pengiriman_id', $pengiriman->id)
            ->whereIn('jenis', ['kwitansi', 'faktur_pajak'])
            ->orderBy('uploaded_at', 'desc')
            ->get();

        return view('keuangan.dokumen.upload', compact('pesanan', 'pengiriman', 'dokumens'));
    }

    public function store(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'jenis' => 'required|in:kwitansi,faktur_pajak',
            'file'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'catatan' => 'nullable|string|max:255',
        ]);

        $pengiriman = Pengiriman::where('pesanan_id', $pesanan->id)->firstOrFail();

        $folder   = 'dokumen-keuangan/' . $pengiriman->id;
        $path     = $request->file('file')->store($folder, 'public');
        $namaJenis = $request->jenis === 'kwitansi' ? 'Kwitansi' : 'Faktur Pajak';

        DokumenPengiriman::create([
            'pengiriman_id' => $pengiriman->id,
            'jenis'         => $request->jenis,
            'file_path'     => $path,
            'status'        => 'verified',
            'catatan'       => $request->catatan,
            'uploaded_by'   => auth()->id(),
            'uploaded_at'   => now(),
        ]);

        return back()->with('success', $namaJenis . ' berhasil diupload.');
    }

    public function destroy(DokumenPengiriman $dokumen)
    {
        Storage::disk('public')->delete($dokumen->file_path);
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}