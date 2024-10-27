<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KaryawanController extends Controller
{
    public function index() {
        return view('contents.pegawai');
    }

    public function create() {
        return view('contents.create'); // Ganti dengan path view yang sesuai
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // Buat akun karyawan baru
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'karyawan',
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Akun karyawan berhasil dibuat.');
    }
}
