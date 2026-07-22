<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Assignment;
use App\Models\Department;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Assignment> */
class AssignmentFactory extends Factory
{
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-2 months', 'now');

        return [
            'application_id' => Application::factory()->approved(),
            'department_id' => Department::factory(),
            'supervisor_id' => Supervisor::factory(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => fake()->dateTimeBetween($startDate, '+3 months')->format('Y-m-d'),
            'required_hours' => fake()->numberBetween(200, 500),
            'completed_hours' => fake()->numberBetween(0, 200),
            'status' => 'Active',
        ];
    }
}
