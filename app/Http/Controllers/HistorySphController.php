<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Services\SPHGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistorySphController extends Controller
{
    public function index(Request $request){
        $query = Pesanan::with(['client', 'createdBy', 'approvedBy', 'details'])->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('sph_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('nama_client', 'like', "%{$search}%");
                  });
            });
        }
        $sphList = $query->paginate(15)->withQueryString();

        // Tentukan layout berdasarkan role user
        $layout = $this->getLayoutByRole();

        return view('history-sph.index', compact('sphList', 'layout'));
    }

    public function preview($id){
        $pesanan = Pesanan::findOrFail($id);
        
        // CEK STATUS
        if ($pesanan->sph_status == 'disetujui' && $pesanan->sph_approved_file) {
            // Tampilkan file approved
            $file = $pesanan->sph_approved_file;
            $path = storage_path('app/private/' . $file);
        } else {
            // Untuk status lain (draft, menunggu, ditolak), generate preview real-time
            $generator = new SPHGenerator();
            $pdf = $generator->generatePreview($pesanan);
            return $pdf->stream('preview-' . $pesanan->no_pesanan . '.pdf');
        }
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($file) . '"'
        ]);
    }
    public function download(Pesanan $pesanan){
        $file = $pesanan->sph_approved_file ?? $pesanan->sph_file;
        
        if (!$file || !Storage::exists($file)) {
            abort(404, 'File tidak ditemukan');
        }
        
        return Storage::download($file);
    }

    private function getLayoutByRole(){
        $user = auth()->user();
        
        return match($user->jabatan) {
            'Marketing' => 'layouts.marketing',
            'Direktur'  => 'layouts.direktur',
            'Gudang'    => 'layouts.gudang',
            default     => 'layouts.app'
        };
    }

}
