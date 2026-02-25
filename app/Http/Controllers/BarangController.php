<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Jenis;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with(['kategori', 'jenis', 'satuan', 'createdBy'])->latest()->paginate(10);
        $kategoris = Kategori::orderBy('name_kategori')->get();
        $jenis = Jenis::orderBy('name_jenis')->get();
        $satuans = Satuan::orderBy('nama_satuan')->get();

        return view('admin.barang.index', compact('barang', 'kategoris', 'jenis', 'satuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|unique:barang',
            'kategori_id' => 'required',
            'jenis_id' => 'required',
            'satuan_id' => 'required',
            'harga_satuan' => 'required|numeric|min:0'
        ]);

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'jenis_id' => $request->jenis_id,
            'satuan_id' => $request->satuan_id,
            'harga_satuan' => $request->harga_satuan,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|unique:barang,nama_barang,' . $barang->id,
            'kategori_id' => 'required',
            'jenis_id' => 'required',
            'satuan_id' => 'required',
            'harga_satuan' => 'required|numeric|min:0'
        ]);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'jenis_id' => $request->jenis_id,
            'satuan_id' => $request->satuan_id,
            'harga_satuan' => $request->harga_satuan
        ]);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }

    public function getJenisByKategori($kategoriId)
    {
        return response()->json(
            Jenis::where('kategori_id', $kategoriId)->orderBy('name_jenis')->get()
        );
    }
}