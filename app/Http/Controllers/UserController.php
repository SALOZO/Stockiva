<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $users = User::paginate(10);
        return view('admin.user.index',compact('users'));
    }

    public function create(){
        return view('admin.user.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'jabatan' => 'required|in:Admin,Direktur,Marketing,Gudang,Keuangan',
            'no_telp' => 'required|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'jabatan' => $request->jabatan,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show($id){
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    public function destroy($id){
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }

    public function edit($id){
            $user = User::findOrFail($id);
            return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'jabatan' => 'required|in:Admin,Marketing,Gudang,Keuangan',
            'no_telp' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $passwordChanged = $request->filled('password');

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->no_telp,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        if ($passwordChanged) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
        }

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }
}
