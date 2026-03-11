<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Ekspedisi;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\SatuanKirim;
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

        $ekspedisiList = Ekspedisi::orderBy('nama_ekspedisi')->get();
        
        $satuanKirimList = SatuanKirim::orderBy('nama_satuan')->get();
        
        return view('gudang.pengiriman.create', compact('pesanan', 'ekspedisiList', 'satuanKirimList'));
    }

    public function store(Request $request, Pesanan $pesanan){
        $request->validate([
            'ekspedisi_id' => 'required|exists:ekspedisi,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'kirim' => 'nullable|array',
            'kirim.*' => 'nullable|integer|min:0',
            // 'satuan_kirim' => 'nullable|array',
            // 'satuan_kirim.*' => 'nullable|exists:satuan_kirim,id'
        ]);

        DB::beginTransaction();
        try {
            // Ambil data ekspedisi untuk mendapatkan nama_ekspedisi
            $ekspedisi = Ekspedisi::findOrFail($request->ekspedisi_id);
            
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
                'ekspedisi_id' => $request->ekspedisi_id,
                'ekspedisi' => $ekspedisi->nama_ekspedisi, 
                'created_by' => auth()->id()
            ]);

            $totalBarang = 0;
            
            foreach ($pesanan->details as $detail) {
                $detailId = $detail->id;
                
                if (isset($request->kirim[$detailId]) && $request->kirim[$detailId] > 0) {
                    $jumlahKirim = $request->kirim[$detailId];
                    // $satuanKirimId = $request->satuan_kirim[$detailId] ?? null;
                    
                    if ($jumlahKirim > $detail->produced_qty) {
                        throw new \Exception(
                            "Jumlah kirim untuk {$detail->barang->nama_barang} " .
                            "melebihi stok ({$detail->produced_qty})"
                        );
                    }
                    
                    // if (!$satuanKirimId) {
                    //     throw new \Exception(
                    //         "Satuan kirim untuk {$detail->barang->nama_barang} harus dipilih"
                    //     );
                    // }
                    
                    DB::table('detail_pengiriman')->insert([
                        'pengiriman_id' => $pengiriman->id,
                        'detail_pesanan_id' => $detailId,
                        'jumlah_kirim' => $jumlahKirim,
                        // 'satuan_kirim_id' => $satuanKirimId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    $detail->shipped_qty -= $jumlahKirim;
                    $detail->save();
                    
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
        $satuanKirimList = SatuanKirim::orderBy('nama_satuan')->get();
        
        return view('gudang.pengiriman.bast-ekspedisi', compact('pengiriman','ekspedisiList','satuanKirimList'));
    }

    private function extractNomorUrut($noPesanan){
        $parts = explode('-', $noPesanan);
        return (int)end($parts);
    }

    public function cetakBastEkspedisi(Request $request, Pengiriman $pengiriman){
        $request->validate([
            'ekspedisi_id' => 'required|exists:ekspedisi,id',
            'penerima_ekspedisi' => 'required|string', 
            'nama_kurir' => 'required|string',
            'kurir_no_telp' => 'required|string',
            'kurir_jenis_identitas' => 'required|in:SIM A,SIM C,SIM B1,SIM B2,KTP,Lainnya',
            'kurir_no_identitas' => 'required|string',
            'kurir_plat_nomor' => 'required|string',
            'satuan_kirim' => 'required|array',
            'satuan_kirim.*' => 'required|exists:satuan_kirim,id'
        ]);

        $ekspedisi = Ekspedisi::findOrFail($request->ekspedisi_id);

        $urutanBAST = Pengiriman::where('pesanan_id', $pengiriman->pesanan_id)
                        ->whereNotNull('bast_ekspedisi_file')
                        ->count() + 1;
        
        $bulan = now()->format('m');
        $tahun = now()->format('Y');
        $hariTanggal = now()->format('l, d F Y'); 
        
        $noBAST = sprintf("%04d", $urutanBAST) . ' / BAST-Ekspedisi / RP / ' . $bulan . ' / ' . $tahun;
        $filename = 'BAST-' . sprintf("%04d", $urutanBAST) . '-RP-' . $bulan . '-' . $tahun . '.pdf';
        $path = 'bast/' . $filename;

        $company = CompanyProfile::first();

        $pengiriman->load([
            'pesanan.client', 
            'detailPengiriman.detailPesanan.barang',
            'detailPengiriman.satuanKirim'
        ]);
        foreach ($pengiriman->detailPengiriman as $detail) {
            $detailId = $detail->id;
            if (isset($request->satuan_kirim[$detailId])) {
                DB::table('detail_pengiriman')
                    ->where('id', $detailId)
                    ->update(['satuan_kirim_id' => $request->satuan_kirim[$detailId]]);
            }
        }

        $pengiriman->update([
            'ekspedisi' => $ekspedisi->nama_ekspedisi,
            'ekspedisi_id' => $request->ekspedisi_id,
            'penerima_ekspedisi' => $request->penerima_ekspedisi, 
            'nama_kurir' => $request->nama_kurir,
            'kurir_no_telp' => $request->kurir_no_telp,
            'kurir_jenis_identitas' => $request->kurir_jenis_identitas,
            'kurir_no_identitas' => $request->kurir_no_identitas,
            'kurir_plat_nomor' => $request->kurir_plat_nomor,
            'status' => 'dikirim',
            'bast_ekspedisi_file' => $path
        ]);

        $pengiriman->load([
            'pesanan.client', 
            'detailPengiriman.detailPesanan.barang',
            'detailPengiriman.satuanKirim'
        ]);


        $pdf = Pdf::loadView('pdf.bast-ekspedisi', [
            'pengiriman' => $pengiriman,
            'company' => $company,
            'no_bast' => $noBAST,
            'hari_tanggal' => now()->format('l, d F Y'),
            'nama_penerima' => $request->penerima_ekspedisi,
            'ekspedisi' => $ekspedisi,
            'staff_gudang' => auth()->user()->name
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

    public function suratJalan(Pengiriman $pengiriman){
        $pengiriman->load([
            'pesanan.client',
            'detailPengiriman.detailPesanan.barang',
            'detailPengiriman.satuanKirim'
        ]);
        
         $lastSuratJalan = Pengiriman::whereNotNull('surat_jalan_ke')->max('surat_jalan_ke');
    
        $suratJalanKe = $lastSuratJalan ? $lastSuratJalan + 1 : 1;
        
        $bulan = now()->format('m');
        $tahun = now()->format('Y');
        
        $noSJ = sprintf("%04d", $suratJalanKe) . ' / SJ / RP / ' . $bulan . ' / ' . $tahun;
        
        return view('gudang.pengiriman.surat-jalan', compact('pengiriman', 'noSJ', 'suratJalanKe'));
    }

    public function cetakSuratJalan(Request $request, Pengiriman $pengiriman){
        $pengiriman->load([
            'pesanan.client',
            'detailPengiriman.detailPesanan.barang',
            'detailPengiriman.satuanKirim'
        ]);
        
        // Ambil nomor surat jalan TERAKHIR dari SEMUA pengiriman
        $lastSuratJalan = Pengiriman::whereNotNull('surat_jalan_ke')
                            ->max('surat_jalan_ke');
        
        $suratJalanKe = $lastSuratJalan ? $lastSuratJalan + 1 : 1;
        
        $bulan = now()->format('m');
        $tahun = now()->format('Y');
        
        $noSJ = sprintf("%04d", $suratJalanKe) . ' / SJ / RP / ' . $bulan . ' / ' . $tahun;
        $filename = 'SJ-' . sprintf("%04d", $suratJalanKe) . '-RP-' . $bulan . '-' . $tahun . '.pdf';
        $path = 'surat-jalan/' . $filename;

        $company = CompanyProfile::first();

        $pdf = Pdf::loadView('pdf.surat-jalan', [
            'pengiriman' => $pengiriman,
            'company' => $company,
            'no_sj' => $noSJ,
            'suratJalanKe' => $suratJalanKe
        ]);
        
        $pdf->setPaper('A4', 'portrait');

        // Update dengan nomor yang baru
        $pengiriman->update([
            'surat_jalan_file' => $path,
            'surat_jalan_ke' => $suratJalanKe
        ]);

        Storage::disk('public')->put($path, $pdf->output());
        
        return $pdf->download($filename);
    }

    public function bastClient(Pengiriman $pengiriman){
        $pengiriman->load([
            'pesanan.client',
            'detailPengiriman.detailPesanan.barang',
            'detailPengiriman.satuanKirim'
        ]);
        
        $satuanKirimList = SatuanKirim::orderBy('nama_satuan')->get();
        
        return view('gudang.pengiriman.bast-client', compact('pengiriman', 'satuanKirimList'));
    }

    public function cetakBastClient(Request $request, Pengiriman $pengiriman){
        $request->validate([
            'hari_penyerahan' => 'required|string',
            'tanggal_penyerahan' => 'required|date',
            'jabatan_penerima' => 'required|string',
            'penerima_client' =>'required|string'
        ]);

        $pengiriman->update([
            'hari_penyerahan' => $request->hari_penyerahan,
            'tanggal_penyerahan' => $request->tanggal_penyerahan,
            'jabatan_penerima' => $request->jabatan_penerima,
            'penerima_client' => $request->penerima_client
        ]);

        $noUrutSPH = $this->extractNomorUrut($pengiriman->pesanan->no_pesanan);
        
        $jumlahBastEkspedisi = Pengiriman::where('pesanan_id', $pengiriman->pesanan_id)
                                ->whereNotNull('bast_ekspedisi_file')
                                ->count();
        
        $jumlahBastClient = Pengiriman::where('pesanan_id', $pengiriman->pesanan_id)
                                ->whereNotNull('bast_client_file')
                                ->where('id', '<=', $pengiriman->id)
                                ->count();
        
        $totalBast = $jumlahBastEkspedisi + $jumlahBastClient;
        $noUrutBAST = $noUrutSPH + $totalBast + 1;
        
        $bulan = now()->format('m');
        $tahun = now()->format('Y');
        
        $noBAST = sprintf("%04d", $noUrutBAST) . ' / BAST / RP / ' . $bulan . ' / ' . $tahun;
        $filename = 'BAST-CLIENT-' . sprintf("%04d", $noUrutBAST) . '-RP-' . $bulan . '-' . $tahun . '.pdf';
        $path = 'bast-client/' . $filename;

        $pengiriman->load([
            'pesanan.client',
            'detailPengiriman.detailPesanan.barang',
            'detailPengiriman.satuanKirim'
        ]);

        $company = CompanyProfile::first();
        $noPO = sprintf("%04d", $noUrutBAST);  

        $pdf = Pdf::loadView('pdf.bast-client', [
            'pengiriman' => $pengiriman,
            'company' => $company,
            'no_bast' => $noBAST,
            'no_po' => $noPO,
            'tanggal_po' => now(),
            'perihal' => 'Berita Acara Serah Terima Barang Pengiriman untuk Pelanggan'
        ]);
        
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont' => 'Helvetica'
        ]);

        $pengiriman->update([
            'bast_client_file' => $path
        ]);

        Storage::disk('public')->put($path, $pdf->output());

        return $pdf->download($filename);
    }

}
