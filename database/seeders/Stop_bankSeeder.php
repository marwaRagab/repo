<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Stop_bankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('military_affairs_stop_bank_type')->insert([
            //Global Admin
            [
                'name_ar' => 'طلب  الحجز',
                'name_en' => 'stop_bank_request',
                'type' => 'stop_bank',
                'slug' => 'stop_bank_request'
            ],
            [
                'name_ar' => '  مامور تنفيذ',
                'name_en' => 'stop_bank_command',
                'type' => 'stop_bank',
                'slug' => 'stop_bank_command'
            ],
            [
                'name_ar' => ' باحث قانونى ',
                'name_en' => 'stop_bank_researcher',
                'type' => 'stop_bank',
                'slug' => 'stop_bank_researcher'
            ],
            [
                'name_ar' => ' البنوك ',
                'name_en' => 'banks',
                'type' => 'stop_bank',
                'slug' => 'banks'
            ],
            [
                'name_ar' => '  تم الحجز',
                'name_en' => 'stop_bank_doing',
                'type' => 'stop_bank',
                'slug' => 'stop_bank_doing'
            ],
            [
                'name_ar' => '   طلب رفع حجز البنك',
                'name_en' => 'stop_bank_cancel_request',
                'type' => 'stop_bank',
                'slug' => 'stop_bank_cancel_request'
            ],
            [
                'name_ar' => '   رفع حجز البنوك',
                'name_en' => 'stop_bank_cancel',
                'type' => 'stop_bank',
                'slug' => 'stop_bank_cancel'
            ],


        ]);



    }
}
