<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\SphSetting;
use Illuminate\Http\Request;

class SphSettingController extends Controller
{
    public function index(){
        $settings = SphSetting::orderBy('key')->get();
        return view('direktur.sph-settings.index', compact('settings'));
    }

    public function update(Request $request, SphSetting $setting){
        $request->validate([
            'value' => 'required'
        ]);

        $setting->update([
            'value' => $request->value
        ]);

        return redirect()->route('direktur.sph-settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }

}
