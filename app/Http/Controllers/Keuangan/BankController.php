<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\BankPerusahaan;
use Illuminate\Http\Request;

class BankController extends Controller
{
      public function index()
    {
        $banks = BankPerusahaan::orderBy('is_active', 'desc')
            ->orderBy('nama_bank')
            ->get();
        return view('keuangan.bank.index', compact('banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:100',
            'cabang' => 'nullable|string|max:100',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:100',
        ]);

        if ($request->is_active) {
            BankPerusahaan::where('id', '!=', $request->id)->update(['is_active' => false]);
        }

        BankPerusahaan::create($request->all());

        return redirect()->route('keuangan.bank.index')
            ->with('success', 'Bank berhasil ditambahkan.');
    }

    public function update(Request $request, $id){
        $bank = BankPerusahaan::findOrFail($id);
        
        $request->validate([
            'nama_bank' => 'required|string|max:100',
            'cabang' => 'nullable|string|max:100',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:100',
        ]);

        $isActive = $request->is_active == 1;

        if ($isActive) {
            BankPerusahaan::where('id', '!=', $id)
                ->update(['is_active' => false]);
        }

        $bank->update([
            'nama_bank' => $request->nama_bank,
            'cabang' => $request->cabang,
            'nomor_rekening' => $request->nomor_rekening,
            'atas_nama' => $request->atas_nama,
            'is_active' => $isActive,
        ]);

        return redirect()->route('keuangan.bank.index')
            ->with('success', 'Bank berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bank = BankPerusahaan::findOrFail($id);
        $bank->delete();
        return redirect()->route('keuangan.bank.index')
            ->with('success', 'Bank berhasil dihapus.');
    }
}
