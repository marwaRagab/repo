<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ministry;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([


            ClassSeeder::class,
            CompanySeeder::class,
            MarkSeeder::class,
            stop_travelSeeder::class,
            stop_carSeeder::class,
            times_typeSeeder::class,
            MinistryPercentageSeeder::class,
            BankSeeder::class,
            MinistrySeeder::class,
            BokerSeeder::class,
            BranchSeeder::class,
            GovernorateSeeder::class,
            RegionSeeder::class,



            ]);
         // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
