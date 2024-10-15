<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderDetail;

class OrderDetailSeeder extends Seeder
{
    public function run()
    {
        OrderDetail::create([
            'order_id' => 1,
            'product_id' => 1,  // Laptop
            'quantity' => 1,
            'unit_price' => 1500.00
        ]);

        OrderDetail::create([
            'order_id' => 2,
            'product_id' => 3,  // T-shirt
            'quantity' => 2,
            'unit_price' => 20.00
        ]);
    }
}
