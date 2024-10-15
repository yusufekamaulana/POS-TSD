<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('contents.index');
});

Route::get('/kasir', function () {
    return view('contents.kasir');
});

Route::get('/produk', function () {
    return view('contents.produk');
});

Route::get('/stok', function () {
    return view('contents.stok');
});