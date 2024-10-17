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

<!-- Product Categories Table -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary fw-bold">Kategori Produk</h3>
            <button type="button" class="btn btn-success btn-icon-text text-white" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="mdi mdi-loupe btn-icon-prepend"></i>Tambah Kategori
            </button>
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Total Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->category_id }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->products->sum('quantity_in_stock') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Daftar Produk -->
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary fw-bold">Daftar Produk</h3>
            <button type="button" class="btn btn-success btn-icon-text text-white" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="mdi mdi-loupe btn-icon-prepend"></i>Tambah Produk
            </button>
        </div>
        
        <div class="row g-4 mb-4" id="product-list">
            @foreach ($products as $product)
            <div class="col-md-4 col-lg-2 col-xl-2">
                <div class="rounded position-relative h-100 shadow-lg clickable-box">
                    <div class="book-img">
                        <img src="{{$product->gambar}}" class="img-fluid w-100 rounded-top" alt="{{ $product->product_name }}">
                    </div>
                    
                    <!-- Edit and Delete Icons -->
                    <div class="position-absolute top-0 end-0 p-2">
                        <!-- Edit Button -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->product_id }}" class="btn btn-sm btn-warning text-white me-2">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                        <!-- Delete Button -->
                        <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </form>
                        
                    </div>

                    <div class="text-white bg-dark px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $product->product_name }}</div>
                    <div class="p-2 border bg-light border-light border-top-0 rounded-bottom d-flex flex-column">
                        <h5 class="text-wrapped text-center">{{ $product->product_name }}</h5>
                        <span class="text-center">Rp. {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                        <p class="text-muted text-center">{{ $product->deskripsi }}</p>
                    </div>
                </div>
            </div>

            <!-- Modal for Editing Product -->
            <div class="modal fade" id="editProductModal{{ $product->product_id }}" tabindex="-1" aria-labelledby="editProductModalLabel{{ $product->product_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel{{ $product->product_id }}">Edit Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="product_name{{ $product->product_id }}" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="product_name{{ $product->product_id }}" name="product_name" value="{{ $product->product_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="category_id{{ $product->product_id }}" class="form-label">Kategori</label>
                                    <select class="form-select" id="category_id{{ $product->product_id }}" name="category_id" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->category_id }}" {{ $product->category_id == $category->category_id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="quantity_in_stock{{ $product->product_id }}" class="form-label">Jumlah Stok</label>
                                    <input type="number" class="form-control" id="quantity_in_stock{{ $product->product_id }}" name="quantity_in_stock" value="{{ $product->quantity_in_stock }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="harga_beli{{ $product->product_id }}" class="form-label">Harga Beli</label>
                                    <input type="number" class="form-control" id="harga_beli{{ $product->product_id }}" name="harga_beli" value="{{ $product->harga_beli }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="harga_jual{{ $product->product_id }}" class="form-label">Harga Jual</label>
                                    <input type="number" class="form-control" id="harga_jual{{ $product->product_id }}" name="harga_jual" value="{{ $product->harga_jual }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="gambar{{ $product->product_id }}" class="form-label">Gambar Produk</label>
                                    <input type="file" class="form-control" id="gambar{{ $product->product_id }}" name="gambar" accept=".jpg,.jpeg,.png">
                                    <img src="{{ asset($product->gambar) }}" alt="{{ $product->product_name }}" class="img-fluid mt-2" width="100"> <!-- Show existing image -->
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi{{ $product->product_id }}" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi{{ $product->product_id }}" name="deskripsi">{{ $product->deskripsi }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Produk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Produk -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Produk -->
                <form id="addProductForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity_in_stock" class="form-label">Jumlah Stok</label>
                        <input type="number" class="form-control" id="quantity_in_stock" name="quantity_in_stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept=".jpg,.jpeg,.png">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Kategori -->
                <form id="addCategoryForm" action="{{ route('products.category.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<!-- JavaScript for Auto Reload and Dismiss Success Message -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hide the success message after 2 seconds
        if (document.getElementById('success-message')) {
            setTimeout(function () {
                document.getElementById('success-message').style.display = 'none';
            }, 2000);  // 2 seconds delay
        }

        // Reload page after form submission
        document.getElementById('addProductForm').addEventListener('submit', function (event) {
            setTimeout(function () {
                location.reload();  // Reload after 2 seconds
            }, 2000);  // 2 seconds delay
        });
    });
</script>

@endsection
