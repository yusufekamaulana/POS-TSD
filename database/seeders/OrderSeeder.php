<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'user_id' => 1,  // Admin user
            'order_date' => now()
        ]);

        Order::create([
            'user_id' => 2,  // Employee user
            'order_date' => now()
        ]);
    }
}
