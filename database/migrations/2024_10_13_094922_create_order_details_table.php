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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('order_detail_id');  // Unsigned Big Integer (primary key)
            $table->unsignedBigInteger('order_id');  // Foreign key column for orders
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade'); // Reference to orders table
    
            $table->unsignedBigInteger('product_id');  // Foreign key column for products
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade'); // Reference to products table
    
            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
