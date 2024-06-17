<?php

namespace App\Database\Seeds;

use App\Database\Factories\PaymentMethodFactory;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new PaymentMethodFactory())->create(4)->save();
    }
}
