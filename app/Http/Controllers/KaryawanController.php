<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        return view('contents.kasir'); // Tampilkan view untuk dashboard karyawan
    }

    public function ManageStock()
    {
        return view('contents.stok'); // Tampilkan view untuk dashboard karyawan
    }

    public function ManageProduct()
    {
        return view('contents.produk'); // Tampilkan view untuk dashboard karyawan
    }
}
    