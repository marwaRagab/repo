<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $marks = [
            [
                'name_ar' => 'ال جي',
                'name_en' => 'LG',
                'company_id' => 1,
                'img' => '/uploads/photos/lg.jpg',
                'discount' => 5,
            ],
            [
                'name_ar' => 'سامسونج',
                'name_en' => 'Samsung',
                'company_id' => 2,
                'img' => '/uploads/photos/samsung.jpg',
                'discount' => 0,
            ],
            [
                'name_ar' => 'شارب',
                'name_en' => 'Sharp',
                'company_id' => 3,
                'img' => '/uploads/photos/شارب1.jpg',
                'discount' => 4,
            ],
        ];
        DB::table('marks')->insert($marks);
    }
}
