<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Ensure categories exist for product seeding
        Category::create(['category_name' => 'Electronics']);
        Category::create(['category_name' => 'Furniture']);
        Category::create(['category_name' => 'Clothing']);
    }
}
