<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinistrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        //
        DB::table('ministries')->insert([
            'name_ar' => 'داخلية',
            'name_en' => 'dakhlia',
            'date'=>'2024-10-25',
            // 'percent' => '',
            'ministry_percentage_id'=>'1',
            'type' =>'working'
        ]);

        DB::table('ministries')->insert([
            'name_ar' => 'دفاع',
            'name_en' => 'defa3',
            'date'=>'2024-10-25',
            // 'percent' => '',
            'ministry_percentage_id'=>'1',
            'type' =>'working'
        ]);
    }
}
