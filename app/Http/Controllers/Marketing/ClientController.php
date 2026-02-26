<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(){
        $clients = Client::latest()->paginate(10);
        return view('marketing.Clients.index', compact('clients'));
    }

    public function show(Client $client){
        return view('marketing.Clients.show', compact('client'));
    }

    public function create(){
        return view('marketing.Clients.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nama_client' => 'required|string|max:255',
            'provinsi' => 'required|string', 
            'kabupaten_kota' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'alamat' => 'required|string',
            'nama_pic' => 'required|string|max:255',
            'jabatan_pic' => 'required|string|max:100',
            'email_pic' => 'nullable|email|max:255',
            'no_telp_pic' => 'nullable|string|max:20',
        ]);

        
        $validated['created_by'] = auth()->id();
        
        Client::create($validated);

        return redirect()->route('marketing.clients.index')
            ->with('success', 'Client berhasil ditambahkan.');
    }

    public function edit(Client $client){
        return view('marketing.Clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client){
    $validated = $request->validate([
        'nama_client' => 'required|string|max:255',
        'provinsi' => 'required|string',
        'kabupaten_kota' => 'required|string',
        'kecamatan' => 'required|string',
        'desa' => 'required|string',
        'alamat' => 'required|string',
        'nama_pic' => 'required|string|max:255',
        'jabatan_pic' => 'required|string|max:100',
        'email_pic' => 'nullable|email|max:255',
        'no_telp_pic' => 'nullable|string|max:20',
    ]);

    $client->update($validated);

    return redirect()->route('marketing.clients.index', $client->id)
        ->with('success', 'Client berhasil diperbarui.');
    }

    public function destroy(Client $client){
        $client->delete();
        return redirect()->route('marketing.clients.index')
            ->with('success', 'Client berhasil dihapus.');
    }
}
