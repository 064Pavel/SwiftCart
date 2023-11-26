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
            'New',
            'Processing',
            'Paid',
            'Ready for Shipment',
        ];

        foreach($statuses as $status){
            DB::table('order_statuses')->insert(['name' => $status]);
        }
    }
}
