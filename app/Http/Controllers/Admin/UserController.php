<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\Role;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with('role');

        if ($request->filled('role')) {
            $query->where('role_id', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create(): View
    {
        $roles = Role::all();
        $departments = Department::all();

        return view('admin.users.create', compact('roles', 'departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'status' => ['required', 'in:Active,Inactive'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'role_id' => $validated['role_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'status' => $validated['status'],
        ]);

        if ($user->isSupervisor() && isset($validated['department_id'])) {
            Supervisor::create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'],
                'position' => $validated['position'] ?? 'Staff',
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if (isset($validated['email']) && $validated['email'] !== $user->email) {
            $existing = User::where('email', $validated['email'])->where('id', '!=', $user->id)->first();
            if ($existing) {
                return redirect()->back()
                    ->withErrors(['email' => 'This email is already in use.'])
                    ->withInput();
            }
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function activate(User $user): RedirectResponse
    {
        $user->update(['status' => 'Active']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User account activated successfully.');
    }

    public function deactivate(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['status' => 'Inactive']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User account deactivated successfully.');
    }
}
