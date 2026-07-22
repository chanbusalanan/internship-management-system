<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Intern;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $internRole = Role::where('role_name', 'Intern')->firstOrFail();

        $user = User::create([
            'role_id' => $internRole->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'status' => 'Active',
        ]);

        Intern::create([
            'user_id' => $user->id,
            'student_number' => $request->student_number,
            'school' => $request->school,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'phone' => $request->phone,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Account created successfully! Welcome to the Internship Management System.');
    }
}
