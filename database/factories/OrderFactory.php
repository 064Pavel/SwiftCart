<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::query()->pluck("id")->toArray();
        $orderStatusIds = OrderStatus::query()->pluck("id")->toArray();

        return [
            "user_id" => fake()->randomElement($userIds),
            "order_status_id" => fake()->randomElement($orderStatusIds),
            "total_price" => fake()->randomFloat(2, 0, 999999),
        ];
    }
}
