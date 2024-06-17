<?php

namespace App\Database\Factories;

use App\Models\Mission;

class MissionFactory extends Factory
{
    /** @var string $model */
    public $model = Mission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'employee_id' => 1,
            'fundraiser_id' => 1,
            'website' => 'https://www.' . strtolower($this->faker->domainName()),
            'description' => $this->faker->text(),
            'goal_amount' => random_int(3000, 6000),
            'goal_currency' => 'EUR',
            'goal_end_date' => $this->faker->dateTimeBetween('now', '+6 months'),
        ];
    }
}
