<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
        public function index(){
        $satuans = Satuan::with('createdBy')->latest()->paginate(10);
        return view('marketing.satuan.index', compact('satuans'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_satuan' => 'required|unique:satuans,nama_satuan'
        ]);

        Satuan::create([
            'nama_satuan' => $request->nama_satuan,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('marketing.satuan.index')->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function update(Request $request, Satuan $satuan){
        $request->validate([
            'nama_satuan' => 'required|unique:satuans,nama_satuan,' . $satuan->id
        ]);

        $satuan->update([
            'nama_satuan' => $request->nama_satuan
        ]);

        return redirect()->route('marketing.satuan.index')->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy(Satuan $satuan){
        // Cek apakah masih digunakan di barang
        if ($satuan->barang()->count() > 0) {
            return redirect()->route('marketing.satuan.index')->with('error', 'Satuan tidak dapat dihapus karena masih digunakan.');
        }

        $satuan->delete();

        return redirect()->route('marketing.satuan.index')->with('success', 'Satuan berhasil dihapus.');
    }
}
