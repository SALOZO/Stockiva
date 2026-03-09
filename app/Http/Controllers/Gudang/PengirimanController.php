<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Ekspedisi;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            $jumlahPengiriman = Pengiriman::where('pesanan_id', $pesanan->id)->count();
            $pengirimanKe = $jumlahPengiriman + 1;

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

            $totalBarang = 0;
            
            foreach ($pesanan->details as $detail) {
                $detailId = $detail->id;
                
                if (isset($request->kirim[$detailId]) && $request->kirim[$detailId] > 0) {
                    $jumlahKirim = $request->kirim[$detailId];
                    
                    if ($jumlahKirim > $detail->produced_qty) {
                        throw new \Exception(
                            "Jumlah kirim untuk {$detail->barang->nama_barang} " .
                            "melebihi stok produksi ({$detail->produced_qty})"
                        );
                    }
                    
                    DB::table('detail_pengiriman')->insert([
                        'pengiriman_id' => $pengiriman->id,
                        'detail_pesanan_id' => $detailId,
                        'jumlah_kirim' => $jumlahKirim,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    $detail->produced_qty -= $jumlahKirim;
                    $detail->save();
                    
                    $totalBarang++;
                }
            }

            if ($totalBarang == 0) {
                throw new \Exception("Minimal harus mengirim 1 barang");
            }

            DB::commit();
            
            return redirect()->route('gudang.pengiriman.index', $pesanan->id)->with('success', 'Pengiriman Ke-' . $pengirimanKe . ' berhasil dibuat. ' .'Stok produksi berkurang ' . $totalBarang . ' item.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pengiriman: ' . $e->getMessage())->withInput();
        }
    }

    public function editEkspedisi(Pengiriman $pengiriman){
        $pengiriman->load(['pesanan.client', 'detailPengiriman.detailPesanan.barang']);
        $ekspedisiList = Ekspedisi::orderBy('nama_ekspedisi')->get();
        
        return view('gudang.pengiriman.edit-ekspedisi', compact('pengiriman','ekspedisiList'));
    }

    public function updateEkspedisi(Request $request, Pengiriman $pengiriman){
        $request->validate([
            'ekspedisi' => 'required|string',
            'nama_kurir' => 'required|string',
            'file_bast' => 'nullable|mimes:pdf|max:2048'
        ]);

        $data = [
            'ekspedisi' => $request->ekspedisi,
            'nama_kurir' => $request->nama_kurir,
            'status' => 'dikirim',
            'tanggal_kirim' => now()
        ];

        if ($request->hasFile('file_bast')) {
            $file = $request->file('file_bast');
            $filename = 'BAST-EKSPEDISI-' . $pengiriman->no_pengiriman . '-' . time() . '.pdf';
            $path = $file->storeAs('public/bast-ekspedisi', $filename);
            $data['bast_ekspedisi_file'] = str_replace('public/', '', $path);
        }

        $pengiriman->update($data);

        return redirect()->route('gudang.pengiriman.index', $pengiriman->pesanan_id)->with('success', 'Data ekspedisi berhasil diperbarui.');
    }

    public function editClient(Pengiriman $pengiriman){
        $pengiriman->load(['pesanan.client', 'detailPengiriman.detailPesanan.barang']);
        
        return view('gudang.pengiriman.edit-client', compact('pengiriman'));
    }

    public function updateClient(Request $request, Pengiriman $pengiriman){
        $request->validate([
            'penerima_client' => 'required|string',
            'file_bast_client' => 'nullable|mimes:pdf|max:2048'
        ]);

        $data = [
            'penerima_client' => $request->penerima_client,
            // 'status' => 'selesai',
            'tanggal_terima' => now()
        ];

        if ($request->hasFile('file_bast_client')) {
            $file = $request->file('file_bast_client');
            $filename = 'BAST-CLIENT-' . $pengiriman->no_pengiriman . '-' . time() . '.pdf';
            $path = $file->storeAs('public/bast-client', $filename);
            $data['bast_client_file'] = str_replace('public/', '', $path);
        }

        $pengiriman->update($data);

        return redirect()->route('gudang.pengiriman.index', $pengiriman->pesanan_id)
            ->with('success', 'Data penerima client berhasil diperbarui.');
    }
    public function bastEkspedisi(Pengiriman $pengiriman){
        $pengiriman->load(['pesanan.client', 'detailPengiriman.detailPesanan.barang','ekspedisi']);
        $ekspedisiList = Ekspedisi::orderBy('nama_ekspedisi')->get();
        
        return view('gudang.pengiriman.bast-ekspedisi', compact('pengiriman','ekspedisiList'));
    }

    private function extractNomorUrut($noPesanan){
        $parts = explode('-', $noPesanan);
        return (int)end($parts);
    }

    public function cetakBastEkspedisi(Request $request, Pengiriman $pengiriman){
        $request->validate([
            'ekspedisi_id' => 'required|exists:ekspedisi,id',
            'nama_kurir' => 'required|string',
            'kurir_no_telp' => 'required|string',
            'kurir_jenis_identitas' => 'required|in:SIM A,SIM C,SIM B1,SIM B2,KTP,Lainnya',
            'kurir_no_identitas' => 'required|string',
            'kurir_plat_nomor' => 'required|string'
        ]);

        $ekspedisi = Ekspedisi::findOrFail($request->ekspedisi_id);

        // Hitung urutan BAST untuk SPH ini
        $urutanBAST = Pengiriman::where('pesanan_id', $pengiriman->pesanan_id)
                        ->whereNotNull('bast_ekspedisi_file')
                        ->count() + 1;
        
        $bulan = now()->format('m');
        $tahun = now()->format('Y');
        
        // Format nomor BAST (reset per SPH)
        $noBAST = sprintf("%04d", $urutanBAST) . ' / BAST / RP / ' . $bulan . ' / ' . $tahun;
        $filename = 'BAST-' . sprintf("%04d", $urutanBAST) . '-RP-' . $bulan . '-' . $tahun . '.pdf';
        $path = 'bast/' . $filename;

        $company = CompanyProfile::first();

        // Update data pengiriman
        $pengiriman->update([
            'ekspedisi' => $ekspedisi->nama_ekspedisi,
            'nama_kurir' => $request->nama_kurir,
            'kurir_no_telp' => $request->kurir_no_telp,
            'kurir_jenis_identitas' => $request->kurir_jenis_identitas,
            'kurir_no_identitas' => $request->kurir_no_identitas,
            'kurir_plat_nomor' => $request->kurir_plat_nomor,
            'status' => 'dikirim',
            'bast_ekspedisi_file' => $path
        ]);

        // Load relasi untuk PDF
        $pengiriman->load([
            'pesanan.client', 
            'detailPengiriman.detailPesanan.barang',
            'ekspedisi'
        ]);

        // Generate PDF
        $pdf = Pdf::loadView('pdf.bast-ekspedisi', [
            'pengiriman' => $pengiriman,
            'company' => $company,
            'no_bast' => $noBAST
        ]);
        
        $pdf->setPaper('A4', 'portrait');

        Storage::disk('public')->put($path, $pdf->output());
        
        return $pdf->download($filename);
    }

    public function destroy(Pengiriman $pengiriman){
        DB::beginTransaction();

        try {
            $pesananId = $pengiriman->pesanan_id;

            // hapus file BAST ekspedisi
            if ($pengiriman->bast_ekspedisi_file && Storage::disk('public')->exists($pengiriman->bast_ekspedisi_file)) {
                Storage::disk('public')->delete($pengiriman->bast_ekspedisi_file);
            }

            // hapus file BAST client
            if ($pengiriman->bast_client_file && Storage::disk('public')->exists($pengiriman->bast_client_file)) {
                Storage::disk('public')->delete($pengiriman->bast_client_file);
            }

            // hapus detail pengiriman
            DB::table('detail_pengiriman')
                ->where('pengiriman_id', $pengiriman->id)
                ->delete();

            // hapus pengiriman
            $pengiriman->delete();

            DB::commit();

            return redirect()
                ->route('gudang.pengiriman.index', $pesananId)
                ->with('success', 'Pengiriman berhasil dihapus.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Gagal menghapus pengiriman: ' . $e->getMessage()
            );
        }
    }

}
