<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Application;
use App\Models\Assignment;
use App\Models\DailyLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        return match ($user->role->role_name) {
            'Admin' => $this->adminDashboard(),
            'HR' => $this->hrDashboard(),
            'Supervisor' => $this->supervisorDashboard(),
            'Intern' => $this->internDashboard(),
            default => redirect()->route('login'),
        };
    }

    private function adminDashboard(): View
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'active_users' => \App\Models\User::where('status', 'Active')->count(),
            'total_departments' => \App\Models\Department::count(),
            'total_interns' => \App\Models\Intern::count(),
            'total_supervisors' => \App\Models\Supervisor::count(),
            'active_assignments' => Assignment::where('status', 'Active')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    private function hrDashboard(): View
    {
        $stats = [
            'pending_applications' => Application::where('status', 'Pending')->count(),
            'approved_applications' => Application::where('status', 'Approved')->count(),
            'rejected_applications' => Application::where('status', 'Rejected')->count(),
            'pending_submissions' => \App\Models\Submission::where('status', 'Pending')->count(),
            'active_assignments' => Assignment::where('status', 'Active')->count(),
            'completed_assignments' => Assignment::where('status', 'Completed')->count(),
        ];

        $recentApplications = Application::with('intern.user')
            ->latest()
            ->limit(5)
            ->get();

        return view('hr.dashboard', compact('stats', 'recentApplications'));
    }

    private function supervisorDashboard(): View
    {
        $supervisor = $user = auth()->user()->supervisor;

        $assignmentIds = $supervisor ? $supervisor->assignments()->pluck('id') : collect();

        $stats = [
            'assigned_interns' => $supervisor ? $supervisor->assignments()->where('status', 'Active')->count() : 0,
            'pending_logs' => DailyLog::whereIn('assignment_id', $assignmentIds)->where('status', 'Pending')->count(),
            'approved_logs' => DailyLog::whereIn('assignment_id', $assignmentIds)->where('status', 'Approved')->count(),
            'total_evaluations' => \App\Models\Evaluation::whereIn('assignment_id', $assignmentIds)->count(),
        ];

        $pendingLogs = DailyLog::with('assignment.application.intern.user')
            ->whereIn('assignment_id', $assignmentIds)
            ->where('status', 'Pending')
            ->latest()
            ->limit(5)
            ->get();

        $announcements = Announcement::latest()->limit(5)->get();

        return view('supervisor.dashboard', compact('stats', 'pendingLogs', 'announcements'));
    }

    private function internDashboard(): View
    {
        $intern = auth()->user()->intern;

        if (! $intern) {
            return view('intern.no-profile');
        }

        $application = $intern->applications()->latest()->first();
        $assignment = $application?->assignment;
        $announcements = Announcement::latest()->limit(5)->get();

        $stats = [
            'application_status' => $application?->status ?? 'Not Applied',
            'assignment_status' => $assignment?->status ?? 'Not Assigned',
            'completed_hours' => $assignment?->completed_hours ?? 0,
            'required_hours' => $assignment?->required_hours ?? 0,
            'total_logs' => $assignment ? $assignment->logs()->count() : 0,
            'pending_logs' => $assignment ? $assignment->logs()->where('status', 'Pending')->count() : 0,
            'approved_logs' => $assignment ? $assignment->logs()->where('status', 'Approved')->count() : 0,
            'evaluations' => $assignment ? $assignment->evaluations()->count() : 0,
        ];

        $recentLogs = $assignment
            ? $assignment->logs()->latest()->limit(5)->get()
            : collect();

        return view('intern.dashboard', compact('stats', 'application', 'assignment', 'announcements', 'recentLogs'));
    }
}
