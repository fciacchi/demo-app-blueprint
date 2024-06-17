<?php

namespace App\Database\Factories;

use App\Models\Employee;

class EmployeeFactory extends Factory
{
    public $model = Employee::class;

    public function definition(): array
    {
        return [
            'username' => strtolower($this->faker->userName),
            'email' => $this->faker->unique()->safeEmail,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => $this->str::random(10),
            'department' => $this->str::random(10),
            // 'created_at' => tick()->now(),
            // 'updated_at' => tick()->now(),
            //'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ];
    }
}
