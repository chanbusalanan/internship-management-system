<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Evaluation;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Evaluation> */
class EvaluationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'assignment_id' => Assignment::factory(),
            'score' => fake()->randomFloat(2, 1, 5),
            'remarks' => fake()->paragraph(),
            'evaluation_date' => fake()->date(),
        ];
    }
}
