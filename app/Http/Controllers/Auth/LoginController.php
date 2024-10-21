<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index ()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|min:8',
        ], [
            'login.required' => 'Email atau username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
        ]);
    
        // Cek apakah input login berupa email atau username
        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        // Coba login user menggunakan email atau username
        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();
    
            // Redirect ke dashboard atau halaman lain
            return redirect()->intended('/')->with('success', 'Anda berhasil login.');
        }
    
        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'login' => 'Email, username, atau password tidak cocok.',
        ])->withInput();
    }    
}
