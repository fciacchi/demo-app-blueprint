<?php

namespace App\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed your application's database.
     */
    public function run(): array
    {
        return [
            EmployeeSeeder::class,
            FundraiserSeeder::class,
            MissionSeeder::class,
            PaymentMethodSeeder::class,
            DonationSeeder::class,
        ];
    }
}
