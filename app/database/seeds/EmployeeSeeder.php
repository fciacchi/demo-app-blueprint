<?php

namespace App\Database\Seeds;

use App\Database\Factories\EmployeeFactory;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new EmployeeFactory)->create(5)->save();
    }
}
