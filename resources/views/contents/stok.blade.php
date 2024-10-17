@extends('layouts.app')

@section('content')
<!-- Alert Sukses -->
@if (session('success'))
    <div class="alert alert-success" id="success-message">
        {{ session('success') }}
    </div>
@endif

<!-- Alert Gagal -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div id="content-placeholder">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mt-2">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> Gambar Produk </th>
                                <th> Kode Barang </th>
                                <th> Nama Barang </th>
                                <th> Stok </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="py-1">
                                    <img src="{{ asset($product->gambar) }}" alt="{{ $product->product_name }}" class="w-20 h-25 object-cover rounded">
                                </td>
                                <td> {{ $product->product_id }} </td>
                                <td> {{ $product->product_name }} </td>
                                <td> {{ $product->quantity_in_stock }} </td>
                                <td>
                                    <!-- Tombol Tambah Stok -->
                                    <button class="btn btn-success btn-sm tambah-stok" data-bs-toggle="modal" data-bs-target="#stokModal" data-mode="tambah" data-kode="{{ $product->product_id }}" data-nama="{{ $product->product_name }}" data-gambar="{{ asset($product->gambar) }}">
                                        Tambah Stok
                                    </button>
                                    <!-- Tombol Kurang Stok -->
                                    <button class="btn btn-warning btn-sm kurang-stok" data-bs-toggle="modal" data-bs-target="#stokModal" data-mode="kurang" data-kode="{{ $product->product_id }}" data-nama="{{ $product->product_name }}" data-gambar="{{ asset($product->gambar) }}">
                                        Kurang Stok
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Tambah/Kurang Stok -->
    <div class="modal fade" id="stokModal" tabindex="-1" aria-labelledby="stokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stokModalLabel">Update Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Form stok -->
                <form id="stokForm" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img id="gambarProduk" src="" alt="image" class="w-50 h-50 object-cover rounded">
                        </div>
                        <p><strong>Kode Barang:</strong> <span id="kodeProduk"></span></p>
                        <p><strong>Nama Barang:</strong> <span id="namaProduk"></span></p>
                        <input type="hidden" id="product_id" name="product_id">
                        <input type="hidden" id="mode" name="mode">
                        <div class="form-group">
                            <label for="jumlahStok" id="labelJumlah">Jumlah Stok</label>
                            <input type="number" id="jumlahStok" name="jumlah_stok" class="form-control" placeholder="Masukkan jumlah">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hide the success message after 2 seconds
        if (document.getElementById('success-message')) {
            setTimeout(function () {
                document.getElementById('success-message').style.display = 'none';
            }, 2000);  // 2 seconds delay
        }

        // Reload page after form submission for adding product
        const addProductForm = document.getElementById('addProductForm');
        if (addProductForm) {
            addProductForm.addEventListener('submit', function (event) {
                setTimeout(function () {
                    location.reload();  // Reload after 2 seconds
                }, 2000);  // 2 seconds delay
            });
        }

        // Event listener untuk membuka modal tambah/kurang stok
        document.querySelectorAll('.tambah-stok, .kurang-stok').forEach(function(button) {
            button.addEventListener('click', function() {
                let mode = this.getAttribute('data-mode');
                let kode = this.getAttribute('data-kode');
                let nama = this.getAttribute('data-nama');
                let gambar = this.getAttribute('data-gambar');

                // Set modal title
                document.getElementById('stokModalLabel').textContent = (mode === 'tambah' ? 'Tambah' : 'Kurang') + ' Stok';

                // Set data di modal
                document.getElementById('kodeProduk').textContent = kode;
                document.getElementById('namaProduk').textContent = nama;
                document.getElementById('gambarProduk').src = gambar;
                document.getElementById('product_id').value = kode;
                document.getElementById('mode').value = mode;

                // Reset jumlah stok input
                document.getElementById('jumlahStok').value = '';
                
                // Set placeholder dan label sesuai mode
                document.getElementById('jumlahStok').placeholder = (mode === 'tambah' ? 'Masukkan jumlah penambahan' : 'Masukkan jumlah pengurangan');
                document.getElementById('labelJumlah').textContent = (mode === 'tambah' ? 'Jumlah Penambahan Stok' : 'Jumlah Pengurangan Stok');

                // Set action form dengan id produk
                document.getElementById('stokForm').action = "{{ url('stok') }}/" + kode;
            });
        });

        // Reload page after form submission for updating stock
        const stokForm = document.getElementById('stokForm');
        if (stokForm) {
            stokForm.addEventListener('submit', function (event) {
                setTimeout(function () {
                    location.reload();  // Reload after 2 seconds
                }, 2000);  // 2 seconds delay
            });
        }
    });
</script>

@endsection
