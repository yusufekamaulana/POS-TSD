<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_id')->primary();  // Primary Key
            $table->string('product_name')->unique();
            $table->unsignedBigInteger('category_id');  // Foreign key ke categories table
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->integer('quantity_in_stock')->default(0);  // Jumlah stok
            $table->decimal('harga_beli', 10, 2);  // Harga beli
            $table->decimal('harga_jual', 10, 2);  // Harga jual
            $table->string('gambar')->nullable();  // Kolom untuk menyimpan nama file gambar
            $table->text('deskripsi')->nullable();  // Kolom deskripsi produk
            $table->string('barcode_image')->nullable(); // Kolom untuk menyimpan path barcode
            $table->timestamps();  // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};




// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up()
//     {
//         Schema::create('products', function (Blueprint $table) {
//             $table->id('product_id');  // Primary Key
//             $table->string('product_name')->unique();
//             $table->unsignedBigInteger('category_id');  // Foreign key ke categories table
//             $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
//             $table->integer('quantity_in_stock')->default(0);  // Jumlah stok
//             $table->decimal('harga_beli', 10, 2);  // Harga beli
//             $table->decimal('harga_jual', 10, 2);  // Harga jual
//             $table->string('gambar')->nullable();  // Kolom untuk menyimpan nama file gambar
//             $table->text('deskripsi')->nullable();  // Kolom deskripsi produk
//             $table->timestamps();  // created_at dan updated_at
//         });
//     }

//     public function down()
//     {
//         Schema::dropIfExists('products');
//     }
// };
