<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function index(Pesanan $pesanan){
        $pengiriman = Pengiriman::where('pesanan_id', $pesanan->id)->orderBy('pengiriman_ke')->get();
        return view('gudang.pengiriman.index', compact('pesanan', 'pengiriman'));
    }

    public function create(Pesanan $pesanan){
        $pesanan->load(['client', 'details.barang', 'details.kategori', 'details.jenis']);
        
        return view('gudang.pengiriman.create', compact('pesanan'));
    }

    public function store(Request $request, Pesanan $pesanan){
        $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'kirim' => 'required|array',
            'kirim.*' => 'required|integer|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Hitung pengiriman ke berapa
            $jumlahPengiriman = Pengiriman::where('pesanan_id', $pesanan->id)->count();
            $pengirimanKe = $jumlahPengiriman + 1;

            // Generate no pengiriman
            $noPengiriman = 'KIRIM/' . $pesanan->no_pesanan . '/' . $pengirimanKe;

            $pengiriman = Pengiriman::create([
                'pesanan_id' => $pesanan->id,
                'no_pengiriman' => $noPengiriman,
                'pengiriman_ke' => $pengirimanKe,
                'tanggal' => $request->tanggal,
                'status' => 'pending',
                'catatan' => $request->catatan,
                'created_by' => auth()->id()
            ]);

            // Simpan detail pengiriman (barang yang dikirim)
            $totalBarang = 0;
            foreach ($pesanan->details as $detail) {
                $detailId = $detail->id;
                if (isset($request->kirim[$detailId]) && $request->kirim[$detailId] > 0) {
                    $jumlahKirim = $request->kirim[$detailId];
                    
                    // Validasi: tidak boleh melebihi produced_qty
                    if ($jumlahKirim > $detail->produced_qty) {
                        throw new \Exception("Jumlah kirim untuk {$detail->barang->nama_barang} melebihi stok produksi ({$detail->produced_qty})");
                    }
                    
                    // Simpan detail pengiriman
                    DB::table('detail_pengiriman')->insert([
                        'pengiriman_id' => $pengiriman->id,
                        'detail_pesanan_id' => $detailId,
                        'jumlah_kirim' => $jumlahKirim,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    $totalBarang++;
                }
            }

            if ($totalBarang == 0) {
                throw new \Exception("Minimal harus mengirim 1 barang");
            }

            DB::commit();
            return redirect()->route('gudang.pengiriman.index', $pesanan->id)->with('success', 'Pengiriman Ke-' . $pengirimanKe . ' berhasil dibuat.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pengiriman: ' . $e->getMessage())->withInput();
        }
    }

}
