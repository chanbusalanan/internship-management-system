<?php

namespace Database\Factories;

use App\Models\Intern;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Intern> */
class InternFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->role('Intern'),
            'student_number' => fake()->unique()->numerify('##-####-###'),
            'school' => fake()->company() . ' University',
            'course' => fake()->randomElement(['BSIT', 'BSCS', 'BSIS', 'BSCpE', 'BSCE', 'BSEM']),
            'year_level' => fake()->numberBetween(3, 5),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'emergency_contact' => fake()->name() . ' - ' . fake()->phoneNumber(),
        ];
    }
}
