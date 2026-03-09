<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function index(Pesanan $pesanan){
        $pesanan->load(['client', 'details.barang', 'details.kategori', 'details.jenis']);
        
        return view('gudang.produksi.index', compact('pesanan'));
    }

    public function update(Request $request, Pesanan $pesanan){
        $request->validate([
            'tambah' => 'nullable|array',
            'tambah.*' => 'nullable|integer|min:0'
        ]);

        $updated = false;
        $warnings = [];

        foreach ($pesanan->details as $detail) {
            $detailId = $detail->id;
            if (isset($request->tambah[$detailId])) {
                $tambah = $request->tambah[$detailId];
                $currentQty = $detail->produced_qty;
                $maxQty = $detail->jumlah;
                
                // Hitung total setelah ditambah
                $totalBaru = $currentQty + $tambah;
                
                // Validasi tidak melebihi maksimal
                if ($totalBaru > $maxQty) {
                    $bisaDitambah = $maxQty - $currentQty;
                    $warnings[] = "{$detail->barang->nama_barang} hanya bisa ditambah {$bisaDitambah} dari {$currentQty} (maksimal {$maxQty})";
                } elseif ($tambah > 0) {
                    $detail->update([
                        'produced_qty' => $totalBaru,
                        'shipped_qty' => $totalBaru
                    ]);
                    $updated = true;
                }
            }
        }

        if ($updated) {
            $message = 'Progres produksi berhasil diperbarui.';
            if (!empty($warnings)) {
                $message .= ' ' . implode('. ', $warnings);
            }
            return redirect()->route('gudang.tugas-gudang.index')
                ->with('success', $message);
        }

        if (!empty($warnings)) {
            return back()->with('error', implode('. ', $warnings))->withInput();
        }

        return back()->with('error', 'Tidak ada data yang diupdate.');
    }

    public static function hitungRataRataProgres($details){
        $totalPersen = 0;
        $jumlahBarang = $details->count();
        
        foreach ($details as $detail) {
            if ($detail->jumlah > 0) {
                $persen = ($detail->produced_qty / $detail->jumlah) * 100;
                $totalPersen += $persen;
            }
        }
        
        return $jumlahBarang > 0 ? round($totalPersen / $jumlahBarang) : 0;
    }
}
