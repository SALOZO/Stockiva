<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Jenis;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(){
        $barang = Barang::with(['kategori', 'jenis', 'createdBy'])->latest()->paginate(10);
        $kategoris = Kategori::orderBy('name_kategori')->get();
        $jenis = Jenis::orderBy('name_jenis')->get();
        
        return view('admin.barang.index', compact('barang', 'kategoris', 'jenis'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255', 'unique:barang,nama_barang'],
            'kategori_id' => ['required', 'exists:categories,id'],
            'jenis_id' => ['required', 'exists:jenis,id']
        ]);

        $validated['created_by'] = auth()->id();

        Barang::create($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Barang "' . $validated['nama_barang'] . '" berhasil ditambahkan.');
    }

    public function update(Request $request, Barang $barang)    {
        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255', 'unique:barang,nama_barang,' . $barang->id],
            'kategori_id' => ['required', 'exists:categories,id'],
            'jenis_id' => ['required', 'exists:jenis,id']
        ]);

        $barang->update($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Barang "' . $barang->nama_barang . '" berhasil diperbarui.');
    }

    public function destroy(Barang $barang){
        $namaBarang = $barang->nama_barang;
        $barang->delete();

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang "' . $namaBarang . '" berhasil dihapus.');
    }

    public function getJenisByKategori($kategoriId){
        $jenis = Jenis::where('kategori_id', $kategoriId)->orderBy('name_jenis')->get();
        return response()->json($jenis);
    }

}
