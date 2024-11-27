<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('governorates')->insert([
            'name_ar' => 'الجهراء',
            'name_en' => 'gahraa',
        ]);

        DB::table('governorates')->insert([
            'name_ar' => 'مبارك',
            'name_en' => 'mbark',
        ]);

        DB::table('governorates')->insert([
            'name_ar' => 'حولى',
            'name_en' => 'hawly',
        ]);
    }
}
