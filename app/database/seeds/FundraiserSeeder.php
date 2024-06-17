<?php

namespace App\Database\Seeds;

use App\Database\Factories\FundraiserFactory;
use Illuminate\Database\Seeder;

class FundraiserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new FundraiserFactory())->create(1)->save();
    }
}
