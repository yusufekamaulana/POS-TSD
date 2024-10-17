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
                            <input type="text" class="form-control h-50" id="search-product" placeholder="Cari Produk" aria-label="search" aria-describedby="search">
                            <div class="input-group-prepend hover-cursor h-50">
                                <span class="input-group-text bg-primary text-white h-100 d-flex align-items-center justify-content-center">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="search-results" class="dropdown-menu mt-2" aria-labelledby="search-product"></div>
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
            let paymentMethod = document.getElementById('paymentDropdown').textContent.trim();
            console.log(paymentMethod);
            document.getElementById('paymentMethod').textContent = paymentMethod;
            
            var myModal = new bootstrap.Modal(document.getElementById('receiptModal'));
            myModal.show();

            let tableRows = document.querySelectorAll('table tbody tr');
            let products = [];

            tableRows.forEach(function(row) {
                let productId = row.cells[1].textContent;
                let quantity = row.cells[4].querySelectorAll('input.form-control')[0].value;
                let price = row.cells[6].textContent.replace('Rp ', '').replace('.', '');
                console.log(quantity)

                products.push({
                    id: productId,
                    quantity: quantity,
                    price: price,
                });
            });

            fetch('{{ route('kasir.prosespembayaran') }}', {
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
                    console.log('Payment processed');
                } else {
                    alert('Error processing payment.');
                }
            })
            .catch(error => console.error('Error:', error));
        });

        document.getElementById('qris').addEventListener('click', function() {
            let paymentMethod = 'Pembayaran QRIS';
            document.getElementById('paymentDropdown').textContent = paymentMethod;
        });

        document.getElementById('cash').addEventListener('click', function() {
            let paymentMethod = 'Pembayaran Tunai';
            document.getElementById('paymentDropdown').textContent = paymentMethod;
        });

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
                                    <div class="dropdown-item product-result mb-2" data-id="${product.product_id}" data-name="${product.product_name}" data-price="${product.price}" data-quantity="${product.quantity_in_stock}">
                                        <p class="mb-0"><strong>${product.product_name}</strong></p>
                                        <p class="mb-0">ID: ${product.product_id}</p>
                                        <p class="mb-0">Harga: Rp ${product.price}</p>
                                        <p class="mb-0">Stock: Rp ${product.quantity_in_stock}</p>
                                    </div>`;
                                searchResults.innerHTML += resultItem;
                                
                            });
                        } else {
                            searchResults.innerHTML = '<p>No products found</p>';
                        }
                    })
                    .catch(error => console.error('Error:', error));
                searchResults.classList.add('show'); 
            } else {
                searchResults.innerHTML = '';
                searchResults.classList.remove('show'); 
            }
        });

        let quantityInput = document.querySelectorAll('quantity-input');

        function updateTotal() {
            let tableRows = document.querySelectorAll('table tbody tr');
            let grandTotal = 0;

            tableRows.forEach(function(row) {
                let priceCell = row.cells[3].textContent.replace('Rp ', '');
                let quantityInput = row.querySelector('input.quantity-input');
                let quantity = quantityInput ? quantityInput.value : 0;

                // Calculate total for this row
                let total = (parseFloat(priceCell) * parseInt(quantity)) || 0;

                // Update the total cell for this row
                row.cells[6].textContent = 'Rp ' + total.toLocaleString().replace(',', ''); // Update total column with formatted total

                // Add to grand total
                grandTotal += total;
            });

            // Update the grand total in the summary section
            document.querySelector('.font-weight-bold.mb-0').textContent = 'Rp ' + grandTotal.toLocaleString(); // Assuming this is where the total is displayed
        }

        // Add event listeners to quantity inputs after adding rows
        document.querySelector('table tbody').addEventListener('input', function(event) {
            if (event.target.classList.contains('quantity-input')) {
                updateTotal(); // Call updateTotal when quantity changes
            }
        });

        searchResults.addEventListener('click', function(event) {
            if (event.target.closest('.product-result')) {
                let selectedProduct = event.target.closest('.product-result');
                let productId = selectedProduct.getAttribute('data-id');
                let productName = selectedProduct.getAttribute('data-name');
                let productPrice = selectedProduct.getAttribute('data-price').replace('.00', '');
                let productStock = selectedProduct.getAttribute('data-quantity');

                // Add the product to the table
                let tableBody = document.querySelector('table tbody');
                let newRow = `
                    <tr>
                        <td><img src="../../assets/images/default-product.jpg" alt="${productName}" style="width: 50px; height: 50px;"></td>
                        <td>${productId}</td>
                        <td>${productName}</td>
                        <td>Rp ${productPrice}</td>
                        <td><input type="number" value="1" class="form-control quantity-input" min="1" max="${productStock}"></td>
                        <td>0</td>
                        <td>Rp ${productPrice}</td>
                    </tr>`;
                tableBody.insertAdjacentHTML('beforeend', newRow);

                // Clear the search input and results
                searchInput.value = '';
                searchResults.innerHTML = '';
                searchResults.classList.remove('show'); // Hide dropdown
            }
        });

        
    });

</script>

@endsection