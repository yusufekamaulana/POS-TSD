@extends('layouts.app')

@section('content')

<!-- Product Categories Table -->
<div class="card mb-4">
    <div class="card-body">
        <h3 class="text-primary fw-bold">Kategori Produk</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Total Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Elektronik</td>
                    <td>1000</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" onclick="editCategory(1)">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteCategory(1)">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Fashion</td>
                    <td>1000</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" onclick="editCategory(2)">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteCategory(2)">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Olahraga</td>
                    <td>1000</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" onclick="editCategory(3)">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteCategory(3)">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Book Collection-->
<div class="card">
    <div class="card-body">
        <!-- Flexbox container to align H3 and button on the same row -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary fw-bold">Daftar Produk</h3>
            <button type="button" class="btn btn-success btn-icon-text text-white" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="mdi mdi-loupe btn-icon-prepend"></i>Tambah Produk
            </button>
        </div>
        
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="input-group shadow-sm w-100">
                    <input type="search" class="form-control p-3" placeholder="Keywords" aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="btn-group w-100">
                    <button type="button" class="btn btn-primary">Kategori</button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownCategoryButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu" aria-labelledby="dropdownCategoryButton">
                        <h6 class="dropdown-header">Kategori</h6>
                        <a class="dropdown-item" href="#">Elektronik</a>
                        <a class="dropdown-item" href="#">Fashion</a>
                        <a class="dropdown-item" href="#">Olahraga</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Semua Kategori</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="btn-group w-100">
                    <button type="button" class="btn btn-info text-white">Urutkan</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split text-white" id="dropdownSortingButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu" aria-labelledby="dropdownSortingButton">
                        <h6 class="dropdown-header">Sort by</h6>
                        <a class="dropdown-item" href="#">Nothing</a>
                        <a class="dropdown-item" href="#">Popularity</a>
                        <a class="dropdown-item" href="#">Organic</a>
                        <a class="dropdown-item" href="#">Fantastic</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-2 justify-content-left">
                    <div class="col-md-4 col-lg-2 col-xl-2">
                        <div class="rounded position-relative fruite-item h-100 clickable-box shadow-lg" onclick="#">
                            <div class="book-img">
                                <img src="assets/images/demo/icon-menu.jpg" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-dark px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Produk 1</div>
                            <div class="p-2 border bg-light border-light border-top-0 rounded-bottom d-flex flex-column">
                                <h5 class="text-wrapped text-center">Nama Produk 1</h5>
                                <span class="text-wrapped text-center">Rp. 100.000</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2 col-xl-2">
                        <div class="rounded position-relative fruite-item h-100 clickable-box shadow-lg" onclick="#">
                            <div class="book-img">
                                <img src="assets/images/demo/icon-menu.jpg" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-dark px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Produk 2</div>
                            <div class="p-2 border bg-light border-light border-top-0 rounded-bottom d-flex flex-column">
                                <h5 class="text-wrapped text-center">Nama Produk 2</h5>
                                <span class="text-wrapped text-center">Rp. 200.000</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2 col-xl-2">
                        <div class="rounded position-relative fruite-item h-100 clickable-box shadow-lg" onclick="#">
                            <div class="book-img">
                                <img src="assets/images/demo/icon-menu.jpg" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-dark px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Produk 3</div>
                            <div class="p-2 border bg-light border-light border-top-0 rounded-bottom d-flex flex-column">
                                <h5 class="text-wrapped text-center">Nama Produk 3</h5>
                                <span class="text-wrapped text-center">Rp. 300.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Product -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="category_id" required>
                            <option value="">Pilih Kategori</option>
                            <option value="1">Elektronik</option>
                            <option value="2">Fashion</option>
                            <option value="3">Olahraga</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity_in_stock" class="form-label">Jumlah Stok</label>
                        <input type="number" class="form-control" id="quantity_in_stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveProductBtn">Simpan Produk</button>
            </div>
        </div>
    </div>
</div>

@endsection
