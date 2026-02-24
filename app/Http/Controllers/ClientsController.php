<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index(){
        $clients = Client::with('createdBy')->latest()->paginate(10);
        return view('admin.Clients.index', compact('clients'));
    }

    public function create(){
        return view('admin.Clients.create');
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

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client berhasil ditambahkan.');
    }

    public function show(Client $client){
        return view('admin.Clients.show', compact('client'));
    }

    public function edit(Client $client){
        return view('admin.Clients.edit', compact('client'));
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

    return redirect()->route('admin.clients.index', $client->id)
        ->with('success', 'Client berhasil diperbarui.');
    }

    public function destroy(Client $client){
        $client->delete();
        return redirect()->route('admin.clients.index')
            ->with('success', 'Client berhasil dihapus.');
    }
}
