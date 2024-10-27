<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Generate multiple orders with related order details and payments
        Order::factory()
            ->hasOrderDetails(3) // Generate 3 order details per order
            ->hasPayments(1) // Generate 1 payment per order
            ->count(10) // Create 10 orders
            ->create();
    }
}
