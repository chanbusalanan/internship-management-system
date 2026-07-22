<?php

namespace Database\Factories;

use App\Models\Requirement;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Requirement> */
class RequirementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'requirement_name' => fake()->randomElement([
                'Resume',
                'Certificate of Enrollment',
                'Letter of Intent',
                'Medical Certificate',
                'Parent Consent Form',
                'School ID',
            ]),
            'description' => fake()->sentence(),
            'is_required' => fake()->boolean(80),
        ];
    }
}
