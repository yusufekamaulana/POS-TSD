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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');  // Unsigned Big Integer (primary key)
            $table->unsignedBigInteger('order_id');  // Foreign key column for orders
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade'); // Reference to orders table
    
            $table->timestamp('payment_date')->useCurrent();
            $table->decimal('payment_amount', 8, 2);  // Up to 8 digits with 2 decimal places
            $table->enum('payment_method', ['credit_card', 'cash', 'bank_transfer']);  // Example payment methods
            $table->timestamps();
        });     
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
