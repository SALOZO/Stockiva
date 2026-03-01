<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(){
        return view('direktur.profile');
    }

        public function uploadTtd(Request $request)
    {
        $request->validate([
            'ttd' => 'required|image|mimes:png|max:1024'
        ]);

        $user = auth()->user();
        
        if ($user->ttd_path && Storage::exists($user->ttd_path)) {
            Storage::delete($user->ttd_path);
        }

        $path = $request->file('ttd')->store('signatures', 'public');
        
        $user->update(['ttd_path' => $path]);

        return back()->with('success', 'Tanda tangan berhasil diupload.');
    }
}
