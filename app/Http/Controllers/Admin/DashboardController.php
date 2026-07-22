<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'active_users' => \App\Models\User::where('status', 'Active')->count(),
            'total_departments' => \App\Models\Department::count(),
            'total_interns' => \App\Models\Intern::count(),
            'total_supervisors' => \App\Models\Supervisor::count(),
            'active_assignments' => \App\Models\Assignment::where('status', 'Active')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
