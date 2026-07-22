<?php

use App\Models\Application;
use App\Models\Department;
use App\Models\Intern;
use App\Models\Requirement;
use App\Models\Role;
use App\Models\Submission;
use App\Models\Supervisor;
use App\Models\User;

describe('Intern Application Workflow', function () {
    beforeEach(function () {
        $this->internRole = Role::create(['role_name' => 'Intern']);
        $this->hrRole = Role::create(['role_name' => 'HR']);
        $this->supervisorRole = Role::create(['role_name' => 'Supervisor']);

        $this->internUser = User::factory()->create(['role_id' => $this->internRole->id]);
        $this->intern = Intern::factory()->create(['user_id' => $this->internUser->id]);

        $this->hrUser = User::factory()->create(['role_id' => $this->hrRole->id]);
    });

    it('allows intern to submit an application', function () {
        $this->actingAs($this->internUser)
            ->post(route('intern.applications.store'), [
                'application_date' => now()->format('Y-m-d'),
            ])
            ->assertRedirect(route('intern.applications.index'));

        expect(Application::where('intern_id', $this->intern->id)->exists())->toBeTrue();

        $application = Application::where('intern_id', $this->intern->id)->first();
        expect($application->status)->toBe('Pending');
    });

    it('prevents intern from submitting multiple pending applications', function () {
        Application::create([
            'intern_id' => $this->intern->id,
            'application_date' => now()->format('Y-m-d'),
            'status' => 'Pending',
        ]);

        $this->actingAs($this->internUser)
            ->post(route('intern.applications.store'), [
                'application_date' => now()->format('Y-m-d'),
            ])
            ->assertRedirect(route('intern.applications.index'))
            ->assertSessionHas('error');
    });

    it('allows HR to approve an application', function () {
        $application = Application::create([
            'intern_id' => $this->intern->id,
            'application_date' => now()->format('Y-m-d'),
            'status' => 'Pending',
        ]);

        $this->actingAs($this->hrUser)
            ->patch(route('hr.applications.approve', $application), [
                'remarks' => 'Welcome to the team!',
            ])
            ->assertRedirect(route('hr.applications.show', $application));

        expect($application->fresh()->status)->toBe('Approved');
        expect($application->fresh()->remarks)->toBe('Welcome to the team!');
    });

    it('allows HR to reject an application', function () {
        $application = Application::create([
            'intern_id' => $this->intern->id,
            'application_date' => now()->format('Y-m-d'),
            'status' => 'Pending',
        ]);

        $this->actingAs($this->hrUser)
            ->patch(route('hr.applications.reject', $application), [
                'remarks' => 'Incomplete requirements.',
            ])
            ->assertRedirect(route('hr.applications.show', $application));

        expect($application->fresh()->status)->toBe('Rejected');
    });

    it('allows intern to view their application', function () {
        $application = Application::create([
            'intern_id' => $this->intern->id,
            'application_date' => now()->format('Y-m-d'),
            'status' => 'Pending',
        ]);

        $this->actingAs($this->internUser)
            ->get(route('intern.applications.show', $application))
            ->assertSuccessful();
    });

    it('prevents intern from viewing other interns applications', function () {
        $otherUser = User::factory()->create(['role_id' => $this->internRole->id]);
        $otherIntern = Intern::factory()->create(['user_id' => $otherUser->id]);
        $application = Application::create([
            'intern_id' => $otherIntern->id,
            'application_date' => now()->format('Y-m-d'),
            'status' => 'Pending',
        ]);

        $this->actingAs($this->internUser)
            ->get(route('intern.applications.show', $application))
            ->assertForbidden();
    });
});

