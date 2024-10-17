<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Cek kredensial pengguna
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();  // Regenerasi session ID

            $role = Auth::user()->role;

            if ($role == 'admin') {
                return redirect()->route('admin.dashboard');
            } else if ($role == 'karyawan') {
                return redirect()->route('kasir.index');
            }
        }

        // Jika login gagal
        return redirect()->back()->withErrors(['email' => 'Login failed']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
