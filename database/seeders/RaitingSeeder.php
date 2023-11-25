<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaitingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $raitings = [
            1, 2, 3, 4, 5
        ];

        foreach($raitings as $raiting){
            DB::table("raitings")->insert(["name" => $raiting]);
        } 
    }
}
