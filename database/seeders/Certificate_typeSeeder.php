<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Certificate_typeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('military_affairs_certificate_type')->insert([
            //Global Admin


            [
                'name_en' => 'info_request',
                'name_ar' => 'طلب الاستعلام',
                'type' => 'Military_certificate',
                'slug' => 'info_request'
            ],
            [
                'name_ar' => 'كتاب الاستعلام',
                'name_en' => 'info_book',
                'type' => 'Military_certificate',
                'slug' => 'info_book'
            ],
            [
                'name_ar' => 'الصادر و الوارد',
                'name_en' => 'export',
                'type' => 'Military_certificate',
                'slug' => 'export'
            ],
            [
                'name_ar' => 'المالية',
                'name_en' => 'money',
                'type' => 'Military_certificate',
                'slug' => 'money'
            ],

        ]);









    }
}
