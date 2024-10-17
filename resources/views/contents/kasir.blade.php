@extends('layouts.app')

@section('content')

<div id="content-placeholder">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <h2 class="text-primary font-weight-bold mb-0">Kasir</h2>
                        <p class="card-description mt-0">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                    </div>
                    <!-- Search Bar -->
                    <div class="col-lg-6 col-md-6 d-flex justify-content-end">
                        <div class="input-group rounded-lg shadow-sm" style="max-width: 300px; max-height: 35px;">
                            <input type="text" class="form-control h-50" id="search-product" placeholder="Cari Produk" aria-label="search" aria-describedby="search">
                            <div class="input-group-prepend hover-cursor h-50">
                                <span class="input-group-text bg-primary text-white h-100 d-flex align-items-center justify-content-center">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6 d-flex justify-content-end mt-0">
                        <div class="input-group rounded-lg shadow-sm" style="max-width: 300px; max-height: 35px;">
                            <div id="search-results" class="dropdown-menu mt-0 position-absolute w-100" aria-labelledby="search-product"></div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> Gambar Produk </th>
                                <th> Kode Barang </th>
                                <th> Nama Barang </th>
                                <th> Harga </th>
                                <th> Jumlah </th>
                                <th> Total </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <!-- Total Pembayaran -->
                <div class="mt-4 d-flex justify-content-end">
                    <div class="col-lg-4">
                        <div class="border p-3 rounded bg-primary text-white">
                            <h4 class="font-weight-bold mb-1">Total Pembayaran:</h4>
                            <h3 class="font-weight-bold mb-0" id="total-payment">Rp 0</h3>
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
                    <button type="button" class="btn btn-success btn-lg text-white" id="processPaymentBtn" disabled>Proses Pembayaran</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal for Receipt -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Isi Modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Transaksi Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Icon Sukses -->
                    <i class="mdi mdi-checkbox-marked-circle-outline" style="color: green; font-size: 100px;"></i>
                    <p class="mt-3"><strong>Total Pembayaran:</strong> <span id="modal-total-payment">Rp 0</span></p>
                    <p><strong>Metode Pembayaran:</strong> <span id="paymentMethod"></span></p>
                    <p>Cetak struk ini sebagai bukti pembayaran!</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Cetak Struk</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk memperbarui total pembayaran
        function updateTotal() {
            let tableRows = document.querySelectorAll('table tbody tr');
            let grandTotal = 0;

            tableRows.forEach(function(row) {
                let priceCell = row.cells[3].textContent.replace('Rp ', '').replace('.', '').replace(',', '');
                let quantityInput = row.querySelector('input.quantity-input');
                let quantity = quantityInput ? parseInt(quantityInput.value) : 0;

                // Hitung total per baris
                let total = (parseFloat(priceCell) * quantity) || 0;

                // Perbarui sel total per baris
                row.cells[5].textContent = 'Rp ' + total.toLocaleString('id-ID');

                // Tambahkan ke grand total
                grandTotal += total;
            });

            // Perbarui total pembayaran
            document.getElementById('total-payment').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        // Ambil elemen tombol dan dropdown
        const processPaymentBtn = document.getElementById('processPaymentBtn');
        const paymentDropdown = document.getElementById('paymentDropdown');

        function checkProductInTable() {
            let tableRows = document.querySelectorAll('table tbody tr');
            return tableRows.length > 0; // Mengembalikan true jika ada produk di tabel
        }


        function updatePaymentButtonState() {
            let paymentMethodSelected = paymentDropdown.textContent.trim() !== 'Pilih Metode Pembayaran';
            let hasProducts = checkProductInTable();

            // Aktifkan tombol hanya jika metode pembayaran dipilih dan ada produk di tabel
            processPaymentBtn.disabled = !(paymentMethodSelected && hasProducts);
        }


        // Event listener untuk pilihan metode pembayaran
        document.getElementById('qris').addEventListener('click', function() {
            let paymentMethod = 'Pembayaran QRIS';
            paymentDropdown.textContent = paymentMethod;
            updatePaymentButtonState(); // Perbarui status tombol setelah memilih metode
        });

        document.getElementById('cash').addEventListener('click', function() {
            let paymentMethod = 'Pembayaran Tunai';
            paymentDropdown.textContent = paymentMethod;
            updatePaymentButtonState(); // Perbarui status tombol setelah memilih metode
        });

        // Event listener untuk tombol Proses Pembayaran
        document.querySelector('.btn-success').addEventListener('click', function() {
            let paymentMethod = document.getElementById('paymentDropdown').textContent.trim();
            document.getElementById('paymentMethod').textContent = paymentMethod;

            // Perbarui total pembayaran di modal
            let totalPayment = document.getElementById('total-payment').textContent;
            document.getElementById('modal-total-payment').textContent = totalPayment;

            var myModal = new bootstrap.Modal(document.getElementById('receiptModal'));
            myModal.show();

            let tableRows = document.querySelectorAll('table tbody tr');
            let products = [];

            tableRows.forEach(function(row) {
                let productId = row.cells[1].textContent;
                let quantity = row.cells[4].querySelector('input.form-control').value;
                let price = row.cells[5].textContent.replace('Rp ', '').replace('.', '').replace(',', '');

                products.push({
                    id: productId,
                    quantity: quantity,
                    price: price,
                });
            });

            fetch('{{ route('kasir.prosespembayaran')}}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            payment_method: paymentMethod,
                            products: products
                        })
                    })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Pembayaran berhasil diproses.');
                    } else {
                        alert('Terjadi kesalahan saat memproses pembayaran.');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Event listener untuk pilihan metode pembayaran
        document.getElementById('qris').addEventListener('click', function() {
            let paymentMethod = 'Pembayaran QRIS';
            document.getElementById('paymentDropdown').textContent = paymentMethod;
        });

        document.getElementById('cash').addEventListener('click', function() {
            let paymentMethod = 'Pembayaran Tunai';
            document.getElementById('paymentDropdown').textContent = paymentMethod;
        });

        // Fungsi pencarian produk
        let searchInput = document.getElementById('search-product');
        let searchResults = document.getElementById('search-results');

        searchInput.addEventListener('keyup', function() {
            let query = searchInput.value.trim();

            if (query.length > 0) {
                fetch(`{{ route('kasir.search') }}?query=` + query)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';

                        if (data.length > 0) {
                            data.forEach(product => {
                                let resultItem = `
                                <div class="dropdown-item product-result mb-2" data-id="${product.product_id}" data-name="${product.product_name}" data-price="${product.harga_jual}" data-quantity="${product.quantity_in_stock}">
                                    <p class="mb-0"><strong>${product.product_name}</strong></p>
                                    <p class="mb-0">ID: ${product.product_id}</p>
                                    <p class="mb-0">Harga: Rp ${product.harga_jual}</p>
                                    <p class="mb-0">Stok: ${product.quantity_in_stock}</p>
                                </div>`;
                                searchResults.innerHTML += resultItem;
                            });
                        } else {
                            searchResults.innerHTML = '<p>Produk tidak ditemukan</p>';
                        }
                    })
                    .catch(error => console.error('Error:', error));
                searchResults.classList.add('show');
            } else {
                searchResults.innerHTML = '';
                searchResults.classList.remove('show');
            }
        });

        // Event listener untuk menambahkan produk dari hasil pencarian ke tabel
        searchResults.addEventListener('click', function(event) {
            if (event.target.closest('.product-result')) {
                let selectedProduct = event.target.closest('.product-result');
                let productId = selectedProduct.getAttribute('data-id');
                let productName = selectedProduct.getAttribute('data-name');
                let productPrice = selectedProduct.getAttribute('data-price');
                let productStock = selectedProduct.getAttribute('data-quantity');

                // Tambahkan produk ke tabel
                let tableBody = document.querySelector('table tbody');
                let newRow = `
                    <tr>
                        <td><img src="../../assets/images/default-product.jpg" alt="${productName}" style="width: 50px; height: 50px;"></td>
                        <td>${productId}</td>
                        <td>${productName}</td>
                        <td>Rp ${parseInt(productPrice).toLocaleString('id-ID')}</td>
                        <td><input type="number" value="1" class="form-control quantity-input" min="1" max="${productStock}"></td>
                        <td>Rp ${parseInt(productPrice).toLocaleString('id-ID')}</td>
                    </tr>`;
                tableBody.insertAdjacentHTML('beforeend', newRow);

                updateTotal(); // Perbarui total setelah menambahkan produk
                updatePaymentButtonState();

                // Kosongkan input pencarian dan hasil
                searchInput.value = '';
                searchResults.innerHTML = '';
                searchResults.classList.remove('show'); // Sembunyikan dropdown
            }
        });

        // Event listener untuk perubahan jumlah pada input quantity
        document.querySelector('table tbody').addEventListener('input', function(event) {
            if (event.target.classList.contains('quantity-input')) {
                updateTotal(); // Panggil updateTotal saat jumlah berubah
                updatePaymentButtonState();
            }
        });
    });
</script>

@endsection