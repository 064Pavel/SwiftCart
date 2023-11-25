<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderIds = Order::query()->pluck("id")->toArray();
        $orderId = fake()->randomElement($orderIds);

        $productIds = Product::query()->pluck("id")->toArray();

        return [
            "order_id" => $orderId,
            "product_id" => fake()->randomElement($productIds),
            "quantity" => fake()->numberBetween(1, 5),
            "price" => Order::query()->find($orderId)->total_price,
        ];
    }
}
