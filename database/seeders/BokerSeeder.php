<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BokerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bokers')->insert([
            'name_ar' => 'احمد نصار',
            'name_en' => 'ahmed nasser',
            'phone' => '1234569',
            'percentage' => '10',
            'percentage_amount' => 'percentage',
        ]);

        DB::table('bokers')->insert([
            'name_ar' => 'احمد عماد',
            'name_en' => 'ahmed emad',
            'phone' => '123456',
            'percentage' => '10',
            'percentage_amount' => 'percentage',
        ]);

        DB::table('bokers')->insert([
            'name_ar' => 'احمد عيد',
            'name_en' => 'ahmed eid',
            'phone' => '1234568741',
            'percentage' => '1000',
            'percentage_amount' => 'amount',
        ]);

        


       
    }
}
