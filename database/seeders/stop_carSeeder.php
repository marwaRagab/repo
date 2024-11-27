<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class stop_carSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('military_affairs_stop_car_type')->insert([
            //Global Admin
            [
                'name_ar' => 'طلب  الحجز',
                'name_en' => 'stop_car_request',
                'type' => 'stop_cars',
                'slug' => 'stop_car_request'
            ],
            [
                'name_ar' => '  المرور',
                'name_en' => 'stop_car_info',
                'type' => 'stop_cars',
                'slug' => 'stop_car_info'
            ],
            [
                'name_ar' => ' المديرية ',
                'name_en' => 'stop_car_police',
                'type' => 'stop_cars',
                'slug' => 'stop_car_police'
            ],
            [
                'name_ar' => ' القيادة ',
                'name_en' => 'stop_car_catch',
                'type' => 'stop_cars',
                'slug' => 'stop_car_catch'
            ],
            [
                'name_ar' => '  مخفر',
                'name_en' => 'stop_car_police_station',
                'type' => 'stop_cars',
                'slug' => 'stop_car_police_station'
            ],
            [
                'name_ar' => '  بانتظار الحجز',
                'name_en' => 'stop_car_doing',
                'type' => 'stop_cars',
                'slug' => 'stop_car_doing'
            ],
            [
                'name_ar' => '  تم الحجز',
                'name_en' => 'stop_car_finished',
                'type' => 'stop_cars',
                'slug' => 'stop_car_finished'
            ],
            [
                'name_ar' => '  طلب رفع الحجز',
                'name_en' => 'stop_car_cancel_request',
                'type' => 'stop_cars',
                'slug' => 'stop_car_cancel_request'
            ],
            [
                'name_ar' => 'رفع  الحجز',
                'name_en' => 'stop_car_cancel',
                'type' => 'stop_cars',
                'slug' => 'stop_car_cancel'
            ],

        ]);
    }
}
