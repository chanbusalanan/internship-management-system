<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\Assignment;
use App\Models\DailyLog;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
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
