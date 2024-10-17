<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'order_date' => now()
        ]);

        Order::create([
            'order_date' => now()
        ]);
    }
}
