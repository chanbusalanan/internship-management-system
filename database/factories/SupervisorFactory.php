<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Supervisor> */
class SupervisorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->role('Supervisor'),
            'department_id' => Department::factory(),
            'position' => fake()->randomElement([
                'Senior Developer',
                'Team Lead',
                'Department Head',
                'Project Manager',
                'QA Lead',
            ]),
        ];
    }
}
