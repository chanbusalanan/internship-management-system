<?php

use App\Models\Intern;
use App\Models\Role;
use App\Models\User;

describe('Authentication', function () {
    it('shows the login page', function () {
        $this->get(route('login'))
            ->assertSuccessful()
            ->assertSee('Sign In');
    });

    it('shows the registration page', function () {
        $this->get(route('register'))
            ->assertSuccessful()
            ->assertSee('Create an Intern Account');
    });

    it('allows a new intern to register', function () {
        $internRole = Role::create(['role_name' => 'Intern']);

        $response = $this->post(route('register'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'student_number' => '2024-0001',
            'school' => 'Test University',
            'course' => 'BSIT',
            'year_level' => 4,
            'phone' => '1234567890',
            'address' => '123 Test St',
            'emergency_contact' => 'Jane Doe - 0987654321',
        ]);

        $response->assertRedirect(route('dashboard'));

        expect(User::where('email', 'john@test.com')->exists())->toBeTrue();
        expect(Intern::where('student_number', '2024-0001')->exists())->toBeTrue();

        $this->assertAuthenticated();
    });

    it('validates registration input', function () {
        Role::create(['role_name' => 'Intern']);

        $this->post(route('register'), [])
            ->assertSessionHasErrors([
                'first_name', 'last_name', 'email', 'password',
                'student_number', 'school', 'course', 'year_level',
            ]);
    });

    it('allows a user to log in with valid credentials', function () {
        $role = Role::create(['role_name' => 'HR']);
        $user = User::factory()->create([
            'role_id' => $role->id,
            'password' => bcrypt('password123'),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    });

    it('rejects login with invalid credentials', function () {
        $role = Role::create(['role_name' => 'HR']);
        $user = User::factory()->create([
            'role_id' => $role->id,
            'password' => bcrypt('password123'),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    });

    it('prevents inactive users from logging in', function () {
        $role = Role::create(['role_name' => 'HR']);
        $user = User::factory()->create([
            'role_id' => $role->id,
            'password' => bcrypt('password123'),
            'status' => 'Inactive',
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertGuest();
    });

    it('allows a user to log out', function () {
        $role = Role::create(['role_name' => 'HR']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    });
});

describe('Role-Based Access Control', function () {
    beforeEach(function () {
        $this->adminRole = Role::create(['role_name' => 'Admin']);
        $this->hrRole = Role::create(['role_name' => 'HR']);
        $this->supervisorRole = Role::create(['role_name' => 'Supervisor']);
        $this->internRole = Role::create(['role_name' => 'Intern']);
    });

    it('redirects intern from HR routes', function () {
        $user = User::factory()->create(['role_id' => $this->internRole->id]);

        $this->actingAs($user)
            ->get(route('hr.dashboard'))
            ->assertForbidden();
    });

    it('redirects intern from supervisor routes', function () {
        $user = User::factory()->create(['role_id' => $this->internRole->id]);

        $this->actingAs($user)
            ->get(route('supervisor.dashboard'))
            ->assertForbidden();
    });

    it('redirects intern from admin routes', function () {
        $user = User::factory()->create(['role_id' => $this->internRole->id]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    });

    it('allows HR to access HR routes', function () {
        $user = User::factory()->create(['role_id' => $this->hrRole->id]);

        $this->actingAs($user)
            ->get(route('hr.dashboard'))
            ->assertSuccessful();
    });

    it('allows admin to access admin routes', function () {
        $user = User::factory()->create(['role_id' => $this->adminRole->id]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertSuccessful();
    });
});
