<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Application;
use App\Models\Assignment;
use App\Models\DailyLog;
use App\Models\Department;
use App\Models\Evaluation;
use App\Models\Intern;
use App\Models\Requirement;
use App\Models\Role;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::create(['role_name' => 'Admin']);
        $hrRole = Role::create(['role_name' => 'HR']);
        $supervisorRole = Role::create(['role_name' => 'Supervisor']);
        $internRole = Role::create(['role_name' => 'Intern']);

        $departments = Department::factory()->count(5)->create();

        $requirements = collect([
            'Resume',
            'Certificate of Enrollment',
            'Letter of Intent',
            'Medical Certificate',
            'Parent Consent Form',
            'School ID',
        ])->map(fn ($name) => Requirement::create([
            'requirement_name' => $name,
            'description' => 'Required document for internship application.',
            'is_required' => true,
        ]));

        $adminUser = User::factory()->role('Admin')->create([
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'email' => 'admin@ims.test',
        ]);

        $hrUser = User::factory()->role('HR')->create([
            'first_name' => 'HR',
            'last_name' => 'Manager',
            'email' => 'hr@ims.test',
        ]);

        $supervisorUsers = User::factory()->role('Supervisor')->count(3)->create();
        $supervisors = $supervisorUsers->map(fn ($user, $index) => Supervisor::create([
            'user_id' => $user->id,
            'department_id' => $departments[$index % $departments->count()]->id,
            'position' => ['Senior Developer', 'Team Lead', 'QA Lead'][$index % 3],
        ]));

        $internUsers = User::factory()->role('Intern')->count(5)->create();
        $interns = $internUsers->map(fn ($user) => Intern::factory()->create([
            'user_id' => $user->id,
        ]));

        $interns->each(function ($intern, $index) use ($requirements, $hrUser, $departments, $supervisors) {
            $application = Application::create([
                'intern_id' => $intern->id,
                'application_date' => now()->subDays(30 - $index * 3)->format('Y-m-d'),
                'status' => $index < 3 ? 'Approved' : 'Pending',
                'remarks' => $index < 3 ? 'Application approved.' : null,
            ]);

            $requirements->each(fn ($req) => \App\Models\Submission::create([
                'application_id' => $application->id,
                'requirement_id' => $req->id,
                'file_path' => 'requirements/' . fake()->uuid() . '.pdf',
                'original_filename' => $req->requirement_name . '.pdf',
                'status' => $index < 3 ? 'Approved' : 'Pending',
                'reviewed_by' => $index < 3 ? $hrUser->id : null,
                'reviewed_at' => $index < 3 ? now()->subDays(20) : null,
            ]));

            if ($index < 3) {
                $assignment = Assignment::create([
                    'application_id' => $application->id,
                    'department_id' => $departments[$index % $departments->count()]->id,
                    'supervisor_id' => $supervisors[$index % $supervisors->count()]->id,
                    'start_date' => now()->subDays(20)->format('Y-m-d'),
                    'end_date' => now()->addDays(40)->format('Y-m-d'),
                    'required_hours' => 300,
                    'completed_hours' => $index * 40,
                    'status' => 'Active',
                ]);

                for ($d = 0; $d < 5; $d++) {
                    DailyLog::create([
                        'assignment_id' => $assignment->id,
                        'log_date' => now()->subDays(20 - $d * 3)->format('Y-m-d'),
                        'time_in' => '08:00:00',
                        'time_out' => '17:00:00',
                        'activity_description' => fake()->paragraph(),
                        'status' => $d < 3 ? 'Approved' : 'Pending',
                        'reviewed_by' => $d < 3 ? $supervisors[$index % $supervisors->count()]->id : null,
                        'reviewed_at' => $d < 3 ? now()->subDays(15 - $d * 3) : null,
                    ]);
                }

                if ($index === 0) {
                    Evaluation::create([
                        'assignment_id' => $assignment->id,
                        'score' => 4.50,
                        'remarks' => 'Excellent performance. Shows initiative and learns quickly.',
                        'evaluation_date' => now()->subDays(5)->format('Y-m-d'),
                    ]);
                }
            }
        });

        Announcement::create([
            'title' => 'Welcome to the Internship Management System',
            'content' => 'Welcome! This platform allows you to manage your internship journey, from application to completion. Please complete your profile and submit required documents.',
            'posted_by' => $hrUser->id,
        ]);

        Announcement::create([
            'title' => 'Internship Orientation Schedule',
            'content' => 'All newly approved interns are required to attend the orientation on Monday at 9:00 AM in the main conference room.',
            'posted_by' => $hrUser->id,
        ]);
    }
}
