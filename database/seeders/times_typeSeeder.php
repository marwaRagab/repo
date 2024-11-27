<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class times_typeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('military_affairs_times_type')->insert([

            [
                'name_ar' => '  اقرار دين غير مستلم ',
                'name_en' => 'eqrar_dain_not_received',
                'type' => 'eqrar_dain',
                'slug' => 'eqrar_dain_not_received'
            ],
            [
                'name_ar' => '  اقرار دين  مستلم ',
                'name_en' => 'eqrar_dain_received',
                'type' => 'eqrar_dain',
                'slug' => 'eqrar_dain_received'
            ],
            [
                'name_ar' => ' فتح ملف',
                'name_en' => 'open_file',
                'type' => 'open_file',
                'slug' => 'open_file'
            ],
            [
                'name_ar' => ' إعلان التنفيذ ',
                'name_en' => 'execute_alert',
                'type' => 'execute_alert',
                'slug' => 'execute_alert'
            ],
            [
                'name_ar' => ' الايمج',
                'name_en' => 'images',
                'type' => 'images',
                'slug' => 'images'
            ],
            [
                'name_ar' => ' إثبات الحالة',
                'name_en' => 'case_proof',
                'type' => 'case_proof',
                'slug' => 'case_proof'
            ],

        ]);

    }
}
