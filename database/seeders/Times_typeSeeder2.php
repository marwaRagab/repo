<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Times_typeSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('military_affairs_times_type')->insert(

            [
                'name_ar' => 'العملاء المتأخرين',
                'name_en' => 'late_clients',
                'type' => 'late_clients',
                'slug' => 'late_install_clients'
            ]);
    }
}
