<?php

namespace App\Database\Seeds;

use App\Database\Factories\DonationFactory;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new DonationFactory)->create(100)->save();
    }
}
