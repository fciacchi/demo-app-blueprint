<?php

namespace App\Database\Factories;

use App\Models\Donation;

class DonationFactory extends Factory
{
    public $model = Donation::class;

    public function definition(): array
    {
        $employeeId = rand(2, 5);
        $paymentMethodId = $employeeId - 1;
        $isRecurring = rand(0,1) === 1;
        $recurringDays = $isRecurring ? null : rand(30, 365);

        return [
            'employee_id' => $employeeId,
            'mission_id' => rand(1, 2),
            'payment_method_id' => $paymentMethodId,
            'amount' => rand(10, 100),
            'currency' => 'EUR',
            'recurring' => $isRecurring,
            "recurring_days" => $recurringDays,
        ];
    }
}
