<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Client;
use App\Models\Kategori;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(){
        $clients = Client::orderBy('nama_client')->paginate(6);
        return view('marketing.pesanan.index', compact('clients'));
    }

    public function create(Request $request){
        $clientId = $request->client_id;
        
        if (!$clientId) {
            return redirect()->route('marketing.pesanan.index')->with('error', 'Pilih client terlebih dahulu.');
        }

        $client = Client::findOrFail($clientId);
        $kategoris = Kategori::orderBy('name_kategori')->get();
        $barangs = Barang::with(['kategori', 'jenis', 'satuan'])->get();
        
        return view('marketing.pesanan.create', compact('client', 'kategoris', 'barangs'));
        // return $barangs;
    }

    public function store(Request $request){
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'tanggal_pesanan' => 'required|date',
            'keterangan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1'
        ]);

        // Buat header pesanan
        $pesanan = Pesanan::create([
            'no_pesanan' => Pesanan::generateNoPesanan(),
            'client_id' => $request->client_id,
            'tanggal_pesanan' => $request->tanggal_pesanan,
            'keterangan' => $request->keterangan,
            'status' => 'baru',
            'created_by' => auth()->id()
        ]);

        $totalKeseluruhan = 0;

        foreach ($request->items as $item) {
            $barang = Barang::find($item['barang_id']);
            $subtotal = $barang->harga_satuan * $item['jumlah'];
            $totalKeseluruhan += $subtotal;

            $pesanan->details()->create([
                'kategori_id' => $barang->kategori_id,
                'jenis_id' => $barang->jenis_id,
                'barang_id' => $barang->id,
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $barang->harga_satuan,
                'subtotal' => $subtotal
            ]);
        }

        $pesanan->update(['total_keseluruhan' => $totalKeseluruhan]);

        return redirect()->route('marketing.pesanan.show', $pesanan->id)->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show(Pesanan $pesanan){
        $pesanan->load(['client', 'details.barang', 'details.kategori', 'details.jenis', 'createdBy']);
        return view('marketing.pesanan.show', compact('pesanan'));
    }

    public function byClient(Client $client){
        $pesanans = Pesanan::where('client_id', $client->id)->with(['client', 'details'])->latest()->paginate(10);
        
        return view('marketing.pesanan.by-client', compact('client', 'pesanans'));
    }

    public function edit(Pesanan $pesanan){
    $pesanan->load(['client', 'details.barang', 'details.kategori', 'details.jenis']);
    $kategoris = Kategori::orderBy('name_kategori')->get();
    
    return view('marketing.pesanan.edit', compact('pesanan', 'kategoris'));
    }

    public function update(Request $request, Pesanan $pesanan){
        // Validasi header pesanan
        $request->validate([
            'tanggal_pesanan' => 'required|date',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:baru,diproses,selesai,dibatalkan',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1'
        ]);

        // Update header pesanan
        $pesanan->update([
            'tanggal_pesanan' => $request->tanggal_pesanan,
            'keterangan' => $request->keterangan,
            'status' => $request->status
        ]);

        // Hapus detail lama
        $pesanan->details()->delete();

        $totalKeseluruhan = 0;

        // Buat detail baru
        foreach ($request->items as $item) {
            $barang = Barang::find($item['barang_id']);
            $subtotal = $barang->harga_satuan * $item['jumlah'];
            $totalKeseluruhan += $subtotal;

            $pesanan->details()->create([
                'kategori_id' => $barang->kategori_id,
                'jenis_id' => $barang->jenis_id,
                'barang_id' => $barang->id,
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $barang->harga_satuan,
                'subtotal' => $subtotal
            ]);
        }

        // Update total pesanan
        $pesanan->update(['total_keseluruhan' => $totalKeseluruhan]);

        return redirect()->route('marketing.pesanan.show', $pesanan->id)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Pesanan $pesanan){
        $noPesanan = $pesanan->no_pesanan;
        $clientId = $pesanan->client_id;
        
        // Hapus pesanan (detail otomatis kehapus karena onDelete cascade)
        $pesanan->delete();
        
        return redirect()->route('marketing.pesanan.by-client', $clientId)
            ->with('success', 'Pesanan "' . $noPesanan . '" berhasil dihapus.');
    }

    public function semuaPesanan(Request $request){
        $query = Pesanan::with(['client', 'details'])->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_pesanan', 'like', "%{$search}%")
                ->orWhereHas('client', function($clientQuery) use ($search) {
                    $clientQuery->where('nama_client', 'like', "%{$search}%");
                });
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $pesanans = $query->paginate(10);
        
        $statuses = ['baru', 'diproses', 'selesai', 'dibatalkan'];
        
        return view('marketing.pesanan.semua-pesanan', compact('pesanans', 'statuses'));
    }


    public function getBarangByKategori($kategoriId){
        $barangs = Barang::where('kategori_id', $kategoriId)->with('satuan','jenis')->orderBy('nama_barang')->get();
        return response()->json($barangs);
    }

    public function getBarangByJenis($jenisId){
        $barangs = Barang::where('jenis_id', $jenisId)->with('satuan','jenis')->orderBy('nama_barang')->get();
        return response()->json($barangs);
    }
}
