<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinistryPercentageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ministry_percentages')->insert([
            'name' => '30',
            'percent' => '30',
            
        ]);

        DB::table('ministry_percentages')->insert([
            'name' => '40',
            'percent' => '40',
            
        ]);
    }
}
