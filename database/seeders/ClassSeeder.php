<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            [
                'name_ar' => 'ثلاجة',
                'name_en' => 'Fridge',
            ],
            [
                'name_ar' => 'مكيف',
                'name_en' => 'AC'
            ],
            [
                'name_ar' => 'تلفزيون',
                'name_en' => 'Television'
            ],
            [
                'name_ar' => 'فريزر ',
                'name_en' => 'Freezer'
            ],
            [
                'name_ar' => 'خلاط ',
                'name_en' => 'Blender'
            ],
            [
                'name_ar' => 'ميكروويف ',
                'name_en' => 'Microwave'
            ],
            [
                'name_ar' => 'صانعة قهوة ',
                'name_en' => 'Coffee Maker'
            ],

        ];
        DB::table('classes')->insert($classes);
    }
}
