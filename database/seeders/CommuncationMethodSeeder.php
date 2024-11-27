<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommuncationMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            [
                'name_ar' => 'واتساب',
                'name_en' => 'Whatsapp',
            ],
            [
                'name_ar' => 'ايميل',
                'name_en' => 'Email'
            ],
            [
                'name_ar' => 'رسالة sms',
                'name_en' => 'SMS Message'
            ],
        ];
        DB::table('communcation_methods')->insert($methods);
    }
}
