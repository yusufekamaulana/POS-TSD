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
            $table->id('product_id');  // Unsigned Big Integer (primary key)
            $table->string('product_name');
            $table->decimal('price', 8, 2);
            $table->unsignedBigInteger('category_id');  // Foreign key to categories table
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->integer('quantity_in_stock')->default(0);  // New column for quantity in stock
            $table->decimal('harga_beli', 10, 2);  // New column for purchase price (harga_beli)
            $table->decimal('harga_jual', 10, 2);  // New column for selling price (harga_jual)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
