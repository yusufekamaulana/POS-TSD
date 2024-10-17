<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Menghasilkan 50 produk palsu
        Product::factory()->count(50)->create();
    }
}
