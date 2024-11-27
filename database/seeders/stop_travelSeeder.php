<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class stop_travelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('military_affairs_stop_travel_type')->insert([
            [
            'name_ar' => 'طلب منع السفر',
            'name_en' => 'request',
            'type' => 'stop_travel',
            'slug' => 'request'
        ],
            [
                'name_ar' => 'امر منع السفر',
                'name_en' => 'command',
                'type' => 'stop_travel',
                'slug' => 'command'
            ],
            [
                'name_ar' => ' منع السفر',
                'name_en' => 'stop_travel_finished',
                'type' => 'stop_travel',
                'slug' => 'stop_travel_finished'
            ],
            [
                'name_ar' => 'طلب رفع منع السفر',
                'name_en' => 'stop_travel_cancel_request',
                'type' => 'stop_travel',
                'slug' => 'stop_travel_cancel_request'
            ],
            [
                'name_ar' => 'رفع منع السفر',
                'name_en' => 'stop_travel_cancel',
                'type' => 'stop_travel',
                'slug' => 'stop_travel_cancel'
            ],

        ]);
           }
}
