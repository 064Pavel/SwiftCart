<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Pending',
            'Processing',
            'Shipped',
            'Delivered',
            'Cancelled',
        ];

        foreach($statuses as $status){
            DB::table('order_statuses')->insert(['name' => $status]);
        }
    }
}
