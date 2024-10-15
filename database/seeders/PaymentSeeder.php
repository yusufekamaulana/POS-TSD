<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        Payment::create([
            'order_id' => 1,
            'payment_date' => now(),
            'payment_amount' => 1500.00,
            'payment_method' => 'credit_card'
        ]);

        Payment::create([
            'order_id' => 2,
            'payment_date' => now(),
            'payment_amount' => 40.00,
            'payment_method' => 'cash'
        ]);
    }
}
