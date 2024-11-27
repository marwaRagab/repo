<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('regions')->insert([
            'name_ar' => 'حولى',
            'name_en' => 'hawly',
            'governorate_id' => '1'
        ]);

        DB::table('regions')->insert([
            'name_ar' => 'مبارك',
            'name_en' => 'mbark',
            'governorate_id' => '2'
        ]);
    }
}
