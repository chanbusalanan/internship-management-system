<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Requirement;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Submission> */
class SubmissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'application_id' => Application::factory(),
            'requirement_id' => Requirement::factory(),
            'file_path' => 'requirements/' . fake()->uuid() . '.pdf',
            'original_filename' => fake()->word() . '.pdf',
            'status' => 'Pending',
            'remarks' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ];
    }
}
