<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Raiting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $userIds = User::query()->pluck("id")->toArray();
        $orderIds = Order::query()->pluck("id")->toArray();
        $raitingIds = Raiting::query()->pluck("id")->toArray();

        return [
            "user_id" => fake()->randomElement($userIds),
            "order_id" => fake()->randomElement($orderIds),
            "raiting_id" => fake()->randomElement($raitingIds),
            "comment" => fake()->text(200),
        ];
    }
}
