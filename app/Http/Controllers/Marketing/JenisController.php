<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Jenis;
use App\Models\Kategori;
use Illuminate\Http\Request;

class JenisController extends Controller
{
        public function index(){
        $jenis = Jenis::with('kategori')->latest()->paginate(10);
        $kategoris = Kategori::orderBy('name_kategori')->get();
        
        return view('marketing.jenis.index', compact('jenis', 'kategoris'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name_jenis' => ['required','string','max:255','unique:jenis,name_jenis'],
            'kategori_id' => ['required','exists:categories,id'
            ]
        ]); 

        Jenis::create($validated);
        
        return redirect()->route('marketing.jenis.index')->with('success', 'Jenis "' . $validated['name_jenis'] . '" berhasil ditambahkan.');
    }

    public function update(Request $request, Jenis $jeni){
        $validated = $request->validate([
            'name_jenis' => ['required', 'string', 'max:255', 'unique:jenis,name_jenis,' . $jeni->id],
            'kategori_id' => ['required', 'exists:categories,id']
        ]);

        $jeni->update($validated);

        return redirect()->route('marketing.jenis.index')->with('success', 'Jenis "' . $jeni->name_jenis . '" berhasil diperbarui.');
    }

    public function destroy(Jenis $jeni){
        // Cek apakah masih dipakai di tabel barang
        if ($jeni->barang()->exists()) {
            return redirect()->route('marketing.jenis.index')
                ->with('error', 'Jenis tidak dapat dihapus karena masih digunakan pada data barang.');
        }

        $namaJenis = $jeni->name_jenis;
        $jeni->delete();

        return redirect()->route('marketing.jenis.index')
            ->with('success', 'Jenis "' . $namaJenis . '" berhasil dihapus.');
    }
}
