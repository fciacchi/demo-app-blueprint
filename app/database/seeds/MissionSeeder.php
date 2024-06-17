<?php

namespace App\Database\Seeds;

use App\Database\Factories\MissionFactory;
use Illuminate\Database\Seeder;

class MissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        (new MissionFactory)->create(2)->save();
    }
}
