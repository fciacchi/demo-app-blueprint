<?php

namespace App\Database\Factories;

use App\Models\Donation;

class DonationFactory extends Factory
{
    /** @var string $model */
    public $model = Donation::class;

    public function definition(): array
    {
        $employeeId = random_int(2, 5);
        $paymentMethodId = $employeeId - 1;
        $isRecurring = random_int(0, 1) === 1;
        $recurringDays = $isRecurring ? null : random_int(30, 365);

        return [
            'employee_id' => $employeeId,
            'mission_id' => random_int(1, 2),
            'payment_method_id' => $paymentMethodId,
            'amount' => random_int(10, 100),
            'currency' => 'EUR',
            'recurring' => $isRecurring,
            "recurring_days" => $recurringDays,
        ];
    }
}
