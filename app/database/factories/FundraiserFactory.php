<?php

namespace App\Database\Factories;

use App\Models\Fundraiser;

class FundraiserFactory extends Factory
{
    /** @var Fundraiser $model */
    public $model = Fundraiser::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'employee_id' => 1,
            'website' => 'https://www.' . strtolower($this->faker->domainName()),
            'description' => $this->faker->text(),
            'goal_amount' => random_int(10000, 20000),
            'goal_currency' => 'EUR',
            'goal_end_date' => $this->faker->dateTimeBetween('+6 months', '+1 year'),
        ];
    }
}
