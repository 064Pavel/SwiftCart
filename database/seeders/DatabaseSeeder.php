<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Product::factory(50)->create();

        $this->call([
            OrderStatusSeeder::class,
            DeliveryTypeSeeder::class,
            DeliveryStatusSeeder::class,
            RaitingSeeder::class,
        ]);

        Order::factory(5)->create();
        OrderItem::factory(5)->create();
        Delivery::factory(5)->create();
        Review::factory(20)->create();
    }
}
