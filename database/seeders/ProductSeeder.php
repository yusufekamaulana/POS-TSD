<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Manually created products
        Product::create([
            'product_name' => 'Laptop',
            'price' => 1500.00,
            'category_id' => 1,  // Electronics category
            'quantity_in_stock' => 100,
            'harga_beli' => 1200.00,   // Purchase price
            'harga_jual' => 1500.00,   // Selling price
        ]);

        Product::create([
            'product_name' => 'Sofa',
            'price' => 300.00,
            'category_id' => 2,  // Furniture category
            'quantity_in_stock' => 50,
            'harga_beli' => 250.00,   // Purchase price
            'harga_jual' => 300.00,   // Selling price
        ]);

        Product::create([
            'product_name' => 'T-shirt',
            'price' => 20.00,
            'category_id' => 3,  // Clothing category
            'quantity_in_stock' => 200,
            'harga_beli' => 15.00,   // Purchase price
            'harga_jual' => 20.00,   // Selling price
        ]);

        // Dynamically create 47 additional products using Faker
        for ($i = 1; $i <= 47; $i++) {
            Product::create([
                'product_name' => 'Product ' . $i,
                'price' => rand(10, 1000),  // Random price between 10 and 1000
                'category_id' => Category::inRandomOrder()->first()->category_id,  // Random category
                'quantity_in_stock' => rand(10, 500),  // Random stock quantity
                'harga_beli' => rand(5, 800),  // Random purchase price between 5 and 800
                'harga_jual' => rand(10, 1000),  // Random selling price between 10 and 1000
            ]);
        }
    }
}
