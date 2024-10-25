<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('contents.dashboard'); // Tampilkan view untuk dashboard karyawan
    }

    public function ManageStock()
    {
        return view('contents.stok'); // Tampilkan view untuk dashboard karyawan
    }

    public function ManageProduct()
    {
        return view('contents.produk'); // Tampilkan view untuk dashboard karyawan
    }

    public function ManagePegawai()
    {
        return view('contents.pegawai'); // Tampilkan view untuk dashboard karyawan
    }

    public function Kasir()
    {
        return view('contents.kasir'); // Tampilkan view untuk dashboard karyawan
    }
}
