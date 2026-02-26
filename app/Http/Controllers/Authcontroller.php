<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authcontroller extends Controller
{
    public function showLoginForm(){
        return view('Login');
    }

    public function authenticate(Request $request){
        $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);

        $loginInput = $request->input('login');
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // CEK JABATAN USER
            $user = Auth::user();
            
            // Redirect berdasarkan jabatan
            if ($user->jabatan === 'Marketing') {
                return redirect()->intended('/marketing/dashboard');
            } else {
                // Admin
                return redirect()->intended('/admin/user');
            }
        }

        return back()->withErrors([
            'login' => 'Email / Username atau password salah.',
        ])->onlyInput('login');
    }
    
    public function logout(Request $request){
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}