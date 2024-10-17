<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_name' => $this->faker->unique()->word,
            'category_id' => $this->faker->numberBetween(1, 3), // Asumsikan ada 3 kategori
            'quantity_in_stock' => $this->faker->numberBetween(0, 100),
            'harga_beli' => $this->faker->randomFloat(2, 10, 1000), // Harga beli antara 10 hingga 1000
            'harga_jual' => $this->faker->randomFloat(2, 15, 1500), // Harga jual antara 15 hingga 1500
            'gambar' => $this->faker->imageUrl(), // URL gambar palsu
            'deskripsi' => $this->faker->paragraph(), // Deskripsi produk
        ];
    }
}
