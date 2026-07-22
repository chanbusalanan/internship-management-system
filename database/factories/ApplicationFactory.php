<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Intern;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Application> */
class ApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'intern_id' => Intern::factory(),
            'application_date' => fake()->date(),
            'status' => 'Pending',
            'remarks' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Approved',
            'remarks' => 'Application approved. Welcome to the team!',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Rejected',
            'remarks' => 'Application rejected. Please reapply next semester.',
        ]);
    }
}
