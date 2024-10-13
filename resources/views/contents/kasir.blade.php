@extends('layouts.app')

@section('content')
<div id="content-placeholder">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Judul Kasir -->
                    <div class="col-lg-6 col-md-6">
                        <h2 class="text-primary font-weight-bold mb-0">Kasir</h2>
                        <p class="card-description mt-0">Sabtu, 12 Oktober 2024</p>
                    </div>
                    <!-- Search Bar -->
                    <div class="col-lg-6 col-md-6 d-flex justify-content-end">
                        <div class="input-group rounded-lg shadow-sm" style="max-width: 300px; max-height: 35px;">
                            <input type="text" class="form-control h-50" id="navbar-search-input"
                                placeholder="Cari Produk" aria-label="search" aria-describedby="search">
                            <div class="input-group-prepend hover-cursor h-50">
                                <span class="input-group-text bg-primary text-white h-100 d-flex align-items-center justify-content-center">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> Gambar Produk </th>
                                <th> Kode Barang </th>
                                <th> Nama Barang </th> <!-- New column for product name -->
                                <th> Harga </th>
                                <th> Jumlah </th>
                                <th> Diskon (%) </th> <!-- Kolom Diskon -->
                                <th> Total </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-1">
                                    <img src="../../assets/images/samples/300x300/1.jpg" alt="image" class="w-20 h-25 object-cover rounded">
                                </td>
                                <td> PRD001 </td>
                                <td> Nama Barang 1 </td> <!-- Product name -->
                                <td> Rp 50,000 </td>
                                <td> 2 </td>
                                <td> 10 </td> <!-- Diskon -->
                                <td> Rp 90,000 </td> <!-- Total Setelah Diskon -->
                            </tr>
                            <tr>
                                <td class="py-1">
                                    <img src="../../assets/images/samples/300x300/2.jpg" alt="image" class="w-20 h-25 object-cover rounded">
                                </td>
                                <td> PRD002 </td>
                                <td> Nama Barang 2 </td> <!-- Product name -->
                                <td> Rp 75,000 </td>
                                <td> 1 </td>
                                <td> 5 </td> <!-- Diskon -->
                                <td> Rp 71,250 </td> <!-- Total Setelah Diskon -->
                            </tr>
                            <tr>
                                <td class="py-1">
                                    <img src="../../assets/images/samples/300x300/3.jpg" alt="image" class="w-20 h-25 object-cover rounded">
                                </td>
                                <td> PRD003 </td>
                                <td> Nama Barang 3 </td> <!-- Product name -->
                                <td> Rp 120,000 </td>
                                <td> 3 </td>
                                <td> 0 </td> <!-- Tidak ada diskon -->
                                <td> Rp 360,000 </td> <!-- Total Tetap -->
                            </tr>
                            <tr>
                                <td class="py-1">
                                    <img src="../../assets/images/samples/300x300/4.jpg" alt="image" class="w-20 h-25 object-cover rounded">
                                </td>
                                <td> PRD004 </td>
                                <td> Nama Barang 4 </td> <!-- Product name -->
                                <td> Rp 200,000 </td>
                                <td> 2 </td>
                                <td> 15 </td> <!-- Diskon -->
                                <td> Rp 340,000 </td> <!-- Total Setelah Diskon -->
                            </tr>
                            <tr>
                                <td class="py-1">
                                    <img src="../../assets/images/samples/300x300/5.jpg" alt="image" class="w-20 h-25 object-cover rounded">
                                </td>
                                <td> PRD005 </td>
                                <td> Nama Barang 5 </td> <!-- Product name -->
                                <td> Rp 45,000 </td>
                                <td> 5 </td>
                                <td> 20 </td> <!-- Diskon -->
                                <td> Rp 180,000 </td> <!-- Total Setelah Diskon -->
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Perincian Total Belanja -->
                <div class="mt-4">
                    <div class="row">
                        <!-- Perincian Jumlah Asli -->
                        <div class="col-lg-4">
                            <div class="border p-3 rounded bg-light">
                                <h5 class="text-dark font-weight-bold mb-1">Jumlah Asli:</h5>
                                <p class="mb-0">Rp 1,250,000</p> <!-- Ini jumlah asli tanpa diskon -->
                            </div>
                        </div>

                        <!-- Perincian Potongan Diskon -->
                        <div class="col-lg-4">
                            <div class="border p-3 rounded bg-light">
                                <h5 class="text-dark font-weight-bold mb-1">Potongan Diskon:</h5>
                                <p class="mb-0">Rp 208,750</p> <!-- Ini jumlah total diskon -->
                            </div>
                        </div>

                        <!-- Total Pembayaran -->
                        <div class="col-lg-4">
                            <div class="border p-3 rounded bg-primary text-white">
                                <h4 class="font-weight-bold mb-1">Total Pembayaran:</h4>
                                <h3 class="font-weight-bold mb-0">Rp 1,041,250</h3> <!-- Total setelah diskon -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Opsi Pembayaran -->
                <div class="mt-4 d-flex justify-content-end">
                    <div class="dropdown">
                        <h5 class="font-weight-bold mb-3">Opsi Pembayaran</h5>
                        <button class="btn btn-inverse-primary dropdown-toggle" type="button" id="paymentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Pilih Metode Pembayaran
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="paymentDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#" id="qris" value="qris">
                                    <img src="../../assets/images/qris.png" alt="QRIS" class="me-2" style="width: 30px; height: 30px;">
                                    Pembayaran QRIS
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#" id="cash" value="cash">
                                    <img src="../../assets/images/qris.png" alt="Cash" class="me-2" style="width: 30px; height: 30px;">
                                    Pembayaran Tunai
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tombol Proses Pembayaran -->
                <div class="mt-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-lg text-white">Proses Pembayaran</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal for Receipt -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Struk Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Terima kasih atas pembayaran Anda!</p>
                    <p><strong>Jumlah Asli:</strong> Rp 1,250,000</p>
                    <p><strong>Potongan Diskon:</strong> Rp 208,750</p>
                    <p><strong>Total Pembayaran:</strong> Rp 1,041,250</p>
                    <p><strong>Metode Pembayaran:</strong> <span id="paymentMethod"></span></p>
                    <p>Silakan simpan struk ini sebagai bukti pembayaran.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Cetak Struk</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener to the payment button
        document.querySelector('.btn-success').addEventListener('click', function() {
            // Get selected payment method
            let selectedPayment = document.querySelector('.dropdown-menu .dropdown-item.active');
            let paymentMethod = selectedPayment ? selectedPayment.textContent.trim() : 'Belum dipilih';

            // Update modal with the selected payment method
            document.getElementById('paymentMethod').textContent = paymentMethod;

            // Show the modal
            var myModal = new bootstrap.Modal(document.getElementById('receiptModal'));
            myModal.show();
        });

        // Update the dropdown button text when a payment method is selected
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                let paymentMethod = item.textContent.trim();
                document.getElementById('paymentDropdown').textContent = paymentMethod;

                // Remove active class from other items
                document.querySelectorAll('.dropdown-item').forEach(i => i.classList.remove('active'));
                item.classList.add('active');
            });
        });
    });
</script>
@endsection