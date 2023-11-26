<?php

namespace Database\Factories;

use App\Models\DeliveryStatus;
use App\Models\DeliveryType;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderIds = Order::query()->pluck("id")->toArray();
        $deliveryTypeIds = DeliveryType::query()->pluck("id")->toArray();
        $deliveryStatusIds = DeliveryStatus::query()->pluck("id")->toArray();

        return [
            "order_id" => fake()->randomElement($orderIds),
            "delivery_type_id" => fake()->randomElement($deliveryTypeIds),
            "delivery_status_id" => fake()->randomElement($deliveryStatusIds),
            "delivery_address" => fake()->address(),
            "delivery_date" => Carbon::now()->addDays(rand(1, 7)), 
        ];
    }
}
