<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoryController extends Controller
{
     public function index(){
        $kategoris = Kategori::latest()->paginate(10);
        return view('marketing.kategori.index', compact('kategoris'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name_kategori' => 'required|string|max:255|unique:categories,name_kategori'
        ]);

        Kategori::create($validated);

        return redirect()->route('marketing.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori){
        $validated = $request->validate([
            'name_kategori' => 'required|string|max:255|unique:categories,name_kategori,' . $kategori->id
        ]);

        $kategori->update($validated);

        return redirect()->route('marketing.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori){
        // Cek apakah masih dipakai di tabel jenis
        if ($kategori->jenis()->exists()) {
            return redirect()->route('marketing.kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data jenis.');
        }

        $kategori->delete();

        return redirect()->route('marketing.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
