<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'name_ar' => 'شركة عبد العزيز سعود  البابطين ',
                'name_en' => 'Abd-Elaziz Saoud Elbabteen Company',
                'phone' => '1234567890',
                'fax' => '1234567890',
                'email' => 'abdelaziz@gmail.com',
                'address' => 'Address 1',
                'store_phone' => '1234567890',
                'delegate_name' => 'Delegate One',
                'delegate_phone' => '9876543210',
                'delegate_email' => 'delegate1@example.com',
                'delivery' => 'Delivery details for abdelaziz company',
                'maintenance' => 'Maintenance details for abdelaziz company',
                'sales' => 'Sales details for abdelaziz company',
                'active' => 1
            ],
            [
                'name_ar' => 'مؤسسة الاندلس التجارية',
                'name_en' => 'Andalus Commercial Institution',
                'phone' => '2345678901',
                'fax' => '2345678901',
                'email' => 'Andalus@example.com',
                'address' => 'Address 2',
                'store_phone' => '2345678901',
                'delegate_name' => 'Delegate Two',
                'delegate_phone' => '8765432109',
                'delegate_email' => 'delegate2@example.com',
                'delivery' => 'Delivery details for Andalus',
                'maintenance' => 'Maintenance details for Andalus',
                'sales' => 'Sales details for Andalus',
                'active' => 1,
            ],
            [
                'name_ar' => 'شركة عيسى حسين اليوسفي واولادة',
                'name_en' => 'Eissa Hussein Elyussefy Company',
                'phone' => '2345678901',
                'fax' => '2345678901',
                'email' => 'Eissa@example.com',
                'address' => 'Address 3',
                'store_phone' => '2345678901',
                'delegate_name' => 'Delegate three',
                'delegate_phone' => '8765432109',
                'delegate_email' => 'delegate3@example.com',
                'delivery' => 'Delivery details for Eissa',
                'maintenance' => 'Maintenance details for Eissa',
                'sales' => 'Sales details for Eissa',
                'active' => 1,
            ]
        ];

        DB::table('companies')->insert($companies);
    }
}
