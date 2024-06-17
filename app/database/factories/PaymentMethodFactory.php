<?php

namespace App\Database\Factories;

use App\Models\PaymentMethod;

class PaymentMethodFactory extends Factory
{
    /** @var PaymentMethod $model */
    public $model = PaymentMethod::class;

    /** @var integer $employeeIdCounter */
    private static int $employeeIdCounter = 2;

    public function definition(): array
    {
        // Get the current value of the counter.
        $employeeId = self::$employeeIdCounter;

        // Increment the counter and reset if it exceeds 5.
        ++self::$employeeIdCounter;
        if (self::$employeeIdCounter > 5) {
            self::$employeeIdCounter = 2;
        }

        return [
            'employee_id' => $employeeId,
            'type' => "credit card",
            'cc_number' => $this->faker->creditCardNumber(),
            'cc_ccv' => '123',
            'expiration_month' => $this->faker->month(),
            'expiration_year' => '2026',
        ];
    }
}
