@extends('layouts.app')

@section('content')
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
                                <th> Aksi </th> <!-- Kolom aksi untuk tambah stok, kurang stok, cetak barcode -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-1">
                                    <img src="../../assets/images/samples/300x300/1.jpg" alt="image" class="w-20 h-25 object-cover rounded">
                                </td>
                                <td> PRD001 </td>
                                <td> Nama Barang 1 </td>
                                <td> 100 </td> <!-- Stok produk -->
                                <td>
                                    <!-- Tombol Aksi -->
                                    <button class="btn btn-success btn-sm tambah-stok" data-bs-toggle="modal" data-bs-target="#stokModal" data-mode="tambah" data-kode="PRD001" data-nama="Nama Barang 1" data-gambar="../../assets/images/samples/300x300/1.jpg">
                                        Tambah Stok
                                    </button>
                                    <button class="btn btn-warning btn-sm kurang-stok" data-bs-toggle="modal" data-bs-target="#stokModal" data-mode="kurang" data-kode="PRD001" data-nama="Nama Barang 1" data-gambar="../../assets/images/samples/300x300/1.jpg">
                                        Kurang Stok
                                    </button>
                                    <button class="btn btn-primary btn-sm cetak-barcode" data-kode="PRD001">
                                        Cetak Barcode
                                    </button>
                                </td>
                            </tr>
                            <!-- Tambahkan baris produk lain di sini -->
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
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img id="gambarProduk" src="" alt="image" class="w-50 h-50 object-cover rounded">
                    </div>
                    <p><strong>Kode Barang:</strong> <span id="kodeProduk"></span></p>
                    <p><strong>Nama Barang:</strong> <span id="namaProduk"></span></p>
                    <div class="form-group">
                        <label for="jumlahStok" id="labelJumlah">Jumlah Stok</label>
                        <input type="number" id="jumlahStok" class="form-control" placeholder="Masukkan jumlah">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="submitStok">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

                // Reset jumlah stok input
                document.getElementById('jumlahStok').value = '';
                
                // Set placeholder dan label sesuai mode
                document.getElementById('jumlahStok').placeholder = (mode === 'tambah' ? 'Masukkan jumlah penambahan' : 'Masukkan jumlah pengurangan');
                document.getElementById('labelJumlah').textContent = (mode === 'tambah' ? 'Jumlah Penambahan Stok' : 'Jumlah Pengurangan Stok');
            });
        });

        // Event listener untuk simpan stok
        document.getElementById('submitStok').addEventListener('click', function() {
            let jumlah = document.getElementById('jumlahStok').value;
            let kode = document.getElementById('kodeProduk').textContent;

            if (jumlah === '' || jumlah <= 0) {
                alert('Masukkan jumlah yang valid');
                return;
            }

            // Lakukan request untuk menambah/kurang stok di sini (gunakan AJAX atau kirim form)
            console.log('Kode Barang:', kode);
            console.log('Jumlah Stok:', jumlah);

            // Tutup modal setelah simpan
            var stokModal = new bootstrap.Modal(document.getElementById('stokModal'));
            stokModal.hide();
        });

        // Event listener untuk cetak barcode
        document.querySelectorAll('.cetak-barcode').forEach(function(button) {
            button.addEventListener('click', function() {
                let kode = this.getAttribute('data-kode');
                // Lakukan aksi untuk mencetak barcode (misal membuka halaman cetak)
                console.log('Cetak Barcode untuk Kode:', kode);
            });
        });
    });
</script>

@endsection
