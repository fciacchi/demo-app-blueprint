<?php

namespace App\Database\Seeds;

use App\Database\Factories\PaymentMethodFactory;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        (new PaymentMethodFactory)->create(4)->save();
    }
}
