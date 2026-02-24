<?php

namespace App\Http\Controllers;

use App\Models\Ekspedisi;
use Illuminate\Http\Request;

class EkspedisiController extends Controller
{
    public function index(){
        $ekspedisi = Ekspedisi::with('createdBy')->latest()->paginate(10);
        return view('admin.ekspedisi.index', compact('ekspedisi'));
    }

    public function create(){
        return view('admin.ekspedisi.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nama_ekspedisi' => ['required', 'string', 'max:255', 'unique:ekspedisi,nama_ekspedisi'],
            'provinsi' => ['required', 'string'],
            'kabupaten_kota' => ['required', 'string'],
            'kecamatan' => ['required', 'string'],
            'desa' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'nama_pic' => ['required', 'string', 'max:255'],
            'no_telp_pic' => ['required', 'string', 'max:20'],
            'email_pic' => ['required', 'string', 'max:255']
        ]);

        $validated['created_by'] = auth()->id();

        Ekspedisi::create($validated);

        return redirect()->route('admin.ekspedisi.index')->with('success', 'Ekspedisi "' . $validated['nama_ekspedisi'] . '" berhasil ditambahkan.');
    }

    public function show(Ekspedisi $ekspedisi){
        return view('admin.ekspedisi.show', compact('ekspedisi'));
    }

    public function edit(Ekspedisi $ekspedisi){
        return view('admin.ekspedisi.edit', compact('ekspedisi'));
    }

    public function update(Request $request, Ekspedisi $ekspedisi){
        $validated = $request->validate([
            'nama_ekspedisi' => ['required', 'string', 'max:255', 'unique:ekspedisi,nama_ekspedisi,' . $ekspedisi->id],
            'provinsi' => ['required', 'string'],
            'kabupaten_kota' => ['required', 'string'],
            'kecamatan' => ['required', 'string'],
            'desa' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'nama_pic' => ['required', 'string', 'max:255'],
            'no_telp_pic' => ['required', 'string', 'max:20'],
            'email_pic' => ['required', 'string', 'max:255']
        ]);

        $ekspedisi->update($validated);

        return redirect()->route('admin.ekspedisi.index')->with('success', 'Ekspedisi "' . $ekspedisi->nama_ekspedisi . '" berhasil diperbarui.');
    }

    public function destroy(Ekspedisi $ekspedisi){
        $namaEkspedisi = $ekspedisi->nama_ekspedisi;
        $ekspedisi->delete();

        return redirect()->route('admin.ekspedisi.index')->with('success', 'Ekspedisi "' . $namaEkspedisi . '" berhasil dihapus.');
    }

}
