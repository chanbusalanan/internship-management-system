<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\DailyLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<DailyLog> */
class DailyLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'assignment_id' => Assignment::factory(),
            'log_date' => fake()->date(),
            'time_in' => '08:00:00',
            'time_out' => '17:00:00',
            'activity_description' => fake()->paragraph(),
            'status' => 'Pending',
            'reviewed_by' => null,
            'reviewed_at' => null,
        ];
    }
}
