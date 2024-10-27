<?php
namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'order_date' => $this->faker->dateTimeThisMonth(),
            'created_at' => $this->faker->dateTimeThisMonth(),
            'updated_at' => $this->faker->dateTimeThisMonth(),
        ];
    }

    public function hasOrderDetails($count = 1)
    {
        return $this->has(\App\Models\OrderDetail::factory()->count($count), 'orderDetails');
    }
    public function hasPayments($count = 1)
    {
        return $this->has(\App\Models\Payment::factory()->count($count), 'payments');
    }
}
