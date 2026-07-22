<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Department> */
class DepartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'department_name' => fake()->unique()->randomElement([
                'Software Development',
                'Quality Assurance',
                'Information Technology',
                'Human Resources',
                'Marketing',
                'Finance',
                'Operations',
                'Research and Development',
            ]),
            'description' => fake()->paragraph(),
        ];
    }
}