describe('Document Submission Workflow', function () {
    beforeEach(function () {
        $this->internRole = Role::create(['role_name' => 'Intern']);
        $this->hrRole = Role::create(['role_name' => 'HR']);

        $this->internUser = User::factory()->create(['role_id' => $this->internRole->id]);
        $this->intern = Intern::factory()->create(['user_id' => $this->internUser->id]);
        $this->hrUser = User::factory()->create(['role_id' => $this->hrRole->id]);

        $this->requirement = Requirement::create([
            'requirement_name' => 'Resume',
            'description' => 'Updated resume',
            'is_required' => true,
        ]);

        $this->application = Application::create([
            'intern_id' => $this->intern->id,
            'application_date' => now()->format('Y-m-d'),
            'status' => 'Pending',
        ]);
    });

    it('allows intern to upload a document', function () {
        \Illuminate\Http\UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf');

        $this->actingAs($this->internUser)
            ->post(route('intern.submissions.store', $this->application), [
                'requirement_id' => $this->requirement->id,
                'file' => \Illuminate\Http\UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect(route('intern.applications.show', $this->application));

        expect(Submission::where('application_id', $this->application->id)->exists())->toBeTrue();
    });

    it('allows HR to approve a submission', function () {
        $submission = Submission::create([
            'application_id' => $this->application->id,
            'requirement_id' => $this->requirement->id,
            'file_path' => 'requirements/test.pdf',
            'original_filename' => 'resume.pdf',
            'status' => 'Pending',
        ]);

        $this->actingAs($this->hrUser)
            ->patch(route('hr.submissions.approve', $submission))
            ->assertRedirect(route('hr.submissions.show', $submission));

        expect($submission->fresh()->status)->toBe('Approved');
        expect($submission->fresh()->reviewed_by)->toBe($this->hrUser->id);
    });

    it('allows HR to reject a submission', function () {
        $submission = Submission::create([
            'application_id' => $this->application->id,
            'requirement_id' => $this->requirement->id,
            'file_path' => 'requirements/test.pdf',
            'original_filename' => 'resume.pdf',
            'status' => 'Pending',
        ]);

        $this->actingAs($this->hrUser)
            ->patch(route('hr.submissions.reject', $submission), [
                'remarks' => 'File is corrupted.',
            ])
            ->assertRedirect(route('hr.submissions.show', $submission));

        expect($submission->fresh()->status)->toBe('Rejected');
        expect($submission->fresh()->remarks)->toBe('File is corrupted.');
    });
});

describe('Assignment Workflow', function () {
    beforeEach(function () {
        $this->internRole = Role::create(['role_name' => 'Intern']);
        $this->hrRole = Role::create(['role_name' => 'HR']);
        $this->supervisorRole = Role::create(['role_name' => 'Supervisor']);

        $this->internUser = User::factory()->create(['role_id' => $this->internRole->id]);
        $this->intern = Intern::factory()->create(['user_id' => $this->internUser->id]);

        $this->hrUser = User::factory()->create(['role_id' => $this->hrRole->id]);

        $this->department = Department::create([
            'department_name' => 'IT Department',
            'description' => 'Information Technology',
        ]);

        $supervisorUser = User::factory()->create(['role_id' => $this->supervisorRole->id]);
        $this->supervisor = Supervisor::create([
            'user_id' => $supervisorUser->id,
            'department_id' => $this->department->id,
            'position' => 'Team Lead',
        ]);

        $this->approvedApplication = Application::create([
            'intern_id' => $this->intern->id,
            'application_date' => now()->format('Y-m-d'),
            'status' => 'Approved',
            'remarks' => 'Approved',
        ]);
    });

    it('allows HR to create an assignment', function () {
        $this->actingAs($this->hrUser)
            ->post(route('hr.assignments.store'), [
                'application_id' => $this->approvedApplication->id,
                'department_id' => $this->department->id,
                'supervisor_id' => $this->supervisor->id,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => now()->addMonths(3)->format('Y-m-d'),
                'required_hours' => 300,
            ])
            ->assertRedirect(route('hr.assignments.index'));

        expect(\App\Models\Assignment::where('application_id', $this->approvedApplication->id)->exists())->toBeTrue();
    });

    it('prevents creating assignment for non-approved application', function () {
        $pendingApp = Application::create([
            'intern_id' => $this->intern->id,
            'application_date' => now()->format('Y-m-d'),
            'status' => 'Pending',
        ]);

        $this->actingAs($this->hrUser)
            ->post(route('hr.assignments.store'), [
                'application_id' => $pendingApp->id,
                'department_id' => $this->department->id,
                'supervisor_id' => $this->supervisor->id,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => now()->addMonths(3)->format('Y-m-d'),
                'required_hours' => 300,
            ]);

        expect(\App\Models\Assignment::where('application_id', $pendingApp->id)->exists())->toBeFalse();
    });
});

describe('Daily Log Workflow', function () {
    beforeEach(function () {
        $this->internRole = Role::create(['role_name' => 'Intern']);
        $this->hrRole = Role::create(['role_name' => 'HR']);
        $this->supervisorRole = Role::create(['role_name' => 'Supervisor']);

        $this->internUser = User::factory()->create(['role_id' => $this->internRole->id]);
        $this->intern = Intern::factory()->create(['user_id' => $this->internUser->id]);

        $this->hrUser = User::factory()->create(['role_id' => $this->hrRole->id]);

        $department = Department::create(['department_name' => 'IT']);
        $supervisorUser = User::factory()->create(['role_id' => $this->supervisorRole->id]);
        $this->supervisor = Supervisor::create([
            'user_id' => $supervisorUser->id,
            'department_id' => $department->id,
            'position' => 'Lead',
        ]);

        $application = Application::create([
            'intern_id' => $this->intern->id,
            'application_date' => now()->format('Y-m-d'),
            'status' => 'Approved',
        ]);

        $this->assignment = \App\Models\Assignment::create([
            'application_id' => $application->id,
            'department_id' => $department->id,
            'supervisor_id' => $this->supervisor->id,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths(3)->format('Y-m-d'),
            'required_hours' => 300,
            'completed_hours' => 0,
            'status' => 'Active',
        ]);
    });

    it('allows intern to submit a daily log', function () {
        $this->actingAs($this->internUser)
            ->post(route('intern.logs.store'), [
                'log_date' => now()->format('Y-m-d'),
                'time_in' => '08:00',
                'time_out' => '17:00',
                'activity_description' => 'Worked on developing the login module and testing it.',
            ])
            ->assertRedirect(route('intern.logs.index'));

        expect(\App\Models\DailyLog::where('assignment_id', $this->assignment->id)->exists())->toBeTrue();
    });

    it('prevents duplicate daily log for the same date', function () {
        $today = now()->format('Y-m-d');

        $log = \App\Models\DailyLog::create([
            'assignment_id' => $this->assignment->id,
            'log_date' => $today,
            'time_in' => '08:00:00',
            'time_out' => '17:00:00',
            'activity_description' => 'Already submitted for this date.',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($this->internUser)
            ->post(route('intern.logs.store'), [
                'log_date' => $today,
                'time_in' => '08:00',
                'time_out' => '17:00',
                'activity_description' => 'Trying to submit again for the same date.',
            ]);

        $response->assertRedirect();
        expect(\App\Models\DailyLog::where('assignment_id', $this->assignment->id)->count())->toBe(1);
    });

    it('allows supervisor to approve a daily log', function () {
        $log = \App\Models\DailyLog::create([
            'assignment_id' => $this->assignment->id,
            'log_date' => now()->format('Y-m-d'),
            'time_in' => '08:00',
            'time_out' => '17:00',
            'activity_description' => 'Completed the UI design for the dashboard.',
            'status' => 'Pending',
        ]);

        $this->actingAs($this->supervisor->user)
            ->patch(route('supervisor.logs.approve', $log))
            ->assertRedirect(route('supervisor.logs.index'));

        expect($log->fresh()->status)->toBe('Approved');
        expect($log->fresh()->reviewed_by)->toBe($this->supervisor->id);
    });

    it('allows supervisor to reject a daily log', function () {
        $log = \App\Models\DailyLog::create([
            'assignment_id' => $this->assignment->id,
            'log_date' => now()->format('Y-m-d'),
            'time_in' => '08:00',
            'time_out' => '17:00',
            'activity_description' => 'Incomplete work description.',
            'status' => 'Pending',
        ]);

        $this->actingAs($this->supervisor->user)
            ->patch(route('supervisor.logs.reject', $log))
            ->assertRedirect(route('supervisor.logs.index'));

        expect($log->fresh()->status)->toBe('Rejected');
    });

    it('increments completed hours when log is approved', function () {
        $log = \App\Models\DailyLog::create([
            'assignment_id' => $this->assignment->id,
            'log_date' => now()->format('Y-m-d'),
            'time_in' => '08:00',
            'time_out' => '17:00',
            'activity_description' => 'Completed testing of the module.',
            'status' => 'Pending',
        ]);

        $this->actingAs($this->supervisor->user)
            ->patch(route('supervisor.logs.approve', $log));

        expect($this->assignment->fresh()->completed_hours)->toBe(8);
    });
});

describe('Evaluation Workflow', function () {
    beforeEach(function () {
        $this->internRole = Role::create(['role_name' => 'Intern']);
        $this->supervisorRole = Role::create(['role_name' => 'Supervisor']);

        $internUser = User::factory()->create(['role_id' => $this->internRole->id]);
        $intern = Intern::factory()->create(['user_id' => $internUser->id]);

        $department = Department::create(['department_name' => 'IT']);
        $supervisorUser = User::factory()->create(['role_id' => $this->supervisorRole->id]);
        $this->supervisor = Supervisor::create([
            'user_id' => $supervisorUser->id,
            'department_id' => $department->id,
            'position' => 'Lead',
        ]);

        $application = Application::create([
            'intern_id' => $intern->id,
            'application_date' => now()->format('Y-m-d'),
            'status' => 'Approved',
        ]);

        $this->assignment = \App\Models\Assignment::create([
            'application_id' => $application->id,
            'department_id' => $department->id,
            'supervisor_id' => $this->supervisor->id,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths(3)->format('Y-m-d'),
            'required_hours' => 300,
            'completed_hours' => 0,
            'status' => 'Active',
        ]);
    });

    it('allows supervisor to evaluate an intern', function () {
        $this->actingAs($this->supervisor->user)
            ->post(route('supervisor.evaluations.store', $this->assignment), [
                'score' => 4.5,
                'remarks' => 'Excellent performance and dedication.',
                'evaluation_date' => now()->format('Y-m-d'),
            ])
            ->assertRedirect(route('supervisor.evaluations.index'));

        expect(\App\Models\Evaluation::where('assignment_id', $this->assignment->id)->exists())->toBeTrue();
    });

    it('validates evaluation score range', function () {
        $this->actingAs($this->supervisor->user)
            ->post(route('supervisor.evaluations.store', $this->assignment), [
                'score' => 10,
                'remarks' => 'Test',
                'evaluation_date' => now()->format('Y-m-d'),
            ])
            ->assertSessionHasErrors('score');
    });
});

describe('Announcement Workflow', function () {
    beforeEach(function () {
        $this->hrRole = Role::create(['role_name' => 'HR']);
        $this->internRole = Role::create(['role_name' => 'Intern']);
        $this->adminRole = Role::create(['role_name' => 'Admin']);

        $this->hrUser = User::factory()->create(['role_id' => $this->hrRole->id]);
        $this->internUser = User::factory()->create(['role_id' => $this->internRole->id]);
    });

    it('allows HR to create an announcement', function () {
        $this->actingAs($this->hrUser)
            ->post(route('hr.announcements.store'), [
                'title' => 'Orientation Schedule',
                'content' => 'All interns must attend the orientation on Monday at 9 AM.',
            ])
            ->assertRedirect(route('hr.announcements.index'));

        expect(\App\Models\Announcement::where('title', 'Orientation Schedule')->exists())->toBeTrue();
    });

    it('allows intern to view announcements', function () {
        \App\Models\Announcement::create([
            'title' => 'Test Announcement',
            'content' => 'This is a test announcement content.',
            'posted_by' => $this->hrUser->id,
        ]);

        $this->actingAs($this->internUser)
            ->get(route('intern.announcements.index'))
            ->assertSuccessful()
            ->assertSee('Test Announcement');
    });

    it('allows HR to delete an announcement', function () {
        $announcement = \App\Models\Announcement::create([
            'title' => 'To Delete',
            'content' => 'This will be deleted.',
            'posted_by' => $this->hrUser->id,
        ]);

        $this->actingAs($this->hrUser)
            ->delete(route('hr.announcements.destroy', $announcement))
            ->assertRedirect(route('hr.announcements.index'));

        expect(\App\Models\Announcement::find($announcement->id))->toBeNull();
    });
});

describe('Admin User Management', function () {
    beforeEach(function () {
        $this->adminRole = Role::create(['role_name' => 'Admin']);
        $this->hrRole = Role::create(['role_name' => 'HR']);
        $this->internRole = Role::create(['role_name' => 'Intern']);

        $this->admin = User::factory()->create(['role_id' => $this->adminRole->id]);
    });

    it('allows admin to view users list', function () {
        $this->actingAs($this->admin)
            ->get(route('admin.users.index'))
            ->assertSuccessful();
    });

    it('allows admin to create a user', function () {
        $this->actingAs($this->admin)
            ->post(route('admin.users.store'), [
                'role_id' => $this->hrRole->id,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@test.com',
                'password' => 'password123',
                'status' => 'Active',
            ])
            ->assertRedirect(route('admin.users.index'));

        expect(User::where('email', 'jane@test.com')->exists())->toBeTrue();
    });

    it('allows admin to deactivate a user', function () {
        $user = User::factory()->create(['role_id' => $this->hrRole->id]);

        $this->actingAs($this->admin)
            ->patch(route('admin.users.deactivate', $user))
            ->assertRedirect(route('admin.users.index'));

        expect($user->fresh()->status)->toBe('Inactive');
    });

    it('prevents admin from deactivating themselves', function () {
        $this->actingAs($this->admin)
            ->patch(route('admin.users.deactivate', $this->admin))
            ->assertSessionHas('error');

        expect($this->admin->fresh()->status)->toBe('Active');
    });

    it('allows admin to activate a user', function () {
        $user = User::factory()->create([
            'role_id' => $this->hrRole->id,
            'status' => 'Inactive',
        ]);

        $this->actingAs($this->admin)
            ->patch(route('admin.users.activate', $user))
            ->assertRedirect(route('admin.users.index'));

        expect($user->fresh()->status)->toBe('Active');
    });
});
