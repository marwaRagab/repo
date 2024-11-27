<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->insert([
            'name_ar' => 'بنك الراحجى',
            'name_en' => 'raghi bank',
            'bank_account_number' => '123456963258741',
            'bank_account_date' => '10-25',
            'iban' => '123456789',
            'active' => '1',
        ]);

        DB::table('banks')->insert([
            'name_ar' => 'بنك الريااض',
            'name_en' => 'rayad bank',
            'bank_account_number' => '123456963258741',
            'bank_account_date' => '10-25',
            'iban' => '123456789',
            'active' => '1',
        ]);


        DB::table('banks')->insert([
            'name_ar' => 'بنك الاهلى',
            'name_en' => 'Alhali bank',
            'bank_account_number' => '123456963258741',
            'bank_account_date' => '10-25',
            'iban' => '123456789',
            'active' => '1',
        ]);
    }
}
